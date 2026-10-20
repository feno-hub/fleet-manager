<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261019125451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD name_company VARCHAR(255) NOT NULL, ADD siret VARCHAR(255) NOT NULL, ADD address_company VARCHAR(255) NOT NULL, ADD sector VARCHAR(255) NOT NULL, ADD poste VARCHAR(255) NOT NULL, ADD total_car NUMERIC(1, 0) NOT NULL, ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP name_company, DROP siret, DROP address_company, DROP sector, DROP poste, DROP total_car, DROP created_at');
    }
}
