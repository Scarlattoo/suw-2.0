<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller
{
    /**
     * @Route("/logowanie", name="login")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj będzie logowanie'));
    }
}
