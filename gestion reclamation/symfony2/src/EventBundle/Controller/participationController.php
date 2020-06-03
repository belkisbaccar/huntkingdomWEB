<?php

namespace EventBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use evenementBundle\Entity\Event;
use EventBundle\Entity\Evenement;
use EventBundle\Entity\Participation;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
class participationController extends Controller
{


    public  function afficherparticipationAction()
    {

        $em=$this->getDoctrine()->getManager();

        $participation=$em->getRepository("EventBundle:Participation")->findAll();
        return $this->render("@Event/evenement/afficherparticipation.html.twig",array('participation'=>$participation));

    }
    public function ajoutParticipationAction($id)
    {
        $participation=new Participation();
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($this->getUser()->getId());
        $participation->setUsername($user);
        $event=$em->getRepository(Evenement::class)->find($id);
        $participation->setIdEvent($event);
        $participation->setDateReservation(new \DateTime("now"));
        $tab = $em->getRepository(Participation::class)->findParticiaptionsEvent($event->getIdEvent(),$user->getUsername());
        if(empty($tab)){
            $event->setNbPlaceEvent(($event->getNbPlaceEvent())-1);
            $em->persist($participation);
            $em->flush();
        }
        return $this->redirectToRoute('frontE');
    }
    public function supprimerparticipationAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $participation = $em->getRepository(\EventBundle\Entity\Participation::class)->find($id);
        $event=$em->getRepository(Evenement::class)->find($participation->getIdEvent());
        $event->setNbPlaceEvent(($event->getNbPlaceEvent())+1);
        $em->remove($participation);
        $em->flush();

        return $this->redirectToRoute('UserAfficheParticipation');
    }
    public function UserAfficheParticipationAction()
    {
        $test="current";
        $em = $this->getDoctrine();
        $tab = $em->getRepository(\EventBundle\Entity\Participation::class)->findMyParticiaptions($this->getUser()->getUsername());
        return $this->render('@Event/Front/Event/UserAfficheParticipation.html.twig', array('participations' => $tab,'test'=>$test));
    }
    public function UserAfficheParticipationtrierAction()
    {
        $test="current";
        $em = $this->getDoctrine();
        $tab = $em->getRepository(\EventBundle\Entity\Participation::class)->findMyParticiaptionstrier($this->getUser()->getUsername());
        return $this->render('@Event/Front/Event/UserAfficheParticipation.html.twig', array('participations' => $tab,'test'=>$test));

    }
    public function statAction(){
        $em=$this->getDoctrine()->getManager();

        $participation=$em->getRepository("EventBundle:Participation")->findAll();
        return $this->render("@Event/evenement/stat.html.twig",array('participations'=>$participation));


    }
    public function PdfAction($id)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('EventBundle:Evenement')->find($id);

        $total = 0;
        /*  foreach ($Product as $Product){
              $totalP= $Product->getPrice() + $total;

          }*/


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Event/Front/Event/pdf.html.twig', [
            'participation' => $actualite
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
