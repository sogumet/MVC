<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController

/**
     * @Route(
     *      methods={"GET","HEAD"}
     * )
     */
{
    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }


}
