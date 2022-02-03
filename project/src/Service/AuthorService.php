<?php

namespace App\Service;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthorService
{
    public AuthorRepository $authorRepository;
    public Request $request;

    public function __construct(
        AuthorRepository $authorRepository,
        RequestStack $requestStack
    )
    {
        $this->authorRepository = $authorRepository;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return int
     */
    public function create(): int
    {
        $data = $this->request->query->all();
        return $this->authorRepository->create($data);
    }

    /**
     * @return array
     */
    public function search(): array
    {
        $data = $this->request->query->all();
        return $this->authorRepository->search($data);
    }
}