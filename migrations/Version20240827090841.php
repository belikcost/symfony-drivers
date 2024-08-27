<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827090841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE driver_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE driver_log (id INT NOT NULL, driver_id INT NOT NULL, old_car_id INT DEFAULT NULL, new_car_id INT NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DF4FACBC3423909 ON driver_log (driver_id)');
        $this->addSql('CREATE INDEX IDX_9DF4FACB8A092518 ON driver_log (old_car_id)');
        $this->addSql('CREATE INDEX IDX_9DF4FACB3B5CCEB5 ON driver_log (new_car_id)');
        $this->addSql('COMMENT ON COLUMN driver_log.changed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE driver_log ADD CONSTRAINT FK_9DF4FACBC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE driver_log ADD CONSTRAINT FK_9DF4FACB8A092518 FOREIGN KEY (old_car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE driver_log ADD CONSTRAINT FK_9DF4FACB3B5CCEB5 FOREIGN KEY (new_car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE driver ALTER car_id SET NOT NULL');
        $this->addSql('ALTER TABLE driver ALTER COLUMN birthdate TYPE DATE USING birthdate::date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE driver_log_id_seq CASCADE');
        $this->addSql('ALTER TABLE driver_log DROP CONSTRAINT FK_9DF4FACBC3423909');
        $this->addSql('ALTER TABLE driver_log DROP CONSTRAINT FK_9DF4FACB8A092518');
        $this->addSql('ALTER TABLE driver_log DROP CONSTRAINT FK_9DF4FACB3B5CCEB5');
        $this->addSql('DROP TABLE driver_log');
        $this->addSql('ALTER TABLE driver ALTER car_id DROP NOT NULL');
        $this->addSql('ALTER TABLE driver ALTER birthdate TYPE VARCHAR(255)');
    }
}
