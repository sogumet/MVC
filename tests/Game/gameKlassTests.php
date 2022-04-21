<?php

namespace Mos\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties, use both arguments.
     */
    public function testCreateObjectBothArguments()
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

      /**
     * Construct object and verify that the object has the expected
     * properties, use both arguments.
     */
    public function testCreateReturnString()
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

    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    public function testReturnOutOfGuess()
    {
        $guess = new Guess(42, 1);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $guess->makeGuess(4);
        $res = $guess->makeGuess(4);
        $exp = "no guesses left.";
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    public function testExeptions()
    {
        
        $this->expectException(GuessException::class);
        $guess = new Guess();
        $guess->makeGuess(101);

        $guess = new Guess();
        $guess->makeGuess(-10);
    }
       
        
        

}
