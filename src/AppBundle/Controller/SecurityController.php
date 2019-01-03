<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/logowanie", name="login")
     */
    public function indexAction()
    {
        return $this->render('login/login.html.twig', array());
    }
    /**
     * @Route("/blad_logowania", name="login_fail")
     */
    public function loginFailAction()
    {
        $this->addFlash('danger','Zły numer użytkownika lub hasło');
        return $this->redirectToRoute('login');
    }
    /**
     * @Route("/wylogowano", name="logout_message")
     */
    public function logoutMessageAction ()
    {
        $this->addFlash('success','Wylogowano pomyślnie');
        return $this->redirectToRoute('main');
    }
}
