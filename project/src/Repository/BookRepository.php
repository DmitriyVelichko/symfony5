<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    private $validator;
    public function __construct(
        ManagerRegistry $registry,
        ValidatorInterface $validator
    )
    {
        parent::__construct($registry, Book::class);
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @param string $locale
     * @return int
     */
    public function create(array $data, string $locale): int
    {
        $entityManager = $this->getEntityManager();
        $book = new Book();

        if(!empty($data['name'])) {
            $book->setName((string)$data['name']);
        }
        if(!empty($data['author'])) {
            $author = $entityManager->getRepository(Author::class)->findOneBy(['name' => (string)$data['author']]);
            $book->addAuthor($author);
        }
        $book->setLang($locale);
        $entityManager->persist($book);

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            throw new BadRequestException('Ошибка валидации полей');
        }
        $entityManager->flush();

        return $book->getId();
    }

    /**
     * @param array $data
     * @return array
     */
    public function search(array $data): array
    {
        $query = $this->createQueryBuilder('b');
        $query->select([
            'a.id as author_id',
            'b.lang as book_lang',
            'b.name as book_name',
            'b.id as book_id',
            'a.name as author_name'
        ]);
        $query->leftJoin('b.authors', 'a');
        if(!empty($data['id'])) {
            $query->andWhere('b.id = :bookId')->setParameter('bookId', $data['id']);
        }
        if(!empty($data['name'])) {
            $query->andWhere('b.name = :bookName')->setParameter('bookName', $data['name']);
        }

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
