<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Course;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WykladyController extends Controller
{
    /**
     * @Route("/wyklady", name="show_all_lectures")
     */
    public function show_all_lecturesAction()
    {
        //Taki mały przykład na próbę ^^
        $transcriptId=12345; //to będzie z logowania
        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user=$userRepository->findOneBytranscriptId($transcriptId);
        $privileges = $user->getPrivileges();
        $files=array();
        $courses=array();
        foreach ($privileges AS $key => $privilege) {
            $files[$key]['title']=$privilege->getFile()->getTitle();
            $files[$key]['description']=$privilege->getFile()->getDescription();
            $files[$key]['size']=$privilege->getFile()->getSize();
            $files[$key]['time']=$privilege->getFile()->getTime();
            $files[$key]['type']=$privilege->getFile()->getType();
            $files[$key]['filename']=$privilege->getFile()->getFilename();
            $files[$key]['course']=$privilege->getFile()->getCourse()->getName();
            $courses[]=$privilege->getFile()->getCourse()->getName();
        }
        $courses=array_unique($courses);
        if (count($courses)===1) {
            return $this->redirectToRoute('show_course_lectures',array ("course" => $courses[0]));
        }
        return $this->render('wyklady/files.html.twig', array('courses' => $courses, 'files' => $files));
    }
    /**
     * @Route("/wyklady/{course}", name="show_course_lectures", requirements={"course"="^\D+"})
     */
    public function show_course_lecturesAction($course='all')
    {
        $transcriptId=12345; //to będzie z logowania
        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user=$userRepository->findOneBytranscriptId($transcriptId);
        $privileges = $user->getPrivileges();
        $files=array();
        foreach ($privileges AS $key => $privilege) {
            if ($course=='all'||$course==$privilege->getFile()->getCourse()->getName()) {
                $files[$key]['title'] = $privilege->getFile()->getTitle();
                $files[$key]['description'] = $privilege->getFile()->getDescription();
                $files[$key]['size'] = $privilege->getFile()->getSize();
                $files[$key]['time'] = $privilege->getFile()->getTime();
                $files[$key]['type'] = $privilege->getFile()->getType();
                $files[$key]['filename'] = $privilege->getFile()->getFilename();
                $files[$key]['course'] = $privilege->getFile()->getCourse()->getName();
            } else continue;
        }
        return $this->render('wyklady/files.html.twig', array('courses' => '', 'files' => $files));
    }
}
