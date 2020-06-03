<?php


namespace HuntkingdomBundle\Controller;


use HuntkingdomBundle\Entity\Product;
use HuntkingdomBundle\Entity\Publicite;
use HuntkingdomBundle\Form\ProductType;
use HuntkingdomBundle\Form\PubliciteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class publiciteController extends Controller
{
    public function ajouterPubliciteAction(Request $request)
    {
        $Publicite= new Publicite();
        $form=$this->createForm(PubliciteType::class,$Publicite);
        $form->handleRequest($request);
        $image= $request->get('image');
        $Publicite->setImage($image);
        $Publicite->setEtat(0);
        $Publicite->setNblike(0);
        if ($form->isSubmitted())
        {

            $em=$this->getDoctrine()->getManager();

            $Publicite->uploadPubimage();
            $em->persist($Publicite);
            $em->flush();
            return $this->redirectToRoute("publicite_ajoutPublicite");
        }
        return $this->render('@Huntkingdom/publicite/ajouterPublicite.html.twig',array('form'=>$form->createView()));
    }

    public  function afficherPubliciteAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Publicite=$em->getRepository("HuntkingdomBundle:Publicite")->findAll();

        foreach ($Publicite as $e)
        {
            if($e->getDateFin() < new \DateTime())
                $e->setEtat(1);
            $em->persist($e);
            $em->flush();


        }
        $Publicite1=$em->getRepository("HuntkingdomBundle:Publicite")->findBy(array('etat'=>0));
        $Publicite2=$em->getRepository("HuntkingdomBundle:Publicite")->findBy(array('etat'=>1));
        $Publicite3=$em->getRepository("HuntkingdomBundle:Publicite")->findBy(array(),array('dateFin' => 'ASC'));
        return $this->render("@Huntkingdom/publicite/afficherPublicite.html.twig",array('Publicite'=>$Publicite1,'Pub'=>$Publicite2,'Pub1'=>$Publicite3));

    }



    public  function afficherPubliciteFrontAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Publicite=$em->getRepository("HuntkingdomBundle:Publicite")->findAll();




        return $this->render("@Huntkingdom/Front/Home.html.twig",array('Publicite'=>$Publicite));

    }
    public function supprimerPubliciteAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("HuntkingdomBundle:Publicite")->find($id);
        $em->remove($Publicite);
        $em->flush();

        return $this->redirectToRoute("publicite_afficherPublicite");
    }
    public function desactiverPubliciteAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("HuntkingdomBundle:Publicite")->find($id);
        $Publicite->setEtat(1);
        $em->flush($Publicite);
        $em->flush();

        return $this->redirectToRoute("publicite_afficherPublicite");
    }
    public function updatePubliciteAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $Publicite=$em->getRepository(Publicite::class)->find($id);
        $form=$this->createForm(PubliciteType::class,$Publicite);
        $form->handleRequest($request);

        $image= $request->get('image');




        if($form->isValid())
        {   $Publicite->setEtat(0);
            $Publicite->uploadPubimage();
            $em->flush();

            return $this->redirectToRoute("publicite_afficherPublicite");

        }
        return $this->render("@Huntkingdom/publicite/updatePublicite.html.twig",array('form'=>$form->createView(),'Publicite'=>$Publicite));

    }

}