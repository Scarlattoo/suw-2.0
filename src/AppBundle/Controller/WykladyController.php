<?php

namespace AppBundle\Controller;
use AppBundle\Entity\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/wyklady/{course}", name="show_course_lectures", requirements={"course"="^\D+"})
     */
    public function show_course_lecturesAction($course)
    {
        $user=$this->getUser();
        $files=$this->getDoctrine()->getRepository(File::class)
            ->findAllByCourse($course,$user);
        return $this->render('wyklady/course.html.twig', array('course' => $course, 'files' => $files));
    }
}
