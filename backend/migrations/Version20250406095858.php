<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406095858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id SERIAL NOT NULL, bar_id INT NOT NULL, date_time DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF89A253A ON availability (bar_id)');
        $this->addSql('CREATE TABLE band (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, embed_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band_category (band_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(band_id, category_id))');
        $this->addSql('CREATE INDEX IDX_C60758CB49ABEB17 ON band_category (band_id)');
        $this->addSql('CREATE INDEX IDX_C60758CB12469DE2 ON band_category (category_id)');
        $this->addSql('CREATE TABLE bar (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, service TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN bar.service IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C112469DE2 ON category (category_id)');
        $this->addSql('CREATE TABLE event (id SERIAL NOT NULL, bar_id INT NOT NULL, band_id INT NOT NULL, date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA789A253A ON event (bar_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA749ABEB17 ON event (band_id)');
        $this->addSql('CREATE TABLE subscribed_event (id SERIAL NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40021B4A76ED395 ON subscribed_event (user_id)');
        $this->addSql('CREATE INDEX IDX_40021B471F7E88B ON subscribed_event (event_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, token_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_band (id SERIAL NOT NULL, user_id INT NOT NULL, band_id INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_325EEE22A76ED395 ON user_band (user_id)');
        $this->addSql('CREATE INDEX IDX_325EEE2249ABEB17 ON user_band (band_id)');
        $this->addSql('CREATE TABLE user_bar (id SERIAL NOT NULL, user_id INT NOT NULL, bar_id INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DE9ED21A76ED395 ON user_bar (user_id)');
        $this->addSql('CREATE INDEX IDX_9DE9ED2189A253A ON user_bar (bar_id)');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF89A253A FOREIGN KEY (bar_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA789A253A FOREIGN KEY (bar_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA749ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B4A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE22A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED21A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED2189A253A FOREIGN KEY (bar_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE availability DROP CONSTRAINT FK_3FB7A2BF89A253A');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB49ABEB17');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB12469DE2');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C112469DE2');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA789A253A');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA749ABEB17');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B4A76ED395');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B471F7E88B');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE22A76ED395');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE2249ABEB17');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED21A76ED395');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED2189A253A');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_category');
        $this->addSql('DROP TABLE bar');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE subscribed_event');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_band');
        $this->addSql('DROP TABLE user_bar');
    }
}
