<?php

namespace App\Deck;

class Deck2 extends Deck
{
    public function __construct()
    {
        parent::__construct();

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
