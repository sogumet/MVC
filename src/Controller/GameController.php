<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{

    /**
     * @Route(
     *      "/game",
     *      name="game",
     *      methods={"GET","HEAD"}
     * )
     */
    public function session(): Response
    {
        return $this->render('deck/game.html.twig');
    }

    /**
     * @Route(
     *      "/game",
     *      name="game-process",
     *      methods={"POST"}
     * )
     */
    public function sessionProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $roll  = $request->request->get('roll');
        $save  = $request->request->get('save');
        $clear = $request->request->get('clear');

        // $session->clear("deck", "hand");
        $deck = $session->get("deck21") ?? new \App\Deck\Deck();
        $hand = $session->get("hand21") ?? new \App\Deck\Hand();
        // $deck->shuffleDeck();

        if ($roll) {
            // $deck = $session->get("deck21");
            // $hand = $session->get("hand21");
            $tempCard = $deck->drawCard();
            $hand->addCard($tempCard);
            $cards = $hand->cardCount() - 1;
            $session->set("deck21", $deck);
            $session->set("hand21", $hand);
            var_dump($cards);
            }
        elseif($clear) {
            $session->clear("deck", "hand");
            return $this->render(
                'deck/game.html.twig');
        }

        return $this->render(
            'deck/game.html.twig',
            ['data' => $hand,
            'cards' => $cards,
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }
}