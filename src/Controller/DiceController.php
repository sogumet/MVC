<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DiceController extends AbstractController
{
    /**
     * @Route("/dice", name="dice-home")
     */
    public function home(): Response
    {
        $die = new \App\Dice\Dice();
        $data = [
            'title' => 'Dice',
            'die_value' => $die->roll(),
            'die_as_string' => $die->getAsString(),
            'link_to_roll' => $this->generateUrl('dice-roll', ['numRolls' => 5,]),
        ];
        return $this->render('dice/home.html.twig', $data);
    }

    /**
     * @Route("/dice/roll/{numRolls}", name="dice-roll")
     */
    public function roll(int $numRolls): Response
    {
        $die = new \App\Dice\Dice();

        $rolls = [];
        for ($i = 1; $i <= $numRolls; $i++) {
            $die->roll();
            $rolls[] = $die->getAsString();
        }

        $data = [
            'title' => 'Dice rolled many times',
            'numRolls' => $numRolls,
            'rolls' => $rolls,
        ];
        return $this->render('dice/roll.html.twig', $data);
    }

    /**
    * @Route("/dice/graphic", name="dice-graphic-home")
    */
    public function homeGraphic(): Response
    {
        $die = new \App\Dice\DiceGraphic();
        $data = [
            'title' => 'Dice with graphic representation',
            'die_value' => $die->roll(),
            'die_as_string' => $die->getAsString(),
            'link_to_roll' => $this->generateUrl('dice-graphic-roll', ['numRolls' => 5,]),
        ];
        return $this->render('dice/home.html.twig', $data);
    }

    /**
     * @Route("/dice/grahpic/roll/{numRolls}", name="dice-graphic-roll")
     */
    public function rollGraphic(int $numRolls): Response
    {
        $die = new \App\Dice\DiceGraphic();

        $rolls = [];
        for ($i = 1; $i <= $numRolls; $i++) {
            $die->roll();
            $rolls[] = $die->getAsString();
        }

        $data = [
            'title' => 'Graphic dice rolled many times',
            'numRolls' => $numRolls,
            'rolls' => $rolls,
        ];
        return $this->render('dice/roll.html.twig', $data);
    }

    /**
     * @Route(
     *      "/dice/hand",
     *      name="dice-hand-home",
     *      methods={"GET","HEAD"}
     * )
     */
    public function homeHand(): Response
    {
        return $this->render('dice/hand.html.twig');
    }

    /**
     * @Route(
     *      "/dice/hand",
     *      name="dice-hand-process",
     *      methods={"POST"}
     * )
     */
    public function process(
        Request $request,
        SessionInterface $session
    ): Response {
        $hand = $session->get("dicehand") ?? new \App\Dice\DiceHand();

        $roll  = $request->request->get('roll');
        $add  = $request->request->get('add');
        $clear = $request->request->get('clear');

        if ($roll) {
            $hand->roll();
        } elseif ($add) {
            //$hand->add(new \App\Dice\Dice());
            $hand->add(new \App\Dice\DiceGraphic());
        } elseif ($clear) {
            $hand = new \App\Dice\DiceHand();
        }

        $session->set("dicehand", $hand);

        $this->addFlash("info", "Your dice hand holds " . $hand->getNumberDices() . " dices.");
        $this->addFlash("info", "Current values: " . $hand->getAsString());

        return $this->redirectToRoute('dice-hand-home');
    }
}
