<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WykladyController extends Controller
{
    /**
     * @Route("/wyklady", name="wyklady")
     */
    public function indexAction()
    {
        $transcriptId=12344; //to będzie z logowania
        $userRepository = $this->getDoctrine()->getRepository("AppBundle:User"); //tworzymy obiekt userRepository
        $user= $userRepository->findOneBytranscriptId($transcriptId); //pobieramy jednego użytkownika o podanym trinscriptId
        $priviledgeRepository = $this->getDoctrine()->getRepository("AppBundle:Priviledge");
        $priviledges = $priviledgeRepository->findByuserId($user->getId());
        $fileRepository = $this->getDoctrine()->getRepository("AppBundle:File"); //tworzymy obiekt fileRepository
        $files= $fileRepository->findByuserId($user->getId()); //pobieramy tablice z obiektami plików z polem userId równym Id użytkownika o numerze indeksu 12345
        return $this->render('base.html.twig', array('content' => $files));
    }
}
