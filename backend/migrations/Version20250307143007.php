<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307143007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id SERIAL NOT NULL, barid_id INT NOT NULL, bandid_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, time TIME(0) WITHOUT TIME ZONE NOT NULL, enum VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA725A1FA7E ON event (barid_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA779570E17 ON event (bandid_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA725A1FA7E FOREIGN KEY (barid_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA779570E17 FOREIGN KEY (bandid_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA725A1FA7E');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA779570E17');
        $this->addSql('DROP TABLE event');
    }
}
