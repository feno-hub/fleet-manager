<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261026090316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Default existing user statuses to pending and make the field mandatory.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE user SET status = 'pending' WHERE status IS NULL");
        $this->addSql('ALTER TABLE user CHANGE status status VARCHAR(255) DEFAULT \'pending\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE status status VARCHAR(255) DEFAULT NULL');
    }
}
