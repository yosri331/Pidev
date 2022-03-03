<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220303202938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_naissance VARCHAR(30) NOT NULL, password VARCHAR(100) NOT NULL, num_tel INT DEFAULT NULL, pays VARCHAR(30) NOT NULL, type VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog CHANGE date_blog date_blog VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE date date VARCHAR(250) NOT NULL, CHANGE id_prod id_prod INT NOT NULL, CHANGE id_user id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE60640479F37AE5 ON reclamation (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640479F37AE5');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE blog CHANGE date_blog date_blog DATE NOT NULL');
        $this->addSql('DROP INDEX IDX_CE60640479F37AE5 ON reclamation');
        $this->addSql('ALTER TABLE reclamation CHANGE date date VARCHAR(255) DEFAULT NULL, CHANGE id_prod id_prod INT DEFAULT NULL, CHANGE id_user_id id_user INT NOT NULL');
    }
}
