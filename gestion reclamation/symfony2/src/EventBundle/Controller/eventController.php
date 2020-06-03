<?php

namespace EventBundle\Controller;
use EventBundle\Entity\Evenement;

use EventBundle\Entity\Reviews;
use EventBundle\Form\evenementType;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class eventController extends Controller
{
    public function ajoutereventAction(Request $request)
    {
        $Evenement= new Evenement();
        $form=$this->createForm(evenementType::class,$Evenement);
        $form->handleRequest($request);
        $image= $request->get('image');
        $Evenement->setImage($image);
        $Evenement->setNb(($Evenement->getNbPlaceEvent()));
        if ($form->isSubmitted())
        {

            $em=$this->getDoctrine()->getManager();

            $Evenement->uploadPubimage();
            $em->persist($Evenement);
            $em->flush();
            return $this->redirectToRoute("evenement_ajoutevenement");
        }
        return $this->render('@Event/evenement/ajouterEvent.html.twig',array('form'=>$form->createView()));
    }

    public  function affichereventAction()
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EventBundle:Evenement")->findAll();
        return $this->render("@Event/evenement/afficherEvent.html.twig",array('evenement'=>$evenement));

    }

    public function supprimereventAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository("EventBundle:Evenement")->find($id);
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute("evenement_afficherevenement");
    }
    public function modifiereventAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $Evenement=$em->getRepository(Evenement::class)->find($id);
        $form=$this->createForm(evenementType::class,$Evenement);
        $form->handleRequest($request);

        $image= $request->get('image');




        if($form->isValid())
        {
            $Evenement->uploadPubimage();
            $em->flush();

            return $this->redirectToRoute("evenement_afficherevenement");

        }

        return $this->render('@Event/evenement/modifierEvent.html.twig', array('form' => $form->createView(),'Evenement'=>$Evenement));

    }
    public  function afficherEAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EventBundle:Evenement")->findAll();
        return $this->render("@Event/Front/Event/Event.html.twig",array('evenement'=>$evenement));
    }





}
