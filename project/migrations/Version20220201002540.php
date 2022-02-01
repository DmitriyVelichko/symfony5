<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201002540 extends AbstractMigration
{
    public EntityManagerInterface $entityManager;

    public function __construct(Connection $connection, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        parent::__construct($connection, $logger);
        $this->entityManager = $entityManager;
    }

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $authorRepository = $this->entityManager->getRepository(Author::class);

        for($i=1; $i<10000; $i++) {
            $authorId = $authorRepository->create([
                'name' => 'Автор ' . $i
            ]);
            $author = $authorRepository->find($authorId);
            $bookId = $this->entityManager->getRepository(Book::class)->create([
                'name' => 'Книга ' . $i,
                'author_id' => $author,
                'lang' => 'ru'
            ]);
            $bookId = $this->entityManager->getRepository(Book::class)->create([
                'name' => 'Book ' . $i,
                'author_id' => $author,
                'lang' => 'en'
            ]);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('truncate table book');
        $this->addSql('truncate table author');
    }
}
