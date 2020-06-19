<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 09/04/2020
 * Time: 02:23
 */

namespace HuntkingdomBundle\Controller;


use HuntkingdomBundle\Entity\Annonce;
use HuntkingdomBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends Controller
{
    public function ajouterAnnonceAction(Request $request)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Annonce = new Annonce();
        $form=$this->createForm(AnnonceType::class,$Annonce);
        $form->handleRequest($request);
        $Annonce->setUser($usrC);
        $Annonce->setEtat(0);

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $Annonce->uploadPicture();
            $em->persist($Annonce);
            $em->flush();
            return $this->redirectToRoute("annonce_afficher_back");
        }
        return $this->render('@Huntkingdom/Annonce/ajouterAnnonce.html.twig',array('form'=>$form->createView()));
    }


    public  function afficherAnnonceAction()
    {     $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository("HuntkingdomBundle:Annonce")->findAll();

        return $this->render("@Huntkingdom/Annonce/afficherAnnonce.html.twig",array('Annonce'=>$Annonce,'user'=>$usrC));

    }

    public function supprimerAnnonceAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository("HuntkingdomBundle:Annonce")->find($id);
        $em->remove($Annonce);
        $em->flush();

        return $this->redirectToRoute("annonce_afficher_back");
    }


    public function updateAnnonceAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository(Annonce::class)->find($id);
        $form=$this->createForm(AnnonceType::class,$Annonce);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $Annonce->uploadPicture();
            $em->flush();

            return $this->redirectToRoute("annonce_afficher_back");

        }
        return $this->render("@Huntkingdom/annonce/modifierAnnonce.html.twig",array('form'=>$form->createView(),'Annonce'=>$Annonce));

    }
    public  function afficherAnnonce_frontAction()
    {

        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository("HuntkingdomBundle:Annonce")->findAll();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        return $this->render("@Huntkingdom/Annonce/afficherAnnonce_front.html.twig",array('Annonce'=>$Annonce,'user'=>$usrC));

    }
    public function ajouterAnnonce_frontAction(Request $request)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Annonce = new Annonce();
        $form=$this->createForm(AnnonceType::class,$Annonce);
        $form->handleRequest($request);
        $Annonce->setUser($usrC);
        $Annonce->setEtat(0);

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $Annonce->uploadPicture();
            $em->persist($Annonce);
            $em->flush();
            return $this->redirectToRoute("annonce_afficher_front");
        }
        return $this->render('@Huntkingdom/Annonce/ajouterAnnonce_front.html.twig',array('form'=>$form->createView()));
    }

    public function supprimerAnnonce_frontAction($id)
    {   $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());


        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository("HuntkingdomBundle:Annonce")->find($id);



        $em->remove($Annonce);
        $em->flush();

        return $this->redirectToRoute("annonce_afficher_front");
    }
    public function modifierAnnonce_frontAction(Request $request,$id)
    {    $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository(Annonce::class)->find($id);
        $form=$this->createForm(AnnonceType::class,$Annonce);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $Annonce->uploadPicture();
            $em->flush();

            return $this->redirectToRoute("annonce_afficher_front");

        }
        return $this->render("@Huntkingdom/annonce/modifierAnnonce_front.html.twig",array('form'=>$form->createView(),'Annonce'=>$Annonce));

    }

    public function aimerAction($id) {
        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository(Annonce::class)->find($id);
        $k=$Annonce->getEtat();
        $a=$Annonce->getAime();

        if($k==0) {
            $Annonce->setEtat(1);
            $a=$a+1;
            $Annonce->setAime($a);
            $em->flush();

        } else {
            $Annonce->setEtat(0);
            $a=$a-1;
            $Annonce->setAime($a);
            $em->flush();

        }

        return $this->redirectToRoute("annonce_afficher_front");

    }

    public function statAction()
    {
        $ids=[];
        $total=[];
        $i=0;
        $Annonces=$this->getDoctrine()->getRepository(Annonce::class)->findAll();
        foreach ($Annonces as $Annonce){
            $ids[$i]=json_decode($Annonce->getIdAnnonce());
            $total[$i]=json_decode($Annonce->getAime());
            $i++;
        }


        return $this->render('@Huntkingdom/Annonce/stat.html.twig',['ids'=>$ids,'totals'=>$total]);  }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);    }
}