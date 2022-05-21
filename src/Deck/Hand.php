<?php

/*
 * This file is part of the Game.
 * Contaning the Hand Class
 *
 * (c) Sogum <sogum@live.com>
 *
 */
namespace App\Deck;

class Hand
{
    public array $hand = [];

    /**
     * Adding a numbers of cards to hand object.
     * @param array
     */
    public function addCards(array $cards): void
    {
        foreach ($cards as $value) {
            $this->hand[] = $value;
        }
    }

    /**
     * Counting cards in hand object
     * @param array
     */
    public function cardCount(): int
    {
        return count($this->hand);
    }

    /**
     * Adding a card to hand object
     * @param array
     */
    public function addCard(object $card): void
    {
        $this->hand[] = $card;
    }
}
