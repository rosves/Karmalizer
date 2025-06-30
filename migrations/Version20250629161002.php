<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250629161002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
       
        $this->addSql(<<<'SQL'
            CREATE TABLE apology (id SERIAL NOT NULL, message VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE creative_redemption (id SERIAL NOT NULL, content VARCHAR(255) NOT NULL, media_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE donation (id SERIAL NOT NULL, amount INT NOT NULL, donation_target VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE excuse_template (id SERIAL NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE goodeed (id SERIAL NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE karma_action (id SERIAL NOT NULL, offense_id_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D30D608D45796F21 ON karma_action (offense_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN karma_action.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE karma_score (id SERIAL NOT NULL, user_id_id INT NOT NULL, score INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_974EACD89D86650F ON karma_score (user_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE offense (id SERIAL NOT NULL, user_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, date_offense TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5F36D3219D86650F ON offense (user_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN offense.date_offense IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE redemption_mission (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE redemption_mission_offense (redemption_mission_id INT NOT NULL, offense_id INT NOT NULL, PRIMARY KEY(redemption_mission_id, offense_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F3EB37EC46807782 ON redemption_mission_offense (redemption_mission_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F3EB37EC3A61EAFD ON redemption_mission_offense (offense_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE redemption_vote (id SERIAL NOT NULL, user_id_id INT NOT NULL, karma_action_id_id INT NOT NULL, vote_value INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8E3905E49D86650F ON redemption_vote (user_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8E3905E4B3C55134 ON redemption_vote (karma_action_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reward (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN reward.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reward_redemption_mission (reward_id INT NOT NULL, redemption_mission_id INT NOT NULL, PRIMARY KEY(reward_id, redemption_mission_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E0C4FCB2E466ACA1 ON reward_redemption_mission (reward_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E0C4FCB246807782 ON reward_redemption_mission (redemption_mission_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reward_user (reward_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(reward_id, user_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8C8246D2E466ACA1 ON reward_user (reward_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8C8246D2A76ED395 ON reward_user (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, karma_balance INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.available_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
                BEGIN
                    PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                    RETURN NEW;
                END;
            $$ LANGUAGE plpgsql;
        SQL);
        $this->addSql(<<<'SQL'
            DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action ADD CONSTRAINT FK_D30D608D45796F21 FOREIGN KEY (offense_id_id) REFERENCES offense (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_score ADD CONSTRAINT FK_974EACD89D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense ADD CONSTRAINT FK_5F36D3219D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission_offense ADD CONSTRAINT FK_F3EB37EC46807782 FOREIGN KEY (redemption_mission_id) REFERENCES redemption_mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission_offense ADD CONSTRAINT FK_F3EB37EC3A61EAFD FOREIGN KEY (offense_id) REFERENCES offense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_vote ADD CONSTRAINT FK_8E3905E49D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_vote ADD CONSTRAINT FK_8E3905E4B3C55134 FOREIGN KEY (karma_action_id_id) REFERENCES karma_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_redemption_mission ADD CONSTRAINT FK_E0C4FCB2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_redemption_mission ADD CONSTRAINT FK_E0C4FCB246807782 FOREIGN KEY (redemption_mission_id) REFERENCES redemption_mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_action DROP CONSTRAINT FK_D30D608D45796F21
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE karma_score DROP CONSTRAINT FK_974EACD89D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offense DROP CONSTRAINT FK_5F36D3219D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission_offense DROP CONSTRAINT FK_F3EB37EC46807782
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_mission_offense DROP CONSTRAINT FK_F3EB37EC3A61EAFD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_vote DROP CONSTRAINT FK_8E3905E49D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE redemption_vote DROP CONSTRAINT FK_8E3905E4B3C55134
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_redemption_mission DROP CONSTRAINT FK_E0C4FCB2E466ACA1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_redemption_mission DROP CONSTRAINT FK_E0C4FCB246807782
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2E466ACA1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE apology
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE creative_redemption
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE donation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE excuse_template
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE goodeed
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE karma_action
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE karma_score
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE offense
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE redemption_mission
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE redemption_mission_offense
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE redemption_vote
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reward
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reward_redemption_mission
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reward_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
