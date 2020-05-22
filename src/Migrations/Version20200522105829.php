<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522105829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transactions (id INT NOT NULL, uid_id INT DEFAULT NULL, amount INT NOT NULL, tid VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAA81A4C534B549B ON transactions (uid_id)');
        $this->addSql('CREATE TABLE account (id INT NOT NULL, balance INT NOT NULL, uid VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C534B549B FOREIGN KEY (uid_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C534B549B');
        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE account');
    }
}
