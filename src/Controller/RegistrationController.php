<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *      "/register/update/{email}",
     *      name="update_user",
     *      methods={"GET","HEAD"}
     * )
     */
    public function updateUser(
        UserRepository $userRepository,
        string $email
    ): Response {
        $user = $userRepository
            ->findOneBy(['email' => $email]);

            return $this->render('registration/role-form.html.twig', ['user' => $user]);
    }
    /**
     * @Route("/register/update/{email}",
     *  name="update_user_process"),
     * methods={"POST"}
     */
    public function UpdateUserProcess(
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {
        $entityManager = $doctrine->getManager();
        $email = $request->request->get('email');
        $name = $request->request->get('name');
        $akronym = $request->request->get('akronym');
        $update = $request->request->get('update');
        

        if ($update) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            // var_dump($role);
            // var_dump($user);
            // $roles[0] = $role;
            // $user->setRoles($roles);
            $user->setName($name);
            $user->setEmail($email);
            $user->setAkronym($akronym);

            $entityManager->flush();

            return $this->redirectToRoute('user', ['email' => $email]);

        }
        return $this->redirectToRoute('app_register');
    }
}
