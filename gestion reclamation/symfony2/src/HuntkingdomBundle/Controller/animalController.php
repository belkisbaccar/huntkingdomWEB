<?php


namespace HuntkingdomBundle\Controller;


use HuntkingdomBundle\Entity\Animals;
use HuntkingdomBundle\Form\AnimalsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class animalController extends Controller
{
    public function ajouterAnimalAction(Request $request)
    {

        $animal=new Animals();

        $form=$this->createForm(AnimalsType::class,$animal);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($animal);
            $animal->uploadPubimage();
            $em->flush();
            return $this->redirectToRoute("animal_ajoutAnimal");
        }
        return $this->render('@Huntkingdom/chasse/ajouterAnimal.html.twig',array('form'=>$form->createView()));
    }

    public function deleteAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository(Animals::class)->find($id);
        $em->remove($animal);
        $em->flush();
        return $this->redirectToRoute('animal_afficherAnimal');


    }
    public function editAnimalAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $animal= $em->getRepository(Animals::class)->find($id);
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $animal->uploadPubimage();
            $em->persist( $animal);
            $em->flush();

            return $this->redirectToRoute('animal_afficherAnimal');
        }


        return $this->render('@Huntkingdom/chasse/Editanim.html.twig',array("form"=>$form->createView()));




    }

    public function showAnimalAction(){


        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository(Animals::class)->findAll();
        return $this->render('@Huntkingdom/chasse/afficherAnimal.html.twig',array(
            'animal'=> $animal));
    }
}