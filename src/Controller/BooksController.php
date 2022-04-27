<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Books;
use App\Repository\BooksRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BooksController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }


    /**
     * @Route(
     *      "/library/create",
     *      name="add_book",
     *      methods={"GET","HEAD"}
     * )
     */
    public function addBook(): Response
    {
        return $this->render('books/forms/add-form.html.twig');
    }
    /**
     * @Route("/library/create",
     *  name="add_book_process"),
     * methods={"POST"}
     */
    public function addBookProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $image = $request->request->get('image');
        $add  = $request->request->get('add');
        

        if ($add) {
            $book = new Books();
            $book->setTitle($title);
            $book->setIsbn($isbn);
            $book->setAuthor($author);
            $book->setPicture($image);

            // tell Doctrine you want to (eventually) save the Product
            // (no queries yet)
            $entityManager->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            $this->addFlash("info", 'Added a new book with title '.$book->getTitle());
            return $this->redirectToRoute('add_book');

        }
        return $this->redirectToRoute('add_book');
    }


    /**
     * @Route("/library/show", name="books_show_all")
     */
    public function showAllBooks(
        EntityManagerInterface $entityManager
    ): Response {
    $books = $entityManager
        ->getRepository(Books::class)
        ->findAll();
    $data = $this->json($books);
    return $this->render('books/show-books.html.twig', ['data' => $books]);
    }

    /**
     * @Route("/library/show/{isbn}", name="books_by_isbn")
     */
    public function showBookByIsbn(
        BooksRepository $booksRepository,
        int $isbn
    ): Response {
        $book = $booksRepository
            ->findOneBy(['isbn' => $isbn]);

        return $this->json($book);
    }

    /**
     * @Route("/library/delete/{isbn}", name="books_delete_by_id")
     */
    public function deleteBookByIsbn(
        ManagerRegistry $doctrine,
        int $isbn
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$isbn
            );
        }
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('books_show_all');
    }

    /**
     * @Route("/library/update/{id}/{value}", name="product_update")
     */
    public function updateProduct(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Books::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$isbn
            );
        }

        $product->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }
}
