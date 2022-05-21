<?php

/*
 * This file is part of the Game and contains the Deck2 Class
 * extending the deck class
 * (c) Sogum <sogum@live.com>
 *
 */
namespace App\Deck;

class Deck2 extends Deck
{
    /**
    * Deck2 class constructor.
    */
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
