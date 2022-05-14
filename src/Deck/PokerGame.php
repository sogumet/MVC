<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Deck;
use App\Deck\PokerHand;

class PokerGame
{

    private object $deck;
    public object $hand;
    private $session;
    private $card;
    private $cardInHand;

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


    private function checkFlushOrStraight(): int
    {
        if ($this->hand->getModulus() ==  5) {
            if($this->hand->checkStraight() and $this->hand->checkIfFlush())
            {
                return 20;
            }
            elseif($this->hand->checkStraight()) 
            {
                return 4;    
            }
            elseif($this->hand->checkIfFlush()) 
            {
                return 5;    
            }
        }
        return 0;
    }
    
    public function getPoints(): int
    {
        $res = $this->checkFlushOrStraight();
        if($res != 0) {
            return $res;
        }

        $res = $this->hand->getModulus();
        {
            switch($res) {
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
                    return 10;
                    break;
            }
        }
        return 0;
    }
}
