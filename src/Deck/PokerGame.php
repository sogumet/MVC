<?php

/*
 * This file is part of the PokerGame.
 * Contaning the PokerGame class.
 *
 * (c) Sogum <sogum@live.com>
 *
 */
namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Deck\Deck;
use App\Deck\PokerHand;
use App\Repository\ScoreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class PokerGame
{
    private object $deck;
    private object $hand1;
    private object $hand2;
    private object $hand3;
    private object $hand4;
    private object $hand5;
    public object $session;
    private object $card;
    private array $fullHands = [];

    /**
    * Deck class constructor.
    *@param session
    */
    public function __construct($session)
    {
        $this->deck = new Deck();
        $this->hand1 = new PokerHand();
        $this->hand2 = new PokerHand();
        $this->hand3 = new PokerHand();
        $this->hand4 = new PokerHand();
        $this->hand5 = new PokerHand();
        $this->session = $session;
    }

    /**
    * Starts the Pokergame.
    */
    public function startGame(): void
    {
        $this->session->clear();
        $this->session->set("hand1", $this->hand1);
        $this->session->set("hand2", $this->hand2);
        $this->session->set("hand3", $this->hand3);
        $this->session->set("hand4", $this->hand4);
        $this->session->set("hand5", $this->hand5);
        $this->session->set("deck", $this->deck);
        $this->session->set("fullHands", $this->fullHands);
        $this->deck->shuffleDeck();
    }

    /**
    * Getting a card object from deck object
    * and saves it in the session.
    */
    public function dealCard(): object
    {

        $this->deck = $this->session->get("deck");
        $this->card = $this->deck->drawCard();
        $this->session->set("card", $this->card);
        return $this->card;
    }

    /**
    * Getting a card object from the session
    * and saves it in a hand object.
    *@param object
    *@SuppressWarnings(PHPMD.CyclomaticComplexity)
    */
    public function saveCard($hand): void
    {
        {
            $this->card = $this->session->get("card");
        switch ($hand) {
            case 1:
                $this->hand1 = $this->session->get("hand1");
                $this->hand1->addCard($this->card);
                if ($this->checkIfFullHand($this->hand1)) {
                    $this->fullHandProcess(1);
                }
                break;
            case 2:
                $this->hand2 = $this->session->get("hand2");
                $this->hand2->addCard($this->card);
                if ($this->checkIfFullHand($this->hand2)) {
                    $this->fullHandProcess(2);
                }
                break;
            case 3:
                $this->hand3 = $this->session->get("hand3");
                $this->hand3->addCard($this->card);
                if ($this->checkIfFullHand($this->hand3)) {
                    $this->fullHandProcess(3);
                }
                break;
            case 4:
                $this->hand4 = $this->session->get("hand4");
                $this->hand4->addCard($this->card);
                if ($this->checkIfFullHand($this->hand4)) {
                    $this->fullHandProcess(4);
                }
                break;
            case 5:
                $this->hand5 = $this->session->get("hand5");
                $this->hand5->addCard($this->card);
                if ($this->checkIfFullHand($this->hand5)) {
                    $this->fullHandProcess(5);
                }
                break;
        }
        }
    }

    /**
    * Test function to create a  5 full hands.
    */
    public function test(): void
    {
        for ($i = 0; $i < 5; $i++) {
            for ($k = 1; $k < 6; $k++) {
                $this->dealCard();
                $this->saveCard($k);
                $this->checkIfAllFullHand("hand");
            }
        }
    }

    /**
    * Sets full hand flag in session, sets hands score
    * in session and checks if all hands are full.
    *@param int
    */
    public function fullHandProcess($hand): void
    {
        switch ($hand) {
            case 1:
                $this->session->set("flag1", true);
                $hand = $this->session->get("hand1");
                $points = $this->getPoints($hand);
                $this->session->set("point1", $points);
                $this->checkIfAllFullHand("full");
                break;
            case 2:
                $this->session->set("flag2", true);
                $hand = $this->session->get("hand2");
                $points = $this->getPoints($hand);
                $this->session->set("point2", $points);
                $this->checkIfAllFullHand("full");
                break;
            case 3:
                $this->session->set("flag3", true);
                $hand = $this->session->get("hand3");
                $points = $this->getPoints($hand);
                $this->session->set("point3", $points);
                $this->checkIfAllFullHand("full");
                break;
            case 4:
                $this->session->set("flag4", true);
                $hand = $this->session->get("hand4");
                $points = $this->getPoints($hand);
                $this->session->set("point4", $points);
                $this->checkIfAllFullHand("full");
                break;
            case 5:
                $this->session->set("flag5", true);
                $hand = $this->session->get("hand5");
                $points = $this->getPoints($hand);
                $this->session->set("point5", $points);
                $this->checkIfAllFullHand("full");
                break;
        }
    }
    /**
    * Counting remaining card objects in the deck object
    */
    public function getCardIndeck(): int
    {
        $this->deck = $this->session->get("deck");
            $cardLeft = $this->deck->cardCount();
        return $cardLeft;
    }

    /**
    * Checking if the hand object contains 5 card objects.
    * @param object
    */
    public function checkIfFullHand($hand): bool
    {
            $amount = $hand->cardCount();
        return $amount == 5;
    }

    /**
    * Checking if all the hand object contains 5 card objects.
    * @param object
    */
    public function checkIfAllFullHand($hand): void
    {
        $this->fullHands = $this->session->get("fullHands");
        $this->fullHands[] = $hand;
        $this->session->set("fullHands", $this->fullHands);
        if (count($this->fullHands) == 5) {
            $this->getTotalScore();
            $this->session->set("allFull", true);
        }
    }

    /**
    * Checking if the hand object is a flush or straight.
    * @param object
    */
    public function checkFlushOrStraight($hand): int
    {
        if ($hand->getModulus() ==  5) {
            if ($hand->checkStraight() and $hand->checkIfFlush()) {
                return 15;
            } elseif ($hand->checkStraight()) {
                return 4;
            } elseif ($hand->checkIfFlush()) {
                return 5;
            }
        }
        return 0;
    }

    /**
    * Getting the points for the hand object.
    * @param object
    */
    public function getPoints($hand): int
    {
        $res = $this->checkFlushOrStraight($hand);
        if ($res != 0) {
            return $res;
        }

        $res = $hand->getModulus();
        {
        switch ($res) {
            case 1:
                return 10;
                break;
            case 6:
                return 1;
                break;
            case 7:
                return 2;
                break;
            case 9:
                return 3;
                break;
            case 10:
                return 8;
                break;
        }
        }
        return 0;
    }

    /**
    * Getting the total score from all 5 hands.
    */
    public function getTotalScore(): void
    {
        $score = $this->session->get('point1') + $this->session->get('point2')
        + $this->session->get('point3') + $this->session->get('point4') +
        $this->session->get('point5');
        $this->session->set('score', $score);
    }

    /**
    * Saving the total score in database.
    * Getting it from the session
    */
    public function saveScore(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        /** @phpstan-ignore-next-line */
        $score = new Score();
        $value = $this->session->get('score');
        $score->setScore($value);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($score);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('success');
    }
}
