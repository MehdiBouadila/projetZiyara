<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217091705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP id, CHANGE id_client id_client INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id_client)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client MODIFY id_client INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON client');
        $this->addSql('ALTER TABLE client ADD id INT NOT NULL, CHANGE id_client id_client VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }
}
