<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303134031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planification (id_plan INT AUTO_INCREMENT NOT NULL, id_mission INT DEFAULT NULL, id_driver INT DEFAULT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_FFC02E1B4EFA5B4C (id_mission), INDEX IDX_FFC02E1B3751C934 (id_driver), PRIMARY KEY(id_plan)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B4EFA5B4C FOREIGN KEY (id_mission) REFERENCES mission (id_mission)');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B3751C934 FOREIGN KEY (id_driver) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B4EFA5B4C');
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B3751C934');
        $this->addSql('DROP TABLE planification');
    }
}
