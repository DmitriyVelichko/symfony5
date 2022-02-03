<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201002540 extends AbstractMigration
{
    use MicroKernelTrait;

    private const TABLE_BOOK = 'book';
    private const TABLE_AUTHOR = 'author';

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $book_autor = [];
        for($i=1; $i<10000; $i++) {

            $connA = $this->connection;
            $stmt = $connA->prepare('INSERT INTO author (name) values(:name)');
            $stmt->bindValue('name', 'Автор ' . $i);
            $stmt->executeStatement();
            $authorId = $connA->lastInsertId();

            $connBr = $this->connection;
            $stmt = $connBr->prepare('INSERT INTO book (name, lang) values(:name_book, :lang)');
            $stmt->bindValue('name_book', 'Книга ' . $i);
            $stmt->bindValue('lang', 'ru');
            $stmt->executeStatement();
            $bookIdRu = $connBr->lastInsertId();

            $connBe = $this->connection;
            $stmt = $connBe->prepare('INSERT INTO book (name, lang) values(:name_book, :lang)');
            $stmt->bindValue('name_book', 'Book ' . $i);
            $stmt->bindValue('lang', 'en');
            $stmt->executeStatement();
            $bookIdEn = $connBe->lastInsertId();

            $book_autor[] = ['author_id' => $authorId, 'book_id' => $bookIdRu];
            $book_autor[] = ['author_id' => $authorId, 'book_id' => $bookIdEn];
        }

        foreach ($book_autor as $row) {
            $connAB = $this->connection;
            $stmt = $connAB->prepare('INSERT INTO book_author (book_id, author_id) values(:book_id, :author_id)');
            $stmt->bindValue('book_id', (int)$row['book_id']);
            $stmt->bindValue('author_id', (int)$row['author_id']);
            $stmt->executeStatement();
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('truncate table book');
        $this->addSql('truncate table author');
    }
}
