<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015175139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle_car_params (id INT AUTO_INCREMENT NOT NULL, vehicle_id_id INT NOT NULL, engine_capacity NUMERIC(3, 2) NOT NULL, color VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_12346D9C1DEB1EBB (vehicle_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle_car_params ADD CONSTRAINT FK_12346D9C1DEB1EBB FOREIGN KEY (vehicle_id_id) REFERENCES vehicle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_car_params DROP FOREIGN KEY FK_12346D9C1DEB1EBB');
        $this->addSql('DROP TABLE vehicle_car_params');
    }
}
