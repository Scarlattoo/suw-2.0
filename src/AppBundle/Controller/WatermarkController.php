<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\File;
use AppBundle\Entity\Course;
use \DateTime;

/**
 * Controller for showing Watermark and PDF protection useability.
 * For the main implementation controller have to be changed after the File manager implementation.
 */


class WatermarkController extends Controller
{
    /**
     * @Route("/waterm_test", name="watermTest")
     */
    // public function indexAction()
    // {
    //     return $this->render('base.html.twig', array('content' => 'TEST'));
    // }

    public function addWatermarkTest(Request $request) {
        $external_packages_path = realpath(__dir__."/../../../vendor");
        include_once(realpath($external_packages_path . '/setasign/fpdf/fpdf.php'));
        include_once(realpath($external_packages_path . '/setasign/fpdi/src/autoload.php'));
        require_once(realpath($external_packages_path . '/setasign/fpdi-protection/src/autoload.php'));

        $this->createTestFileRecord();
        $file_name = 'test_file.pdf';
        $password = strval(rand(1000, 9999));
        $date = date('Y-m-d H:i:s');
        $client_ip = $request->getClientIp();
        $user = $this->getUser();
        $text = join("\n\n", array($user, $date, $client_ip));
        $courses = $this->getCourseNames();
        $pdf = $this->add_watermark($file_name, $text, $password);
        $file_abspath = $this->getFileAbspath($file_name);

        // return $this->render('base.html.twig', array('content' => $external_packages_path));
        return $this->render('download/download.html.twig', array(
            'courses_names' => $courses,
            'password' => $password,
            'file' => $file_name,
            'pdf' => $pdf,
            'file_abspath' => $file_abspath
        ));
    }

    private function createTestFileRecord() {
        $fileRepository = $this->getDoctrine()->getRepository('AppBundle:File');
        $our_file = $fileRepository->findBy(array("filename" => "test_file.pdf"));
        if (empty($our_file) == true) {
            $new_file = new File();
            $new_file->setTitle('TestTitle');
            $new_file->setDescription('TestDescription');
            $new_file->setSize(1234);
            $new_file->setTime(new DateTime('2011-01-01T15:03:01.012345Z'));
            $new_file->setType('PDF');
            $new_file->setFilename('test_file.pdf');
            $new_file->setLectureFile('ssss');
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($new_file);
            $entityManager->flush();
        }
    }

    private function getCourseNames(){
        $coursesRepo = $this->getDoctrine()->getRepository('AppBundle:Course');
        $courses = $coursesRepo->findAll();
        $courses_names = array();
        foreach ($courses as $course){
            array_push($courses_names, $course->getName());
        }
        return $courses_names;

    }

    private function getFileAbspath($file_name){
        $storage_path = realpath(__dir__."/../../../storage");
        $file_path = $storage_path."/".$file_name;
        return $file_path;
    }

    private function add_watermark($file_name, $text, $password)
    {   
        $pdf =  new \setasign\FpdiProtection\FpdiProtection();
        $file = $this->getFileAbspath($file_name);
        try {
            $page_count = $pdf->setSourceFile($file);
        } catch (Exception $pdfp_e) {
            Warning::set(
                'File is corrupted. Error: ' . $pdfp_e
            );
            return false;
        }
        for ($i = 1; $i <= $page_count; $i++) {
            $page_templ = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($page_templ);
            $page_orient = $size['orientation'];
            $page_width = (int)$size['width'];
            $page_height = (int)$size['height'];
            $pdf->addPage($page_orient);
            $pdf->SetFont('Times', 'I', 20);
            $pdf->SetTextColor(206, 204, 204);
            $text_x_pos = ceil((5 / 100) * $page_width); // Watermark position: % of page width, % of page height
            $text_y_pos = ceil((80 / 100) * $page_height);
            $pdf->SetXY($text_x_pos, $text_y_pos);
            $pdf->Write(4, $text);
            $pdf->useTemplate($page_templ);
        }
        $pdf->SetProtection(array(), $password);
        // $this->DownloadFile($file, $pdf);
        return $pdf;
    }

    private function DownloadFile($file, $pdf){
        $pdf->Output('I', $file);
        return;
    }

}
