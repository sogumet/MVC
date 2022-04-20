<?php

namespace App\Deck;

class Hand
{
    public array $hand = [];

    public function addCards(array $cards): void
    {
        foreach ($cards as $value) {
            $this->hand[] = $value;
        }
    }
    public function cardCount(): int
    {
        return count($this->hand);
    }

    public function addCard(object $card): void
    {
        $this->hand[] = $card;
    }
}
