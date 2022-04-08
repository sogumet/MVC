<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('deck/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck")
     */
    public function deck(): Response
    {
        $tempDeck = new \App\Deck\Deck();
        $data = $tempDeck->deck;

        return $this->render('deck/deck.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/card/shuffle", name="shuffle")
     */
    public function shuffledDeck(): Response
    {
        $tempDeck = new \App\Deck\Deck();
        $tempdeck = $tempDeck->shuffleDeck();
        $data = $tempDeck->deck;
        return $this->render('deck/shuffle.html.twig', ['data' => $data]);
    }
}
