<?php

namespace App\Deck;

class Hand
{
    private $hand = [];

    public function addCards($cards): array
    {
        foreach ($cards as $value) {
            $hand[] = $value;
        }

        return $hand;
    }
    public function cardCount()
    {
        return count($this->hand);
    }

}
