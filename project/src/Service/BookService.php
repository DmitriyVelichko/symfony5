<?php

namespace App\Service;

use App\Repository\BookRepository;
use http\Exception\BadQueryStringException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookService
{
    public $bookRepository;
    public $request;
    public $validator;

    public function __construct(
        BookRepository $bookRepository,
        RequestStack $requestStack,
        ValidatorInterface $validator
    )
    {
        $this->bookRepository = $bookRepository;
        $this->request = $requestStack->getCurrentRequest();
        $this->validator = $validator;
    }

    /**
     * @return int
     */
    public function create(): int
    {
        $data = $this->request->query->all();
        try {
            $result = $this->bookRepository->create($data);
        } catch (\Throwable $throwable) {
            throw new BadQueryStringException($throwable->getMessage());
        }
        return $result;
    }

    /**
     * @return array
     */
    public function search(): array
    {
        $data = $this->request->query->all();
        return $this->bookRepository->search($data);
    }
}