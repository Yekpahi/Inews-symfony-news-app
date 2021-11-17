<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211116223634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_likes (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3E7D3C6C1EBAF6CC (articles_id), INDEX IDX_3E7D3C6CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, categories_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, statut VARCHAR(1) DEFAULT NULL, INDEX IDX_BFDD316867B3B43D (users_id), INDEX IDX_BFDD3168A21214B7 (categories_id), FULLTEXT INDEX IDX_BFDD31682B36786BFEC530A96DE44026 (title, content, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_user (articles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D76F110E1EBAF6CC (articles_id), INDEX IDX_D76F110EA76ED395 (user_id), PRIMARY KEY(articles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(7) DEFAULT NULL, INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE change_password (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, articles_id INT NOT NULL, parent_id INT DEFAULT NULL, launes_id INT NOT NULL, video_posts_id INT NOT NULL, content LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, rgpd TINYINT(1) NOT NULL, INDEX IDX_5F9E962AA76ED395 (user_id), INDEX IDX_5F9E962A1EBAF6CC (articles_id), INDEX IDX_5F9E962A727ACA70 (parent_id), INDEX IDX_5F9E962A7DE9BCF0 (launes_id), INDEX IDX_5F9E962A7D606A79 (video_posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_ala_une (id INT AUTO_INCREMENT NOT NULL, launes_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F92B389E7DE9BCF0 (launes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A1EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE laune (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, categories_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, statut VARCHAR(1) DEFAULT NULL, INDEX IDX_8DE6847267B3B43D (users_id), INDEX IDX_8DE68472A21214B7 (categories_id), FULLTEXT INDEX IDX_8DE684722B36786BFEC530A96DE44026 (title, content, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, sex VARCHAR(1) DEFAULT NULL, avatar VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videoPost (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, categories_id INT NOT NULL, title VARCHAR(255) NOT NULL, video_pics VARCHAR(255) NOT NULL, video_filename VARCHAR(255) NOT NULL, duration INT NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, statut VARCHAR(1) DEFAULT NULL, INDEX IDX_4D4A1F4D67B3B43D (users_id), INDEX IDX_4D4A1F4DA21214B7 (categories_id), FULLTEXT INDEX IDX_4D4A1F4D2B36786BFEC530A96DE44026 (title, content, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_likes ADD CONSTRAINT FK_3E7D3C6C1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE article_likes ADD CONSTRAINT FK_3E7D3C6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110E1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A727ACA70 FOREIGN KEY (parent_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7DE9BCF0 FOREIGN KEY (launes_id) REFERENCES laune (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7D606A79 FOREIGN KEY (video_posts_id) REFERENCES videoPost (id)');
        $this->addSql('ALTER TABLE image_ala_une ADD CONSTRAINT FK_F92B389E7DE9BCF0 FOREIGN KEY (launes_id) REFERENCES laune (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE laune ADD CONSTRAINT FK_8DE6847267B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE laune ADD CONSTRAINT FK_8DE68472A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE videoPost ADD CONSTRAINT FK_4D4A1F4D67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE videoPost ADD CONSTRAINT FK_4D4A1F4DA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_likes DROP FOREIGN KEY FK_3E7D3C6C1EBAF6CC');
        $this->addSql('ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110E1EBAF6CC');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A1EBAF6CC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A1EBAF6CC');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168A21214B7');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE laune DROP FOREIGN KEY FK_8DE68472A21214B7');
        $this->addSql('ALTER TABLE videoPost DROP FOREIGN KEY FK_4D4A1F4DA21214B7');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A727ACA70');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7DE9BCF0');
        $this->addSql('ALTER TABLE image_ala_une DROP FOREIGN KEY FK_F92B389E7DE9BCF0');
        $this->addSql('ALTER TABLE article_likes DROP FOREIGN KEY FK_3E7D3C6CA76ED395');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316867B3B43D');
        $this->addSql('ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110EA76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE laune DROP FOREIGN KEY FK_8DE6847267B3B43D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE videoPost DROP FOREIGN KEY FK_4D4A1F4D67B3B43D');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7D606A79');
        $this->addSql('DROP TABLE article_likes');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_user');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE change_password');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE image_ala_une');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE laune');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE videoPost');
    }
}
