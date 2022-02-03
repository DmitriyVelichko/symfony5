<?php

namespace App\Service;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookService
{
    public BookRepository $bookRepository;
    public Request $request;
    public TranslatorInterface $translator;
    public array $query;
    public string $locale;

    public function __construct(
        BookRepository $bookRepository,
        RequestStack $requestStack,
        TranslatorInterface $translator
    )
    {
        $this->bookRepository = $bookRepository;
        $this->request = $requestStack->getCurrentRequest();
        $this->query = $this->request->query->all();
        $this->locale = $this->request->getLocale();
        $this->translator = $translator;
    }

    /**
     * @return int
     */
    public function create(): int
    {
        try {
            $result = $this->bookRepository->create($this->query, $this->request->getLocale());
        } catch (\Throwable $throwable) {
            throw new BadRequestException($throwable->getMessage());
        }
        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public function search($id = null): array
    {
        $this->setId($id);
        $books = $this->bookRepository->search($this->query);
        $this->validate($books);
        $books = $this->translate($books);
        return $this->reformate($books);
    }

    private function reformate($books)
    {
        $result = [];
        foreach ($books as $book) {
            $result[$book['book_id']]['id'] = $book['book_id'];
            $result[$book['book_id']]['id'] = $book['book_id'];
            $result[$book['book_id']]['name'] = $book['book_name'];
            $result[$book['book_id']]['author'][] = ['id' => $book['author_id'], 'name' => $book['author_name']];
        }
        return array_values($result);
    }

    private function setId($id)
    {
        if(ctype_digit($id)) {
            $this->query['id'] = $id;
        }
    }

    private function translate($books)
    {
        foreach ($books as $key => $book) {
            if($book['book_lang'] != $this->locale) {
                $books[$key]['book_name'] = $this->translator->trans($book['book_name'], [], 'book');
            }
        }
        return $books;
    }

    private function validate($books)
    {
        if(empty($books)) {
            throw new BadRequestException('Ничего не найдено', Response::HTTP_BAD_REQUEST);
        }
    }
}