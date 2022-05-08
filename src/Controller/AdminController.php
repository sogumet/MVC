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

    /**
    * @Route("/admin/all_users", name="all_users")
    */
    public function showAllUsers(
        EntityManagerInterface $entityManager
    ): Response {
        $users = $entityManager
        ->getRepository(User::class)
        ->findAll();
        // $users = $this->json($users);
        return $this->render('admin/all_users.html.twig', ['users' => $users]);
    }

    /**
     * @Route(
     *      "/admin/update/{email}",
     *      name="admin_edit",
     *      methods={"GET","HEAD"}
     * )
     */
    public function editUser(
        UserRepository $userRepository,
        string $email
    ): Response {
        $user = $userRepository
            ->findOneBy(['email' => $email]);

        return $this->render('admin/form/edit_user_form.html.twig', ['user' => $user]);
    }

    /**
     * @Route(
     *      "/admin/update/{email}",
     *      name="admin_edit_process",
     *      methods={"POST"}
     * )
     */

    public function updateUserProcess(
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {
        $entityManager = $doctrine->getManager();
        $email = $request->request->get('email');
        $name = $request->request->get('name');
        $akronym = $request->request->get('akronym');
        $role = $request->request->get('role');
        $update = $request->request->get('update');
        $delete = $request->request->get('delete');

        if ($update) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            $roles = array();
            $roles[0] = $role;
            $user->setRoles($roles);
            $user->setName($name);
            $user->setEmail($email);
            $user->setAkronym($akronym);
            $entityManager->flush();

            return $this->redirectToRoute('all_users');
        }
        if ($delete) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash("info", 'Deleted user with email ' . $user->getEmail());
        }
        return $this->redirectToRoute('all_users');
    }
}
