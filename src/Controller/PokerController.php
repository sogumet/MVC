<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Score;
use App\Repository\ScoreRepository;

use Doctrine\Persistence\ManagerRegistry;
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
            SessionInterface $session,
            ManagerRegistry $doctrine,
            ScoreRepository $scoreRepository,
        ): Response {
            $reset = $request->request->get('reset');
            $draw = $request->request->get('draw');
            $hand1 = $request->request->get('hand1');
            $hand2 = $request->request->get('hand2');
            $hand3 = $request->request->get('hand3');
            $hand4 = $request->request->get('hand4');
            $hand5 = $request->request->get('hand5');
            $test = $request->request->get('test');
            $flag1 = $session->get("flag1") ? true : false;
            $flag2 = $session->get("flag2") ? true : false;
            $flag3 = $session->get("flag3") ? true : false;
            $flag4 = $session->get("flag4") ? true : false;
            $flag5 = $session->get("flag5") ? true : false;
            $game = new PokerGame($session);
            $back = "img/deck/back.jpg";
             
            if ($draw) {
                $card = $game->dealCard();
                $cardLeft = $game->getCardInDeck();
                $session->set("cardLeft", $cardLeft);
                return $this->render(
                    'poker/poker-game.html.twig',
                    ['card' => $card,
                    'hand1' => $session->get("hand1"),
                    'hand2' => $session->get("hand2"),
                    'hand3' => $session->get("hand3"),
                    'hand4' => $session->get("hand4"),
                    'hand5' => $session->get("hand5"),
                    'flag1' => $flag1,
                    'flag2' => $flag2,
                    'flag3' => $flag3,
                    'flag4' => $flag4,
                    'flag5' => $flag5,
                    ]
                );
            }
            if ($reset) {
                $game->startGame();
                return $this->redirectToRoute('pokerplay');
            }
            if ($hand1) {
                if($game->saveCard(1))
                {
                    $session->set("flag1", true);
                    $flag1 = true;
                    $hand = $session->get("hand1");
                    $points = $game->getPoints($hand);
                    $session->set("point1", $points);
                    $game->checkIfAllFullHand("full");
                }
            }
            if ($hand2) {
                if($game->saveCard(2))
                {
                    $session->set("flag2", true);
                    $flag2 = true;
                    $hand = $session->get("hand2");
                    $points = $game->getPoints($hand);
                    $session->set("point2", $points);
                    $game->checkIfAllFullHand("full");
                }
            }
            if ($hand3) {
                if($game->saveCard(3))
                {
                    $session->set("flag3", true);
                    $flag3 = true;
                    $hand = $session->get("hand3");
                    $points = $game->getPoints($hand);
                    $session->set("point3", $points);
                    $fullHand = $game->checkIfAllFullHand("full");
                }
            }
            if ($hand4) {
                if($game->saveCard(4))
                {
                    $session->set("flag4", true);
                    $flag4 = true;
                    $hand = $session->get("hand4");
                    $points = $game->getPoints($hand);
                    $session->set("point4", $points);
                    $fullHand = $game->checkIfAllFullHand("full");
                }
            }
            if ($hand5) {
                if($game->saveCard(5))
                {
                    $session->set("flag5", true);
                    $flag5 = true;
                    $hand = $session->get("hand5");
                    $points = $game->getPoints($hand);
                    $session->set("point5", $points);
                    $fullHand = $game->checkIfAllFullHand("full");
                }
            }
            if ($test) {
                $game->test();
                $session->set("flag1", true);
                    $flag1 = true;
                    $hand = $session->get("hand1");
                    $points = $game->getPoints($hand);
                    $session->set("point1", $points);
                    $session->set("flag2", true);
                    $flag2 = true;
                    $hand = $session->get("hand2");
                    $points = $game->getPoints($hand);
                    $session->set("point2", $points);
                    $session->set("flag3", true);
                    $flag3 = true;
                    $hand = $session->get("hand3");
                    $points = $game->getPoints($hand);
                    $session->set("point3", $points);
                    $session->set("flag4", true);
                    $flag4 = true;
                    $hand = $session->get("hand4");
                    $points = $game->getPoints($hand);
                    $session->set("point4", $points);
                    $session->set("flag5", true);
                    $flag5 = true;
                    $hand = $session->get("hand5");
                    $points = $game->getPoints($hand);
                    $session->set("point5", $points);
                    for($i = 0; $i < 5; $i++) {
                        $fullHand = $game->checkIfAllFullHand("full");
                
                    }
                            $entityManager = $doctrine->getManager();
                            $score = new Score();
                            $value = $session->get("score");
                            $score->setScore($value);
                            $entityManager->persist($score);                    
                            $entityManager->flush();
                            $highScore = $scoreRepository->findHighScore();
                            $session->set('highScore', $highScore);
                    
                        } 
                    
                   
                    

            return $this->render(
                'poker/poker-game.html.twig',
                [
                'hand1' => $session->get("hand1"),
                'hand2' => $session->get("hand2"),
                'hand3' => $session->get("hand3"),
                'hand4' => $session->get("hand4"),
                'hand5' => $session->get("hand5"),
                'flag1' => $flag1,
                'flag2' => $flag2,
                'flag3' => $flag3,
                'flag4' => $flag4,
                'flag5' => $flag5,
                ]
            );

            return $this->redirectToRoute('pokerplay');
        }

    }

