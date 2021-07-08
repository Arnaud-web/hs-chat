<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708111808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE like_article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE like_article (id INT NOT NULL, article_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51B744457294869C ON like_article (article_id)');
        $this->addSql('CREATE TABLE like_article_user (like_article_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(like_article_id, user_id))');
        $this->addSql('CREATE INDEX IDX_37623A81D1002664 ON like_article_user (like_article_id)');
        $this->addSql('CREATE INDEX IDX_37623A81A76ED395 ON like_article_user (user_id)');
        $this->addSql('ALTER TABLE like_article ADD CONSTRAINT FK_51B744457294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE like_article_user ADD CONSTRAINT FK_37623A81D1002664 FOREIGN KEY (like_article_id) REFERENCES like_article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE like_article_user ADD CONSTRAINT FK_37623A81A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE like_article_user DROP CONSTRAINT FK_37623A81D1002664');
        $this->addSql('DROP SEQUENCE like_article_id_seq CASCADE');
        $this->addSql('DROP TABLE like_article');
        $this->addSql('DROP TABLE like_article_user');
    }
}
