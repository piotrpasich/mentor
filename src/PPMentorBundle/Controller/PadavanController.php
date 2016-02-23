<?php

namespace PPMentorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PPMentorBundle\Entity\Padavan;
use PPMentorBundle\Form\PadavanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Padavan controller.
 *
 * @Route("/admin/padavan")
 */
class PadavanController extends Controller
{
    /**
     * Lists all Padavan entities.
     *
     * @Route("/", name="padavan_index")
     * @Method("GET")
     * @Template("padavan/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $padavans = $em->getRepository('PPMentorBundle:Padavan')->findAll();

        return [
            'padavans' => $padavans,
        ];
    }

    /**
     * Displays a form to edit an existing Padavan entity.
     *
     * @Route("/{id}/edit", name="padavan_edit")
     * @Method({"GET", "POST"})
     * @Template("padavan/edit.html.twig")
     */
    public function editAction(Request $request, Padavan $padavan)
    {
        $deleteForm = $this->createDeleteForm($padavan);
        $editForm = $this->createForm('PPMentorBundle\Form\PadavanType', $padavan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($padavan);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully edited the padavan!'
            );

            return $this->redirectToRoute('padavan_edit', array('id' => $padavan->getId()));
        }

        return [
            'padavan' => $padavan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Padavan entity.
     *
     * @Route("/{id}", name="padavan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Padavan $padavan)
    {
        $form = $this->createDeleteForm($padavan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($padavan);
            $em->flush();
        }

        return $this->redirectToRoute('padavan_index');
    }

    /**
     * Creates a form to delete a Padavan entity.
     *
     * @param Padavan $padavan The Padavan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Padavan $padavan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('padavan_delete', array('id' => $padavan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
