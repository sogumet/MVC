<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Repository\UserRepository;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
        return $this->redirectToRoute('add_book');
    }

    /**
     * @Route("/login/direct", name="login_direct")
     */
    public function direct(
        UserRepository $userRepository,
    ): Response
    {
        $user = $this->getUser();
        $email = $user->getEmail();
        var_dump($email);
        return $this->redirectToRoute('user', ['email' => $email]);
        // {{ path('book_by_id', {id: book.id})}}
    }

}
