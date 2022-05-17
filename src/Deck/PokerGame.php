<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Deck\Deck;
use App\Deck\PokerHand;
use App\Repository\ScoreRepository;
use Doctrine\Persistence\ManagerRegistry;
class PokerGame
{

    private object $deck;
    public object $hand;
    private object $session;
    private object $card;
    private array $fullHands = [];

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

    public function dealCard(): object
    {
        
        $this->deck = $this->session->get("deck");
        $this->card = $this->deck->drawCard();
        $this->session->set("card", $this->card);
        return $this->card;
    }

    public function saveCard($hand): bool
    {
        {
            $this->card = $this->session->get("card");
            switch($hand) {
                case 1;
                    $this->hand1 = $this->session->get("hand1");
                    $this->hand1->addCard($this->card);
                    return $this->checkIfFullHand($this->hand1);
                    break;
                case 2;
                    $this->hand2 = $this->session->get("hand2");
                    $this->hand2->addCard($this->card);
                    return $this->checkIfFullHand($this->hand2);
                    break;
                case 3;
                    $this->hand3 = $this->session->get("hand3");
                    $this->hand3->addCard($this->card);
                    return $this->checkIfFullHand($this->hand3);
                    break;
                case 4;
                    $this->hand4 = $this->session->get("hand4");
                    $this->hand4->addCard($this->card);
                    return $this->checkIfFullHand($this->hand4);
                    break;
                case 5;
                    $this->hand5 = $this->session->get("hand5");
                    $this->hand5->addCard($this->card);
                    return $this->checkIfFullHand($this->hand5);
                    break;
            }
        }
    }

    public function test(): void
    {
        for($i = 0; $i < 5; $i++)
        {
            for($k = 1; $k < 6; $k++) {
                $card = $this->dealCard();
                $this->saveCard($k);            }
        }
    }

    public function getCardIndeck(): int 
    {
        $this->deck = $this->session->get("deck");
            $cardLeft = $this->deck->cardCount();
        return $cardLeft;
    }

    public function checkIfFullHand($hand): bool
    {
            $amount = $hand->cardCount();
        return $amount == 5;
    }

    public function checkIfAllFullHand($hand)
    {
        $this->fullHands = $this->session->get("fullHands");
        $this->fullHands[] = $hand;
        $this->session->set("fullHands", $this->fullHands);
        if(count($this->fullHands) == 5) {
            $this->getTotalScore();
            $this->session->set("allFull", true);
        }
    }
    
    private function checkFlushOrStraight($hand): int
    {
        if ($hand->getModulus() ==  5) {
            if($hand->checkStraight() and $hand->checkIfFlush())
            {
                return 15;
            }
            elseif($hand->checkStraight()) 
            {
                return 4;    
            }
            elseif($hand->checkIfFlush()) 
            {
                return 5;    
            }
        }
        return 0;
    }
    
    public function getPoints($hand): int
    {
        $res = $this->checkFlushOrStraight($hand);
        if($res != 0) {
            return $res;
        }

        $res = $hand->getModulus();
        {
            switch($res) {
                case 1;
                    return 10;
                    break;
                case 6;
                    return 1;
                    break;
                case 7;
                    return 2;
                    break;
                case 9;
                    return 3;
                    break;
                case 10;
                    return 8;
                    break;
            }
        }
        return 0;
    }

    public function getTotalScore(): void
    {
        $score = $this->session->get('point1') + $this->session->get('point2')
        + $this->session->get('point3') + $this->session->get('point4') +
        $this->session->get('point5');
        $this->session->set('score', $score);
    
    }

    public function saveScore(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $score = new Score();
        $value = $this->session->get('score');
        $score->setScore($value);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($score);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('pokerplay');
    }
}
