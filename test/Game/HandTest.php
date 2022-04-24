<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class Guess.
 */
class HandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateHandObject()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
    }

    /**
     * Create object and testing addCard function
     */
    public function testAddCards()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $cards =  $deck->drawCards(0);
        $hand->addCards($cards);
        $exp = $cards[0];
        $res = $hand->hand[0];
        $this->assertEquals($exp, $res);
    }

    /**
     * Create object and testing cardCount function
     */
    public function testCardCount()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $cards =  $deck->drawCards(10);
        $hand->addCards($cards);
        $res = $hand->cardCount();
        $exp = 11;
        $this->assertEquals($exp, $res);
    }

    /**
     * Create object and testing addCard function
     */
    public function testAddCard()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
        $deck = new Deck();
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $card =  $deck->drawCards(0);
        $hand->addCard($card[0]);
        $exp = $card[0];
        $res = $hand->hand[0];
        $this->assertEquals($exp, $res);
    }
}
