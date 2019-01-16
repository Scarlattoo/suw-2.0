<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Course controller.
 *
 * @Route("admin")
 */
class CourseController extends Controller
{
    /**
     * Lists all course entities.
     *
     * @Route("/kursy", name="admin_courses_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:Course')->findAll();
        $course = new Course();
        $form = $this->createForm('AppBundle\Form\CourseType', $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('admin_courses_index');
        }
        return $this->render('course/index.html.twig', array(
            'courses' => $courses,
            'course' => $course,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing course entity.
     *
     * @Route("/kursy/{id}/edit", name="admin_edit_course")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Course $course)
    {
        $editForm = $this->createForm('AppBundle\Form\CourseType', $course);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_courses_index', array('id' => $course->getId()));
        }

        return $this->render('course/edit.html.twig', array(
            'course' => $course,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a course entity.
     *
     * @Route("kursy/{id}/usun", name="admin_delete_course")
     */
    public function deleteAction(Request $request, Course $course)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($course);
            $em->flush();
        return $this->redirectToRoute('admin_courses_index');
    }

}
