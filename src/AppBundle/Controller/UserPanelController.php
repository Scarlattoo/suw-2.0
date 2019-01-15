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

        $user = $this->getUser();
        $oldPassword = $user->getPassword();

        $form = $this->createForm(ChangePwd::class, $user);
        $form->handleRequest($request);

     
        if ($form->isSubmitted() && $form->isValid()) {

            if (password_verify($user->getPassword(), $oldPassword)){
                $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setLastActivity(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Pomyślnie zmieniono hasło!');
                return $this->redirectToRoute('main');

            }
            
                $this->addFlash('danger','Obecne hasło niepoprawne!');
                return $this->redirectToRoute('userPanel');
         }
   
         return $this->render('userPanel/user.html.twig', array(
             'form' => $form->createView(),
         ));      
    }
}
