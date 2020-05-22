<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522125452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, uid_id INT DEFAULT NULL, amount INT NOT NULL, tid VARCHAR(32) NOT NULL, type VARCHAR(6) NOT NULL, transaction_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D152596C31 ON transaction (tid)');
        $this->addSql('CREATE INDEX IDX_723705D1534B549B ON transaction (uid_id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1534B549B FOREIGN KEY (uid_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE transactions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE transaction_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transactions (id INT NOT NULL, uid_id INT DEFAULT NULL, amount INT NOT NULL, tid VARCHAR(32) NOT NULL, type VARCHAR(6) NOT NULL, transaction_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_eaa81a4c52596c31 ON transactions (tid)');
        $this->addSql('CREATE INDEX idx_eaa81a4c534b549b ON transactions (uid_id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT fk_eaa81a4c534b549b FOREIGN KEY (uid_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE transaction');
    }
}
