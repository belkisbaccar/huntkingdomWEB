<?php

namespace GrapheBundle\Controller;

use HuntkingdomBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;
class GrapheController extends Controller
{
    public function chartPieAction(){





        $em=$this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Reclamation::class)->findAll();

        foreach ($reclamations as $e)
        {
            $datetime1=new \DateTime();
            $difference=$datetime1->diff($e->getDate())->days;
            if ( $difference >=5 and $e->getEtat() =='Non traitée')
            {
                $e->setPriority(3);
                $em->persist($e);
                $em->flush();
            }
            elseif ($difference >= 3 and  $difference <5 and $e->getEtat() =='Non traitée')
            {
                $e->setPriority(2);
                $em->persist($e);
                $em->flush();


            }
            elseif ($difference >=2 and $difference <3 and $e->getEtat() =='Non traitée'  )
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

        $nb= count($reclamations1);
        $nb1= count($nbrec1);
        $nb2= count($nbrec2);
        $nb3= count($nbrec3);

        $nb1 =$nb1/$nb;
        $nb2 =$nb2/$nb;
        $nb3 =$nb3/$nb;





        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Les réclamations selon leurs niveaux de priorités');

        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true ));
        $data = array(
                array('niveau 1', $nb1),
                array('niveau 2', $nb2),
                array('niveau 3', $nb3),

            );

        $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data)));

        $em=$this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Reclamation::class)->findAll();


        $nbrec1 = $em->getRepository(Reclamation::class)->findBy(array('etat'=>'Non traitée'));
        $nbrec2 = $em->getRepository(Reclamation::class)->findBy(array('etat'=>'En cours'));
        $nbrec3 = $em->getRepository(Reclamation::class)->findBy(array('etat'=>'Traitée'));

        $nb= count($reclamations);
        $nb1= count($nbrec1);
        $nb2= count($nbrec2);
        $nb3= count($nbrec3);

        $nb1 =$nb1/$nb;
        $nb2 =$nb2/$nb;
        $nb3 =$nb3/$nb;

        $ob1 = new Highchart();
        $ob1->chart->renderTo('piechart1');
        $ob1->title->text('Les réclamations selon leurs etats');

        $ob1->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true ));
        $data1 = array(
            array('Non traites', $nb1),
            array('En cours', $nb2),
            array('Triatée', $nb3),

        );





        $ob1->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data1)));



        $nbrec0 = $em->getRepository(Reclamation::class)->findBy(array('note'=>0));
        $nbrec1 = $em->getRepository(Reclamation::class)->findBy(array('note'=>1));
        $nbrec2 = $em->getRepository(Reclamation::class)->findBy(array('note'=>2));
        $nbrec3 = $em->getRepository(Reclamation::class)->findBy(array('note'=>3));
        $nbrec4 = $em->getRepository(Reclamation::class)->findBy(array('note'=>4));
        $nbrec5 = $em->getRepository(Reclamation::class)->findBy(array('note'=>5));


        $nb1= count($nbrec1);
        $nb2= count($nbrec2);
        $nb3= count($nbrec3);
        $nb4= count($nbrec4);
        $nb5= count($nbrec5);
        $nb0= count($nbrec0);
        $series3 = array(
            array("name" => "nb de réclamations avec cette note",
                "data" => array($nb0,$nb1,$nb2,$nb3,$nb4,$nb5))
        );

        $ob3 = new Highchart();
        $ob3->chart->renderTo('linechart');  //  #id du div où afficher le graphe
        $ob3->title->text('les réclamations selon leurs notes');
        $ob3->xAxis->title(array('text'  => "note de la reclamation"));
        $ob3->yAxis->title(array('text'  => "nb de reclamations "));
        $ob3->series($series3);



        return $this->render('GrapheBundle:Graphe:graph_pis_etat.html.twig', array(
            'chart' => $ob,
            'chart1' => $ob1,
            'chart3' => $ob3));
    }
}
