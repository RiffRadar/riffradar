<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406083112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id SERIAL NOT NULL, bar_id_id INT NOT NULL, date_time DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFB7940FC3 ON availability (bar_id_id)');
        $this->addSql('CREATE TABLE band (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, embed_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band_category (band_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(band_id, category_id))');
        $this->addSql('CREATE INDEX IDX_C60758CB49ABEB17 ON band_category (band_id)');
        $this->addSql('CREATE INDEX IDX_C60758CB12469DE2 ON band_category (category_id)');
        $this->addSql('CREATE TABLE bar (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, service TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN bar.service IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, category_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C19777D11E ON category (category_id_id)');
        $this->addSql('CREATE TABLE event (id SERIAL NOT NULL, bar_id_id INT NOT NULL, band_id_id INT NOT NULL, date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B7940FC3 ON event (bar_id_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA783A620CB ON event (band_id_id)');
        $this->addSql('CREATE TABLE subscribed_event (id SERIAL NOT NULL, userid_id INT NOT NULL, eventid_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40021B458E0A285 ON subscribed_event (userid_id)');
        $this->addSql('CREATE INDEX IDX_40021B43DAAA2E7 ON subscribed_event (eventid_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, token_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_band (id SERIAL NOT NULL, userid_id INT NOT NULL, bandid_id INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_325EEE2258E0A285 ON user_band (userid_id)');
        $this->addSql('CREATE INDEX IDX_325EEE2279570E17 ON user_band (bandid_id)');
        $this->addSql('CREATE TABLE user_bar (id SERIAL NOT NULL, user_id_id INT NOT NULL, bar_id_id INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DE9ED219D86650F ON user_bar (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9DE9ED21B7940FC3 ON user_bar (bar_id_id)');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFB7940FC3 FOREIGN KEY (bar_id_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B7940FC3 FOREIGN KEY (bar_id_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA783A620CB FOREIGN KEY (band_id_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B458E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscribed_event ADD CONSTRAINT FK_40021B43DAAA2E7 FOREIGN KEY (eventid_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2258E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2279570E17 FOREIGN KEY (bandid_id) REFERENCES band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED219D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED21B7940FC3 FOREIGN KEY (bar_id_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE availability DROP CONSTRAINT FK_3FB7A2BFB7940FC3');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB49ABEB17');
        $this->addSql('ALTER TABLE band_category DROP CONSTRAINT FK_C60758CB12469DE2');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C19777D11E');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7B7940FC3');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA783A620CB');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B458E0A285');
        $this->addSql('ALTER TABLE subscribed_event DROP CONSTRAINT FK_40021B43DAAA2E7');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE2258E0A285');
        $this->addSql('ALTER TABLE user_band DROP CONSTRAINT FK_325EEE2279570E17');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED219D86650F');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED21B7940FC3');
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
