<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203225709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, type VARCHAR(128) NOT NULL, occurred_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sent TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, payload JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.occurred_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.sent IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE event');
    }
}
