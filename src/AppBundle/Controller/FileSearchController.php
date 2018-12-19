<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class FileSearchController extends Controller
{
    /**
     * @Route("/wyszukiwanie_wykladow", name="fileSearch")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig', array('content' => 'Tutaj będzie wyszukiwanie_wykladow'));
    }
}
