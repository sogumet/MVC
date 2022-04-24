<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class Guess.
 */
class DeckTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateDeckObject()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
    }

    /**
     * Create object and testing drawCard function
     */
    public function testDrawCard()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $exp = $deck->deck[0];
        $res = $deck->drawCard();
        $this->assertEquals($exp, $res);
    }

    /**
     * Create object and testing cardCount function
     */
    public function testCardCount()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $deck->drawCards(9);
        $exp = 42;
        $res = $deck->cardCount();
        $this->assertEquals($exp, $res);
    }

    /**
     * Create object and testing shuffleDeck function
     */
    public function testShuffleDeck()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $deck1 = new Deck();
        $deck->shuffleDeck();
        $res = $deck->deck;
        $exp = $deck1->deck;
        $this->assertSamesize($exp, $res);
    }
}
