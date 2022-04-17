<?php

namespace App\Deck;

class Hand
{
    public $hand = [];

    public function addCards($cards)
    {
        foreach ($cards as $value) {
            $this->hand[] = $value;
        }
    }
    public function cardCount(): int
    {
        return count($this->hand);
    }

    public function addCard($card)
    {
        $this->hand[] = $card;
    }
}
