<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Score;
use App\Repository\ScoreRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Deck\PokerGame;

class PokerController extends AbstractController
{
        /**
         * @Route(
         *      "/poker",
         *      name="poker",
         *      methods={"GET","HEAD"}
         * )
         */
    public function startgame(): Response
    {
        return $this->render('poker/poker-start.html.twig');
    }

    /**
    * @Route(
    *      "/poker",
    *      name="poker-start",
    *      methods={"POST"}
    * )
    */
    public function startProcess(
        Request $request,
        SessionInterface $session,
        ScoreRepository $scoreRepository
    ): Response {
        $start = $request->request->get('start');
        $game = new PokerGame($session);
        $session->set("game", $game);


        if ($start) {
            $game->startGame();
            $highScore = $scoreRepository->findHighScore();
            $session->set('highScore', $highScore);
            $session->set('cardLeft', 52);
            return $this->redirectToRoute('pokerplay');
        }
        return $this->render('poker/poker-start.html.twig');
    }
    /**
     * @Route(
     *      "/poker/play",
     *      name="pokerplay",
     *      methods={"GET","HEAD"}
     * )
     */
    public function session(): Response
    {

        return $this->render(
            'poker/poker-game.html.twig',
        );
    }
    /**
         * @Route(
         *      "/poker/play",
         *      name="poker-play",
         *      methods={"POST", "GET"}
         * )
         * @SuppressWarnings(PHPMD.CyclomaticComplexity)
         * @SuppressWarnings(PHPMD.NPathComplexity)
         */
    public function sessionProcess(
        Request $request,
        SessionInterface $session,
        ManagerRegistry $doctrine,
        ScoreRepository $scoreRepository,
    ): Response {
        $reset = $request->request->get('reset');
        $draw = $request->request->get('draw');
        $hand1 = $request->request->get('hand1');
        $hand2 = $request->request->get('hand2');
        $hand3 = $request->request->get('hand3');
        $hand4 = $request->request->get('hand4');
        $hand5 = $request->request->get('hand5');
        $game = new PokerGame($session);

        if ($draw) {
            $card = $game->dealCard();
            $cardLeft = $game->getCardInDeck();
            $session->set("cardLeft", $cardLeft);
            return $this->render(
                'poker/poker-game.html.twig',
                ['card' => $card,
                'hand1' => $session->get("hand1"),
                'hand2' => $session->get("hand2"),
                'hand3' => $session->get("hand3"),
                'hand4' => $session->get("hand4"),
                'hand5' => $session->get("hand5"),
                ]
            );
        }
        if ($reset) {
            $game->startGame();
            $highScore = $scoreRepository->findHighScore();
            $session->set('highScore', $highScore);
            $session->set('cardLeft', 52);
            return $this->redirectToRoute('pokerplay');
        }
        if ($hand1) {
            $game->saveCard(1);
        }
        if ($hand2) {
            $game->saveCard(2);
        }
        if ($hand3) {
            $game->saveCard(3);
        }
        if ($hand4) {
            $game->saveCard(4);
        }
        if ($hand5) {
            $game->saveCard(5);
        }
        if ($session->get('allFull')) {
            $entityManager = $doctrine->getManager();
            $score = new Score();
            $value = $session->get("score");
            $score->setScore($value);
            $entityManager->persist($score);
            $entityManager->flush();
            $highScore = $scoreRepository->findHighScore();
            $session->set('highScore', $highScore);
        }

        return $this->render(
            'poker/poker-game.html.twig',
            [
            'hand1' => $session->get("hand1"),
            'hand2' => $session->get("hand2"),
            'hand3' => $session->get("hand3"),
            'hand4' => $session->get("hand4"),
            'hand5' => $session->get("hand5"),
            ]
        );

        return $this->redirectToRoute('pokerplay');
    }
}
