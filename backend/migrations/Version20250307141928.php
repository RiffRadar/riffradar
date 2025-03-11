<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307141928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, embed_link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band_category (band_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(band_id, category_id))');
        $this->addSql('CREATE INDEX IDX_C60758CB49ABEB17 ON band_category (band_id)');
        $this->addSql('CREATE INDEX IDX_C60758CB12469DE2 ON band_category (category_id)');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB49ABEB17');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB12469DE2');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_category');
    }
}
