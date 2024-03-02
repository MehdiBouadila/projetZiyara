<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229222132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_visite (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_visite_id INT DEFAULT NULL, INDEX IDX_8933C43279F37AE5 (id_user_id), INDEX IDX_8933C43241F0607E (id_visite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_visite (id INT AUTO_INCREMENT NOT NULL, id_visite_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, date_reservation_visite DATE NOT NULL, nbrparticipant_visite INT NOT NULL, UNIQUE INDEX UNIQ_F86DC52041F0607E (id_visite_id), INDEX IDX_F86DC52079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, categorie_visite_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description_visite VARCHAR(255) NOT NULL, date_visite DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, imagev VARCHAR(255) NOT NULL, INDEX IDX_B09C8CBB6C9AD35E (categorie_visite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43241F0607E FOREIGN KEY (id_visite_id) REFERENCES visite (id)');
        $this->addSql('ALTER TABLE reservation_visite ADD CONSTRAINT FK_F86DC52041F0607E FOREIGN KEY (id_visite_id) REFERENCES visite (id)');
        $this->addSql('ALTER TABLE reservation_visite ADD CONSTRAINT FK_F86DC52079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB6C9AD35E FOREIGN KEY (categorie_visite_id) REFERENCES categorie_visite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43279F37AE5');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43241F0607E');
        $this->addSql('ALTER TABLE reservation_visite DROP FOREIGN KEY FK_F86DC52041F0607E');
        $this->addSql('ALTER TABLE reservation_visite DROP FOREIGN KEY FK_F86DC52079F37AE5');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB6C9AD35E');
        $this->addSql('DROP TABLE categorie_visite');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE reservation_visite');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
