<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224221834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282C4584665A ON commandes (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C4584665A');
        $this->addSql('DROP INDEX UNIQ_35D4282C4584665A ON commandes');
        $this->addSql('ALTER TABLE commandes DROP product_id');
    }
}
