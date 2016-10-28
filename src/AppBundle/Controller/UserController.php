<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserAccount;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/signup", name="app_signup")
     * @Method("GET|POST")
     */
    public function signUpAction(Request $request)
    {
        return $this->render('/user/sign.html.twig');
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
