<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030160811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_ala_une ADD launes_id INT NOT NULL');
        $this->addSql('ALTER TABLE image_ala_une ADD CONSTRAINT FK_F92B389E7DE9BCF0 FOREIGN KEY (launes_id) REFERENCES laune (id)');
        $this->addSql('CREATE INDEX IDX_F92B389E7DE9BCF0 ON image_ala_une (launes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_ala_une DROP FOREIGN KEY FK_F92B389E7DE9BCF0');
        $this->addSql('DROP INDEX IDX_F92B389E7DE9BCF0 ON image_ala_une');
        $this->addSql('ALTER TABLE image_ala_une DROP launes_id');
    }
}
