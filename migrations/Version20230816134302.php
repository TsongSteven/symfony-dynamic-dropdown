<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816134302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mc (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, location_id INT DEFAULT NULL, family VARCHAR(255) NOT NULL, pg VARCHAR(255) NOT NULL, hostel VARCHAR(255) NOT NULL, hotel VARCHAR(255) NOT NULL, restaurant VARCHAR(255) NOT NULL, INDEX IDX_453137F712469DE2 (category_id), INDEX IDX_453137F764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mc ADD CONSTRAINT FK_453137F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mc ADD CONSTRAINT FK_453137F764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mc DROP FOREIGN KEY FK_453137F712469DE2');
        $this->addSql('ALTER TABLE mc DROP FOREIGN KEY FK_453137F764D218E');
        $this->addSql('DROP TABLE mc');
    }
}
