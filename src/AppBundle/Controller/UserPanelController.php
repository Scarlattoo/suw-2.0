<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\ChangePwd;
use Symfony\Component\HttpFoundation\Request;

class UserPanelController extends Controller
{
     /**
     * @Route("/panel_uzytkownika", name="userPanel")
     */
    public function userAction(Request $request)
    {
        $user = $this->getUser();
        $LecturesPassword = $user->getLecturesPassword();
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
             'LecturesPassword' => $LecturesPassword,
         ));      
    }
    /**
     * @Route("/panel_uzytkownika/generuj_nowe_haslo", name="userPanel_generate_new_pwd")
     */
    public function generateAction(Request $request)
    {

        $user = $this->getUser();
        $lecturesPassword = \substr(\md5(\uniqid()),0,10);
        $user->setLecturesPassword($lecturesPassword);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success','Wygenerowano nowe hasło do plików wykładów.');
        return $this->redirectToRoute('userPanel');
    }
}
