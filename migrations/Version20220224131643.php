<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224131643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_panier ADD product_id INT NOT NULL, ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B44584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B41AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_21691B44584665A ON ligne_panier (product_id)');
        $this->addSql('CREATE INDEX IDX_21691B41AD5CDBF ON ligne_panier (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B44584665A');
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B41AD5CDBF');
        $this->addSql('DROP INDEX IDX_21691B44584665A ON ligne_panier');
        $this->addSql('DROP INDEX IDX_21691B41AD5CDBF ON ligne_panier');
        $this->addSql('ALTER TABLE ligne_panier DROP product_id, DROP cart_id');
    }
}
