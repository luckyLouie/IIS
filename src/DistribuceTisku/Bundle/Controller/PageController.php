<?php

namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DistribuceTisku\Bundle\Entity\Enquiry;
use DistribuceTisku\Bundle\Form\EnquiryType;

class PageController extends UpperController
{
    public function indexAction()
    {
        if(($pom = $this->timeCheck()) != "") {echo $pom;return $this->render($pom);}
        return $this->render('DistribuceTiskuBundle:Page:index.html.twig');
    }

    public function aboutAction()
    {
        if(($pom = $this->timeCheck()) != "") {echo $pom;return $this->render($pom);}
        print($this->getUser());
        return $this->render('DistribuceTiskuBundle:Page:about.html.twig');
    }
    
    public function contactAction()
    {
        if(($pom = $this->timeCheck()) != "") {echo $pom;return $this->render($pom);}
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

               /* $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo('email@email.com')
                    ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);
                */
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('_contact'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function seznamTiskovinAction()
    {
        if(($pom = $this->timeCheck()) != "") {echo $pom;return $this->render($pom);}
        $conn = $this->get('database_connection');
        $tiskoviny = $conn->fetchAll('SELECT * FROM tiskovina');
        $name = "";
        return $this->render('DistribuceTiskuBundle:Page:seznamTiskovin.html.twig',array('tiskoviny' => $tiskoviny));
    }
 
}
