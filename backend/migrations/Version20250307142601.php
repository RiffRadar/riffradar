<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307142601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_band (id SERIAL NOT NULL, userid_id INT NOT NULL, bandid_id INT NOT NULL, enum VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_325EEE2258E0A285 ON user_band (userid_id)');
        $this->addSql('CREATE INDEX IDX_325EEE2279570E17 ON user_band (bandid_id)');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2258E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2279570E17 FOREIGN KEY (bandid_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE2258E0A285');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE2279570E17');
        $this->addSql('DROP TABLE user_band');
    }
}
