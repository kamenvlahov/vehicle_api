<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018141236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follow (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follow_user (follow_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B35425148711D3BC (follow_id), INDEX IDX_B3542514A76ED395 (user_id), PRIMARY KEY(follow_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follow_vehicle (follow_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_4575BC368711D3BC (follow_id), INDEX IDX_4575BC36545317D1 (vehicle_id), PRIMARY KEY(follow_id, vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follow_user ADD CONSTRAINT FK_B35425148711D3BC FOREIGN KEY (follow_id) REFERENCES follow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE follow_user ADD CONSTRAINT FK_B3542514A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE follow_vehicle ADD CONSTRAINT FK_4575BC368711D3BC FOREIGN KEY (follow_id) REFERENCES follow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE follow_vehicle ADD CONSTRAINT FK_4575BC36545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follow_user DROP FOREIGN KEY FK_B35425148711D3BC');
        $this->addSql('ALTER TABLE follow_user DROP FOREIGN KEY FK_B3542514A76ED395');
        $this->addSql('ALTER TABLE follow_vehicle DROP FOREIGN KEY FK_4575BC368711D3BC');
        $this->addSql('ALTER TABLE follow_vehicle DROP FOREIGN KEY FK_4575BC36545317D1');
        $this->addSql('DROP TABLE follow');
        $this->addSql('DROP TABLE follow_user');
        $this->addSql('DROP TABLE follow_vehicle');
    }
}
