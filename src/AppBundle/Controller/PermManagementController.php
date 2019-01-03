<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PermManagementController extends Controller
{
    /**
     * @Route("/zarzadzanie_uprawnieniami", name="permManagement")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj nie będzie zarzadzanie_uprawnieniami'));
    }
}
