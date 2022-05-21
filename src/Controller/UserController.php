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

class UserController extends AbstractController

/**
     * @Route(
     *      methods={"GET","HEAD"}
     * )
     */
{
    #[Route('/user/{email}', name: 'user')]

    public function updateUser(
        UserRepository $userRepository,
        string $email
    ): Response {
        $user = $userRepository->findOneBy(['email' => $email]);

        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render(
            'user/index.html.twig',
            ['user' => $user,
            'controller_name' => 'UserController', ]
        );
    }

    /**
     * @Route(
     *      "/reset",
     *      name="reset_book",
     *      methods={"GET","HEAD"}
     * )
     */
    public function reset(
        UserRepository $userRepository
    ) {
        $userRepository->resetUser();
        return $this->redirectToRoute('books_show_all');
    }
}
