DROP DATABASE IF EXISTS `corahn_rin`;

CREATE DATABASE `corahn_rin` COLLATE utf8_unicode_ci;

USE `corahn_rin`;

CREATE TABLE `weapons`(
		`id`		INT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`dmg`		TINYINT NOT NULL ,
		`price`		INT NOT NULL ,
		`availability` VARCHAR(3) NOT NULL ,
		`contact` Bool NOT NULL ,
		`range`		INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `armors`(
		`id`		INT NOT NULL ,
		`name`			VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL ,
		`protection` INT NOT NULL ,
		`price`			INT NOT NULL ,
		`availability` VARCHAR(3) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `avdesv`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`name_female` VARCHAR(50) NOT NULL ,
		`xp`		INT NOT NULL ,
		`description` TEXT NOT NULL ,
		`can_be_doubled` Bool NOT NULL ,
		`bonusdisc` VARCHAR(10) NOT NULL ,
		`is_desv`		Bool NOT NULL ,
		`is_combat_art` Bool NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `characters`(
		`id`				INT (11) AUTO_INCREMENT NOT NULL ,
		`name`				VARCHAR(255) NOT NULL ,
		`status`		INT NOT NULL ,
		`sex`				VARCHAR(1) NOT NULL ,
		`inventory`		TEXT NOT NULL ,
		`money`				VARCHAR(150) NOT NULL ,
		`orientation`		VARCHAR(30) NOT NULL ,
		`char_content`		MEDIUMTEXT NOT NULL ,
		`geo_living`		VARCHAR(25) NOT NULL ,
		`age`				INT NOT NULL ,
		`mental_resist`		INT NOT NULL ,
		`health`		INT NOT NULL ,
		`stamina`		INT NOT NULL ,
		`survival`		TINYINT NOT NULL ,
		`speed`				INT NOT NULL ,
		`defense`		INT NOT NULL ,
		`rindath`		INT NOT NULL ,
		`exaltation`		INT NOT NULL ,
		`experience_actual` INT NOT NULL ,
		`experience_spent` INT NOT NULL ,
		`id_regions`		INT NOT NULL ,
		`id_users`		INT NOT NULL ,
		`id_traits_quality` INT NOT NULL ,
		`id_traits_flaw` INT NOT NULL ,
		`id_desordres`		INT NOT NULL ,
		`id_jobs`		INT NOT NULL ,
		`id_char_social_class` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `char_modifications`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`content_before` TEXT NOT NULL ,
		`content_after` TEXT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`id_users` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE `desordres`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(100) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `disciplines`(
		`id`		INT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL ,
		`rank`		VARCHAR(40) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `domains`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(70) NOT NULL ,
		`description` TEXT NOT NULL ,
		`id_ways` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `games`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(140) NOT NULL ,
		`summary` TEXT NOT NULL ,
		`gm_notes` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE `jobs`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(140) NOT NULL ,
		`description` TEXT NOT NULL ,
		`id_books` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `mails`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`code` VARCHAR(50) NOT NULL ,
		`content` TEXT NOT NULL ,
		`subject` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (code )
)ENGINE=InnoDB;


CREATE TABLE `mails_sent`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`to_name` VARCHAR(255) NOT NULL ,
		`to_email` VARCHAR(255) NOT NULL ,
		`subject` TEXT NOT NULL ,
		`content` TEXT NOT NULL ,
		`date` VARCHAR(50) NOT NULL ,
		`id_mails` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE `pages`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`slug`		VARCHAR(30) NOT NULL ,
		`title`		VARCHAR(75) NOT NULL ,
		`show_in_admin` Bool NOT NULL ,
		`show_in_menu` Bool NOT NULL ,
		`require_login` Bool NOT NULL ,
		`id_groups` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		INDEX (slug )
)ENGINE=InnoDB;


CREATE TABLE `regions`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL ,
		`kingdom` VARCHAR(70) NOT NULL ,
		`coords` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `revers`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `steps`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`step` INT NOT NULL ,
		`slug` VARCHAR(50) NOT NULL ,
		`title` VARCHAR(75) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (step )
)ENGINE=InnoDB;


CREATE TABLE `traits`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(50) NOT NULL ,
		`name_female` VARCHAR(50) NOT NULL ,
		`is_quality` Bool NOT NULL ,
		`is_major` Bool NOT NULL ,
		`id_ways` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `users`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(100) NOT NULL ,
		`password`		VARCHAR(50) NOT NULL ,
		`email`		VARCHAR(255) NOT NULL ,
		`status`		INT NOT NULL ,
		`confirm_register` VARCHAR(50) NOT NULL ,
		`id_groups`		INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		INDEX (name ,email )
)ENGINE=InnoDB;


CREATE TABLE `ways`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`short_name` VARCHAR(3) NOT NULL ,
		`name`		VARCHAR(40) NOT NULL ,
		`fault` VARCHAR(40) NOT NULL ,
		`description` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (short_name ,name )
)ENGINE=InnoDB;


