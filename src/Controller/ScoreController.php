<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Score;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ScoreController extends AbstractController
{
    #[Route('/score', name: 'app_score')]
    public function index(): Response
    {
        return $this->redirectToRoute('pokerplay');
    }

    /**
     * @Route("/score/save", name="save_score")
     */

    public function saveScore(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $score = new Score();
        // $value = $this->session->get('score');
        $value = $session->get("score");
        $score->setScore($value);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($score);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('pokerplay');
    }

}



