<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230815070154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monthly_consumption ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monthly_consumption ADD CONSTRAINT FK_B1E4473612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B1E4473612469DE2 ON monthly_consumption (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monthly_consumption DROP FOREIGN KEY FK_B1E4473612469DE2');
        $this->addSql('DROP INDEX IDX_B1E4473612469DE2 ON monthly_consumption');
        $this->addSql('ALTER TABLE monthly_consumption DROP category_id');
    }
}
