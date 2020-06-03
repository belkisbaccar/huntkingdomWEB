<?php

namespace HuntkingdomBundle\Controller;

use HuntkingdomBundle\Entity\Commentaire;
use HuntkingdomBundle\Entity\Annonce;
use HuntkingdomBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function ajouterCommentaireAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Commentaire = new Commentaire();
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);
        $Commentaire->setIdUser($usrC);
        $Commentaire->setIdAnnonce($id);


        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();

            $em->persist($Commentaire);
            $em->flush();

            $em=$this->getDoctrine()->getManager();
            $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$id));

            return $this->render("@Huntkingdom/Commentaire/afficherCommentaire.html.twig",array('Commentaire'=>$Commentaire,'user'=>$usrC));
        }
        return $this->render('@Huntkingdom/Commentaire/ajouterCommentaire.html.twig',array('form'=>$form->createView()));
    }


    public function supprimerCommentaireAction($id)
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        $em = $this->getDoctrine()->getManager();
        $Commentaire = $em->getRepository("HuntkingdomBundle:Commentaire")->find($id);
        $k=$Commentaire->getIdAnnonce();
        $em->remove($Commentaire);
        $em->flush();

        $em=$this->getDoctrine()->getManager();
        $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$k));

        return $this->render("@Huntkingdom/Commentaire/afficherCommentaire.html.twig",array('Commentaire'=>$Commentaire,'user'=>$usrC));

    }
    public  function afficherCommentaireAction($id)
    {   $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $em=$this->getDoctrine()->getManager();
        $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$id));

        return $this->render("@Huntkingdom/Commentaire/afficherCommentaire.html.twig",array('Commentaire'=>$Commentaire,'user'=>$usrC));

    }
    public function updateCommentaireAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        $em=$this->getDoctrine()->getManager();
        $Commentaire=$em->getRepository(Commentaire::class)->find($id);
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);
        $c=$Commentaire->getIdAnnonce();

        if($form->isValid())
        {
            $em->flush();

            $em=$this->getDoctrine()->getManager();
            $k=$Commentaire->getIdAnnonce();
            $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$k));

            return $this->render("@Huntkingdom/Commentaire/afficherCommentaire.html.twig",array('Commentaire'=>$Commentaire,'user'=>$usrC));

        }
        return $this->render("@Huntkingdom/commentaire/modifierCommentaire.html.twig",array('form'=>$form->createView(),'Commentaire'=>$Commentaire));

    }
    public  function afficherCommentaire_frontAction($id)
    { $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $em=$this->getDoctrine()->getManager();
        $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$id));
        $Annonce=$em->getRepository("HuntkingdomBundle:Annonce")->find($id);
        return $this->render("@Huntkingdom/Commentaire/afficherCommentaire_front.html.twig",array('Commentaire'=>$Commentaire,'Annonce'=>$Annonce,'user'=>$usrC));

    }


    public function supprimerCommentaire_frontAction($id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $em = $this->getDoctrine()->getManager();
        $Commentaire = $em->getRepository("HuntkingdomBundle:Commentaire")->find($id);
        $c=$Commentaire->getIdAnnonce();





        $em->remove($Commentaire);
        $em->flush();

        $Commentairee=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$c));
        $Annonce = $em->getRepository("HuntkingdomBundle:Annonce")->find($c);

        return $this->render("@Huntkingdom/Commentaire/afficherCommentaire_front.html.twig", array('Commentaire' => $Commentairee,'Annonce'=>$Annonce,'user'=>$usrC));


    }

    public function ajouterCommentaire_frontAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Commentaire = new Commentaire();
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);
        $Commentaire->setIdUser($usrC);
        $Commentaire->setIdAnnonce($id);


        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();

            $em->persist($Commentaire);
            $em->flush();

            $em=$this->getDoctrine()->getManager();
            $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$id));
            $Annonce=$em->getRepository("HuntkingdomBundle:Annonce")->find($id);
            return $this->render("@Huntkingdom/Commentaire/afficherCommentaire_front.html.twig",array('Commentaire'=>$Commentaire,'Annonce'=>$Annonce,'user'=>$usrC));
        }
        return $this->render('@Huntkingdom/Commentaire/ajouterCommentaire_front.html.twig',array('form'=>$form->createView()));
    }

    public function updateCommentaire_frontAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        $em=$this->getDoctrine()->getManager();
        $Commentaire=$em->getRepository(Commentaire::class)->find($id);
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);
        $c=$Commentaire->getIdAnnonce();

        if($form->isValid())
        {
            $em->flush();

            $em=$this->getDoctrine()->getManager();

            $Commentaire=$em->getRepository("HuntkingdomBundle:Commentaire")->findBy(array('idAnnonce'=>$c));
            $Annonce=$em->getRepository("HuntkingdomBundle:Annonce")->find($c);
            return $this->render("@Huntkingdom/Commentaire/afficherCommentaire_front.html.twig",array('Commentaire'=>$Commentaire,'Annonce'=>$Annonce,'user'=>$usrC));

        }
        return $this->render("@Huntkingdom/commentaire/modifierCommentaire_front.html.twig",array('form'=>$form->createView(),'Commentaire'=>$Commentaire));

    }

}
