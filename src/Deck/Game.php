<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game
{
    public $deck;
    public $hand;
    public $bank;
    public $cards;
    public $cardsleft;

    public function __construct($session)
    {
        $this->deck = New Deck();
        $this->hand = New Hand();
        $this->bank = New Hand();
        $this->session = $session;
    }

    public function startGame() {
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
        $this->deck = $this->session->get("deck21");
        $this->deck->shuffleDeck();
    }

    public function drawCard()

    {
        $this->deck = $this->session->get("deck21");
        $this->hand = $this->session->get("hand21");
        $tempCard = $this->deck->drawCard();
        $this->hand->addCard($tempCard);
        $this->cards = $this->hand->cardCount() - 1;
        $this->cardsleft = $this->deck->cardCount();
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
        
    }

}
