<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230815065734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD monthly_consumption_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB5EF8A300 FOREIGN KEY (monthly_consumption_id) REFERENCES monthly_consumption (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB5EF8A300 ON location (monthly_consumption_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB5EF8A300');
        $this->addSql('DROP INDEX IDX_5E9E89CB5EF8A300 ON location');
        $this->addSql('ALTER TABLE location DROP monthly_consumption_id');
    }
}
