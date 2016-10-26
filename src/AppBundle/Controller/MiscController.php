<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
    /**
     * @Route("/contact", name="app_contact")
     * @Method("GET|POST")
     */
    public function contactAction()
    {
        //return $this->render('contact.html.twig');
    }
}
