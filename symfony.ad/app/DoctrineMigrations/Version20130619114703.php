<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130619114703 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(42) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE attribute ADD type_id INT NOT NULL");
        $this->addSql("ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE");
        $this->addSql("CREATE INDEX IDX_FA7AEFFBC54C8C93 ON attribute (type_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFBC54C8C93");
        $this->addSql("DROP TABLE type");
        $this->addSql("DROP INDEX IDX_FA7AEFFBC54C8C93 ON attribute");
        $this->addSql("ALTER TABLE attribute DROP type_id");
    }
}
