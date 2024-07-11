<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711205354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb25325980c0');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb25881ecfa7');
        $this->addSql('DROP INDEX idx_527edb25881ecfa7');
        $this->addSql('DROP INDEX idx_527edb25325980c0');
        $this->addSql('ALTER TABLE task ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task DROP employe_id_id');
        $this->addSql('ALTER TABLE task DROP status_id_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB251B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527EDB251B65292 ON task (employe_id)');
        $this->addSql('CREATE INDEX IDX_527EDB256BF700BD ON task (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB251B65292');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB256BF700BD');
        $this->addSql('DROP INDEX IDX_527EDB251B65292');
        $this->addSql('DROP INDEX IDX_527EDB256BF700BD');
        $this->addSql('ALTER TABLE task ADD employe_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD status_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task DROP employe_id');
        $this->addSql('ALTER TABLE task DROP status_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_527edb25325980c0 FOREIGN KEY (employe_id_id) REFERENCES employe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_527edb25881ecfa7 FOREIGN KEY (status_id_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_527edb25881ecfa7 ON task (status_id_id)');
        $this->addSql('CREATE INDEX idx_527edb25325980c0 ON task (employe_id_id)');
    }
}
