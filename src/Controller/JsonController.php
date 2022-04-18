<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Deck;

class JsonController extends AbstractController
{
    /**
    * @Route("card/api/deck", name="deckjson")
    */
    public function deckJson(): Response
    {
        $deck = new Deck();

        return new JsonResponse($deck);
    }

    /**
     * @Route("card/api/deck/shuffle", name="jsonshuffle")
     */
    public function shuffle(
        SessionInterface $session
    ): Response {
        $session->clear();
        $deck = new Deck();
        $deck->shuffleDeck();

        return new JsonResponse($deck);
    }
}
