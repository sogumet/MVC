<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\PokerGame;

class PokerController extends AbstractController
{
    /**
     * @Route(
     *      "/poker/test",
     *      name="poker_test"
     * )
     */
    public function testgame(
        SessionInterface $session
    ): Response
    {
        $poker = New PokerGame($session);
        $poker->startGame();
        $hand = $poker->dealCard();
        // var_dump($hand);
        $arr = $hand->checkIfFlush();
        $values = $hand->valueArray();
        $arr1 = $hand->shiftNumberArray();
        $res = $hand->getModulus();
        // $straight = $hand->checkStraight();
        $points = $poker->getPoints();
        
        return $this->render('poker/poker.html.twig', [
        'hand' => $hand,
        'arr' => $arr,
        'values' => $values,
        'arr1' => $arr1,
        'res' => $res,
        'points' => $points,
        // 'straight' => $straight,
    ]);
    }
        /**
         * @Route(
         *      "/poker",
         *      name="poker",
         *      methods={"GET","HEAD"}
         * )
         */
    public function startgame(): Response
    { 
        return $this->render('poker/poker-start.html.twig');
    }

    /**
    * @Route(
    *      "/poker",
    *      name="poker-start",
    *      methods={"POST"}
    * )
    */
    public function startProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $start = $request->request->get('start');
        $game = new PokerGame($session);
        $session->set("game", $game);
        

        if ($start) {
            $game->startGame();
            return $this->redirectToRoute('pokerplay');
        }
        
    }
    /**
     * @Route(
     *      "/poker/play",
     *      name="pokerplay",
     *      methods={"GET","HEAD"}
     * )
     */
    public function session(): Response
    {
        
        return $this->render(
            'poker/poker-game.html.twig',
        );
    }
    /**
         * @Route(
         *      "/poker/play",
         *      name="poker-play",
         *      methods={"POST", "GET"}
         * )
         */
        public function sessionProcess(
            Request $request,
            SessionInterface $session
        ): Response {
            $draw = $request->request->get('draw');
            $hand1 = $request->request->get('hand1');
            $hand2 = $request->request->get('hand2');
            $hand3 = $request->request->get('hand3');
            $hand4 = $request->request->get('hand4');
            $hand5 = $request->request->get('hand5');
            $game = new PokerGame($session);
            $back = "img/deck/back.jpg";
            $cardLeft ='';
             
            if ($draw) {
                $card = $game->dealCard();
                $cardLeft = $game->getCardInDeck();
                return $this->render(
                    'poker/poker-game.html.twig',
                    ['card' => $card,
                    'hand1' => $session->get("hand1"),
                    'hand2' => $session->get("hand2"),
                    'hand3' => $session->get("hand3"),
                    'hand4' => $session->get("hand4"),
                    'hand5' => $session->get("hand5"),
                    'cardLeft' => $cardLeft,
                    ]
                );
            }
            if ($hand1) {
                $game->saveCard(1);
            }
            if ($hand2) {
                $game->saveCard(2);
            }
            if ($hand3) {
                $game->saveCard(3);
            }
            if ($hand4) {
                $game->saveCard(4);
            }
            if ($hand5) {
                $game->saveCard(5);
            }
            return $this->render(
                'poker/poker-game.html.twig',
                [
                'hand1' => $session->get("hand1"),
                'hand2' => $session->get("hand2"),
                'hand3' => $session->get("hand3"),
                'hand4' => $session->get("hand4"),
                'hand5' => $session->get("hand5"),
                'cardLeft' => $cardLeft,
                ]
            );

            return $this->redirectToRoute('pokerplay');
        }
}
