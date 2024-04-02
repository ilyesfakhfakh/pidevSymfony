<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303144219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC6957CCE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B4EFA5B4C');
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B3751C934');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B4EFA5B4C FOREIGN KEY (id_mission) REFERENCES mission (id_mission)');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B3751C934 FOREIGN KEY (id_driver) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC6957CCE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B4EFA5B4C');
        $this->addSql('ALTER TABLE planification DROP FOREIGN KEY FK_FFC02E1B3751C934');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B4EFA5B4C FOREIGN KEY (id_mission) REFERENCES mission (id_mission) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planification ADD CONSTRAINT FK_FFC02E1B3751C934 FOREIGN KEY (id_driver) REFERENCES user (id) ON DELETE CASCADE');
    }
}
