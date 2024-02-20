<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220033351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD cat VARCHAR(255) NOT NULL, ADD catt_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279595381F FOREIGN KEY (catt_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC279595381F ON produit (catt_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279595381F');
        $this->addSql('DROP INDEX IDX_29A5EC279595381F ON produit');
        $this->addSql('ALTER TABLE produit DROP cat, DROP catt_id');
    }
}
