<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Event/Default/index.html.twig');
    }
    public function filterEventAction(Request $request)
    {
        $EventSearch = $request->get("nom");

        $Events = $this->getDoctrine()->getManager()
            ->getRepository(Evenement::class)->filterEvents($EventSearch);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Events);
        return new JsonResponse($formatted);

    }
    public function statAction()
    {
        $ids=[];
        $total=[];
        $i=0;
        $plats=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        foreach ($plats as $plat){
            $ids[$i]=json_decode($plat->getIdEvent());
            $total[$i]=json_decode(($plat->getNb())-($plat->getnbPlaceEvent()));
            $i++;
        }


        return $this->render('@Event/evenement/stat.html.twig',['ids'=>$ids,'totals'=>$total]);  }

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
