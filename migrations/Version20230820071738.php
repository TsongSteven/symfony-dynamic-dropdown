<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820071738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE population ADD CONSTRAINT FK_B449A00864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B449A00864D218E ON population (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population DROP FOREIGN KEY FK_B449A00864D218E');
        $this->addSql('DROP INDEX UNIQ_B449A00864D218E ON population');
        $this->addSql('ALTER TABLE population DROP location_id');
    }
}
