<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250804010255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP CONSTRAINT fk_81398e09896dbbde
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_81398e09896dbbde
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD approved_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD approved_by_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP updated_by_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD CONSTRAINT FK_81398E092D234F6A FOREIGN KEY (approved_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_81398E092D234F6A ON customer (approved_by_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP CONSTRAINT FK_81398E092D234F6A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_81398E092D234F6A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD updated_by_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP approved_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP approved_by_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD CONSTRAINT fk_81398e09896dbbde FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_81398e09896dbbde ON customer (updated_by_id)
        SQL);
    }
}
