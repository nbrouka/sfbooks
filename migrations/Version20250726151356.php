<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250726151356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_user DROP CONSTRAINT fk_940e9d4156ae248b');
        $this->addSql('DROP INDEX idx_940e9d4156ae248b');
        $this->addSql('ALTER TABLE book_user RENAME COLUMN user1_id TO user_id');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT FK_940E9D41A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_940E9D41A76ED395 ON book_user (user_id)');
        $this->addSql('CREATE SEQUENCE refresh_token_id_seq');
        $this->addSql('SELECT setval(\'refresh_token_id_seq\', (SELECT MAX(id) FROM refresh_token))');
        $this->addSql('ALTER TABLE refresh_token ALTER id SET DEFAULT nextval(\'refresh_token_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_user DROP CONSTRAINT FK_940E9D41A76ED395');
        $this->addSql('DROP INDEX IDX_940E9D41A76ED395');
        $this->addSql('ALTER TABLE book_user RENAME COLUMN user_id TO user1_id');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT fk_940e9d4156ae248b FOREIGN KEY (user1_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_940e9d4156ae248b ON book_user (user1_id)');
        $this->addSql('ALTER TABLE refresh_token ALTER id DROP DEFAULT');
    }
}
