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

        return $this->render('report/home.html.twig', [
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

        return $this->render('report/report.html.twig', [
            'number' => $number,
            'kurs' => "MVC",
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('report/about.html.twig', [
            'kurs' => "MVC",
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function number(): Response
    {
        $number = random_int(0, 100);
        $arr[] = "Testing";
        $arr[] = "Snolep";


        return $this->render('report/test.html.twig', [
            'number' => $number,
            'type' => "MVC",
            'arr' => $arr
        ]);
    }

    /**
     * @Route("/report/metrics", name="metrics")
     */
    public function metrics(): Response
    {

        return $this->render('report/metrics.html.twig');
    }

}
