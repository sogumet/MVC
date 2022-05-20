<?php

namespace App\Deck;

class Deck
{
    private array $suits = array("clubs", "diamonds", "spades", "hearts");
    private array $cardSuit = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
    public array $deck;

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

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function drawCard(): object
    {
        $card = array_shift($this->deck);

        return $card;
    }

    public function cardCount(): int
    {
        return count($this->deck);
    }

    public function drawCards(int $number): array
    {
        $cards = array();
        for ($number; $number >= 0; $number--) {
            $card = array_shift($this->deck);
            $cards[] = $card;
        }

        return $cards;
    }

    public function getCard(int $value, string $suit): object
    {
        $card = array_filter($this->deck,
        function ($e) use (&$value, &$suit){
            return ($e->getValue() == $value and $e->getSuit() == $suit);
        });

        return array_pop($card);
    }
}
