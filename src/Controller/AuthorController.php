<?php

namespace App\Controller;

use App\Entity\Author;
use App\Helpers\ValidatorHelper;
use App\Repository\AuthorRepository;
use App\Requests\AddAuthorRequest;
use App\Responses\ApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="author_list")
     * @param AuthorRepository $repository
     * @return ApiResponse
     */
    public function list(AuthorRepository $repository): ApiResponse
    {
        $authors = $repository->findAll();

        return new ApiResponse('', $authors);
    }

    /**
     * @Route("/create", name="author_create", methods={"post"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param AddAuthorRequest $addAuthorRequest
     * @return ApiResponse
     * @throws \App\Exceptions\ApiException
     */
    public function create(Request $request, EntityManagerInterface $em, AddAuthorRequest $addAuthorRequest): ApiResponse
    {
        $errors = $addAuthorRequest->validate($request);
        ValidatorHelper::checkErrors($errors);

        $author = new Author();
        $author->setName($request->get('name'));
        $em->persist($author);

        $em->flush();

        return new ApiResponse('Автор успешно сохранен');
    }
}
