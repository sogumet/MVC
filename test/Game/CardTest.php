<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class Guess.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateCardObject()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Deck\Card", $card);
    }

    /**
     * Create object and testing getValue function
     */
    public function testGetValue()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Deck\Card", $card);
        $hand = new Hand();
        $deck = new Deck();
        $cards =  $deck->drawCards(0);
        $res = $cards[0]->getValue();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Create object and testing getImage function
     */
    public function testGetImage()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Deck\Card", $card);
        $hand = new Hand();
        $deck = new Deck();
        $cards =  $deck->drawCards(0);
        $res = $cards[0]->getImage();
        $exp = "img/deck/2-clubs.png";
        $this->assertEquals($exp, $res);
    }
}
