<?php

namespace HuntkingdomBundle\Controller;

use HuntkingdomBundle\Entity\AnnonceMob;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class AnnonceMobController extends Controller
{
    public function allAction($id){
        $annonces = $this->getDoctrine()->getManager()
            ->getRepository('HuntkingdomBundle:AnnonceMob')
            ->findBy(array("user"=>$id));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonces);
        return new JsonResponse($formatted);
    }


    public function allsAction(){
        $annonces = $this->getDoctrine()->getManager()
            ->getRepository('HuntkingdomBundle:AnnonceMob')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonces);
        return new JsonResponse($formatted);
    }


    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $annonce = new AnnonceMob();

        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($request->get('user'));

        $annonce->setText($request->get('text'));
        $annonce->setEtat(0);
        $annonce->setAime(0);
        $annonce->setImage($request->get('image'));

        $annonce->setUser($usrC);
        $em->persist($annonce);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonce);
        return new JsonResponse($formatted);

    }

    public function updateAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $this->getDoctrine()->getManager()
            ->getRepository('HuntkingdomBundle:AnnonceMob')
            ->find($id);

        $annonce->setText($request->get('text'));
        $annonce->setImage($request->get('image'));
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonce);
        return new JsonResponse($formatted);
    }
    public function  deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $annonce = $this->getDoctrine()->getManager()
            ->getRepository('HuntkingdomBundle:AnnonceMob')
            ->find($id);
        $em->remove($annonce);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonce);
        return new JsonResponse($formatted);
    }
}