CREATE TABLE `groups`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(70) NOT NULL ,
		`acl` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `social_class`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(25) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `ogham`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(70) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `miracles`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(70) NOT NULL ,
		`is_major` Bool NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `artifacts`(
		`id`				INT (11) AUTO_INCREMENT NOT NULL ,
		`name`				VARCHAR(70) NOT NULL ,
		`price`		INT NOT NULL ,
		`consumption_value` INT NOT NULL ,
		`consuption_interval` INT NOT NULL ,
		`tank`				INT NOT NULL ,
		`resistance`		INT NOT NULL ,
		`vulnerability` VARCHAR(70) NOT NULL ,
		`handling`		VARCHAR(20) NOT NULL ,
		`damage`		INT NOT NULL ,
		`id_flux`		INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `flux`(
		`id` INT (11) AUTO_INCREMENT NOT NULL ,
		`name` VARCHAR(70) NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `books`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`name`		VARCHAR(80) NOT NULL ,
		`description` TEXT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id ) ,
		UNIQUE (name )
)ENGINE=InnoDB;


CREATE TABLE `char_social_class`(
		`id`		INT (11) AUTO_INCREMENT NOT NULL ,
		`id_social_class` INT NOT NULL ,
		`id_domains1` INT NOT NULL ,
		`id_domains2` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE `char_ways`(
		`score`		TINYINT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`id_ways` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_ways )
)ENGINE=InnoDB;


CREATE TABLE `character_revers`(
		`is_avoided` Bool NOT NULL ,
		`id_revers` INT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_revers ,id_characters )
)ENGINE=InnoDB;


CREATE TABLE `char_armors`(
		`id_characters` INT NOT NULL ,
		`id_armors` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_armors )
)ENGINE=InnoDB;


CREATE TABLE `char_avtgs`(
		`is_doubled` Bool NOT NULL ,
		`id_avdesv` INT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_avdesv ,id_characters )
)ENGINE=InnoDB;


CREATE TABLE `char_weapons`(
		`id_characters` INT NOT NULL ,
		`id_weapons` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_weapons )
)ENGINE=InnoDB;


CREATE TABLE `char_domains`(
		`score`		INT NOT NULL ,
		`rank`		TINYINT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`id_domains` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_domains )
)ENGINE=InnoDB;


CREATE TABLE `discipline_domains`(
		`id_disciplines` INT NOT NULL ,
		`id_domains` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_disciplines ,id_domains )
)ENGINE=InnoDB;


CREATE TABLE `char_disciplines`(
		`score`		INT NOT NULL ,
		`id_disciplines` INT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_disciplines ,id_characters )
)ENGINE=InnoDB;


CREATE TABLE `game_players`(
		`is_gm`		Bool ,
		`confirm_invite` VARCHAR(70) NOT NULL ,
		`id_users` INT NOT NULL ,
		`id_games` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_users ,id_games )
)ENGINE=InnoDB;


CREATE TABLE `disorder_ways`(
		`is_major` Bool ,
		`id_desordres` INT NOT NULL ,
		`id_ways` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_desordres ,id_ways )
)ENGINE=InnoDB;


CREATE TABLE `char_ogham`(
		`id_characters` INT NOT NULL ,
		`id_ogham` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_ogham )
)ENGINE=InnoDB;


CREATE TABLE `char_miracles`(
		`id_miracles` INT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_miracles ,id_characters )
)ENGINE=InnoDB;


CREATE TABLE `char_artifacts`(
		`id_characters` INT NOT NULL ,
		`id_artifacts` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_artifacts )
)ENGINE=InnoDB;


CREATE TABLE `char_flux`(
		`quantity` INT NOT NULL ,
		`id_characters` INT NOT NULL ,
		`id_flux` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_characters ,id_flux )
)ENGINE=InnoDB;


CREATE TABLE `social_class_domains`(
		`id_social_class` INT NOT NULL ,
		`id_domains` INT NOT NULL ,
		`date_created` INT NOT NULL,
		`date_updated` INT NOT NULL,
		PRIMARY KEY (id_social_class ,id_domains )
)ENGINE=InnoDB;

