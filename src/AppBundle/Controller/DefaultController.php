<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route(
     *     "/hello/{name}",
     *     name="app_hello",
     *     defaults={"name" = "you"}
     *     )
     * @Method("GET")
     */
    public function helloAction(Request $request, $name)
    {
        
        // Every variable available is in the request object
        // This is the same as passing $name into the function call
        $name = $request->attributes->get('name');
        
        // See all attributes
//        var_dump($request->attributes);
        var_dump($request->headers);
        
        // Query strings use request->query
        // returns null if no query string
        $page = $request->query->get('page');
        
        // I just want a number
        $page = $request->query->getInt('page');
        
        // I also want to set a default
        $page = $request->query->getInt('page', 1);
        
        echo "Page: ".$page."<br>";
        echo "Type: ".gettype($page)."<br>";
        
        return new Response("Hello World, ".$name."!");
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
          'default/index.html.twig',
          [
            'base_dir' => realpath(
                $this->getParameter('kernel.root_dir').'/..'
              ).DIRECTORY_SEPARATOR,
          ]
        );
    }
    
    /**
     * @Route(
     *     "/birthday/{month}/{day}",
     *     name="app_birthday",
     *     requirements={
     *          "month": "0[1-9]|1[0-2]",
     *          "day": "0[1-9]|[1-2][0-9]|3[0-1]"
     *      }
     * )
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function birthdayAction($month, $day)
    {
        
        $weekDays = [];
        $current = (int)date('Y');
        $last = $current + 10;
        
        for ($year = $current; $year <= $last; $year++) {
            
            $date = checkdate($month, $day, $year);
            // If date doesn't exist
            if (!$date) {
                throw $this->createNotFoundException('Dat ain\'t no birfday');
            }
            $weekDays[$year] = date('l', mktime(0, 0, 0, $month, $day, $year));
        }
        
        return $this->render(
          'birthday.html.twig',
          [
            'month' => $month,
            'day' => $day,
            'week_days' => $weekDays,
          ]
        );
        
    }
}
