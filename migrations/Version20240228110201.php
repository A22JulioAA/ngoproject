<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228110201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer ADD id_organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EDB966056 FOREIGN KEY (id_organization_id) REFERENCES organization (id)');
        $this->addSql('CREATE INDEX IDX_29D6873EDB966056 ON offer (id_organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EDB966056');
        $this->addSql('DROP INDEX IDX_29D6873EDB966056 ON offer');
        $this->addSql('ALTER TABLE offer DROP id_organization_id');
    }
}
