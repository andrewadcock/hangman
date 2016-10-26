<?php

namespace AppBundle\Controller;

use AppBundle\Contact\ContactRequest;
use AppBundle\Form\ContactRequestType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MiscController extends Controller
{
    /**
     * This action handles the
     *
     * @Route("/contact", name="app_contact")
     * @Method("GET|POST")
     */
    public function contactAction(Request $request)
    {
        $contact = new ContactRequest();
        $form = $this->createForm(ContactRequestType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $message = \Swift_Message::newInstance()
              ->setFrom($contact->emailAddress, $contact->fullName)
              ->setTo('sysadmin@example.com')
              ->setCc($contact->emailAddress)
              ->setReplyTo($contact->emailAddress)
              ->setSubject($contact->subject)
              ->setBody($contact->message);
            
            $this->get('mailer')->send($message);
            
            $this->addFlash('success', 'contact_request.success');
            
            return $this->redirectToRoute('app_contact');
        }
        
        return $this->render(
          'contact.html.twig',
          [
            'form' => $form->createView(),
          ]
        );
    }
}
