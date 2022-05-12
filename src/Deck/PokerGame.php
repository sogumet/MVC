<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Deck;
use App\Deck\PokerHand;

class PokerGame
{

    private object $deck;
    private object $hand;
    private $session;
    private $card;

    public function __construct($session)
    {
        $this->deck = new Deck();
        $this->hand = new PokerHand();
        $this->session = $session;
    }

    public function startGame(): void
    {
        $this->session->clear();
        $this->session->set("hand", $this->hand);
        $this->deck->shuffleDeck();
        $this->session->set("deck", $this->deck);
    }

    public function createHand(): object 
    {
        $this->deck = $this->session->get("deck");
        for($i = 0; $i < 5; $i++) {
            $this->card = $this->deck->drawCard();
            $this->hand->addCard($this->card);
    }
        return $this->hand;

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
