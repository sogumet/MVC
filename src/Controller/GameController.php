<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Game;

class GameController extends AbstractController
{
    /**
     * @Route(
     *      "/game",
     *      name="game",
     *      methods={"GET","HEAD"}
     * )
     */
    public function startgame(): Response
    {
        return $this->render('deck/game-start.html.twig');
    }

    /**
    * @Route(
    *      "/game",
    *      name="game-start",
    *      methods={"POST"}
    * )
    */
    public function startProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $start = $request->request->get('start');
        $game = new Game($session);

        if ($start) {
            $game->startGame();
        }
        return $this->redirectToRoute('gameplay');
    }

    /**
     * @Route(
     *      "/game/play",
     *      name="gameplay",
     *      methods={"GET","HEAD"}
     * )
     */
    public function session(): Response
    {
        $jscrpt = "jscrpt";
        return $this->render(
            'deck/game.html.twig',
            ['jscrpt' => $jscrpt]
        );
    }

    /**
     * @Route(
     *      "/game/play",
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
        $game = new Game($session);
        $jscrpt = 0;
        if ($draw) {
            $game->playerDrawCard();
            if ($game->sum > 21) {
                $this->addFlash("info", "Bust! Bank wins");
                $jscrpt = 1;
            }
        } elseif ($stay) {
            $game->drawBank();

            if ($game->sumbank >= $game->sum && $game->sumbank < 22) {
                $this->addFlash("info", $game->sumbankAsString());
                $this->addFlash("info", "Bank is the winner");
                $jscrpt = 1;
            }
            if ($game->sumbank > 21 || $game->sumbank < $game->sum) {
                $this->addFlash("info", $game->sumbankAsString());
                $this->addFlash("info", "You are the winner");
                $jscrpt = 1;
            }
        } elseif ($clear) {
            $game->startGame();

            return $this->redirectToRoute('gameplay');
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
            'jscrpt' => $jscrpt
            ]
        );
    }

    /**
    * @Route("/game/doc", name="game-doc")
    */
    public function number(): Response
    {
        return $this->render('deck/game-doc.html.twig');
    }
}
