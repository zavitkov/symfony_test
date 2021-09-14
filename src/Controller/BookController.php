<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Exceptions\ApiException;
use App\Helpers\ValidatorHelper;
use App\Repository\BookRepository;
use App\Repository\BookTranslationRepository;
use App\Requests\AddBookRequest;
use App\Responses\ApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book_list")
     * @param BookRepository $repository
     * @return ApiResponse
     */
    public function list(BookRepository $repository): ApiResponse
    {
        $books = $repository->findAll();

        return new ApiResponse('', $books);
    }

    /**
     * @Route("/lang/{_locale}/book/{id}", name="translated_book_info", requirements={"_locale": "en|ru"})
     */
    public function show(Book $book, Request $request)
    {
        $locale = $request->getLocale();

        return new ApiResponse('', [
            'id' => $book->getId(),
            'name' => $book->translate($locale)->getName(),
            'author' => $book->getAuthor(),
        ]);
    }

    /**
     * @Route("/lang/{_locale}/book/search/{needle}", name="book_search", requirements={"_locale": "en|ru"})
     * @param string $needle
     * @param BookRepository $repository
     * @return ApiResponse
     */
    public function search(string $needle, BookTranslationRepository $repository, Request $request): ApiResponse
    {
        $book = $repository->searchByName($needle, $request->getLocale());

        return new ApiResponse('', $book);
    }

    /**
     * @Route("/book/create", name="book_create", methods={"post"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param AddBookRequest $addBookRequest
     * @return ApiResponse
     * @throws ApiException
     */
    public function create(Request $request, EntityManagerInterface $em, AddBookRequest $addBookRequest): ApiResponse
    {
        $errors = $addBookRequest->validate($request);
        ValidatorHelper::checkErrors($errors);

        $name_en = $request->get('name_en');
        $name_ru = $request->get('name_ru');
        $author = $em->getRepository(Author::class)->find($request->get('author_id'));

        $book = new Book();
        $book->translate('en')->setName($name_en);
        $book->translate('ru')->setName($name_ru);
        $book->setAuthor($author);
        $em->persist($book);

        $book->mergeNewTranslations();

        $em->flush();

        return new ApiResponse('Книга успешно добавлена');
    }
}
