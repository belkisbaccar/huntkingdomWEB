<?php

namespace HuntkingdomBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    { $em=$this->getDoctrine()->getManager();
        $Publicite=$em->getRepository("HuntkingdomBundle:Publicite")->findAll();
        foreach ($Publicite as $e)
        {
            if($e->getDateFin() < new \DateTime())
                $e->setEtat(1);
            $em->persist($e);
            $em->flush();


        }
        $Publicite1=$em->getRepository("HuntkingdomBundle:Publicite")->findAll();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $PubliciteAimer=$em->getRepository("HuntkingdomBundle:PubliciteAimer")->findBy(array('idUser'=>$user));

        return $this->render('@Huntkingdom/front/index.html.twig',array('Publicite'=>$Publicite1,'PubliciteA'=>$PubliciteAimer));
    }

    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotificationAction(Request $request)
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $usrC = $this->getDoctrine()
            ->getManager()
            ->getRepository('HuntkingdomBundle:User')
            ->find($user->getId());
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($user), $notif, true);

        return $this->redirectToRoute('notif');
    }
}
