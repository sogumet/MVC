<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\Deck;
use App\Deck\PokerGame;

/**
 * @SuppressWarnings(PHPMD)
 */

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
    public function number(SessionInterface $session): Response
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
        $shift1 = 23;
        $shift2 = 28;
        $shift3 = 29;
        $shift4 = 30;
        $shift5 = 31;
        $bit1 = $bit1 << $shift1;
        $bit2 = $bit2 << $shift2;
        $bit3 = $bit3 << $shift3;
        $bit4 = $bit4 << $shift4;
        $bit5 = $bit5 << $shift5;
        $bit = $bit1 | $bit2 | $bit3 | $bit4 | $bit5;
        // $lsb = $bit & (-1 * $bit);
        // $bit = $bit / $lsb;
        $dec = bindec('11110001000000000000000000000000');
        $modulus = $bit % 15;
       /*  $deck = new Deck();
        $card = $deck->getCard(12, 'clubs');
        $card1 = $deck->getCard(7, 'hearts');
        $pokerGame = new PokerGame($session);
        $pokerGame->startGame();
        $deck = $session->get("deck");
        $hand1 = $session->get("hand1");
        $hand[] = $deck->getCard(2, "hearts");
        $hand[] = $deck->getCard(3, "hearts");
        $hand[] = $deck->getCard(4, "hearts");
        $hand[] = $deck->getCard(5, "hearts");
        $hand[] = $deck->getCard(6, "hearts");
        for ($i = 0; $i < 5; $i++) {
            $hand1->addCard($hand[$i]);
        } */


        return $this->render('report/test.html.twig', [
            'number' => $number,
            'type' => "MVC",
            'arr' => $arr,
            'bit' => $bit,
            'shift' => $shift1,
            'dec' => $dec,
            'modulus' => $modulus,
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
