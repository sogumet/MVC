<?php

namespace App\Deck;

class Deck
{
    public $suits = array("clubs", "diamonds", "spades", "hearts");
    public $cardSuit = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');

    public function __construct()
    {
        $rank = 1;
        foreach ($this->suits as $suit) {
            $value = 2;
            foreach ($this->cardSuit as $card) {
                $newCard = new Card();
                $newCard->suit = $suit;
                $newCard->value = $value;
                $newCard->rankingAll = $rank;
                $newCard->image = '/img/deck/' . $card . '-' . $suit . '.png';
                $rank++;
                $value++;
                $this->deck[] = $newCard;
            }
        }
    }
    public function shuffleDeck() {
        shuffle($this->deck);
    }
}
