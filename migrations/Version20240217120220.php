<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217120220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_pack (id INT AUTO_INCREMENT NOT NULL, pack_id INT DEFAULT NULL, date_reservation_pack DATETIME NOT NULL, nbr_participant_pack INT NOT NULL, INDEX IDX_81E7934B1919B217 (pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, prix_transport INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_pack ADD CONSTRAINT FK_81E7934B1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack ADD transports_id INT DEFAULT NULL, ADD guide_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23518E99D9 FOREIGN KEY (transports_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97DE5E23518E99D9 ON pack (transports_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97DE5E23D7ED1D4B ON pack (guide_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23518E99D9');
        $this->addSql('ALTER TABLE reservation_pack DROP FOREIGN KEY FK_81E7934B1919B217');
        $this->addSql('DROP TABLE reservation_pack');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23D7ED1D4B');
        $this->addSql('DROP INDEX UNIQ_97DE5E23518E99D9 ON pack');
        $this->addSql('DROP INDEX UNIQ_97DE5E23D7ED1D4B ON pack');
        $this->addSql('ALTER TABLE pack DROP transports_id, DROP guide_id');
    }
}
