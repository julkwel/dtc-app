<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921182631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cohorte (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, name VARCHAR(255) NOT NULL, alias VARCHAR(20) DEFAULT NULL, amount VARCHAR(255) NOT NULL, is_register_open TINYINT(1) NOT NULL, is_ended TINYINT(1) NOT NULL, ended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, phone VARCHAR(255) NOT NULL, facebook VARCHAR(100) DEFAULT NULL, linkedin VARCHAR(200) DEFAULT NULL, github VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_4C62E638A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_formation (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, certificate LONGTEXT DEFAULT NULL, paid_amount VARCHAR(255) DEFAULT NULL, is_total_paid TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_272EE03F5200282E (formation_id), UNIQUE INDEX UNIQ_272EE03FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_formation (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, file_name LONGTEXT NOT NULL, type INT NOT NULL, INDEX IDX_F692BA095200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainer_formation (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, trainer_id INT DEFAULT NULL, started_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', alias VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5327AE095200282E (formation_id), UNIQUE INDEX UNIQ_5327AE09FB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, image LONGTEXT DEFAULT NULL, username VARCHAR(255) NOT NULL, password LONGTEXT DEFAULT NULL, is_enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student_formation ADD CONSTRAINT FK_272EE03F5200282E FOREIGN KEY (formation_id) REFERENCES cohorte (id)');
        $this->addSql('ALTER TABLE student_formation ADD CONSTRAINT FK_272EE03FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE support_formation ADD CONSTRAINT FK_F692BA095200282E FOREIGN KEY (formation_id) REFERENCES cohorte (id)');
        $this->addSql('ALTER TABLE trainer_formation ADD CONSTRAINT FK_5327AE095200282E FOREIGN KEY (formation_id) REFERENCES cohorte (id)');
        $this->addSql('ALTER TABLE trainer_formation ADD CONSTRAINT FK_5327AE09FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A76ED395');
        $this->addSql('ALTER TABLE student_formation DROP FOREIGN KEY FK_272EE03F5200282E');
        $this->addSql('ALTER TABLE student_formation DROP FOREIGN KEY FK_272EE03FA76ED395');
        $this->addSql('ALTER TABLE support_formation DROP FOREIGN KEY FK_F692BA095200282E');
        $this->addSql('ALTER TABLE trainer_formation DROP FOREIGN KEY FK_5327AE095200282E');
        $this->addSql('ALTER TABLE trainer_formation DROP FOREIGN KEY FK_5327AE09FB08EDF6');
        $this->addSql('DROP TABLE cohorte');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE student_formation');
        $this->addSql('DROP TABLE support_formation');
        $this->addSql('DROP TABLE trainer_formation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
