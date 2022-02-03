<?php
namespace App\Controller;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{!_locale}/book", requirements={"_locale": "en|ru"}, name="book_", defaults={"_locale": "ru"})
 */
class BookController extends AbstractController
{
    public BookService $bookService;
    public int $status;
    public string $message;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
        $this->status = Response::HTTP_OK;
        $this->message = Response::$statusTexts[Response::HTTP_OK];
    }

    /**
     * @Route("/create", name="create")
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        try {
            $id = $this->bookService->create();
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
     * @Route("/{id}", name="search", defaults={"id"="search"})
     * @param $id
     * @return JsonResponse
     */
    public function search($id): JsonResponse
    {
        try {
            $book = $this->bookService->search($id);
        } catch (\Throwable $throwable) {
            $book = [];
            $this->status = $throwable->getCode();
            $this->message = $throwable->getMessage();
        }
        return new JsonResponse([
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'book' => $book
            ]
        ]);
    }
}