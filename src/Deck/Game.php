<?php

namespace App\Deck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Deck;
use App\Deck\Hand;

class Game
{
    public object $deck;
    public object $hand;
    public object $bank;
    public int $bankcards = 0;
    public int $cards = 0;
    public int $cardsleft = 0;
    public int $sum = 0;
    public int $sumbank = 0;
    public object $tempCard;
    public $session;

    public function __construct($session)
    {
        $this->deck = new Deck();
        $this->hand = new Hand();
        $this->bank = new Hand();
        $this->session = $session;
    }

    public function startGame(): void
    {
        $this->session->clear();
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
        $this->session->set("bank", $this->bank);
        $this->deck = $this->session->get("deck21");
        $this->deck->shuffleDeck();
    }

    public function playerDrawCard(): void
    {
        $this->deck = $this->session->get("deck21");
        $this->hand = $this->session->get("hand21");
        $this->tempCard = $this->deck->drawCard();
        $this->hand->addCard($this->tempCard);
        $this->sum = $this->countSumBank($this->hand);
        $this->cards = $this->hand->cardCount() - 1;
        $this->cardsleft = $this->deck->cardCount();
        $this->session->set("deck21", $this->deck);
        $this->session->set("hand21", $this->hand);
    }

    public function drawBank(): void
    {
        $this->sumbank = 0;

        while ($this->sumbank < 17) {
            $this->deck = $this->session->get("deck21");
            $this->bank = $this->session->get("bank");
            $this->hand = $this->session->get("hand21");
            $this->tempCard = $this->deck->drawCard();
            $this->bank->addCard($this->tempCard);
            $this->sumbank = $this->countSumBank($this->bank);
            $this->session->set("deck21", $this->deck);
            $this->session->set("bank", $this->bank);
            $this->session->set("hand21", $this->hand);
        }
        $this->bankcards = $this->bank->cardCount() - 1;
        $this->cards = $this->hand->cardCount() - 1;
        $this->cardsleft = $this->deck->cardCount();
        $this->sum = $this->countSumBank($this->hand);
    }

    public function countSumBank(object $bank): int
    {
        $sum = 0;
        $ace = 0;
        foreach ($bank as $card) {
            foreach ($card as $value) {
                $tempValue = $value->getValue();
                if ($tempValue == 14) {
                    $ace += 1;
                }
                $sum += $tempValue;
                if ($sum > 21 && $ace == 0) {
                    return $sum;
                }
                if ($sum > 21 && $ace == 1) {
                    $sum -= 13;
                    $ace = 0;
                } elseif ($sum > 21 && $ace == 2) {
                    $sum -= 13;
                    $ace = 1;
                }
            }
            return $sum;
        }
    }

    public function sumBankAsString(): string
    {
        return "{$this->sumbank}";
    }

    /**
     * Sum as string.
     *
     * @return string
     */
    public function sumAsString(): string
    {
        return "{$this->sum}";
    }
}
