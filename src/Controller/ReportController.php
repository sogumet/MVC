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
        $arr = array();
        $number = random_int(0, 100);
        $arr[] = "Testing";
        $arr[] = "Snolep";
        $bit1 = 1;
        $bit2 = 1;
        $bit3 = 1;
        $bit4 = 1;
        $bit5 = 1;
        $shift1 = 8;
        $shift2 = 7;
        $shift3 = 6;
        $shift4 = 5;
        $shift5 = 4;
        $bit1 = $bit1 << $shift1;
        $bit2 = $bit2 << $shift2;
        $bit3 = $bit3 << $shift3;
        $bit4 = $bit4 << $shift4;
        $bit5 = $bit5 << $shift5;
        $bit = $bit1 | $bit2 | $bit3 | $bit4 | $bit5;
        $lsb = $bit & (-1 * $bit);
        $bit = $bit / $lsb;

        // $bit = $bit % 15;


        return $this->render('report/test.html.twig', [
            'number' => $number,
            'type' => "MVC",
            'arr' => $arr,
            'bit' => $bit,
            'shift' => $shift1
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
