<?php

namespace PPMentorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PPMentorBundle\Entity\Mentor;
use PPMentorBundle\Form\MentorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Mentor controller.
 *
 * @Route("/admin/mentor")
 */
class MentorController extends Controller
{
    /**
     * Lists all Mentor entities.
     *
     * @Route("/", name="admin_mentor_index")
     * @Method("GET")
     * @Template("mentor/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mentors = $em->getRepository('PPMentorBundle:Mentor')->findAll();

        return [
            'mentors' => $mentors,
        ];
    }

    /**
     * Creates a new Mentor entity.
     *
     * @Route("/new", name="admin_mentor_new")
     * @Method({"GET", "POST"})
     * @Template("mentor/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $mentor = new Mentor();
        $form = $this->createForm('PPMentorBundle\Form\MentorType', $mentor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mentor);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully created the mentor!'
            );

            return $this->redirectToRoute('admin_mentor_show', array('id' => $mentor->getId()));
        }

        return [
            'mentor' => $mentor,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Mentor entity.
     *
     * @Route("/{id}/edit", name="admin_mentor_edit")
     * @Method({"GET", "POST"})
     * @Template("mentor/edit.html.twig")
     */
    public function editAction(Request $request, Mentor $mentor)
    {
        $deleteForm = $this->createDeleteForm($mentor);
        $editForm = $this->createForm('PPMentorBundle\Form\MentorType', $mentor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mentor);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully edited the mentor!'
            );

            return $this->redirectToRoute('admin_mentor_edit', array('id' => $mentor->getId()));
        }

        return [
            'mentor' => $mentor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Mentor entity.
     *
     * @Route("/{id}", name="admin_mentor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mentor $mentor)
    {
        $form = $this->createDeleteForm($mentor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mentor);
            $em->flush();
        }

        return $this->redirectToRoute('admin_mentor_index');
    }

    /**
     * Creates a form to delete a Mentor entity.
     *
     * @param Mentor $mentor The Mentor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mentor $mentor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_mentor_delete', array('id' => $mentor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
