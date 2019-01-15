<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserPanelController extends Controller
{
    /**
     * @Route("/panel_uzytkownika", name="userPanel")
     */
    public function indexAction()
    {
        

        return $this->render('userPanel/user.html.twig');
    }

      /**
     * @Route("/panel_uzytkownika/zmiana_hasla", name="change_password")
     */
    public function changePassword()
    {
        $user=$this->getUser();
        $files=$this->getDoctrine()->getRepository(User::class);
        return $this->render('userPanel/user.html.twig');
    }
}
