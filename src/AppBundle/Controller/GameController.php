<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

/**
 * Class GameController
 * @package AppBundle\Controller
 * @Route("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("", name="app_game_play")
     * @Method("GET")
     */
    public function playAction()
    {
        return $this->render('game/play.html.twig');
    }
    
    /**
     * @Route("/reset", name="app_game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        return $this->redirectToRoute("app_game_play");
    }
    
    /**
     * @Route(
     *   "/play/{letter}",
     *   name="app_game_try_letter",
     *   requirements={
     *     "letter": "[a-z]"
     *   }
     * )
     * @Method("GET")
     */
    public function tryLetterAction($letter)
    {
        
        return $this->redirectToRoute("app_game_play");
    }
    
    /**
     * @Route(
     *   path="/play",
     *   name="app_game_try_word",
     *   condition="request.request.get('word') matches '/^[a-z]{2,}$/i'"
     * )
     * @Method("POST")
     */
    public function tryWordAction(Request $request)
    {
        if (!$word = $request->request->get('word')) {
            throw $this->createNotFoundException('No word entered');
        }
        
        return $this->redirectToRoute("app_game_play");
    }
    
    /**
     * @Route("/fail", name="app_game_fail")
     * @Method("GET")
     */
    public function failAction()
    {
        
        return $this->render('game/fail.html.twig');
    }
    
    /**
     * @Route("/win", name="app_game_win")
     * @Method("GET")
     */
    public function winAction()
    {
        
        return $this->render('game/win.html.twig');
    }
    
    public function listMostRecentAction()
    {
        
        return $this->render('game/sidebar.html.twig');
    }
    
}
