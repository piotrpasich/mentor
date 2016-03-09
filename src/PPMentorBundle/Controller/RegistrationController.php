<?php

namespace PPMentorBundle\Controller;

use PPMentorBundle\Entity\Mentor;
use PPMentorBundle\Entity\Padawan;
use PPMentorBundle\Event\PadawanRegisteredEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegistrationController extends Controller
{
    /**
     * @Route("/", name="landing_page")
     * @Template("PPMentorBundle:Registration:index.html.twig")
     */
    public function indexAction(Request $originalRequest)
    {
        $padawan = new Padawan();
        $form    = $this->createForm('PPMentorBundle\Form\PadawanType', $padawan);
        $form->handleRequest($originalRequest);

        if ($form->isSubmitted() && $form->isValid()) {
            if ('' !== $originalRequest->request->get('address')) die('ok');
            $em = $this->getDoctrine()->getManager();
            $em->persist($padawan);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully registerd!'
            );

            $this->get('event_dispatcher')->dispatch('pp.padawan_regstered', new PadawanRegisteredEvent($padawan));

            return $this->redirectToRoute('landing_page');
        }

        return [
            'padawan' => $padawan,
            'form' => $form->createView(),
            'mentors' => $this->getDoctrine()->getRepository("PPMentorBundle:Mentor")->findByApproved(true),
        ];
    }

    /**
     * @Route("/mentor", name="register_mentor")
     * @Template("PPMentorBundle:Registration:mentor.html.twig")
     */
    public function mentorAction(Request $request)
    {
        $mentor = new Mentor();
        $form   = $this->createForm('PPMentorBundle\Form\RegisterMentorType', $mentor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mentor->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($mentor);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully registerd as a Mentor!'
            );

            return $this->redirectToRoute('register_mentor');
        }

        return [
            'mentor' => $mentor,
            'form' => $form->createView(),
        ];
    }
}
