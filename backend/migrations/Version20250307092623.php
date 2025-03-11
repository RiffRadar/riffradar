<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307092623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_bar (id SERIAL NOT NULL, user_id_id INT NOT NULL, bar_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DE9ED219D86650F ON user_bar (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9DE9ED21B7940FC3 ON user_bar (bar_id_id)');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED219D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_bar ADD CONSTRAINT FK_9DE9ED21B7940FC3 FOREIGN KEY (bar_id_id) REFERENCES bar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED219D86650F');
        $this->addSql('ALTER TABLE user_bar DROP CONSTRAINT FK_9DE9ED21B7940FC3');
        $this->addSql('DROP TABLE user_bar');
    }
}
