<?php

namespace App\Service;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorService
{
    public $authorRepository;
    public $request;
    public $validator;

    public function __construct(
        AuthorRepository $authorRepository,
        RequestStack $requestStack,
        ValidatorInterface $validator
    )
    {
        $this->authorRepository = $authorRepository;
        $this->request = $requestStack->getCurrentRequest();
        $this->validator = $validator;
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