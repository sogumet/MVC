<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $number = random_int(0, 100);

        return $this->render('home.html.twig', [
            'number' => $number,
            'type' => "Mega",
        ]);
    }
    

    /**
     * @Route("/report", name="report")
     */
    public function report(): Response
    {
        $number = random_int(0, 100);

        return $this->render('report.html.twig', [
            'number' => $number,
            'kurs' => "MVC",
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about.html.twig', [
            'kurs' => "MVC",
        ]);
    }
}
