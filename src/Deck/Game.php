<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game
{
    public $deck;
    public $hand;
    public $bank;
    public $bankcards;
    public $cards;
    public $cardsleft;
    public $sum;
    public $sumbank;

    public function __construct($session)
    {
        $this->deck = New Deck();
        $this->hand = New Hand();
        $this->bank = New Hand();
        $this->session = $session;
    }

    public function startGame() {
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
        $this->session->set("bank", $this->bank);
        $this->deck = $this->session->get("deck21");
        $this->deck->shuffleDeck();
    }

    public function drawCard()

    {
        $this->deck = $this->session->get("deck21");
        $this->hand = $this->session->get("hand21");
        $tempCard = $this->deck->drawCard();
        $this->hand->addCard($tempCard);
        $this->cards = $this->hand->cardCount() - 1;
        $this->cardsleft = $this->deck->cardCount();
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
        
    }

    public function clearGame()

    {
        $this->session->clear("deck21", "hand21","bank");
    }

    public function countSum() {
        $this->sum = 0;
        $ace = 0;
        foreach($this->hand as $card) {
            foreach($card as $value) {
                if($value->ace) {
                    $ace +=1;}
                $this->sum += $value->value;
                if($this->sum > 21 && $ace == 0) {
                    $this->sum += $value->value;
                }
                elseif($this->sum > 21 && $ace != 0) {
                    $this->sum -= 13 * $ace;
                }
            }
        }  
    }

    public function drawBank() {
        $this->sumbank = 0;
        
        while($this->sumbank < 17) {
            $this->deck = $this->session->get("deck21");
            $this->bank = $this->session->get("bank");
            $this->hand = $this->session->get("hand21");
            $tempCard = $this->deck->drawCard();
            $this->bank->addCard($tempCard);
            $this->sumbank = $this->countSumBank();
            $this->session->set("deck21", $this->deck);
            $this->session->set("bank", $this->bank);
            $this->session->set("hand21", $this->hand);
        }
        $this->bankcards = $this->bank->cardCount() - 1;
        $this->cards = $this->hand->cardCount() - 1;
        $this->cardsleft = $this->deck->cardCount();
    }

    public function countSumBank() {
        $sum = 0;
        $ace = 0;
        foreach($this->bank as $card) {
            foreach($card as $value) {
                if ($value->ace) {
                    $ace += 1;
                }
                $sum += $value->value;
                if($sum > 16 && $sum < 21) {
                    return $sum;
                }
                if($sum > 21 && $ace == 0) {
                    return $sum;
                }
                elseif($sum > 21 && $ace != 0) {
                    $sum -= $ace * 13;
                    return $sum;
                }
            }
        }  
        return $sum;
    }

}
