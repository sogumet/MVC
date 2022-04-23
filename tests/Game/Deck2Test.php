<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class Guess.
 */
class Deck2Test extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateDeck2Object()
    {
        $deck = new Deck2();
        $this->assertInstanceOf("\App\Deck\Deck2", $deck); 
    }

    

    /**
     * Create object and testing size of deck2
     */
    public function testSizeOfDeck2()
    {
        $deck2 = new Deck2();
        $this->assertInstanceOf("\App\Deck\Deck2", $deck2);
        $res = count($deck2->deck);
        $exp = 54;
        $this->assertEquals($exp, $res);
    }

}
