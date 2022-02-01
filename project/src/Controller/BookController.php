<?php
namespace App\Controller;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    public $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/create")
     * @return Response
     */
    public function create(): Response
    {
        $id = $this->bookService->create();
        return new Response(
            '<html><body>CREATE '.$id.'</body></html>'
        );
    }

    /**
     * @Route("/search")
     * @return Response
     */
    public function search(): Response
    {
        $result = $this->bookService->search();
        return new Response(
            '<html><body><pre>'.var_dump($result).'<pre></body></html>'
        );
    }
}