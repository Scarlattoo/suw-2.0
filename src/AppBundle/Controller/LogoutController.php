<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LogoutController extends Controller
{
    /**
     * @Route("/wyloguj", name="logout")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj bedzie wylogowywanie'));
    }
}
