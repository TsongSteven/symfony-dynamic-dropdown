<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820084301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population ADD family_count VARCHAR(255) NOT NULL, ADD hostel_count VARCHAR(255) NOT NULL, ADD hotel_count VARCHAR(255) NOT NULL, ADD restaurant_count VARCHAR(255) NOT NULL, DROP family, DROP hostel, DROP hotel, DROP restaurant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE population ADD family VARCHAR(255) NOT NULL, ADD hostel VARCHAR(255) NOT NULL, ADD hotel VARCHAR(255) NOT NULL, ADD restaurant VARCHAR(255) NOT NULL, DROP family_count, DROP hostel_count, DROP hotel_count, DROP restaurant_count');
    }
}
