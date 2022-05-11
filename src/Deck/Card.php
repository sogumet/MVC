<?php

namespace App\Deck;

class Card
{
    private string $suit;       // The suit of the card
    private int $value;    // The ranking of card in suit
    private string $image;      // The image for this card

    public function setSuit(string $aSuit): void
    {
        $this->suit = $aSuit;
    }
    public function setValue(int $aValue): void
    {
        $this->value = $aValue;
    }
    public function setImage(string $aImage): void
    {
        $this->image = $aImage;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getimage(): string
    {
        return $this->image;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
}
