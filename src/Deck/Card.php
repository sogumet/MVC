<?php

/*
 * This file is part of the PokerGame and the Game.
 * Contaning the CardClass
 *
 * (c) Sogum <sogum@live.com>
 *
 */
namespace App\Deck;

class Card
{
    private string $suit;       // The suit of the card
    private int $value;    // The ranking of card in suit
    private string $image;      // The image for this card

    /**
     * suit setter
     * @param string
     */
    public function setSuit(string $aSuit): void
    {
        $this->suit = $aSuit;
    }

    /**
     * value setter
     * @param int
     */
    public function setValue(int $aValue): void
    {
        $this->value = $aValue;
    }

    /**
     * image setter
     * @param string
     */
    public function setImage(string $aImage): void
    {
        $this->image = $aImage;
    }

    /**
     * value getter
     * @param int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * image getter
     * @param string
     */
    public function getimage(): string
    {
        return $this->image;
    }

    /**
     * suit getter
     * @param string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }
}
