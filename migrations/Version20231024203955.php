<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024203955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD room_id INT DEFAULT NULL, CHANGE nom name VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D54177093 ON car (room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D54177093');
        $this->addSql('DROP INDEX IDX_773DE69D54177093 ON car');
        $this->addSql('ALTER TABLE car DROP room_id, CHANGE name nom VARCHAR(55) NOT NULL');
    }
}
