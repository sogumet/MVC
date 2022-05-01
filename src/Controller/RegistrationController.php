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

            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *      "/register/update/{name}",
     *      name="update_user",
     *      methods={"GET","HEAD"}
     * )
     */
    public function updateUser(
        UserRepository $userRepository,
        string $name
    ): Response {
        $user = $userRepository
            ->findOneBy(['name' => $name]);

            return $this->render('registration/role-form.html.twig', ['user' => $user]);
    }
    /**
     * @Route("/register/update/{name}",
     *  name="update_user_process"),
     * methods={"POST"}
     */
    public function UpdateUserProcess(
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {
        $entityManager = $doctrine->getManager();
        $name = $request->request->get('name');
        $role = $request->request->get('role');
        $update = $request->request->get('update');
        

        if ($update) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['name' => $name]);
            var_dump($role);
            var_dump($user);
            $roles[] = $role;
            $user->setRoles($roles);

            $entityManager->flush();

            return $this->redirectToRoute('app_register');

        }
        return $this->redirectToRoute('app_register');
    }
}
