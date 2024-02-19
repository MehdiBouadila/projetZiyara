<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218103349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_visite (id INT AUTO_INCREMENT NOT NULL, id_visite_id INT DEFAULT NULL, date_reservation_visite DATE NOT NULL, nbrparticipant_visite INT NOT NULL, UNIQUE INDEX UNIQ_F86DC52041F0607E (id_visite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_visite ADD CONSTRAINT FK_F86DC52041F0607E FOREIGN KEY (id_visite_id) REFERENCES visite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_visite DROP FOREIGN KEY FK_F86DC52041F0607E');
        $this->addSql('DROP TABLE reservation_visite');
    }
}
