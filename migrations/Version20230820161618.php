<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820161618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mc ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mc ADD CONSTRAINT FK_453137F798260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_453137F798260155 ON mc (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mc DROP FOREIGN KEY FK_453137F798260155');
        $this->addSql('DROP INDEX IDX_453137F798260155 ON mc');
        $this->addSql('ALTER TABLE mc DROP region_id');
    }
}
