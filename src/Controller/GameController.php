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
        $save  = $request->request->get('stay');
        $clear = $request->request->get('clear');
        $start = $request->request->get('start');
        $game = New \App\Deck\Game($session);

        if($start) {
            $game->startGame();
            
            return $this->render('deck/game.html.twig');  
        }

        elseif($roll) {
            $game->drawCard();
            $sum = $game->countSum();
            if ($sum > 21) {
                $this->addFlash("info", "You lost");
            }
            
            }
        elseif($clear) {
            $game->clearGame();

            return $this->render('deck/game.html.twig');
        }

        return $this->render(
            'deck/game.html.twig',
            ['data' => $game->hand,
            'sum' => $sum,
            'cards' => $game->cards,
            'cardsleft'=> $game->cardsleft,
            'link_to_deal' => $this->generateUrl('deal-cards', ['players' => 4, 'numCard' => 5])]
        );
    }
}