<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class Guess.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateGameObject()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $this->assertInstanceOf("\App\Deck\Game", $game);
        $hand = new Hand();
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
        $this->assertInstanceOf("Symfony\Component\HttpFoundation\Session\Session", $game->session);
    }

    /**
     * Construct objects, getting objects from session
     * an verify that the object has the expected properties.
     */
    public function testStartGameFunction()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $this->assertInstanceOf("\App\Deck\Game", $game);
        $game->startGame();
        $deck = $game->session->get("deck21");
        $this->assertInstanceOf("\App\Deck\Deck", $deck);
        $hand = $game->session->get("hand21");
        $this->assertInstanceOf("\App\Deck\Hand", $hand);
        $bank = $game->session->get("bank");
        $this->assertInstanceOf("\App\Deck\Hand", $bank);
       
    }

    /**
     * Construct objects, getting and verifying cardvalue.
     */
    public function testPlayerDrawCard()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $game->startGame();
        $game->playerDrawCard();
        $exp = $game->tempCard->getValue();
        $res = $game->countSumBank($game->hand);
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct objects, getting and verifying the sum of bankhand cards.
     */
    public function testDrawBank()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $game->session->clear();
        $game->session->set("deck21", $game->deck);
        $game->session->set("bank", $game->bank);
        $game->session->set("hand21", $game->hand);
        $game->drawBank();
        $res = $game->sumbank;
        $exp = 20; // 2 + 3 + 4 + 5 + 6 from an unshuffled deck        
        $this->assertEquals($exp, $res);
    }

    /**
     * Verifying bankhand cardsum > 21 no aces.
     */
    public function testCountSumBank1()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $tempCard = $game->deck->deck[11]; //cardvalue 13
        $game->bank->addCard($tempCard);
        $tempCard = $game->deck->deck[11]; //cardvalue 13
        $game->bank->addCard($tempCard);
        $res = $game->countSumBank($game->bank);
        $exp = 26;
        $this->assertEquals($exp, $res);
    }

    /**
     * Verifying bankhand cardsum > 21 with 1 ace.
     */
    public function testCountSumBank2()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $tempCard = $game->deck->deck[11]; //cardvalue 13
        $game->bank->addCard($tempCard);
        $tempCard = $game->deck->deck[12]; //cardvalue 14
        $game->bank->addCard($tempCard);
        $res = $game->countSumBank($game->bank);
        $exp = 14;
        $this->assertEquals($exp, $res);
    }

    
    /**
     * Verifying bankhand cardsum > 21 with 2 ace.
     */
    public function testCountSumBank3()
    {
        $session = new Session(new MockFileSessionStorage());
        $game = new Game($session);
        $tempCard = $game->deck->deck[3]; //cardvalue 5
        $game->bank->addCard($tempCard);
        $tempCard = $game->deck->deck[12]; //cardvalue 14
        $game->bank->addCard($tempCard);
        $tempCard = $game->deck->deck[12]; //cardvalue 14
        $game->bank->addCard($tempCard);
        $res = $game->countSumBank($game->bank);
        $exp = 20;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties, use both arguments.
     */
    /* public function testCreateObjectBothArguments()
    {
        $guess = new Guess(42, 7);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 7;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }
 */
      /**
     * Construct object and verify that the object has the expected
     * properties, use both arguments.
     */
    /* public function testCreateReturnString()
    {

        $guess = new Guess();
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $numberHigh = $guess->number() + 1;
        $numberLow = $guess->number() - 1;
        $number = $guess->number();

        $res = $guess->makeGuess($numberHigh);
        $exp = "to high...";
        $this->assertEquals($exp, $res);

        $res = $guess->makeGuess($numberLow);
        $exp = "to low...";
        $this->assertEquals($exp, $res);

        $res = $guess->makeGuess($number);
        $exp = "correct!!!";
        $this->assertEquals($exp, $res);

    } */

    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
   /*  public function testReturnOutOfGuess()
    {
        $guess = new Guess(42, 1);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $guess->makeGuess(4);
        $res = $guess->makeGuess(4);
        $exp = "no guesses left.";
        $this->assertEquals($exp, $res);
    } */

    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    /* public function testExeptions()
    {
        
        $this->expectException(GuessException::class);
        $guess = new Guess();
        $guess->makeGuess(101);

        $guess = new Guess();
        $guess->makeGuess(-10);
    } */
       
        
        

}
