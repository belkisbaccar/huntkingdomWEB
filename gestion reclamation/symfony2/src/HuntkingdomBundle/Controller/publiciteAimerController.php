<?php


namespace HuntkingdomBundle\Controller;


use HuntkingdomBundle\Entity\Publicite;
use HuntkingdomBundle\Entity\PubliciteAimer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class publiciteAimerController extends Controller
{
    public function ajouterPubliciteAimerAction($id)
    { $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $PubliciteAimer= new PubliciteAimer();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Publicite = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:Publicite')
            ->find($id);
        $Publicite->setNblike($Publicite->getNblike()+1);
        $PubliciteAimer->setIdPublicite($id);
        $PubliciteAimer->setIdUser($usrC);
        $PubliciteAimer->setDate(new \DateTime());
        $em->persist($PubliciteAimer);
        $em->persist($Publicite);
        $em->flush();



        return $this->redirectToRoute("front");

    }
    public function supprimerPubliciteAimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $Publicite2 = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:Publicite')
            ->find($id);
        $Publicite2->setNblike($Publicite2->getNblike()-1);
        $em->persist($Publicite2);
        $Publicite = $em->getRepository(Publicite::class)->findPubAimer($id,$usrC->getId());
        foreach ($Publicite as $e)
        {$em->remove($e);
        $em->flush();
        }

        return $this->redirectToRoute("front");

    }

}