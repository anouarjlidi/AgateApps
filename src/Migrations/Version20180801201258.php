<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use CorahnRin\Data\Domains;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180801201258 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $conn = $this->connection;
        $simpleArray = Type::getType(Type::SIMPLE_ARRAY);

        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EC4BE6905');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410ED60BC6EB');
        $this->addSql('ALTER TABLE characters_disciplines DROP FOREIGN KEY FK_5009941115F0EE5');
        $this->addSql('ALTER TABLE characters_domains DROP FOREIGN KEY FK_C4F7C6C6115F0EE5');
        $this->addSql('ALTER TABLE disciplines_domains DROP FOREIGN KEY FK_FE41FAE8115F0EE5');
        $this->addSql('ALTER TABLE geo_environments DROP FOREIGN KEY FK_18F4720A115F0EE5');
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC5B05C1029');
        $this->addSql('ALTER TABLE jobs_domains DROP FOREIGN KEY FK_FBB18A2C3700F4DC');
        $this->addSql('ALTER TABLE social_classes_domains DROP FOREIGN KEY FK_B915B07A3700F4DC');
        $this->addSql('DROP INDEX IDX_18F4720A115F0EE5 ON geo_environments');
        $this->addSql('DROP INDEX IDX_A8936DC5B05C1029 ON jobs');
        $this->addSql('DROP INDEX IDX_3A29410EC4BE6905 ON characters');
        $this->addSql('DROP INDEX IDX_3A29410ED60BC6EB ON characters');
        $this->addSql('DROP INDEX IDX_5009941115F0EE5 ON characters_disciplines');

        $this->addSql('ALTER TABLE characters_disciplines DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE characters_disciplines ADD PRIMARY KEY (character_id, discipline_id)');

        $this->addSql('ALTER TABLE avantages ADD bonuses_for LONGTEXT COMMENT \'(DC2Type:simple_array)\', ADD bonuses_for_all TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE disciplines ADD domains LONGTEXT COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE characters_disciplines ADD domain VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE geo_environments ADD domain VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE jobs ADD primary_domain VARCHAR(100) NOT NULL, ADD secondary_domains LONGTEXT COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE social_class ADD domains LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');

        $this->addSql('
            ALTER TABLE characters 
            ADD social_class_domain1 VARCHAR(100) NOT NULL, 
            ADD social_class_domain2 VARCHAR(100) NOT NULL, 
            ADD way_combativeness INT NOT NULL, 
            ADD way_creativity INT NOT NULL, 
            ADD way_empathy INT NOT NULL, 
            ADD way_reason INT NOT NULL, 
            ADD way_conviction INT NOT NULL, 
            ADD domain_craft SMALLINT NOT NULL, 
            ADD domain_craft_bonus SMALLINT NOT NULL, 
            ADD domain_craft_malus SMALLINT NOT NULL, 
            ADD domain_close_combat SMALLINT NOT NULL, 
            ADD domain_close_combat_bonus SMALLINT NOT NULL, 
            ADD domain_close_combat_malus SMALLINT NOT NULL, 
            ADD domain_stealth SMALLINT NOT NULL, 
            ADD domain_stealth_bonus SMALLINT NOT NULL, 
            ADD domain_stealth_malus SMALLINT NOT NULL, 
            ADD domain_magience SMALLINT NOT NULL, 
            ADD domain_magience_bonus SMALLINT NOT NULL, 
            ADD domain_magience_malus SMALLINT NOT NULL, 
            ADD domain_natural_environment SMALLINT NOT NULL, 
            ADD domain_natural_environment_bonus SMALLINT NOT NULL, 
            ADD domain_natural_environment_malus SMALLINT NOT NULL, 
            ADD domain_demorthen_mysteries SMALLINT NOT NULL, 
            ADD domain_demorthen_mysteries_bonus SMALLINT NOT NULL, 
            ADD domain_demorthen_mysteries_malus SMALLINT NOT NULL, 
            ADD domain_occultism SMALLINT NOT NULL, 
            ADD domain_occultism_bonus SMALLINT NOT NULL, 
            ADD domain_occultism_malus SMALLINT NOT NULL, 
            ADD domain_perception SMALLINT NOT NULL, 
            ADD domain_perception_bonus SMALLINT NOT NULL, 
            ADD domain_perception_malus SMALLINT NOT NULL, 
            ADD domain_prayer SMALLINT NOT NULL, 
            ADD domain_prayer_bonus SMALLINT NOT NULL, 
            ADD domain_prayer_malus SMALLINT NOT NULL, 
            ADD domain_feats SMALLINT NOT NULL, 
            ADD domain_feats_bonus SMALLINT NOT NULL, 
            ADD domain_feats_malus SMALLINT NOT NULL, 
            ADD domain_relation SMALLINT NOT NULL, 
            ADD domain_relation_bonus SMALLINT NOT NULL, 
            ADD domain_relation_malus SMALLINT NOT NULL, 
            ADD domain_performance SMALLINT NOT NULL, 
            ADD domain_performance_bonus SMALLINT NOT NULL, 
            ADD domain_performance_malus SMALLINT NOT NULL, 
            ADD domain_science SMALLINT NOT NULL, 
            ADD domain_science_bonus SMALLINT NOT NULL, 
            ADD domain_science_malus SMALLINT NOT NULL, 
            ADD domain_shooting_and_throwing SMALLINT NOT NULL, 
            ADD domain_shooting_and_throwing_bonus SMALLINT NOT NULL, 
            ADD domain_shooting_and_throwing_malus SMALLINT NOT NULL, 
            ADD domain_travel SMALLINT NOT NULL, 
            ADD domain_travel_bonus SMALLINT NOT NULL, 
            ADD domain_travel_malus SMALLINT NOT NULL, 
            ADD domain_erudition SMALLINT NOT NULL, 
            ADD domain_erudition_bonus SMALLINT NOT NULL, 
            ADD domain_erudition_malus SMALLINT NOT NULL, 
            DROP social_class_domain1_id, 
            DROP social_class_domain2_id, 
            DROP combativeness, 
            DROP creativity, 
            DROP empathy, 
            DROP reason, 
            DROP conviction 
        ');

        $domainsIdReplacers = [
            1 => Domains::CRAFT['title'],
            2 => Domains::CLOSE_COMBAT['title'],
            3 => Domains::STEALTH['title'],
            4 => Domains::MAGIENCE['title'],
            5 => Domains::NATURAL_ENVIRONMENT['title'],
            6 => Domains::DEMORTHEN_MYSTERIES['title'],
            7 => Domains::OCCULTISM['title'],
            8 => Domains::PERCEPTION['title'],
            9 => Domains::PRAYER['title'],
            10 => Domains::FEATS['title'],
            11 => Domains::RELATION['title'],
            12 => Domains::PERFORMANCE['title'],
            13 => Domains::SCIENCE['title'],
            14 => Domains::SHOOTING_AND_THROWING['title'],
            15 => Domains::TRAVEL['title'],
            16 => Domains::ERUDITION['title'],
        ];

        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[1], 'id' => 1]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[2], 'id' => 2]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[3], 'id' => 3]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[4], 'id' => 4]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[5], 'id' => 5]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[6], 'id' => 6]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[7], 'id' => 7]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[8], 'id' => 8]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[9], 'id' => 9]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[10], 'id' => 10]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[11], 'id' => 11]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[12], 'id' => 12]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[13], 'id' => 13]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[14], 'id' => 14]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[15], 'id' => 15]);
        $this->addSql('UPDATE characters_disciplines SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[16], 'id' => 16]);

        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[1], 'id' => 1]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[2], 'id' => 2]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[3], 'id' => 3]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[4], 'id' => 4]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[5], 'id' => 5]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[6], 'id' => 6]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[7], 'id' => 7]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[8], 'id' => 8]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[9], 'id' => 9]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[10], 'id' => 10]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[11], 'id' => 11]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[12], 'id' => 12]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[13], 'id' => 13]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[14], 'id' => 14]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[15], 'id' => 15]);
        $this->addSql('UPDATE geo_environments SET domain = :domain WHERE domain_id = :id', [':domain' => $domainsIdReplacers[16], 'id' => 16]);

        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[1], 'id' => 1]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[2], 'id' => 2]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[3], 'id' => 3]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[4], 'id' => 4]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[5], 'id' => 5]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[6], 'id' => 6]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[7], 'id' => 7]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[8], 'id' => 8]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[9], 'id' => 9]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[10], 'id' => 10]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[11], 'id' => 11]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[12], 'id' => 12]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[13], 'id' => 13]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[14], 'id' => 14]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[15], 'id' => 15]);
        $this->addSql('UPDATE jobs SET primary_domain = :domain WHERE domain_primary_id = :id', [':domain' => $domainsIdReplacers[16], 'id' => 16]);

        $newDisciplinesDomains = [];
        $disciplinesDomains = $conn->query('select discipline_id, domain_id from disciplines_domains')->fetchAll();
        foreach ($disciplinesDomains as $line) {
            $newDisciplinesDomains[$line['discipline_id']][] = $line['domain_id'];
        }
        foreach  ($newDisciplinesDomains as $id => $domains) {
            $convertedDomains = $simpleArray->convertToDatabaseValue($domains, $conn->getDatabasePlatform());
            $this->addSql('UPDATE disciplines SET domains = :domains WHERE id = :id', [':domains' => $convertedDomains, ':id' => $id]);
        }

        $newSocialClassesSecondaryDomains = [];
        $socialClassesSecondaryDomains = $conn->query('select social_classes_id, domains_id from social_classes_domains')->fetchAll();
        foreach ($socialClassesSecondaryDomains as $line) {
            $newSocialClassesSecondaryDomains[$line['social_classes_id']][] = $line['domains_id'];
        }
        foreach  ($newSocialClassesSecondaryDomains as $id => $domains) {
            $convertedDomains = $simpleArray->convertToDatabaseValue($domains, $conn->getDatabasePlatform());
            $this->addSql('UPDATE social_class SET domains = :domains WHERE id = :id', [':domains' => $convertedDomains, ':id' => $id]);
        }

        $newJobsSecondaryDomains = [];
        $jobsSecondaryDomains = $conn->query('select jobs_id, domains_id from jobs_domains')->fetchAll();
        foreach ($jobsSecondaryDomains as $line) {
            $newJobsSecondaryDomains[$line['jobs_id']][] = $line['domains_id'];
        }
        foreach  ($newJobsSecondaryDomains as $id => $domains) {
            $convertedDomains = $simpleArray->convertToDatabaseValue($domains, $conn->getDatabasePlatform());
            $this->addSql('UPDATE jobs SET secondary_domains = :domains WHERE id = :id', [':domains' => $convertedDomains, ':id' => $id]);
        }

        $newAdvantagesBonuses = [];
        $advantages = $conn->query('select id, bonusdisc from avantages')->fetchAll();
        foreach ($advantages as $line) {
            if (!trim($line['bonusdisc'])) {
                continue;
            }
            $bonuses = explode(',', $line['bonusdisc']);
            foreach ($bonuses as $k => $bonus) {
                if ($bonus && !is_numeric($bonus)) {
                    continue;
                }
                $bonuses[$k] = $domainsIdReplacers[(int) $bonus];
            }
            if ($bonuses) {
                $newAdvantagesBonuses[$line['id']] = $bonuses;
            }
        }
        foreach ($newAdvantagesBonuses as $id => $bonuses) {
            $convertedBonuses = $simpleArray->convertToDatabaseValue($bonuses, $conn->getDatabasePlatform());
            $this->addSql('UPDATE avantages SET bonuses_for = :bonuses WHERE id = :id', [':bonuses' => $convertedBonuses, ':id' => $id]);
        }

        // Scholar, the only advantage for which bonuses are not for all domains
        $this->addSql('UPDATE avantages SET bonuses_for_all = :value WHERE id = :id', [':value' => false, ':id' => 23]);

        $this->addSql('ALTER TABLE characters_disciplines DROP domain_id');
        $this->addSql('ALTER TABLE geo_environments DROP domain_id');
        $this->addSql('ALTER TABLE avantages DROP bonusdisc');
        $this->addSql('ALTER TABLE jobs DROP domain_primary_id');

        $this->addSql('DROP TABLE characters_domains');
        $this->addSql('DROP TABLE disciplines_domains');
        $this->addSql('DROP TABLE domains');
        $this->addSql('DROP TABLE jobs_domains');
        $this->addSql('DROP TABLE social_classes_domains');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE characters_domains (character_id INT NOT NULL, domain_id INT NOT NULL, score SMALLINT NOT NULL, bonus SMALLINT DEFAULT 0 NOT NULL, malus SMALLINT DEFAULT 0 NOT NULL, INDEX IDX_C4F7C6C61136BE75 (character_id), INDEX IDX_C4F7C6C6115F0EE5 (domain_id), PRIMARY KEY(character_id, domain_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disciplines_domains (discipline_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_FE41FAE8A5522701 (discipline_id), INDEX IDX_FE41FAE8115F0EE5 (domain_id), PRIMARY KEY(discipline_id, domain_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domains (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, way VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_8C7BBF9D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs_domains (jobs_id INT NOT NULL, domains_id INT NOT NULL, INDEX IDX_FBB18A2C48704627 (jobs_id), INDEX IDX_FBB18A2C3700F4DC (domains_id), PRIMARY KEY(jobs_id, domains_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_classes_domains (social_classes_id INT NOT NULL, domains_id INT NOT NULL, INDEX IDX_B915B07A5071E9E6 (social_classes_id), INDEX IDX_B915B07A3700F4DC (domains_id), PRIMARY KEY(social_classes_id, domains_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE avantages ADD bonus_disc LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:simple_array)\', DROP bonuses_for, DROP bonuses_for_all');
        $this->addSql('ALTER TABLE characters_domains ADD CONSTRAINT FK_C4F7C6C61136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE characters_domains ADD CONSTRAINT FK_C4F7C6C6115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id)');
        $this->addSql('ALTER TABLE disciplines_domains ADD CONSTRAINT FK_FE41FAE8115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id)');
        $this->addSql('ALTER TABLE disciplines_domains ADD CONSTRAINT FK_FE41FAE8A5522701 FOREIGN KEY (discipline_id) REFERENCES disciplines (id)');
        $this->addSql('ALTER TABLE jobs_domains ADD CONSTRAINT FK_FBB18A2C3700F4DC FOREIGN KEY (domains_id) REFERENCES domains (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jobs_domains ADD CONSTRAINT FK_FBB18A2C48704627 FOREIGN KEY (jobs_id) REFERENCES jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE social_classes_domains ADD CONSTRAINT FK_B915B07A3700F4DC FOREIGN KEY (domains_id) REFERENCES domains (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE social_classes_domains ADD CONSTRAINT FK_B915B07A5071E9E6 FOREIGN KEY (social_classes_id) REFERENCES social_class (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters ADD social_class_domain1_id INT DEFAULT NULL, ADD social_class_domain2_id INT DEFAULT NULL, ADD combativeness INT NOT NULL, ADD creativity INT NOT NULL, ADD empathy INT NOT NULL, ADD reason INT NOT NULL, ADD conviction INT NOT NULL, DROP social_class_domain1, DROP social_class_domain2, DROP way_combativeness, DROP way_creativity, DROP way_empathy, DROP way_reason, DROP way_conviction, DROP domain_craft, DROP domain_craft_bonus, DROP domain_craft_malus, DROP domain_close_combat, DROP domain_close_combat_bonus, DROP domain_close_combat_malus, DROP domain_stealth, DROP domain_stealth_bonus, DROP domain_stealth_malus, DROP domain_magience, DROP domain_magience_bonus, DROP domain_magience_malus, DROP domain_natural_environment, DROP domain_natural_environment_bonus, DROP domain_natural_environment_malus, DROP domain_demorthen_mysteries, DROP domain_demorthen_mysteries_bonus, DROP domain_demorthen_mysteries_malus, DROP domain_occultism, DROP domain_occultism_bonus, DROP domain_occultism_malus, DROP domain_perception, DROP domain_perception_bonus, DROP domain_perception_malus, DROP domain_prayer, DROP domain_prayer_bonus, DROP domain_prayer_malus, DROP domain_feats, DROP domain_feats_bonus, DROP domain_feats_malus, DROP domain_relation, DROP domain_relation_bonus, DROP domain_relation_malus, DROP domain_performance, DROP domain_performance_bonus, DROP domain_performance_malus, DROP domain_science, DROP domain_science_bonus, DROP domain_science_malus, DROP domain_shooting_and_throwing, DROP domain_shooting_and_throwing_bonus, DROP domain_shooting_and_throwing_malus, DROP domain_travel, DROP domain_travel_bonus, DROP domain_travel_malus, DROP domain_erudition, DROP domain_erudition_bonus, DROP domain_erudition_malus');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EC4BE6905 FOREIGN KEY (social_class_domain1_id) REFERENCES domains (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410ED60BC6EB FOREIGN KEY (social_class_domain2_id) REFERENCES domains (id)');
        $this->addSql('CREATE INDEX IDX_3A29410EC4BE6905 ON characters (social_class_domain1_id)');
        $this->addSql('CREATE INDEX IDX_3A29410ED60BC6EB ON characters (social_class_domain2_id)');
        $this->addSql('ALTER TABLE characters_disciplines DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE characters_disciplines ADD domain_id INT NOT NULL, DROP domain');
        $this->addSql('ALTER TABLE characters_disciplines ADD CONSTRAINT FK_5009941115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id)');
        $this->addSql('CREATE INDEX IDX_5009941115F0EE5 ON characters_disciplines (domain_id)');
        $this->addSql('ALTER TABLE characters_disciplines ADD PRIMARY KEY (character_id, discipline_id, domain_id)');
        $this->addSql('ALTER TABLE disciplines DROP domains');
        $this->addSql('ALTER TABLE geo_environments ADD domain_id INT DEFAULT NULL, DROP domain');
        $this->addSql('ALTER TABLE geo_environments ADD CONSTRAINT FK_18F4720A115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id)');
        $this->addSql('CREATE INDEX IDX_18F4720A115F0EE5 ON geo_environments (domain_id)');
        $this->addSql('ALTER TABLE jobs ADD domain_primary_id INT DEFAULT NULL, DROP primary_domain, DROP secondary_domains');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5B05C1029 FOREIGN KEY (domain_primary_id) REFERENCES domains (id)');
        $this->addSql('CREATE INDEX IDX_A8936DC5B05C1029 ON jobs (domain_primary_id)');
        $this->addSql('ALTER TABLE social_class DROP domains');
    }
}
