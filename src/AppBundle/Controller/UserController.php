<?php

namespace AppBundle\Controller;

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
        $users = [
          ['username' => 'Homer'],
          ['username' => 'Marge'],
          ['username' => 'Maggie'],
          ['username' => 'Lisa'],
          ['username' => 'Bart'],
        ];
        
        shuffle($users);
        
        return $this->render(
          '/user/sidebar.html.twig',
          [
            'users' => $users,
          ]
        );
    }
}
