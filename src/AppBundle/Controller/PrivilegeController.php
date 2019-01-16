<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Privilege;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\File;


/**
 * Privilege controller.
 *
 * @Route("/zarzadzanie_uprawnieniami")
 */
class PrivilegeController extends Controller
{
    /**
     * Lists all privilege entities.
     *
     * @Route("/", name="privilege_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses=$this->getUser()->getCourses()->getValues();
        dump($courses);
        die();
        $privileges = $em->getRepository('AppBundle:Privilege')->findAll();

        return $this->render('privilege/index.html.twig', array(
            'privileges' => $privileges,
        ));
    }

    /**
     * Lists all privilege entities by course.
     *
     * @Route("/{course}", name="privilege_course")
     * @Method("GET")
     */
    public function courseAction($course)
    {
        $em = $this->getDoctrine()->getManager();
        $privileges = $em->getRepository('AppBundle:File')->findAllByCourse($course);
        dump($courses);
        die();

        return $this->render('privilege/index.html.twig', array(
            'privileges' => $privileges,
        ));
    }

    /**
     * Creates a new privilege entity.
     *
     * @Route("ghjgfjgf", name="")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $privilege = new Privilege();
        $form = $this->createForm('AppBundle\Form\PrivilegeType', $privilege);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($privilege);
            $em->flush();

            return $this->redirectToRoute('privilege_show', array('id' => $privilege->getId()));
        }

        return $this->render('privilege/new.html.twig', array(
            'privilege' => $privilege,
            'form' => $form->createView(),
        ));
    }


}
