<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
        
        $game = $this->get('app.game_runner')->loadGame();
        
        return $this->render(
          'game/play.html.twig',
          [
            'game' => $game,
          ]
        );
    }
    
    /**
     * @Route("/reset", name="app_game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $$this->get('app.game_runner')->resetGame();
        
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
        $game = $this->get('app.game_runner')->playLetter($letter);
        
        if (!$game->isOver()) {
            return $this->redirectToRoute("app_game_play");
        }
        
        return $this->redirectToRoute(
          $game->isWon() ? 'app_game_win' : 'app_game_fail'
        );
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
        $game =
          $this->get('app.game_runner')
            ->playWord($request->request->get('word'));
        
        
        return $this->redirectToRoute(
          $game->isWon() ? 'app_game_win' : 'app_game_fail'
        );
    }
    
    /**
     * @Route("/fail", name="app_game_fail")
     * @Method("GET")
     */
    public function failAction()
    {
        $game = $this->get('app.game_runner')->resetGameOnFailure();
        
        return $this->render(
          'game/fail.html.twig',
          [
            'game' => $game,
          ]
        );
    }
    
    /**
     * @Route("/win", name="app_game_win")
     * @Method("GET")
     */
    public function winAction()
    {
        $game = $this->get('app.game_runner')->resetGameOnSuccess();
        
        return $this->render(
          'game/win.html.twig',
          [
            'game' => $game,
          ]
        );
    }
    
    public function listMostRecentAction()
    {
        
        return $this->render('game/sidebar.html.twig');
    }
}
