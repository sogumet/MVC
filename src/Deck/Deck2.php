<?php

namespace App\Deck;

class Deck2 extends Deck
{
    public function __construct()
    {
        parent::__construct();

        $joker = new Card();
        $joker->setSuit('Joker');
        $joker->setValue(0);
        $joker->setImage('img/deck/joker-black.png');
        $this->deck[] = $joker;
        $joker = new Card();
        $joker->setSuit('Joker');
        $joker->setValue(0);
        $joker->setImage('img/deck/joker-red.png');
        $this->deck[] = $joker;
    }
}
