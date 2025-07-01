<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250630124043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE excuse_template ADD severity_min INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action ADD user_id_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action ADD CONSTRAINT FK_D30D608D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D30D608D9D86650F ON karma_action (user_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_score ADD level INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense ADD severity INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense ADD platform VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense DROP score
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission ADD severity_min INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD username VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission DROP severity_min
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP username
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action DROP CONSTRAINT FK_D30D608D9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D30D608D9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action DROP user_id_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_score DROP level
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense ADD score DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense DROP severity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense DROP platform
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE excuse_template DROP severity_min
        SQL);
    }
}