ALTER TABLE characters ADD CONSTRAINT FK_characters_id_regions FOREIGN KEY (id_regions) REFERENCES regions(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_users FOREIGN KEY (id_users) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_traits_quality FOREIGN KEY (id_traits_quality) REFERENCES traits(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_traits_flaw FOREIGN KEY (id_traits_flaw) REFERENCES traits(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_desordres FOREIGN KEY (id_desordres) REFERENCES desordres(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_jobs FOREIGN KEY (id_jobs) REFERENCES jobs(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE characters ADD CONSTRAINT FK_characters_id_char_social_class FOREIGN KEY (id_char_social_class) REFERENCES char_social_class(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_modifications ADD CONSTRAINT FK_char_modifications_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_modifications ADD CONSTRAINT FK_char_modifications_id_users FOREIGN KEY (id_users) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE domains ADD CONSTRAINT FK_domains_id_ways FOREIGN KEY (id_ways) REFERENCES ways(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE jobs ADD CONSTRAINT FK_jobs_id_books FOREIGN KEY (id_books) REFERENCES books(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE mails_sent ADD CONSTRAINT FK_mails_sent_id_mails FOREIGN KEY (id_mails) REFERENCES mails(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE pages ADD CONSTRAINT FK_pages_id_groups FOREIGN KEY (id_groups) REFERENCES groups(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE traits ADD CONSTRAINT FK_traits_id_ways FOREIGN KEY (id_ways) REFERENCES ways(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE users ADD CONSTRAINT FK_users_id_groups FOREIGN KEY (id_groups) REFERENCES groups(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE artifacts ADD CONSTRAINT FK_artifacts_id_flux FOREIGN KEY (id_flux) REFERENCES flux(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_social_class ADD CONSTRAINT FK_char_social_class_id_social_class FOREIGN KEY (id_social_class) REFERENCES social_class(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_social_class ADD CONSTRAINT FK_char_social_class_id_domains1 FOREIGN KEY (id_domains1) REFERENCES domains(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_social_class ADD CONSTRAINT FK_char_social_class_id_domains2 FOREIGN KEY (id_domains2) REFERENCES domains(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_ways ADD CONSTRAINT FK_char_ways_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_ways ADD CONSTRAINT FK_char_ways_id_ways FOREIGN KEY (id_ways) REFERENCES ways(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE character_revers ADD CONSTRAINT FK_character_revers_id_revers FOREIGN KEY (id_revers) REFERENCES revers(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE character_revers ADD CONSTRAINT FK_character_revers_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_armors ADD CONSTRAINT FK_char_armors_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_armors ADD CONSTRAINT FK_char_armors_id_armors FOREIGN KEY (id_armors) REFERENCES armors(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_avtgs ADD CONSTRAINT FK_char_avtgs_id_avdesv FOREIGN KEY (id_avdesv) REFERENCES avdesv(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_avtgs ADD CONSTRAINT FK_char_avtgs_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_weapons ADD CONSTRAINT FK_char_weapons_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_weapons ADD CONSTRAINT FK_char_weapons_id_weapons FOREIGN KEY (id_weapons) REFERENCES weapons(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_domains ADD CONSTRAINT FK_char_domains_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_domains ADD CONSTRAINT FK_char_domains_id_domains FOREIGN KEY (id_domains) REFERENCES domains(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE discipline_domains ADD CONSTRAINT FK_discipline_domains_id_disciplines FOREIGN KEY (id_disciplines) REFERENCES disciplines(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE discipline_domains ADD CONSTRAINT FK_discipline_domains_id_domains FOREIGN KEY (id_domains) REFERENCES domains(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_disciplines ADD CONSTRAINT FK_char_disciplines_id_disciplines FOREIGN KEY (id_disciplines) REFERENCES disciplines(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_disciplines ADD CONSTRAINT FK_char_disciplines_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE game_players ADD CONSTRAINT FK_game_players_id_users FOREIGN KEY (id_users) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE game_players ADD CONSTRAINT FK_game_players_id_games FOREIGN KEY (id_games) REFERENCES games(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE disorder_ways ADD CONSTRAINT FK_disorder_ways_id_desordres FOREIGN KEY (id_desordres) REFERENCES desordres(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE disorder_ways ADD CONSTRAINT FK_disorder_ways_id_ways FOREIGN KEY (id_ways) REFERENCES ways(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_ogham ADD CONSTRAINT FK_char_ogham_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_ogham ADD CONSTRAINT FK_char_ogham_id_ogham FOREIGN KEY (id_ogham) REFERENCES ogham(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_miracles ADD CONSTRAINT FK_char_miracles_id_miracles FOREIGN KEY (id_miracles) REFERENCES miracles(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_miracles ADD CONSTRAINT FK_char_miracles_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_artifacts ADD CONSTRAINT FK_char_artifacts_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_artifacts ADD CONSTRAINT FK_char_artifacts_id_artifacts FOREIGN KEY (id_artifacts) REFERENCES artifacts(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_flux ADD CONSTRAINT FK_char_flux_id_characters FOREIGN KEY (id_characters) REFERENCES characters(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE char_flux ADD CONSTRAINT FK_char_flux_id_flux FOREIGN KEY (id_flux) REFERENCES flux(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE social_class_domains ADD CONSTRAINT FK_social_class_domains_id_social_class FOREIGN KEY (id_social_class) REFERENCES social_class(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE social_class_domains ADD CONSTRAINT FK_social_class_domains_id_domains FOREIGN KEY (id_domains) REFERENCES domains(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
