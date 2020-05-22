<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522112730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE transactions ADD type VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE transactions ADD transaction_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA81A4C52596C31 ON transactions (tid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4539B0606 ON account (uid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX UNIQ_7D3656A4539B0606');
        $this->addSql('DROP INDEX UNIQ_EAA81A4C52596C31');
        $this->addSql('ALTER TABLE transactions DROP type');
        $this->addSql('ALTER TABLE transactions DROP transaction_date');
    }
}
