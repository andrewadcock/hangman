<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="app_login")
     * @Method("GET")
     */
    public function loginAction()
    {
        $utils = $this->get('security.authentication_utils');
        
        return $this->render(
          'login.html.twig',
          [
            'last_username' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError(),
          ]
        );
    }
    
    /**
     * @Route("/login/check", name="app_login_check")
     * @Method("GET|POST")
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * @Route("/logout", name="app_logout")
     * @Method("GET")
     */
    public function logoutAction()
    {
    }
    
    
}
