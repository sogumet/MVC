<?php

/*
 * This file is part of the PokerGame and the Game.
 * Contaning the Deck Class
 * (c) Sogum <sogum@live.com>
 *
 */

namespace App\Deck;

class Deck
{
    private array $suits = array("clubs", "diamonds", "spades", "hearts");
    private array $cardSuit = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
    public array $deck;

    /**
    * Deck class constructor.
    */
    public function __construct()
    {
        $rank = 1;
        foreach ($this->suits as $suit) {
            $value = 2;
            foreach ($this->cardSuit as $card) {
                $newCard = new Card();
                $newCard->setSuit($suit);
                $newCard->setValue($value);
                $newCard->setImage('img/deck/' . $card . '-' . $suit . '.png');
                $rank++;
                $value++;
                $this->deck[] = $newCard;
            }
        }
    }

    /**
    * Shuffles the deck object.
    */
    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    /**
    * Getting a card object from the deck object.
    */
    public function drawCard(): object
    {
        $card = array_shift($this->deck);

        return $card;
    }

    /**
    * Counting remaining cards in deck object.
    */
    public function cardCount(): int
    {
        return count($this->deck);
    }

    /**
    * Getting a number of cards from the deck object.
    * @param int
    */
    public function drawCards(int $number): array
    {
        $cards = array();
        for ($number; $number >= 0; $number--) {
            $card = array_shift($this->deck);
            $cards[] = $card;
        }

        return $cards;
    }

    /**
    * Getting a specific card from the deck object.
    * @param int
    * @param string
    */
    public function getCard(int $value, string $suit): object
    {
        $card = array_filter($this->deck,
        function ($e) use (&$value, &$suit){
            return ($e->getValue() == $value and $e->getSuit() == $suit);
        });

        return array_pop($card);
    }
}
