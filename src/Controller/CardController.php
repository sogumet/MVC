<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render(
            'deck/card.html.twig',
            ['link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }

    /**
     * @Route("/card/deck", name="deck")
     */
    public function deck(): Response
    {
        $tempDeck = new \App\Deck\Deck();
        $data = $tempDeck->deck;

        return $this->render(
            'deck/deck.html.twig',
            ['data' => $data,
            'link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }

    /**
     * @Route("/card/deck2", name="deck2")
     */
    public function deck2(): Response
    {
        $tempDeck = new \App\Deck\Deck2();
        $data = $tempDeck->deck;

        return $this->render(
            'deck/deck2.html.twig',
            ['data' => $data,
            'link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
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

        return $this->render(
            'deck/shuffle.html.twig',
            ['data' => $data,
            'link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
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

        return $this->render(
            'deck/draw.html.twig',
            ['data' => $card,
            'cardleft' => $cardLeft,
            'link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }

    /**
    * @Route("/card/deck/draw/{numCard}", name="draw-number")
    */
    public function drawSomeCards(
        int $numCard,
        SessionInterface $session
    ): Response {
        $tempDeck = $session->get("deck") ?? new \App\Deck\Deck();
        $tempdeck = $tempDeck->shuffleDeck();
        $cards = $tempDeck->drawCards($numCard - 1);
        $cardLeft = $tempDeck->cardCount();
        $session->set("deck", $tempDeck);

        return $this->render(
            'deck/draw-cards.html.twig',
            ['data' => $cards,
            'cardleft' => $cardLeft,
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }

    /**
    * @Route("/card/deck/deal/{players}/{numCard}", name="deal-cards")
    */
    public function dealHands(
        int $players,
        int $numCard,
        SessionInterface $session
    ): Response {
        // $hands = $players;
        $session->clear("deck");
        $deck = $session->get("deck") ?? new \App\Deck\Deck();
        $tempdeck = $deck->shuffleDeck();
        for ($players > 0; $players--;) {
            $cards = $deck->drawCards($numCard - 1);
            $hand = new \App\Deck\Hand();
            $hand->addCards($cards);
            $hands[] = $hand;
        }
        $cardLeft = $deck->cardCount();
        $session->set("deck", $deck);
        return $this->render(
            'deck/players.html.twig',
            ['cards' => $numCard - 1,
            'cardleft' => $cardLeft,
            'hands' => $hands,
            'link_to_draw' => $this->generateUrl('draw-number', ['numCard' => 4]),]
        );
    }
}
