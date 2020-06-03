<?php


namespace HuntkingdomBundle\Controller;


use HuntkingdomBundle\Entity\Chasse;
use HuntkingdomBundle\Form\ChasseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChasseController extends Controller
{
    public function ajouterChasseAction(Request $request)
    {$user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $chase= new Chasse();
        $chase->setIdUser($usrC);
        $chase->setEtat(0);
        $form=$this->createForm(ChasseType::class,$chase);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($chase);
            $em->flush();
            return $this->redirectToRoute("chasse_ajoutChasse");
        }
        return $this->render('@Huntkingdom/chasse/ajouterChasse.html.twig',array('form'=>$form->createView()));
    }

    public function showChasseAction(){


        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository(Chasse::class)->findAll();
        foreach ($animal as $e)
        {
            if($e->getDateFin() < new \DateTime())
                $e->setEtat(1);
            $em->persist($e);
            $em->flush();


        }
        $animal1 =$em->getRepository(Chasse::class)->findAll();
        return $this->render('@Huntkingdom/chasse/afficherChasse.html.twig',array(
            'chasse'=> $animal1));
    }
    public function showChasseFAction(){


        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository(Chasse::class)->findAll();
        foreach ($animal as $e)
        {
            if($e->getDateFin() < new \DateTime())
                $e->setEtat(1);
            $em->persist($e);
            $em->flush();


        }
        $animal1 =$em->getRepository(Chasse::class)->findAll();
        return $this->render('@Huntkingdom/Front/chasse.html.twig',array(
            'chasse'=> $animal1));
    }
    public function modifChasseAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $chasse= $em->getRepository(Chasse::class)->find($id);
        $form = $this->createForm(ChasseType::class, $chasse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $chasse->setEtat(0);
            $em->persist( $chasse);
            $em->flush();
            $this->addFlash('info', 'edit Successfully !');
          return $this->redirectToRoute('chasse_afficherChasse');
        }


        return $this->render('@Huntkingdom/chasse/Editchasse.html.twig',array("form"=>$form->createView()));




    }
    public function deleteChasseAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $chasse =$em->getRepository(Chasse::class)->find($id);
        $em->remove($chasse);
        $em->flush();
        return $this->redirectToRoute('chasse_afficherChasse');


    }
}