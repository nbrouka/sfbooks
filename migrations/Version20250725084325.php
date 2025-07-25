<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725084325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('CREATE TABLE book_user (id SERIAL NOT NULL, book_id INT DEFAULT NULL, user1_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_940E9D4116A2B381 ON book_user (book_id)');
        $this->addSql('CREATE INDEX IDX_940E9D4156AE248B ON book_user (user1_id)');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT FK_940E9D4116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT FK_940E9D4156AE248B FOREIGN KEY (user1_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER INDEX uniq_9bace7e1c74f2195 RENAME TO UNIQ_C74F2195C74F2195');
        $this->addSql('ALTER INDEX idx_9bace7e1a76ed395 RENAME TO IDX_C74F2195A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE book_user DROP CONSTRAINT FK_940E9D4116A2B381');
        $this->addSql('ALTER TABLE book_user DROP CONSTRAINT FK_940E9D4156AE248B');
        $this->addSql('DROP TABLE book_user');
        $this->addSql('ALTER INDEX idx_c74f2195a76ed395 RENAME TO idx_9bace7e1a76ed395');
        $this->addSql('ALTER INDEX uniq_c74f2195c74f2195 RENAME TO uniq_9bace7e1c74f2195');
    }
}
