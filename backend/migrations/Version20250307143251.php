<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307143251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscribed_event (id SERIAL NOT NULL, userid_id INT NOT NULL, eventid_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40021B458E0A285 ON subscribed_event (userid_id)');
        $this->addSql('CREATE INDEX IDX_40021B43DAAA2E7 ON subscribed_event (eventid_id)');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B458E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B43DAAA2E7 FOREIGN KEY (eventid_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B458E0A285');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B43DAAA2E7');
        $this->addSql('DROP TABLE subscribed_event');
    }
}
