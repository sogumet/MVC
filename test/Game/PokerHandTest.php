<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class pokerGame.
 */
class PokerHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreatePokerHandObject()
    {
        $session = new Session(new MockFileSessionStorage());
        $hand = new PokerHand();
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand);
    }

    /**
     * Construct objects, getting objects from session
     * an verify that the object has the expected properties.
     */
    public function testgetHand()
    {
        $hand = new PokerHand();
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand);
        $res = $hand->getHand();
        $this->assertIsIterable($res);
    }

    /**
     * Construct objects, getting and verifying cardObject.
     */
    /* public function testDrawCard()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $card = $pokerGame->dealCard();
        $this->assertInstanceOf("\App\Deck\Card", $card);
    } */
}