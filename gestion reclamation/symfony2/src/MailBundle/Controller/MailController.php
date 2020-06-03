<?php

namespace MailBundle\Controller;

use MailBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{
    /**
     * @Route("/sendm")
     */
    public function sendMailAction(Request $request){
        $mail = new Mail();

        $subject= "nouvelle reclamation";
        $mail=$mail->getMail();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($user != null) {
            $usrC = $this->getDoctrine()
                ->getManager()
                ->getRepository('HuntkingdomBundle:User')
                ->find($user->getId());
        }

        $sendto=$usrC->getEmail();
        $object=$request->get('form')['object'];
        $username='belkisbaccar29@gmail.com';
        $message= \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($username)
            ->setTo($sendto);

        $img = $message->embed(\Swift_Image::fromPath('images/Divisor_Lines.png'));
        $img2 = $message->embed(\Swift_Image::fromPath('images/Invite_Illustration.png'));
        $message->setBody($this->renderView('@Mail/Mail/send_mail.html.twig', ['img' => $img,'img2' => $img2]), 'text/html');
        $this->get('mailer')->send($message);
        $this->get('session')->getFlashBag()->add('notice','Message envoyé avec success');
        return $this->redirectToRoute("reclamation_front");
    }
}
