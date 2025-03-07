<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307085808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disponibility (id SERIAL NOT NULL, bar_id_id INT NOT NULL, date DATE NOT NULL, time TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_38BB9260B7940FC3 ON disponibility (bar_id_id)');
        $this->addSql('ALTER TABLE disponibility ADD CONSTRAINT FK_38BB9260B7940FC3 FOREIGN KEY (bar_id_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE disponibility DROP CONSTRAINT FK_38BB9260B7940FC3');
        $this->addSql('DROP TABLE disponibility');
    }
}
