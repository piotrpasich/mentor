<?php

namespace PPMentorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PPMentorBundle\Entity\Padawan;
use PPMentorBundle\Form\PadawanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Padawan controller.
 *
 * @Route("/admin/padawan")
 */
class PadawanController extends Controller
{
    /**
     * Lists all Padawan entities.
     *
     * @Route("/", name="padawan_index")
     * @Method("GET")
     * @Template("padawan/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $padawans = $em->getRepository('PPMentorBundle:Padawan')->findAll();

        return [
            'padawans' => $padawans,
        ];
    }

    /**
     * Displays a form to edit an existing Padawan entity.
     *
     * @Route("/{id}/edit", name="padawan_edit")
     * @Method({"GET", "POST"})
     * @Template("padawan/edit.html.twig")
     */
    public function editAction(Request $request, Padawan $padawan)
    {
        $deleteForm = $this->createDeleteForm($padawan);
        $editForm = $this->createForm('PPMentorBundle\Form\PadawanType', $padawan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($padawan);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully edited the padawan!'
            );

            return $this->redirectToRoute('padawan_edit', array('id' => $padawan->getId()));
        }

        return [
            'padawan' => $padawan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Padawan entity.
     *
     * @Route("/{id}", name="padawan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Padawan $padawan)
    {
        $form = $this->createDeleteForm($padawan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($padawan);
            $em->flush();
        }

        return $this->redirectToRoute('padawan_index');
    }

    /**
     * Creates a form to delete a Padawan entity.
     *
     * @param Padawan $padawan The Padawan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Padawan $padawan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('padawan_delete', array('id' => $padawan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
