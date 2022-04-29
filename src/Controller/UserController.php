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
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * @Route(
     *      "/user/add",
     *      name="add_user",
     *      methods={"GET","HEAD"}
     * )
     */
    public function addUser(): Response
    {
        return $this->render('user/form/add-form.html.twig');
    }
    /**
     * @Route("/user/add",
     *  name="add_user_process"),
     * methods={"POST"}
     */
    public function addUserProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $akronym = $request->request->get('akronym');
        $add  = $request->request->get('add');        

        if ($add) {
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setAkronym($akronym);

            // tell Doctrine you want to (eventually) save the Product
            // (no queries yet)
            $entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            $this->addFlash("info", 'Added a new user with name '.$user->getName());
            return $this->redirectToRoute('add_user');

        }
        return $this->redirectToRoute('add_user');
    }

   
}
