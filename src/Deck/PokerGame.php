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

    public function createHand() {
        $this->deck = $this->session->get("deck");
        for($i = 0; $i < 5; $i++) {
            $this->card = $this->deck->drawCard();
            $this->hand->addCard($this->card);
        }
        return $this->hand;

    }

    
}
