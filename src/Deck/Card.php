<?php

namespace App\Deck;

class Card
{
    public string $suit;       // The suit of the card
    public int $value;    // The ranking of card in suit
    public int $ace;       // To see if card is ace
    public string $image;      // The image for this card
    public int $rankingAll; // The ranking of card in deck
}
