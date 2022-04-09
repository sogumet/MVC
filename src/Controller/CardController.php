<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
     * @Route("/card/deck/shuffle", name="shuffle")
     */
    public function shuffledDeck(
        SessionInterface $session
    ): Response {
        $session->clear("deck");
        $tempDeck = new \App\Deck\Deck();
        $tempdeck = $tempDeck->shuffleDeck();
        $data = $tempDeck->deck;
        return $this->render('deck/shuffle.html.twig', ['data' => $data]);
    }

    /**
    * @Route("/card/deck/draw", name="draw")
    */
    public function drawACard(
        SessionInterface $session
    ): Response {
        $tempDeck = $session->get("deck") ?? new \App\Deck\Deck();
        $tempdeck = $tempDeck->shuffleDeck();
        $card = $tempDeck->drawCard();
        $cardLeft = $tempDeck->cardCount();
        $session->set("deck", $tempDeck);
        return $this->render('deck/draw.html.twig', ['data' => $card,
                                                    'cardleft' => $cardLeft]);
    }
}
