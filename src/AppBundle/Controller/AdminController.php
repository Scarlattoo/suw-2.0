<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/panel_administratora", name="admin")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj będzie wyszukiwanie_wykladow'));
    }
}
