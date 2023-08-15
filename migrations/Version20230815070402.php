<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230815070402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category ADD monthly_consumption_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F7985EF8A300 FOREIGN KEY (monthly_consumption_id) REFERENCES monthly_consumption (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F7985EF8A300 ON sub_category (monthly_consumption_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F7985EF8A300');
        $this->addSql('DROP INDEX IDX_BCE3F7985EF8A300 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP monthly_consumption_id');
    }
}
