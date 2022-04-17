<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    /**
     * @Route(
     *      "/game",
     *      name="game",
     *      methods={"GET","HEAD"}
     * )
     */
    public function session(): Response
    {
        $js = "js";
        return $this->render('deck/game.html.twig',
    ['js' => $js]);
    }

    /**
     * @Route(
     *      "/game",
     *      name="game-process",
     *      methods={"POST"}
     * )
     */
    public function sessionProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $draw = $request->request->get('draw');
        $stay = $request->request->get('stay');
        $clear = $request->request->get('clear');
        $start = $request->request->get('start');
        $game = new \App\Deck\Game($session);
        $js = 0;

        if ($start) {
            $game->startGame();
            

            return $this->render('deck/game.html.twig',
        ['js' => $js]);
        } elseif ($draw) {
            $game->drawCard();
            var_dump("Sum" ,$game->sum);
            if($game->sum > 21) {
                $this->addFlash("info", "You lost");
                $js = 1;
            }  
        } elseif ($stay) {
            $game->drawBank();
            
            if($game->sumbank >= $game->sum && $game->sumbank < 22) {
                $this->addFlash("info", $game->sumbankAsString());
                $this->addFlash("info", "Bank wins");
                $js = 1;
            } if ($game->sumbank > 21 || $game->sumbank < $game->sum) { 
                $this->addFlash("info", $game->sumbankAsString());
                $this->addFlash("info", "You wins");
                $js = 1;
                }
        } elseif ($clear) {
            $game->clearGame();

            return $this->render('deck/game.html.twig');
        }
        return $this->render(
            'deck/game.html.twig',
            ['data' => $game->hand,
            'bank' => $game->bank,
            'sum' => $game->sum,
            'sumbank' => $game->sumbank,
            'cards' => $game->cards,
            'bankcards' => $game->bankcards,
            'cardsleft' => $game->cardsleft,
            'js' => $js
            ]
        );
    }
}
