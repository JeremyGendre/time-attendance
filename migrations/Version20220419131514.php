<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419131514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE extra_ticking (id INT AUTO_INCREMENT NOT NULL, ticking_id INT NOT NULL, start_date TIME NOT NULL, end_date TIME NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2F704DD4D35810A (ticking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ticking_day DATE NOT NULL, enter_date TIME NOT NULL, break_date TIME DEFAULT NULL, return_date TIME DEFAULT NULL, exit_date TIME DEFAULT NULL, INDEX IDX_F7AB4A36A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE extra_ticking ADD CONSTRAINT FK_2F704DD4D35810A FOREIGN KEY (ticking_id) REFERENCES ticking (id)');
        $this->addSql('ALTER TABLE ticking ADD CONSTRAINT FK_F7AB4A36A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user ADD service_id INT DEFAULT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ED5CA9E6 ON user (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('ALTER TABLE extra_ticking DROP FOREIGN KEY FK_2F704DD4D35810A');
        $this->addSql('DROP TABLE extra_ticking');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE ticking');
        $this->addSql('DROP INDEX IDX_8D93D649ED5CA9E6 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP service_id, DROP lastname, DROP firstname, DROP created_at');
    }
}
