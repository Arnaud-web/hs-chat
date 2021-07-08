<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708091021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_vu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article_vu (id INT NOT NULL, article_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D57EA8F07294869C ON article_vu (article_id)');
        $this->addSql('CREATE TABLE article_vu_user (article_vu_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(article_vu_id, user_id))');
        $this->addSql('CREATE INDEX IDX_B27DB3E52E6DCEF ON article_vu_user (article_vu_id)');
        $this->addSql('CREATE INDEX IDX_B27DB3E5A76ED395 ON article_vu_user (user_id)');
        $this->addSql('ALTER TABLE article_vu ADD CONSTRAINT FK_D57EA8F07294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_vu_user ADD CONSTRAINT FK_B27DB3E52E6DCEF FOREIGN KEY (article_vu_id) REFERENCES article_vu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_vu_user ADD CONSTRAINT FK_B27DB3E5A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article_vu_user DROP CONSTRAINT FK_B27DB3E52E6DCEF');
        $this->addSql('DROP SEQUENCE article_vu_id_seq CASCADE');
        $this->addSql('DROP TABLE article_vu');
        $this->addSql('DROP TABLE article_vu_user');
    }
}
