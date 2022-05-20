<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class pokerGame.
 */
class PokerGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateGameObject()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $hand = new PokerHand();
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand);
        $this->assertInstanceOf("Symfony\Component\HttpFoundation\Session\Session", $pokerGame->session);
    }

    /**
     * Construct objects, getting objects from session
     * an verify that the object has the expected properties.
     */
    public function testStartGameFunction()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $pokerGame->session->get("deck");
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $hand1 = $pokerGame->session->get("hand1");
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand1);
        $hand2 = $pokerGame->session->get("hand2");
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand2);
        $hand3 = $pokerGame->session->get("hand3");
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand3);
        $hand4 = $pokerGame->session->get("hand4");
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand4);
        $hand5 = $pokerGame->session->get("hand5");
        $this->assertInstanceOf("\App\Deck\PokerHand", $hand5);
        $fullHands = $pokerGame->session->get("fullHands");
        $this->assertIsIterable($fullHands);
    }

    /**
     * Construct objects, getting and verifying cardObject.
     */
    public function testDrawCard()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $card = $pokerGame->dealCard();
        $this->assertInstanceOf("\App\Deck\Card", $card);
    }
    /**
     * saving card in hand and check if fullhand is false.
     */
    public function testSave1Card()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $pokerGame->dealCard();
        $res = $pokerGame->saveCard(1);
        $exp = false;
        $this->assertEquals($exp, $res);
        $res = $pokerGame->saveCard(2);
        $exp = false;
        $this->assertEquals($exp, $res);
        $res = $pokerGame->saveCard(3);
        $exp = false;
        $this->assertEquals($exp, $res);
        $res = $pokerGame->saveCard(4);
        $exp = false;
        $this->assertEquals($exp, $res);
        $res = $pokerGame->saveCard(5);
        $exp = false;
        $this->assertEquals($exp, $res);
    }

    /**
     * saving  5cards in hand and check if fullhand is true.
     */
    public function testSave5Cards()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $pokerGame->dealCard();
        $res = $pokerGame->saveCard(1);
        $res = $pokerGame->saveCard(1);
        $res = $pokerGame->saveCard(1);
        $res = $pokerGame->saveCard(1);
        $res = $pokerGame->saveCard(1);
        $exp = true;
        $this->assertEquals($exp, $res);
    }

    /**
     * saving  5cards in 5hands and check if Allfullhand is true.
     */
    public function testTest()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $pokerGame->test();
        $pokerGame->checkIfAllFullHand("full");
        $exp = true;
        $res = $pokerGame->session->get("allFull");
        $this->assertEquals($exp, $res);
    }

    /**
     * Picking som cards from deck and check if remaining cards number is correct.
     */
    public function testGetCardInDeck()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $pokerGame->dealCard();
        $pokerGame->dealCard();
        $res = $pokerGame->getCardInDeck();
        $exp = 50;
        $this->assertEquals($exp, $res);
    }


    /**
     * Constructing a straight hand and checking return value).
     */
    public function testIfFlushOrStraight()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(2, "hearts");
        $hand[] = $deck->getCard(3, "clubs");
        $hand[] = $deck->getCard(4, "hearts");
        $hand[] = $deck->getCard(5, "hearts");
        $hand[] = $deck->getCard(6, "spades");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->checkFlushOrStraight($session->get('hand1'));
        $exp = 4;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a flush hand and checking return value).
     */
    public function testIfFlushOrStraight1()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(2, "hearts");
        $hand[] = $deck->getCard(3, "hearts");
        $hand[] = $deck->getCard(4, "hearts");
        $hand[] = $deck->getCard(6, "hearts");
        $hand[] = $deck->getCard(11, "hearts");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->checkFlushOrStraight($session->get('hand1'));
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a straightflush and checking return value).
     */
    public function testIfFlushOrStraight2()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(9, "diamonds");
        $hand[] = $deck->getCard(10, "diamonds");
        $hand[] = $deck->getCard(11, "diamonds");
        $hand[] = $deck->getCard(12, "diamonds");
        $hand[] = $deck->getCard(13, "diamonds");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->checkFlushOrStraight($session->get('hand1'));
        $exp = 15;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a pair and checking return value).
     */
    public function testIfFlushOrStraight3()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(9, "diamonds");
        $hand[] = $deck->getCard(10, "diamonds");
        $hand[] = $deck->getCard(12, "spades");
        $hand[] = $deck->getCard(12, "diamonds");
        $hand[] = $deck->getCard(13, "diamonds");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->checkFlushOrStraight($session->get('hand1'));
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a no point hand and checking return value).
     */
    public function testGetPointsZero()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(9, "diamonds");
        $hand[] = $deck->getCard(10, "diamonds");
        $hand[] = $deck->getCard(12, "spades");
        $hand[] = $deck->getCard(14, "clubs");
        $hand[] = $deck->getCard(13, "diamonds");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a pair hand and checking return value).
     */
    public function testGetPointsPair()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(9, "diamonds");
        $hand[] = $deck->getCard(10, "diamonds");
        $hand[] = $deck->getCard(10, "spades");
        $hand[] = $deck->getCard(14, "clubs");
        $hand[] = $deck->getCard(13, "diamonds");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a two pair hand and checking return value).
     */
    public function testGetPointsTwoPair()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(9, "diamonds");
        $hand[] = $deck->getCard(10, "diamonds");
        $hand[] = $deck->getCard(10, "spades");
        $hand[] = $deck->getCard(14, "clubs");
        $hand[] = $deck->getCard(14, "spades");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 2;
        $this->assertEquals($exp, $res);
    
    }
    /**
     * Constructing a three of a kind hand and checking return value).
     */
    public function testGetPointThreeAKind()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(3, "diamonds");
        $hand[] = $deck->getCard(4, "diamonds");
        $hand[] = $deck->getCard(4, "spades");
        $hand[] = $deck->getCard(4, "clubs");
        $hand[] = $deck->getCard(14, "spades");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 3;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a straight hand and checking return value).
     */
    public function testGetPointStraight()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(3, "diamonds");
        $hand[] = $deck->getCard(4, "diamonds");
        $hand[] = $deck->getCard(5, "spades");
        $hand[] = $deck->getCard(6, "clubs");
        $hand[] = $deck->getCard(7, "spades");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 4;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a flush hand and checking return value).
     */
    public function testGetPointFlush()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(3, "diamonds");
        $hand[] = $deck->getCard(4, "diamonds");
        $hand[] = $deck->getCard(5, "diamonds");
        $hand[] = $deck->getCard(6, "diamonds");
        $hand[] = $deck->getCard(13, "diamonds");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a fullhand hand and checking return value).
     */
    public function testGetPointFullHouse()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(11, "diamonds");
        $hand[] = $deck->getCard(11, "spades");
        $hand[] = $deck->getCard(11, "hearts");
        $hand[] = $deck->getCard(6, "diamonds");
        $hand[] = $deck->getCard(6, "hearts");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 8;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a four of a kind hand and checking return value).
     */
    public function testGetPointFourAKind()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(14, "diamonds");
        $hand[] = $deck->getCard(5, "spades");
        $hand[] = $deck->getCard(5, "hearts");
        $hand[] = $deck->getCard(5, "diamonds");
        $hand[] = $deck->getCard(5, "clubs");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 10;
        $this->assertEquals($exp, $res);
    }

    /**
     * Constructing a straightFlush hand and checking return value).
     */
    public function testGetPointStraightFlush()
    {
        $session = new Session(new MockFileSessionStorage());
        $pokerGame = new PokerGame($session);
        $this->assertInstanceOf("\App\Deck\PokerGame", $pokerGame);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(5, "clubs");
        $hand[] = $deck->getCard(6, "clubs");
        $hand[] = $deck->getCard(7, "clubs");
        $hand[] = $deck->getCard(8, "clubs");
        $hand[] = $deck->getCard(9, "clubs");
        for($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        }
        $res = $pokerGame->getPoints($session->get('hand1'));
        $exp = 15;
        $this->assertEquals($exp, $res);
    }


}
