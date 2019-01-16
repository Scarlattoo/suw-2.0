<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Course;
use AppBundle\Entity\Download;
use AppBundle\Entity\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use setasign\Fpdi\PdfParser\PdfParserException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use setasign\FpdiProtection\FpdiProtection as FPDI;
/**
 * Class WykladyController
 * @package AppBundle\Controller
 */
class WykladyController extends Controller
{
    /**
     * @Route("/wyklady", name="show_all_lectures")
     */
    public function show_all_lecturesAction()
    {
        $user=$this->getUser();
        $files = $this->getDoctrine()->getRepository(File::class)
            ->findAllByUserPrivileges($user);
        if (count($files)===1) {
            return $this->redirectToRoute('show_course_lectures',array ("course" => $files[0]['name']));
        } else if (count($files)===0) {
            return $this->render('base.html.twig',array('content' => '<h2>Brak udostępnionych wykładów</h2>'));
        } else {
            foreach ($files AS $file) {
                $courses[]=$file['name'];
            }
            $courses=\array_unique($courses);
        }
        return $this->render('wyklady/files.html.twig', array('courses' => $courses, 'files' => $files));
    }
    /**
     * @Route("/wyklady/{course}", name="show_course_lectures", requirements={"course"="^(\w| )+"})
     */
    public function show_course_lecturesAction($course)
    {
        if (!$this->getDoctrine()->getRepository(Course::class)->findOneByName($course)) {
            $this->addFlash('warning','Nie znaleziono kursu');
            return $this->redirectToRoute('show_all_lectures');
        }
        $user=$this->getUser();
        $files=$this->getDoctrine()->getRepository(File::class)
            ->findAllByCourse($course,$user);
        return $this->render('wyklady/course.html.twig', array('course' => $course, 'files' => $files));
    }
    /**
     * @Route("/wyklady/pokaz/{lecture}", name="show_lecture", requirements={"lecture"="^\d+"})
     */
    public function show_lectureAction($lecture)
    {
        if (!$file = $this->checkFile($lecture)) {
            $this->addFlash('warning', 'Nie znaleziono pliku');
            return $this->redirectToRoute('show_all_lectures');
        }
        $pdf = $this->encryptAndWatermark($file);
        return $pdf->Output('I', $file->getFilename());
    }
    /**
     * @Route("/wyklady/pobierz/{lecture}", name="download_lecture", requirements={"lecture"="^\d+"})
     */
    public function download_lectureAction($lecture)
    {
       if (!$file = $this->checkFile($lecture)) {
           $this->addFlash('warning', 'Nie znaleziono pliku');
           return $this->redirectToRoute('show_all_lectures');
       }
        $pdf = $this->encryptAndWatermark($file);
        return $pdf->Output('D', $file->getFilename());
    }


    private function checkFile($lecture)
    {
        $file = $this->getDoctrine()->getRepository('AppBundle:File')->find($lecture);
        $lectures_directory = realpath($this->getParameter('lectures_directory'));
        if (empty($file) || !is_file($lectures_directory.DIRECTORY_SEPARATOR.$file->getLectureFile())) {
            return false;
        }
        return $file;
    }

    public function encryptAndWatermark($file) {
        $pdf = new FPDI;
        $lectures_directory = realpath($this->getParameter('lectures_directory'));
        $filePath = $lectures_directory.DIRECTORY_SEPARATOR.$file->getLectureFile();
        try {
            $page_count = $pdf->setSourceFile($filePath);
        } catch (PdfParserException $pdfp_e) {
                die('File is corrupted. Error: ' . $pdfp_e);
        }
        $user = $this->getUser();
        $watermark[] = $user->getTranscriptId();
        $now = new \DateTime('now');
        $watermark[] = $now->format('d-m-y H:i');
        $ip = $this->container->get('request')->getClientIp();
        $watermark[] = $ip;
        $download = new Download();
        $download->setUser($this->getUser());
        $download->setFile($file);
        $download->setIp($ip);
        $download->setTime($now);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($download);
        $entityManager->flush();

        for ($i = 1; $i <= $page_count; $i++) {
            $page_templ = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($page_templ);
            $page_orient = $size['orientation'];
            $page_width = (int)$size['width'];
            $page_height = (int)$size['height'];
            $pdf->addPage($page_orient);
            $pdf->useTemplate($page_templ);
            $pdf->SetFont('Courier', 'I', 50);
            $pdf->SetTextColor(126, 124, 124);
            $text_x_pos = \ceil((40 / 100) * $page_width); // Watermark position: % of page width, % of page height
            $text_y_pos = \ceil((20 / 100) * $page_height);
            $pdf->SetXY($text_x_pos, $text_y_pos);
            $pdf->Write(0, $watermark[0]);
            $text_x_pos = \ceil((20 / 100) * $page_width);
            $text_y_pos = \ceil((50 / 100) * $page_height);
            $pdf->SetXY($text_x_pos, $text_y_pos);
            $pdf->Write(0, $watermark[1]);
            $text_x_pos = \ceil((20 / 100) * $page_width);
            $text_y_pos = \ceil((70 / 100) * $page_height);
            $pdf->SetXY($text_x_pos, $text_y_pos);
            $pdf->Write(0, $watermark[2]);
        }
        $pdf->SetProtection(array(), $user->getLecturesPassword());
        return $pdf;
    }
}
