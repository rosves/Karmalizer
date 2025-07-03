<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250702084003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE offense ALTER content TYPE VARCHAR(600)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offense ALTER content TYPE VARCHAR(255)');
    }
}
