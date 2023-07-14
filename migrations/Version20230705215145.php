<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705215145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, winner_id_id INT DEFAULT NULL, start_date DATE NOT NULL, INDEX IDX_232B318CFC53D4E9 (winner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, game_id_id INT DEFAULT NULL, team_id_id INT NOT NULL, points INT NOT NULL, scored INT NOT NULL, conceded INT NOT NULL, UNIQUE INDEX UNIQ_136AC1134D77E7D8 (game_id_id), INDEX IDX_136AC113B842D717 (team_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFC53D4E9 FOREIGN KEY (winner_id_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1134D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD description VARCHAR(255) NOT NULL, ADD color VARCHAR(50) NOT NULL, CHANGE nr_oameni pcount INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CFC53D4E9');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1134D77E7D8');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113B842D717');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE result');
        $this->addSql('ALTER TABLE team DROP description, DROP color, CHANGE pcount nr_oameni INT NOT NULL');
    }
}
