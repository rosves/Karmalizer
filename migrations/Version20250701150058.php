<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250701150058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {


    }

    public function down(Schema $schema): void
    {
       
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
    }
}
