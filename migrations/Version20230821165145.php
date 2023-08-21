<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821165145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population ADD region_id INT DEFAULT NULL, CHANGE pg pg_count VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE population ADD CONSTRAINT FK_B449A00898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B449A00898260155 ON population (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population DROP FOREIGN KEY FK_B449A00898260155');
        $this->addSql('DROP INDEX UNIQ_B449A00898260155 ON population');
        $this->addSql('ALTER TABLE population DROP region_id, CHANGE pg_count pg VARCHAR(255) NOT NULL');
    }
}
