<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030153436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7DE9BCF0');
        $this->addSql('DROP INDEX IDX_E01FBE6A7DE9BCF0 ON images');
        $this->addSql('ALTER TABLE images DROP launes_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD launes_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7DE9BCF0 FOREIGN KEY (launes_id) REFERENCES laune (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A7DE9BCF0 ON images (launes_id)');
    }
}
