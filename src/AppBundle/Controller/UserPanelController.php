<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserPanelController extends Controller
{
    /**
     * @Route("/panel_uzytkownika", name="userPanel")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj będzie panel_uzytkownika'));
    }
}
