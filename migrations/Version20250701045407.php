<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701045407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add the column as nullable first
        $this->addSql('ALTER TABLE oficio ADD created_at DATETIME DEFAULT NULL');
        
        // Set a default date for existing records
        $this->addSql("UPDATE oficio SET created_at = NOW() WHERE created_at IS NULL");
        
        // Change the column to NOT NULL
        $this->addSql('ALTER TABLE oficio MODIFY created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oficio DROP created_at');
    }
}
