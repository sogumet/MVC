<?php

/*
 * This file is part of the PokerGame.
 * Contaning the PokerHand class.
 *
 * (c) Sogum <sogum@live.com>
 *
 */
namespace App\Deck;

class PokerHand
{
    private array $hand = [];

    /**
     * Counting cards in hand object
     */
    public function cardCount(): int
    {
        return count($this->hand);
    }

    /**
     * Adding a card object to hand object
     * @param object
     */
    public function addCard(object $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Getter for the hand object
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Checking if hand object is a flush
     */
    public function checkIfFlush(): bool
    {
        $tmp = array();
        foreach ($this->hand as $card) {
            $tmp[] = $card->getSuit();
        }
        $flush = (count(array_unique($tmp)) === 1);

        return $flush;
    }

    /**
     * Splitting up cards in hand to arrays, cards with same
     * value is placed in different arrays
     */
    public function valueArray(): array
    {
        $tmp = array();
        $arr1 = array();
        $arr2 = array();    // If pair
        $arr3 = array();    // If three of a kind
        $arr4 = array();    // If four of a kind
        $result = array();
        foreach ($this->hand as $card) {
            $tmp[] = $card->getValue();
        }
        for ($i = 0; $i < 5; $i++) {
            $value = array_shift($tmp);
            if (in_array($value, $arr1) == false) {
                $arr1[] = $value;
            } elseif (in_array($value, $arr2) == false) {
                $arr2[] = $value;
            } elseif (in_array($value, $arr3) == false) {
                $arr3[] = $value;
            }
                $arr4[] = $value;
        }
        $result = [$arr1, $arr2, $arr3, $arr4];
        return $result;
    }

    /**
     * Preparing the valueArray for bitwise operation.
     * All cardvalues in same arrays after
     * multiplay operation.
     */
    public function shiftNumberArray(): array
    {
        $resultArr = [];
        $arr = $this->valueArray();
        for ($i = 0; $i < 4; $i++) {
            foreach ($arr[$i] as $value) {
                    $value = $value * 4 + $i ;
                    $resultArr[] = $value;
            }
        }
        return $resultArr;
    }

    /**
     * All values in arr bit shifted
     * and Or Operated. All hand vill
     * be returned as one number.
     */
    public function shifting(): int
    {
        $arr = $this->shiftNumberArray();
        $bit1 = 1;
        $bit2 = 1;
        $bit3 = 1;
        $bit4 = 1;
        $bit5 = 1;

        $bit1 = $bit1 << $arr[0];
        $bit2 = $bit2 << $arr[1];
        $bit3 = $bit3 << $arr[2];
        $bit4 = $bit4 << $arr[3];
        $bit5 = $bit5 << $arr[4];
        $res = $bit1 | $bit2 | $bit3 | $bit4 | $bit5;

        return $res;
    }

    /**
     * Modulus opration on the result from the
     * shifting() function.
     */
    public function getModulus(): int
    {
        $numb = $this->shifting();
        $res = $numb % 15;
        return $res;
    }

    /**
     * Checking if the hand object is a straight
     */
    public function checkStraight(): bool
    {
        $arr = $this->valueArray();
        $arr = $arr[0];
        $bit1 = 1;
        $bit2 = 1;
        $bit3 = 1;
        $bit4 = 1;
        $bit5 = 1;
        $bit1 = $bit1 << $arr[0];
        $bit2 = $bit2 << $arr[1];
        $bit3 = $bit3 << $arr[2];
        $bit4 = $bit4 << $arr[3];
        $bit5 = $bit5 << $arr[4];
        $bit = $bit1 | $bit2 | $bit3 | $bit4 | $bit5;
        $lsb = $bit & (-1 * $bit);
        $res = $bit / $lsb;
        return ($res == 31 or $bit == 16444);
    }

    /* public function checkRoyalStraight(): bool
    {
        $numb = $this->shifting();
        $lsb = $numb & (-1 * $numb);
        $numb = $numb / $lsb;
        $res = ($numb == 11111);
        return $res;
    } */
}
