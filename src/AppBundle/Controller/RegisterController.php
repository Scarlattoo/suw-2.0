<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegisterController extends Controller
{
    /**
     * @Route("/rejestracja", name="register")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj będzie rejestracja'));
    }
}
