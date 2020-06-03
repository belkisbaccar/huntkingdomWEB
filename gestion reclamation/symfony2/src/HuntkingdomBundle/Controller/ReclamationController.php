<?php

namespace HuntkingdomBundle\Controller;

use HuntkingdomBundle\Entity\Reclamation;

use HuntkingdomBundle\Entity\Reponse;
use HuntkingdomBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends Controller
{
    public function createAction(Request $request)
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());

        // Récupération d'un user déjà existant, d'id $id.
        /* $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:Utilisateur')
                ->find(3);*/
        $annonce = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:Annonce')
            ->find(12);

        $reclamation = new Reclamation();
        $reclamation->setDate(new \DateTime('now'));
        $reclamation->setIdUser($usrC);
        $reclamation->setNote(0);
        $reclamation->setEtat("Non traitee");
        $reclamation->setIdAnnonceReclame($annonce);
        $reclamation->setPriority(0);
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form = $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $reclamation->uploadPicture();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute("reclamation_afficherReclamations");
        }
        return $this->render('@Huntkingdom/Reclamation/ajouterReclamation.html.twig',array('form'=>$form->createView()));
    }

    public function create_produitAction(Request $request)
    {

        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($user != null) {
            $usrC = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:User')
                ->find($user->getId());
            $produit = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:Product')
                ->find(17);

            $reclamation = new Reclamation();
            $reclamation->setDate(new \DateTime('now'));
            $reclamation->setIdUser($usrC);
            $reclamation->setNote(0);
            $reclamation->setEtat("Non traitee");
            $reclamation->setIdProduit($produit);


            $form = $this->createForm(ReclamationType::class, $reclamation);
            $form = $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $reclamation->uploadPicture();
                $em->persist($reclamation);
                $em->flush();
                return $this->redirectToRoute("reclamation_afficherReclamations");
            }
            return $this->render('@Huntkingdom/Reclamation/reclamerProduit.html.twig', array('form' => $form->createView()));
        }
    }


    public function readAction(){
        $em=$this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Reclamation::class)->findAll();

        foreach ($reclamations as $e)
        {
            $datetime1=new \DateTime();
            $difference=$datetime1->diff($e->getDate())->days;
            if ( $difference >5 && $e->getEtat() =="Non traitée")
            {
                $e->setPriority(3);
                $em->persist($e);
                $em->flush();
            }
            elseif ($difference >= 3 &&  $difference <=5 && $e->getEtat() =="Non Traitée")
            {
                $e->setPriority(2);
                $em->persist($e);
                $em->flush();


            }
            elseif ($difference >=1 && $difference <3 && $e->getEtat() =="Non traitée"  )
            {
                $e->setPriority(1);
                $em->persist($e);
                $em->flush();
            }
        }
        $reclamations1 = $em->getRepository(Reclamation::class)->findAll();
        $nbrec3 = $em->getRepository(Reclamation::class)->findBy(array('priority'=>3));
        $nbrec2 = $em->getRepository(Reclamation::class)->findBy(array('priority'=>2));
        $nbrec1 = $em->getRepository(Reclamation::class)->findBy(array('priority'=>1));
        return $this->render('@Huntkingdom/Reclamation/afficherReclamations.html.twig',array('reclamations'=>$reclamations1,'nbr3'=>$nbrec3
        ,'nbr2'=>$nbrec2,'nbr1'=>$nbrec1));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("HuntkingdomBundle:Reclamation")->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("reclamation_afficherReclamations");
    }

    public function update_etatAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamtion=$em->getRepository(Reclamation::class)->find($id);
        $form=$this->createForm(ReclamationType::class,$reclamtion);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $reclamtion->setPriority(0);
            $reclamtion->uploadPicture();
            $em->flush();
            return $this->redirectToRoute("reclamation_afficherReclamations");
        }
        return $this->render("@Huntkingdom/Reclamation/traiterReclamation.html.twig",
            array("form"=>$form->createView(),'reclamation'=>$reclamtion));
    }




    /*
        public function update_noteAction(Request $request,$id)
        {
            $reclamtion= $this->getDoctrine()->getRepository(Reclamation::class)
                ->find($id);
            $form= $this->createForm(ReclamationType::class,$reclamtion);
            $form->handleRequest($request);
            if ($form->isSubmitted()){
                $em= $this->getDoctrine()->getManager();
                $em->persist($reclamtion);
                $em->flush();
                $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
                return $this->render('@Huntkingdom/Reclamation/afficherReclamations.html.twig',array('reclamations'=>$reclamations));
            }
            //return $this->render("@Huntkingdom/Reclamation/noterReclamation.html.twig",
             //   array("form"=>$form->createView()));
        }

    */


    public function readfrontAction(){

        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($user != null) {


            $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findBy(array('idUser'=>$user->getId()));
            return $this->render('@Huntkingdom/Reclamation/reclamationfront.html.twig',array('reclamations'=>$reclamations));
        }
        $reclamations=$this->getDoctrine()->getRepository(Reclamation::class)->find(-1);
        return $this->render('@Huntkingdom/Reclamation/reclamationfront.html.twig',array('reclamations'=>$reclamations));

    }


    public function create_produit_frontAction(Request $request,$id)
    {

        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($user != null) {
            $usrC = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:User')
                ->find($user->getId());
            $produit = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:Product')
                ->find($id);

            $reclamation = new Reclamation();
            $reclamation->setDate(new \DateTime('now'));
            $reclamation->setIdUser($usrC);
            $reclamation->setNote(0);
            $reclamation->setEtat("Non traitee");
            $reclamation->setIdProduit($produit);
            $reclamation->setPriority(0);

            $form = $this->createForm(ReclamationType::class, $reclamation);
            $form = $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $reclamation->uploadPicture();
                $em->persist($reclamation);
                $em->flush();
                return $this->redirectToRoute("sendmailajout");
            }
            return $this->render('@Huntkingdom/Reclamation/reclamation_ajout_front.html.twig', array('form' => $form->createView()));
        }
    }
    public function update_frontAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamtion=$em->getRepository(Reclamation::class)->find($id);
        $form=$this->createForm(ReclamationType::class,$reclamtion);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $rate=$request->get('rate');
            $reclamtion->setNote($rate);
            $reclamtion->uploadPicture();
            $em->flush();
            return $this->redirectToRoute("reclamation_front");
        }
        return $this->render("@Huntkingdom/Reclamation/reclamation_modifier_front.html.twig",
            array("form"=>$form->createView(),'reclamation'=>$reclamtion));
    }

    public  function  satisfaction_algorithmAction(){
        $nb_traitee=0;
        $nb5=0;
        $nb_5=0;
        $nb_4=0;
        $nb_3=0;
        $nb_2=0;
        $nb_1=0;
        $nb_0=0;
        $nb35=0;
        $nb1_5=0;
        $nb1_4=0;
        $nb1_3=0;
        $nb1_2=0;
        $nb1_1=0;
        $nb1_0=0;
        $nb3=0;
        $nb2_5=0;
        $nb2_4=0;
        $nb2_3=0;
        $nb2_2=0;
        $nb2_1=0;
        $nb2_0=0;
        $em=$this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Reclamation::class)->findAll();
        $nb_reclamations = count($reclamations);
        $em=$this->getDoctrine()->getManager();
        $reponses = $em->getRepository(Reponse::class)->findAll();
        $nb_reponse = count($reponses);

        foreach ($reclamations as $e) {
            $em=$this->getDoctrine()->getManager();
            $reponse = $em->getRepository(Reponse::class)->findBy(array("idReclamation"=>$e->getIdReclamation()));

            $nb_reponses = count($reponse);
            foreach ($reponse as $r){
                $difference=$e->getDate()->diff($r->getDate())->days;
                if ($e->getEtat()=="Traitée"){
                    $nb_traitee= $nb_traitee+1;
                    if($difference >=5 ){
                        $nb5=$nb5+1;
                        if($e->getNote()==5){
                            $nb_5=$nb_5+1;
                        }elseif($e->getNote()==4){
                            $nb_4=$nb_4+1;
                        }elseif($e->getNote()==3){
                            $nb_3=$nb_3+1;
                        }elseif($e->getNote()==2){
                            $nb_2=$nb_2+1;
                        }elseif($e->getNote()==1){
                            $nb_1=$nb_1+1;
                        }elseif($e->getNote()==0){
                            $nb_0=$nb_0+1;
                        }
                    }elseif($difference >=3 and  $difference <5 ){
                        $nb35=$nb35+1;
                        if($e->getNote()==5){
                            $nb1_5=$nb1_5+1;
                        }elseif($e->getNote()==4){
                            $nb1_4=$nb1_4+1;
                        }elseif($e->getNote()==3){
                            $nb1_3=$nb1_3+1;
                        }elseif($e->getNote()==2){
                            $nb1_2=$nb1_2+1;
                        }elseif($e->getNote()==1){
                            $nb1_1=$nb1_1+1;
                        }elseif($e->getNote()==0){
                            $nb1_0=$nb1_0+1;
                        }
                    }elseif($difference <3  ) {
                        $nb3 = $nb3 + 1;
                        if ($e->getNote() == 5) {
                            $nb2_5 = $nb2_5 + 1;
                        } elseif ($e->getNote() == 4) {
                            $nb2_4 = $nb2_4 + 1;
                        } elseif ($e->getNote() == 3) {
                            $nb2_3 = $nb2_3 + 1;
                        } elseif ($e->getNote() == 2) {
                            $nb2_2 = $nb2_2 + 1;
                        } elseif ($e->getNote() == 1) {
                            $nb2_1 = $nb2_1 + 1;
                        } elseif ($e->getNote() == 0) {
                            $nb2_0 = $nb2_0 + 1;
                        }
                    }
                }
            }
        }
        $taux_note5_5j=0;
        $taux_note4_5j=0;
        $taux_note3_5j=0;
        $taux_note2_5j=0;
        $taux_note1_5j=0;
        $taux_note0_5j=0;
        $taux_note5_35j=0;
        $taux_note4_35j=0;
        $taux_note3_35j=0;
        $taux_note2_35j=0;
        $taux_note1_35j=0;
        $taux_note0_35j=0;
        $taux_note5_3j=0;
        $taux_note4_3j=0;
        $taux_note3_3j=0;
        $taux_note2_3j=0;
        $taux_note1_3j=0;
        $taux_note0_3j=0;
        $taux_reponse_5j=0;
        $taux_reponse_3j_5j=0;
        $taux_reponse_3j=0;
        $taux_reponse_reclamation = $nb_reponse/$nb_reclamations;
        if($nb_traitee!=0) {
            $taux_reponse_5j = $nb5 / $nb_traitee;

            $taux_reponse_3j_5j = $nb35 / $nb_traitee;

            $taux_reponse_3j = $nb3 / $nb_traitee;
        }
        if($nb_5 !=0 )
            $taux_note5_5j=$nb_5/$nb5;
        if($nb_4 !=0 )
            $taux_note4_5j=$nb_4/$nb5;
        if($nb_3 !=0 )
            $taux_note3_5j=$nb_3/$nb5;
        if($nb_2 !=0 )
            $taux_note2_5j=$nb_2/$nb5;
        if($nb_1 !=0 )
            $taux_note1_5j=$nb_1/$nb5;
        if($nb_0 !=0 )
            $taux_note0_5j=$nb_0/$nb5;

        if($nb1_5 !=0)
            $taux_note5_35j=$nb1_5/$nb35;
        if($nb1_4 !=0)
            $taux_note4_35j=$nb1_4/$nb35;
        if($nb1_3 !=0)
            $taux_note3_35j=$nb1_3/$nb35;
        if($nb1_2 !=0)
            $taux_note2_35j=$nb1_2/$nb35;
        if($nb1_1 !=0)
            $taux_note1_35j=$nb1_1/$nb35;
        if($nb1_0 !=0)
            $taux_note0_35j=$nb1_0/$nb35;

        if($nb2_5 !=0)
            $taux_note5_3j=$nb2_5/$nb3;
        if($nb2_4 !=0)
            $taux_note4_3j=$nb2_4/$nb3;
        if($nb2_3 !=0)
            $taux_note3_3j=$nb2_3/$nb3;
        if($nb2_2 !=0)
            $taux_note2_3j=$nb2_2/$nb3;
        if($nb2_1 !=0)
            $taux_note1_3j=$nb2_1/$nb3;
        if($nb2_0 !=0)
            $taux_note0_3j=$nb2_0/$nb3;
        return $this->render('@Huntkingdom/Reclamation/algorithme_satisfaction.html.twig',array('taux_reponse_reclamation'=>$taux_reponse_reclamation
            ,'taux_reponse_5j'=>$taux_reponse_5j
            ,'taux_reponse_3j_5j'=>$taux_reponse_3j_5j
            ,'taux_reponse_3j'=>$taux_reponse_3j
            ,'taux_note5_5j'=>$taux_note5_5j
            ,'taux_note4_5j'=>$taux_note4_5j
            ,'taux_note3_5j'=>$taux_note3_5j
            ,'taux_note2_5j'=>$taux_note2_5j
            ,'taux_note1_5j'=>$taux_note1_5j
            ,'taux_note0_5j'=>$taux_note0_5j
            ,'taux_note5_35j'=>$taux_note5_35j
            ,'taux_note4_35j'=>$taux_note4_35j
            ,'taux_note3_35j'=>$taux_note3_35j
            ,'taux_note2_35j'=>$taux_note2_35j
            ,'taux_note1_35j'=>$taux_note1_35j
            ,'taux_note0_35j'=>$taux_note0_35j
            ,'taux_note5_3j'=>$taux_note5_3j
            ,'taux_note4_3j'=>$taux_note4_3j
            ,'taux_note3_3j'=>$taux_note3_3j
            ,'taux_note2_3j'=>$taux_note2_3j
            ,'taux_note1_3j'=>$taux_note1_3j
            ,'taux_note0_3j'=>$taux_note0_3j  )

        );
    }


}
