<?php

namespace App\Deck;

class Deck
{
    public $suits = array("clubs", "diamonds", "spades", "hearts");
    public $cardSuit = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');

    public function __construct($j = 0)
    {
        $rank = 1;
        foreach ($this->suits as $suit) {
            $value = 2;
            foreach ($this->cardSuit as $card) {
                $newCard = new Card();
                $newCard->suit = $suit;
                $newCard->value = $value;
                $newCard->rankingAll = $rank;
                $newCard->image = 'img/deck/' . $card . '-' . $suit . '.png';
                $rank++;
                $value++;
                $this->deck[] = $newCard;
            }
        }
        if ($j != 0) {
            $joker = new Card();
            $joker->suit = 'Joker';
            $joker->value = 0;
            $joker->rankingAll = 0;
            $joker->image = 'img/deck/joker-black.png';
            $this->deck[] = $joker;
            $joker = new Card();
            $joker->suit = 'Joker';
            $joker->value = 0;
            $joker->rankingAll = 0;
            $joker->image = 'img/deck/joker-red.png';
            $this->deck[] = $joker;
        }
    }
    public function shuffleDeck()
    {
        shuffle($this->deck);
    }

    public function drawCard(): object
    {
        $card = array_shift($this->deck);

        return $card;
    }

    public function cardCount()
    {
        return count($this->deck);
    }

    public function drawCards($number)
    {
        for ($number; $number >= 0; $number--) {
            $card = array_shift($this->deck);
            $cards[] = $card;
        }

        return $cards;
    }
}
