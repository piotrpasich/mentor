<?php

namespace PPMentorBundle\Controller;

use PPMentorBundle\Entity\Mentor;
use PPMentorBundle\Entity\Padavan;
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
        $padavan = new Padavan();
        $form    = $this->createForm('PPMentorBundle\Form\PadavanType', $padavan);
        $form->handleRequest($originalRequest);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($padavan);
            $em->flush();

            $this->addFlash(
                'notice',
                'You have successfully registerd!'
            );

            return $this->redirectToRoute('landing_page');
        }

        return [
            'padavan' => $padavan,
            'form' => $form->createView(),
            'mentors' => $this->getDoctrine()->getRepository("PPMentorBundle:Mentor")->findAll(),
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

//            return $this->redirectToRoute('register_mentor');
        }

        return [
            'mentor' => $mentor,
            'form' => $form->createView(),
        ];
    }
}
