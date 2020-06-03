<?php

namespace HuntkingdomBundle\Controller;

use HuntkingdomBundle\Entity\Reclamation;
use HuntkingdomBundle\Entity\Reponse;
use HuntkingdomBundle\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ReponseController extends Controller
{
    public function createAction(Request $request, $id)
    {
        $reclamation = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:Reclamation')
            ->find($id);
        $reponse = new Reponse();
        $reponse->setIdReclamation($reclamation);
        // $reclamation->setEtat("En cours");
        $reponse->setDate(new \DateTime('now'));
        $form = $this->createForm(ReponseType::class, $reponse);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reponse->uploadPicture();
            $em->persist($reponse);
            //  $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute("reponse_afficherReponses");
        }
        return $this->render('@Huntkingdom/Reponse/ajouterReponse.html.twig', array('form' => $form->createView()));
    }


    public function readAction()
    {
        $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findAll();
        return $this->render('@Huntkingdom/Reponse/afficherReponses.html.twig', array('reponses' => $reponses));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reponse = $em->getRepository("HuntkingdomBundle:Reponse")->find($id);
        $em->remove($reponse);
        $em->flush();
        return $this->redirectToRoute("reponse_afficherReponses");
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reponse = $em->getRepository(Reponse::class)->find($id);
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $reponse->uploadPicture();
            $em->flush();
            return $this->redirectToRoute("reponse_afficherReponses");
        }
        return $this->render("@Huntkingdom/Reponse/modifierReponse.html.twig",
            array("form" => $form->createView(), 'reponse' => $reponse));
    }


    public function read_frontAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user != null) {
            $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->findBy(array('idUser' => $user->getId()));
            $reponse=array();
            foreach ($reclamation as $value) {

                $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findBy(array('idReclamation' => $value->getIdReclamation()));

                $reponse=array_merge($reponse,$reponses);

            }return $this->render('@Huntkingdom/Reponse/reponse_front.html.twig', array('reponses' => $reponse));
        }
    }
}
