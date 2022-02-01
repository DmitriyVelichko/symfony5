<?php
namespace App\Controller;

use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    public $authorService;
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * @Route("/create")
     * @return Response
     */
    public function create(): Response
    {
        $id = $this->authorService->create();
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
        $result = $this->authorService->search();
        return new Response(
            '<html><body><pre>'.var_dump($result).'<pre></body></html>'
        );
    }
}