<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\ChangePwd;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserPanelController extends Controller
{
     /**
     * @Route("/panel_uzytkownika", name="userPanel")
     */
    public function userAction(Request $request)
    {

        $user = new User();
        $form = $this->createForm(ChangePwd::class, $user);
   
        $form->handleRequest($request);
   
        if ($form->isSubmitted() && $form->isValid()) {

            //tu musi byc jeszcze encode i decode
            
             return $this->redirect($this->generateUrl('change_passwd_success'));
         }
   
         return $this->render('userPanel/user.html.twig', array(
             'form' => $form->createView(),
         ));      
    }
}
