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
        return $this->render('login.html.twig');
    }
    
    /**
     * @Route("/login/check", name="app_login_check")
     * @Method("GET")
     */
    public function loginCheckAction()
    {
        return $this->render('login.html.twig');
    }
    
    
}
