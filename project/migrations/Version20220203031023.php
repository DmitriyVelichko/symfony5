<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203031023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE DATABASE symfony_base_test');
        $this->addSql('
            CREATE TABLE symfony_base_test.author (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE KEY
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE symfony_base_test.book (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE KEY,
                lang VARCHAR(255) NOT NULL                
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE symfony_base_test.book_author (
                author_id INT NOT NULL, 
                book_id INT NOT NULL, 
                INDEX IDX_9478D345F675F31B (author_id), 
                INDEX IDX_9478D34516A2B381 (book_id), 
                PRIMARY KEY(book_id, author_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE symfony_base_test.book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON UPDATE RESTRICT ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE symfony_base_test.book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE RESTRICT ON DELETE RESTRICT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D345F675F31B');
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D34516A2B381');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_author');
        $this->addSql('DROP DATABASE symfony_base_test');
    }
}
