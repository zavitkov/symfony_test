<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914130536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_translation ADD translatable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book_translation ADD locale VARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE book_translation ADD CONSTRAINT FK_E69E0A132C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E69E0A132C2AC5D3 ON book_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX book_translation_unique_translation ON book_translation (translatable_id, locale)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_translation DROP CONSTRAINT FK_E69E0A132C2AC5D3');
        $this->addSql('DROP INDEX IDX_E69E0A132C2AC5D3');
        $this->addSql('DROP INDEX book_translation_unique_translation');
        $this->addSql('ALTER TABLE book_translation DROP translatable_id');
        $this->addSql('ALTER TABLE book_translation DROP locale');
    }
}
