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

        $form = $this->createForm(ChangePwd::class, $user);
        $form->handleRequest($request);

     
        if ($form->isSubmitted() && $form->isValid()) {

            // $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            // $old_pwd_encoded = $encoder->encodePassword($user->getFilledPassword(), $user->getSalt());

            $old_pwd_encoded = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getFilledPassword());

            if ($old_pwd_encoded = $user->getPassword() ){
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
                return $this->redirectToRoute('main');
         }
   
         return $this->render('userPanel/user.html.twig', array(
             'form' => $form->createView(),
         ));      
    }
}
