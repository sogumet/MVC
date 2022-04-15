<?php

namespace App\Deck;

class Deck
{
    private $suits = array("clubs", "diamonds", "spades", "hearts");
    private $cardSuit = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');

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
                $newCard->image = 'img/deck/' . $card . '-' . $suit . '.png';
                ;
                if($value == 14)
                {
                    $newCard->ace = TRUE; 
                }
                else {
                    $newCard->ace = FALSE; 
                }
                $rank++;
                $value++;
                $this->deck[] = $newCard;
            }
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
