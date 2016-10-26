<?php

namespace AppBundle\Controller;

use AppBundle\Birthday\WeekDaysCalendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route(
     *   path="/birthday/{month}/{day}",
     *   name="app_birthday",
     *   requirements={
     *     "month": "0[1-9]|1[0-2]",
     *     "day": "0[1-9]|[1-2][0-9]|3[0-1]"
     *   }
     * )
     * @Method("GET")
     */
    public function birthdayAction($month, $day)
    {
        $calendar = new WeekDaysCalendar();

        return $this->render('birthday.html.twig', [
            'month' => $month,
            'day' => $day,
            'week_days' => $calendar->getCalendar($month, $day),
        ]);
    }

    /**
     * @Route("/hello", name="app_hello")
     * @Method("GET")
     */
    public function helloAction(Request $request)
    {
        $name = $request->attributes->get('name');

        return new Response('Hello '.$name.'!');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
