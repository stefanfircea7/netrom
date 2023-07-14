<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705084641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nr_oameni INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE teamgame');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (ID INT AUTO_INCREMENT NOT NULL, Name VARCHAR(50) CHARACTER SET armscii8 DEFAULT \'\' NOT NULL COLLATE `armscii8_bin`, Hscored INT DEFAULT 0 NOT NULL, Ascored INT DEFAULT 0 NOT NULL, CompetitionID INT DEFAULT 0 NOT NULL, Date DATE DEFAULT NULL, HteamID INT NOT NULL, AteamID INT NOT NULL, Winner INT DEFAULT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET armscii8 COLLATE `armscii8_bin` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teamgame (ID INT AUTO_INCREMENT NOT NULL, Game_ID INT DEFAULT 0 NOT NULL, Team_ID INT DEFAULT 0 NOT NULL, Points INT DEFAULT 0 NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET armscii8 COLLATE `armscii8_bin` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
