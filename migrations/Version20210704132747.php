<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704132747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_vu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, user_send_id INT DEFAULT NULL, user_receved_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, idm VARCHAR(255) NOT NULL, send_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, new BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F4B9E2071 ON message (user_send_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F86A29159 ON message (user_receved_id)');
        $this->addSql('CREATE TABLE message_vu (id INT NOT NULL, user_id INT DEFAULT NULL, message_id INT DEFAULT NULL, vu_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F4903D45A76ED395 ON message_vu (user_id)');
        $this->addSql('CREATE INDEX IDX_F4903D45537A1329 ON message_vu (message_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON "user" (name)');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
        $this->addSql('CREATE TABLE user_photo (id INT NOT NULL, user_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F6757F40A76ED395 ON user_photo (user_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4B9E2071 FOREIGN KEY (user_send_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F86A29159 FOREIGN KEY (user_receved_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message_vu ADD CONSTRAINT FK_F4903D45A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message_vu ADD CONSTRAINT FK_F4903D45537A1329 FOREIGN KEY (message_id) REFERENCES message (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_photo ADD CONSTRAINT FK_F6757F40A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE message_vu DROP CONSTRAINT FK_F4903D45537A1329');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F4B9E2071');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F86A29159');
        $this->addSql('ALTER TABLE message_vu DROP CONSTRAINT FK_F4903D45A76ED395');
        $this->addSql('ALTER TABLE user_user DROP CONSTRAINT FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP CONSTRAINT FK_F7129A80233D34C1');
        $this->addSql('ALTER TABLE user_photo DROP CONSTRAINT FK_F6757F40A76ED395');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_vu_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_photo_id_seq CASCADE');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_vu');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE user_photo');
    }
}
