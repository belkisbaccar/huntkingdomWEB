<?php

namespace HuntkingdomBundle\Controller;
use Knp\Component\Pager\Paginator;
use HuntkingdomBundle\Entity\Product;
use HuntkingdomBundle\Form\ProductType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use QRcode;
use Dompdf\Dompdf;
use Dompdf\Options;
include "../vendor/phpqrcode/qrlib.php";


class produitController extends Controller
{
    public function ajouterProduitAction(Request $request)
    {
        $Product= new Product();
        $form=$this->createForm(ProductType::class,$Product);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            /**
             *  @var UploadedFile $file
             */
            $file=$Product->getImage();
            QRcode::png("Le nom du produit:".$Product->getNom()."-Prix :".$Product->getPrix()."DT", $Product->getNom().".png", "H", 20, 20);
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter( 'image_directory'),$fileName);
            $Product->setImage($fileName);
            $Product->setPrixPromo(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($Product);
            $em->flush();

            $this->addFlash('info','ajout avec succées');
        }
        return $this->render('@Huntkingdom/commerce/ajouterProduit.html.twig',array('form'=>$form->createView()));
    }

    public  function afficherProduitAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $dql = "SELECT a from HuntkingdomBundle:Product a";
        $query=$em->createQuery($dql);
        // $posts=$em->getRepository("HuntkingdomBundle:Product")->findAll();
        /**
         * @var $paginator  Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',1)
        );


        return $this->render("@Huntkingdom/commerce/afficherProduit.html.twig",array( 'posts' => $result));


    }

    public function supprimerProduitAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $Product = $em->getRepository("HuntkingdomBundle:Product")->find($id);
        $em->remove($Product);
        $em->flush();

        return $this->redirectToRoute("commerce_afficherProduit");
    }
    public function updateProduitAction(Request $request,$id)
    {
        $c= $this->getDoctrine()->getManager();
        $Product = $c->getRepository("HuntkingdomBundle:Product")->find($id);
        $form=$this->createForm(ProductType::class,$Product);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($Product);
            $em->flush();
            return $this->redirectToRoute("commerce_afficherProduit");
        }
        return $this->render('@Huntkingdom/commerce/ajouterProduit.html.twig',array('form'=>$form->createView()));
    }


    public  function afficherPAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Promotion=$em->getRepository("HuntkingdomBundle:Promotion")->findAll();
        foreach ($Promotion as $e)
        {
            if($e->getDateFin() < new \DateTime()) {
                $e->setEtat(1);
                $Produit11= $e->getProduct();
                $Produit11->setPrixPromo(0);
                $em->persist($Produit11);
            }
            $em->persist($e);

            $em->flush();


        }


        $dql = "SELECT a from HuntkingdomBundle:Product a";
        $query=$em->createQuery($dql);
        // $posts=$em->getRepository("HuntkingdomBundle:Product")->findAll();
        /**
         * @var $paginator  Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',2)
        );




        return $this->render("@Huntkingdom/front/Shop/Shop.html.twig",array( 'posts' => $result));


    }
    public function addPanierAction($id, SessionInterface $session){

        $panier = $session->get('panier',[]);
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('frontP');

    }


    public function showPanierAction(SessionInterface $session){
        $panier = $session->get('panier',[]);
        $em= $this->getDoctrine()->getManager();
        $products= $em->getRepository('HuntkingdomBundle:Product')->findByArray(array_keys($session->get('panier')));
        $total=0;
        foreach ($products as $product){
            $totalP= $product->getprix() + $total;

        }

        return $this->render('@HuntkingdomBundle/Front/Shop/afficherPanier.html.twig',array(
            'products' => $products,
            'panier' => $session->get('panier')
        ));


    }

    public function removePanierAction($id, SessionInterface $session){
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('show_panier');
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $em->getRepository('HuntkingdomBundle:Product')->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Post Not found :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getImage(),$posts->getNom()];

        }
        return $realEntities;
    }

    public function facturePDFAction(SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $em = $this->getDoctrine()->getManager();
        $Produit=$em->getRepository('HuntkingdomBundle:Product')->findByArray(array_keys($session->get('panier')));

        $total = 0;
        /*  foreach ($Product as $Product){
              $totalP= $Product->getPrice() + $total;

          }*/


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@HuntkingdomBundle/Front/Shop/pdf.html.twig', [
            'Produit' => $Produit,
            'panier' => $session->get('panier')
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

}
