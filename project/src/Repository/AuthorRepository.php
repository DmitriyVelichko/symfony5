<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    private $validator;
    public function __construct(
        ManagerRegistry $registry,
        ValidatorInterface $validator
    )
    {
        parent::__construct($registry, Author::class);
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $entityManager = $this->getEntityManager();
        $author = new Author();
        if(!empty($data['name'])) {
            $author->setName((string)$data['name']);
        }
        $entityManager->persist($author);

        $errors = $this->validator->validate($author);
        if (count($errors) > 0) {
            throw new BadRequestException('Ошибка валидации полей');
        }
        $entityManager->flush();

        return $author->getId();
    }

    /**
     * @param array $data
     * @return array
     */
    public function search(array $data): array
    {
        $query = $this->createQueryBuilder('a');

        if(!empty($data['id'])) {
            $query->andWhere('a.id = :authorId')->setParameter('authorId', $data['id']);
        }
        if(!empty($data['name'])) {
            $query->andWhere('a.name = :authorName')->setParameter('authorName', $data['name']);
        }

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    // /**
    //  * @return Author[] Returns an array of Author objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
