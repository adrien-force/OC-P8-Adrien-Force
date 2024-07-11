<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711194437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE timeslot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employe (id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, role INT NOT NULL, contract VARCHAR(255) NOT NULL, arrival_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, active INT NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN employe.arrival_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE employe_project (employe_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(employe_id, project_id))');
        $this->addSql('CREATE INDEX IDX_EBBCBC4D1B65292 ON employe_project (employe_id)');
        $this->addSql('CREATE INDEX IDX_EBBCBC4D166D1F9C ON employe_project (project_id)');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, status_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, archive INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE6BF700BD ON project (status_id)');
        $this->addSql('COMMENT ON COLUMN project.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN project.deadline IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag_project (tag_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(tag_id, project_id))');
        $this->addSql('CREATE INDEX IDX_1D82FD44BAD26311 ON tag_project (tag_id)');
        $this->addSql('CREATE INDEX IDX_1D82FD44166D1F9C ON tag_project (project_id)');
        $this->addSql('CREATE TABLE tag_task (tag_id INT NOT NULL, task_id INT NOT NULL, PRIMARY KEY(tag_id, task_id))');
        $this->addSql('CREATE INDEX IDX_BC716493BAD26311 ON tag_task (tag_id)');
        $this->addSql('CREATE INDEX IDX_BC7164938DB60186 ON tag_task (task_id)');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, employe_id_id INT DEFAULT NULL, status_id_id INT DEFAULT NULL, project_id_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB25325980C0 ON task (employe_id_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25881ECFA7 ON task (status_id_id)');
        $this->addSql('CREATE INDEX IDX_527EDB256C1197C9 ON task (project_id_id)');
        $this->addSql('CREATE TABLE timeslot (id INT NOT NULL, task_id_id INT NOT NULL, start TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, stop_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BE452F7B8E08577 ON timeslot (task_id_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE employe_project ADD CONSTRAINT FK_EBBCBC4D1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employe_project ADD CONSTRAINT FK_EBBCBC4D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_project ADD CONSTRAINT FK_1D82FD44BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_project ADD CONSTRAINT FK_1D82FD44166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_task ADD CONSTRAINT FK_BC716493BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_task ADD CONSTRAINT FK_BC7164938DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25325980C0 FOREIGN KEY (employe_id_id) REFERENCES employe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE timeslot ADD CONSTRAINT FK_3BE452F7B8E08577 FOREIGN KEY (task_id_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE employe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE timeslot_id_seq CASCADE');
        $this->addSql('ALTER TABLE employe_project DROP CONSTRAINT FK_EBBCBC4D1B65292');
        $this->addSql('ALTER TABLE employe_project DROP CONSTRAINT FK_EBBCBC4D166D1F9C');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE tag_project DROP CONSTRAINT FK_1D82FD44BAD26311');
        $this->addSql('ALTER TABLE tag_project DROP CONSTRAINT FK_1D82FD44166D1F9C');
        $this->addSql('ALTER TABLE tag_task DROP CONSTRAINT FK_BC716493BAD26311');
        $this->addSql('ALTER TABLE tag_task DROP CONSTRAINT FK_BC7164938DB60186');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25325980C0');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25881ECFA7');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB256C1197C9');
        $this->addSql('ALTER TABLE timeslot DROP CONSTRAINT FK_3BE452F7B8E08577');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_project');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_project');
        $this->addSql('DROP TABLE tag_task');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE timeslot');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
