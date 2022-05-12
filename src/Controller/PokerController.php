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
     *      "/poker",
     *      name="poker"
     * )
     */
    public function startgame(
        SessionInterface $session
    ): Response
    {
        $poker = New PokerGame($session);
        $poker->startGame();
        $hand = $poker->createHand();
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

    
}
