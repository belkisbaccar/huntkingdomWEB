<?php


namespace HuntkingdomBundle\Controller;



use HuntkingdomBundle\Entity\Product;
use HuntkingdomBundle\Entity\Promotion;
use HuntkingdomBundle\Entity\Publicite;
use HuntkingdomBundle\Form\PromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client;
class promotionController extends Controller

{
    public function ajouterPromotionAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Promotion= new Promotion();
        $Promotion->setEtat(0);


        $form=$this->createForm(PromotionType::class,$Promotion);
        $form->handleRequest($request);
        $produits=$em->getRepository("HuntkingdomBundle:Product")->findBy(array('prixPromo'=>'0'));




        if ($form->isSubmitted())
        {


            $id=$request->get('produit');
            $em1=$this->getDoctrine()->getManager();
            $Prod=$em1->getRepository("HuntkingdomBundle:Product")->findBy(array('id'=>$id));
            foreach ($Prod as $value){

                $value->setPrixPromo($value->getPrix()-$value->getPrix()*$request->get('taux')/100);
                $Promotion->setTaux($request->get('taux'));
                $Promotion->setProduct($value);

                $em1->persist($value);
                $em1->persist($Promotion);
                $em1->flush();
               /* $account_sid = 'ACd133f6219bb4c58abee84fa46d92b4dc';
                $auth_token = '03092fa7f788be25d7505d3ac0cf7a97';
                $twilio_number = "+12015946415";
                $client = new Client($account_sid, $auth_token);
                try {
                    $client->messages->create(
                    // Where to send a text message (your cell phone?)
                        '+21623831858',
                        array(
                            'from' => $twilio_number,
                            'body' => ' Nouvelle Promotion Sur le Produit '.$value->getNom().',taux '.$Promotion->getTaux().'%'
                        )
                    );
                } catch (TwilioException $e) {
                    echo ('error');
                }*/
                break;

            }


            return $this->redirectToRoute("promotion_ajoutPromotion");
        }
        return $this->render('@Huntkingdom/promotion/ajouterPromotion.html.twig',array('form'=>$form->createView(),'produits'=>$produits));
    }
    public  function afficherPromotionAction(Request $request)
    {
        $Pr=new Promotion();
        $em=$this->getDoctrine()->getManager();
        $Promotion=$em->getRepository("HuntkingdomBundle:Promotion")->findAll();
        $form=$this->createForm(PromotionType::class,$Pr);

        foreach ($Promotion as $e)
        {
            if($e->getDateFin() < new \DateTime()) {
                $e->setEtat(1);
                $Produit= $e->getProduct();
                $Produit->setPrixPromo(0);
                $em->persist($Produit);
            }
            $em->persist($e);

            $em->flush();


        }
        $Promotion1=$em->getRepository("HuntkingdomBundle:Promotion")->findAll();
        return $this->render("@Huntkingdom/promotion/afficherPromotion.html.twig",array('form'=>$form->createView(),'Promotion'=>$Promotion1));

    }
    public function supprimerPromotionAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Promotion = $em->getRepository("HuntkingdomBundle:Promotion")->find($id);
        $Produit=$Promotion->getProduct();
        $Produit->setPrixPromo(0);
        $em->persist($Produit);

        $em->remove($Promotion);
        $em->flush();

        return $this->redirectToRoute("promotion_afficherPromotion");
    }
    public function desactiverPromotionAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Promotion = $em->getRepository("HuntkingdomBundle:Promotion")->find($id);
        $Promotion->setEtat(1);
        $Produit=$Promotion->getProduct();
        $Produit->setPrixPromo(0);
        $em->persist($Produit);

        $em->persist($Promotion);
        $em->flush();

        return $this->redirectToRoute("promotion_afficherPromotion");
    }







    public function updatePromotionAction($id,Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        $Promotion = $em->getRepository("HuntkingdomBundle:Promotion")->find($id);
        $form=$this->createForm(PromotionType::class,$Promotion);
        $form->handleRequest($request);
        if($form->isValid())
        {   $Promotion->setTaux($request->get('taux'));
            $Promotion->setEtat(0);

            $Produit=$Promotion->getProduct();
            $Produit->setPrixPromo($Produit->getPrix()-$Produit->getPrix()*$request->get('taux')/100);
            $em->persist($Produit);

            $em->flush();

            return $this->redirectToRoute("promotion_afficherPromotion");

        }
        return $this->render("@Huntkingdom/promotion/updatePromotion.html.twig",array('form'=>$form->createView(),'Promotion'=>$Promotion));

    }

}