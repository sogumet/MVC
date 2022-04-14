<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game
{
    public $deck;
    public $player;
    protected $bank;

    public function __construct()
    {
        $this->deck = New Deck();
        $this->player = New Hand();
        $this->bank = New Hand();
    }
    public function drawCard()
    {

        $card = $this->deck->drawCard();
        return $card;
    }

}
