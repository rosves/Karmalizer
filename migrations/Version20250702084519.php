<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702084519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apology (id INT NOT NULL, message VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE creative_redemption (id INT NOT NULL, content VARCHAR(255) NOT NULL, media_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE donation (id INT NOT NULL, amount INT NOT NULL, donation_target VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE excuse_template (id SERIAL NOT NULL, content VARCHAR(255) NOT NULL, severity_min INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE goodeed (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE karma_action (id SERIAL NOT NULL, offense_id_id INT NOT NULL, user_id_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D30D608D45796F21 ON karma_action (offense_id_id)');
        $this->addSql('CREATE INDEX IDX_D30D608D9D86650F ON karma_action (user_id_id)');
        $this->addSql('COMMENT ON COLUMN karma_action.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE karma_score (id SERIAL NOT NULL, user_id_id INT NOT NULL, score INT DEFAULT NULL, level INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_974EACD89D86650F ON karma_score (user_id_id)');
        $this->addSql('CREATE TABLE offense (id SERIAL NOT NULL, user_id_id INT NOT NULL, content VARCHAR(600) NOT NULL, date_offense TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, target VARCHAR(255) NOT NULL, severity INT NOT NULL, platform VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F36D3219D86650F ON offense (user_id_id)');
        $this->addSql('COMMENT ON COLUMN offense.date_offense IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE redemption_mission (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, severity_min INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE redemption_mission_offense (redemption_mission_id INT NOT NULL, offense_id INT NOT NULL, PRIMARY KEY(redemption_mission_id, offense_id))');
        $this->addSql('CREATE INDEX IDX_F3EB37EC46807782 ON redemption_mission_offense (redemption_mission_id)');
        $this->addSql('CREATE INDEX IDX_F3EB37EC3A61EAFD ON redemption_mission_offense (offense_id)');
        $this->addSql('CREATE TABLE redemption_vote (id SERIAL NOT NULL, user_id_id INT NOT NULL, karma_action_id_id INT NOT NULL, vote_value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8E3905E49D86650F ON redemption_vote (user_id_id)');
        $this->addSql('CREATE INDEX IDX_8E3905E4B3C55134 ON redemption_vote (karma_action_id_id)');
        $this->addSql('CREATE TABLE reward (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN reward.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reward_redemption_mission (reward_id INT NOT NULL, redemption_mission_id INT NOT NULL, PRIMARY KEY(reward_id, redemption_mission_id))');
        $this->addSql('CREATE INDEX IDX_E0C4FCB2E466ACA1 ON reward_redemption_mission (reward_id)');
        $this->addSql('CREATE INDEX IDX_E0C4FCB246807782 ON reward_redemption_mission (redemption_mission_id)');
        $this->addSql('CREATE TABLE reward_user (reward_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(reward_id, user_id))');
        $this->addSql('CREATE INDEX IDX_8C8246D2E466ACA1 ON reward_user (reward_id)');
        $this->addSql('CREATE INDEX IDX_8C8246D2A76ED395 ON reward_user (user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, karma_balance INT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE apology ADD CONSTRAINT FK_91F3852CBF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creative_redemption ADD CONSTRAINT FK_EEEA8FF5BF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0BF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE goodeed ADD CONSTRAINT FK_99B0A33ABF396750 FOREIGN KEY (id) REFERENCES karma_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE karma_action ADD CONSTRAINT FK_D30D608D45796F21 FOREIGN KEY (offense_id_id) REFERENCES offense (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE karma_action ADD CONSTRAINT FK_D30D608D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE karma_score ADD CONSTRAINT FK_974EACD89D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offense ADD CONSTRAINT FK_5F36D3219D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redemption_mission_offense ADD CONSTRAINT FK_F3EB37EC46807782 FOREIGN KEY (redemption_mission_id) REFERENCES redemption_mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redemption_mission_offense ADD CONSTRAINT FK_F3EB37EC3A61EAFD FOREIGN KEY (offense_id) REFERENCES offense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redemption_vote ADD CONSTRAINT FK_8E3905E49D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redemption_vote ADD CONSTRAINT FK_8E3905E4B3C55134 FOREIGN KEY (karma_action_id_id) REFERENCES karma_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_redemption_mission ADD CONSTRAINT FK_E0C4FCB2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_redemption_mission ADD CONSTRAINT FK_E0C4FCB246807782 FOREIGN KEY (redemption_mission_id) REFERENCES redemption_mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE apology DROP CONSTRAINT FK_91F3852CBF396750');
        $this->addSql('ALTER TABLE creative_redemption DROP CONSTRAINT FK_EEEA8FF5BF396750');
        $this->addSql('ALTER TABLE donation DROP CONSTRAINT FK_31E581A0BF396750');
        $this->addSql('ALTER TABLE goodeed DROP CONSTRAINT FK_99B0A33ABF396750');
        $this->addSql('ALTER TABLE karma_action DROP CONSTRAINT FK_D30D608D45796F21');
        $this->addSql('ALTER TABLE karma_action DROP CONSTRAINT FK_D30D608D9D86650F');
        $this->addSql('ALTER TABLE karma_score DROP CONSTRAINT FK_974EACD89D86650F');
        $this->addSql('ALTER TABLE offense DROP CONSTRAINT FK_5F36D3219D86650F');
        $this->addSql('ALTER TABLE redemption_mission_offense DROP CONSTRAINT FK_F3EB37EC46807782');
        $this->addSql('ALTER TABLE redemption_mission_offense DROP CONSTRAINT FK_F3EB37EC3A61EAFD');
        $this->addSql('ALTER TABLE redemption_vote DROP CONSTRAINT FK_8E3905E49D86650F');
        $this->addSql('ALTER TABLE redemption_vote DROP CONSTRAINT FK_8E3905E4B3C55134');
        $this->addSql('ALTER TABLE reward_redemption_mission DROP CONSTRAINT FK_E0C4FCB2E466ACA1');
        $this->addSql('ALTER TABLE reward_redemption_mission DROP CONSTRAINT FK_E0C4FCB246807782');
        $this->addSql('ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2E466ACA1');
        $this->addSql('ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2A76ED395');
        $this->addSql('DROP TABLE apology');
        $this->addSql('DROP TABLE creative_redemption');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE excuse_template');
        $this->addSql('DROP TABLE goodeed');
        $this->addSql('DROP TABLE karma_action');
        $this->addSql('DROP TABLE karma_score');
        $this->addSql('DROP TABLE offense');
        $this->addSql('DROP TABLE redemption_mission');
        $this->addSql('DROP TABLE redemption_mission_offense');
        $this->addSql('DROP TABLE redemption_vote');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE reward_redemption_mission');
        $this->addSql('DROP TABLE reward_user');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
