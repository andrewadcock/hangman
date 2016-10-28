<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserAccount;
use AppBundle\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/signup", name="app_signup")
     * @Method("GET|POST")
     */
    public function signupAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', 'user_account.registration.success');
            
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('/user/signup.html.twig', [
          'form' => $form->createView(),
        ]);
    }
    
    
    public function listMostRecentAction()
    {
        
        $users = $this
          ->getDoctrine()
          ->getRepository(UserAccount::class)
          ->findMostRecentUsers()
        ;
        
        return $this->render(
          '/user/sidebar.html.twig',
          [
            'users' => $users,
          ]
        );
    }
}
