<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118093019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE train (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, reference_code VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, station_from_id INT DEFAULT NULL, station_to_id INT DEFAULT NULL, arrival_time TIME DEFAULT NULL, departure_time TIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, reference_code VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7656F53B31687C55 (station_from_id), INDEX IDX_7656F53B68B33553 (station_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip_history (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, train_id INT DEFAULT NULL, conductor_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, reference_code VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_115635E6A5BC2E0E (trip_id), INDEX IDX_115635E623BCD4D0 (train_id), INDEX IDX_115635E6A49DECF0 (conductor_id), INDEX IDX_115635E6700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B31687C55 FOREIGN KEY (station_from_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B68B33553 FOREIGN KEY (station_to_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE trip_history ADD CONSTRAINT FK_115635E6A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trip_history ADD CONSTRAINT FK_115635E623BCD4D0 FOREIGN KEY (train_id) REFERENCES train (id)');
        $this->addSql('ALTER TABLE trip_history ADD CONSTRAINT FK_115635E6A49DECF0 FOREIGN KEY (conductor_id) REFERENCES symfony_demo_user (id)');
        $this->addSql('ALTER TABLE trip_history ADD CONSTRAINT FK_115635E6700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B31687C55');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B68B33553');
        $this->addSql('ALTER TABLE trip_history DROP FOREIGN KEY FK_115635E6A5BC2E0E');
        $this->addSql('ALTER TABLE trip_history DROP FOREIGN KEY FK_115635E623BCD4D0');
        $this->addSql('ALTER TABLE trip_history DROP FOREIGN KEY FK_115635E6A49DECF0');
        $this->addSql('ALTER TABLE trip_history DROP FOREIGN KEY FK_115635E6700047D2');
        $this->addSql('DROP TABLE train');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_history');
    }
}
