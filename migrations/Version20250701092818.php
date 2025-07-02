<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250701092818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP SEQUENCE apology_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE creative_redemption_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE donation_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE goodeed_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apology ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apology ADD CONSTRAINT FK_91F3852CBF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE creative_redemption ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE creative_redemption ADD CONSTRAINT FK_EEEA8FF5BF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation ADD CONSTRAINT FK_31E581A0BF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goodeed ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goodeed ADD CONSTRAINT FK_99B0A33ABF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE apology_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE creative_redemption_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE donation_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE goodeed_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation DROP CONSTRAINT FK_31E581A0BF396750
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE donation_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('donation_id_seq', (SELECT MAX(id) FROM donation))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation ALTER id SET DEFAULT nextval('donation_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goodeed DROP CONSTRAINT FK_99B0A33ABF396750
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE goodeed_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('goodeed_id_seq', (SELECT MAX(id) FROM goodeed))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goodeed ALTER id SET DEFAULT nextval('goodeed_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE creative_redemption DROP CONSTRAINT FK_EEEA8FF5BF396750
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE creative_redemption_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('creative_redemption_id_seq', (SELECT MAX(id) FROM creative_redemption))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE creative_redemption ALTER id SET DEFAULT nextval('creative_redemption_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apology DROP CONSTRAINT FK_91F3852CBF396750
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE apology_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('apology_id_seq', (SELECT MAX(id) FROM apology))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apology ALTER id SET DEFAULT nextval('apology_id_seq')
        SQL);
    }
}
