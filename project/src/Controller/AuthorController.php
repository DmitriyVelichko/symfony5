<?php
namespace App\Controller;

use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    public AuthorService $authorService;
    public int $status;
    public string $message;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
        $this->status = Response::HTTP_OK;
        $this->message = Response::$statusTexts[Response::HTTP_OK];
    }

    /**
     * @Route("/create")
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        try {
            $id = $this->authorService->create();
        } catch (\Throwable $throwable) {
            $id = null;
            $this->status = $throwable->getCode();
            $this->message = $throwable->getMessage();
        }
        return new JsonResponse([
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $id
            ]
        ]);
    }

    /**
     * @Route("/search")
     * @return JsonResponse
     */
    public function search(): JsonResponse
    {
        try {
            $author = $this->authorService->search();
        } catch (\Throwable $throwable) {
            $author = [];
            $this->status = $throwable->getCode();
            $this->message = $throwable->getMessage();
        }
        return new JsonResponse([
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'author' => $author
            ]
        ]);
    }
}