<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712121734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE timeslot DROP CONSTRAINT fk_3be452f7b8e08577');
        $this->addSql('DROP INDEX uniq_3be452f7b8e08577');
        $this->addSql('ALTER TABLE timeslot RENAME COLUMN task_id_id TO task_id');
        $this->addSql('ALTER TABLE timeslot ADD CONSTRAINT FK_3BE452F78DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BE452F78DB60186 ON timeslot (task_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE timeslot DROP CONSTRAINT FK_3BE452F78DB60186');
        $this->addSql('DROP INDEX UNIQ_3BE452F78DB60186');
        $this->addSql('ALTER TABLE timeslot RENAME COLUMN task_id TO task_id_id');
        $this->addSql('ALTER TABLE timeslot ADD CONSTRAINT fk_3be452f7b8e08577 FOREIGN KEY (task_id_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_3be452f7b8e08577 ON timeslot (task_id_id)');
    }
}
