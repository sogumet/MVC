<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BooksRepository;
use App\Repository\ScoreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj", name="project")
     */
    public function home(): Response
    {
        return $this->render('project/home.html.twig');
    }

    /**
     * @Route("/proj/about", name="project_about")
     */
    public function about(): Response
    {
        return $this->render('project/about.html.twig');
    }

    /**
     * @Route(
     *      "/proj/reset", name="reset")
     */
    public function reset(
        BooksRepository $booksRepository,
        ScoreRepository $scoreRepository
    ) {
        $booksRepository->resetBooks();
        $scoreRepository->resetScore();
        return $this->render('project/reset.html.twig');
    }
}
