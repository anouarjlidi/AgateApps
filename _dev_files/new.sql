
DROP DATABASE IF EXISTS `corahn_rin`;
CREATE DATABASE `corahn_rin` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `corahn_rin`;
-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Lun 30 Septembre 2013 à 09:48
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `corahn_rin`
--

-- --------------------------------------------------------

--
-- Structure de la table `armors`
--

CREATE TABLE IF NOT EXISTS `armors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `protection` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `artifacts`
--

CREATE TABLE IF NOT EXISTS `artifacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `consumptionValue` int(11) NOT NULL,
  `consumptionInterval` int(11) NOT NULL,
  `tank` int(11) NOT NULL,
  `resistance` int(11) NOT NULL,
  `vulnerability` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `handling` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `damage` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `Flux_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB6FC42BC338ABF2` (`Flux_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `avdesv`
--

CREATE TABLE IF NOT EXISTS `avdesv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nameFemale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `canBeDoubled` tinyint(1) NOT NULL,
  `bonusdisc` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `isDesv` tinyint(1) NOT NULL,
  `isCombatArt` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `disorder_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `inventory` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `money` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `orientation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `geoLiving` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `mentalResist` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `stamina` int(11) NOT NULL,
  `survival` tinyint(1) NOT NULL,
  `speed` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `rindath` int(11) NOT NULL,
  `exaltation` int(11) NOT NULL,
  `experienceActual` int(11) NOT NULL,
  `experienceSpent` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `CharSocialClass_id` int(11) DEFAULT NULL,
  `traitFlaw_id` int(11) DEFAULT NULL,
  `traitQuality_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_757442DE5E237E06` (`name`),
  KEY `IDX_757442DE6F8C514D` (`CharSocialClass_id`),
  KEY `IDX_757442DE87EB36AD` (`disorder_id`),
  KEY `IDX_757442DEBE04EA9` (`job_id`),
  KEY `IDX_757442DE98260155` (`region_id`),
  KEY `IDX_757442DE8F7F0595` (`traitFlaw_id`),
  KEY `IDX_757442DE68BCB902` (`traitQuality_id`),
  KEY `IDX_757442DEA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `charavtgs`
--

CREATE TABLE IF NOT EXISTS `charavtgs` (
  `character` int(11) NOT NULL,
  `avdesv` int(11) NOT NULL,
  `isDoubled` tinyint(1) NOT NULL,
  PRIMARY KEY (`character`,`avdesv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chardisciplines`
--

CREATE TABLE IF NOT EXISTS `chardisciplines` (
  `character` int(11) NOT NULL,
  `discipline` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character`,`discipline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chardomains`
--

CREATE TABLE IF NOT EXISTS `chardomains` (
  `character` int(11) NOT NULL,
  `domain` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character`,`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charflux`
--

CREATE TABLE IF NOT EXISTS `charflux` (
  `character` int(11) NOT NULL,
  `flux` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`character`,`flux`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charmodifications`
--

CREATE TABLE IF NOT EXISTS `charmodifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contentBefore` longtext COLLATE utf8_unicode_ci NOT NULL,
  `contentAfter` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B29321471136BE75` (`character_id`),
  KEY `IDX_B2932147A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `charsetbacks`
--

CREATE TABLE IF NOT EXISTS `charsetbacks` (
  `character` int(11) NOT NULL,
  `setback` int(11) NOT NULL,
  `isAvoided` tinyint(1) NOT NULL,
  PRIMARY KEY (`character`,`setback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charsocialclass`
--

CREATE TABLE IF NOT EXISTS `charsocialclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_domains1` int(11) DEFAULT NULL,
  `id_domains2` int(11) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `socialClass_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7B6034935D359764` (`id_domains1`),
  KEY `IDX_7B603493C43CC6DE` (`id_domains2`),
  KEY `IDX_7B603493E8455DA6` (`socialClass_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `charways`
--

CREATE TABLE IF NOT EXISTS `charways` (
  `character` int(11) NOT NULL,
  `way` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character`,`way`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `char_armors`
--

CREATE TABLE IF NOT EXISTS `char_armors` (
  `characters_id` int(11) NOT NULL,
  `armors_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`armors_id`),
  KEY `IDX_E096864C70F0E28` (`characters_id`),
  KEY `IDX_E096864333F27F1` (`armors_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `char_artifacts`
--

CREATE TABLE IF NOT EXISTS `char_artifacts` (
  `characters_id` int(11) NOT NULL,
  `artifacts_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`artifacts_id`),
  KEY `IDX_E7C69EB0C70F0E28` (`characters_id`),
  KEY `IDX_E7C69EB038F3D9E1` (`artifacts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `char_miracles`
--

CREATE TABLE IF NOT EXISTS `char_miracles` (
  `miracles_id` int(11) NOT NULL,
  `characters_id` int(11) NOT NULL,
  PRIMARY KEY (`miracles_id`,`characters_id`),
  KEY `IDX_52BEE3B86B117C2B` (`miracles_id`),
  KEY `IDX_52BEE3B8C70F0E28` (`characters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `char_ogham`
--

CREATE TABLE IF NOT EXISTS `char_ogham` (
  `characters_id` int(11) NOT NULL,
  `ogham_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`ogham_id`),
  KEY `IDX_103DDD01C70F0E28` (`characters_id`),
  KEY `IDX_103DDD013241FF23` (`ogham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `char_weapons`
--

CREATE TABLE IF NOT EXISTS `char_weapons` (
  `characters_id` int(11) NOT NULL,
  `weapons_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`weapons_id`),
  KEY `IDX_6D1A0E02C70F0E28` (`characters_id`),
  KEY `IDX_6D1A0E022EE82581` (`weapons_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `disciplines`
--

CREATE TABLE IF NOT EXISTS `disciplines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rank` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `discipline_domains`
--

CREATE TABLE IF NOT EXISTS `discipline_domains` (
  `disciplines_id` int(11) NOT NULL,
  `domains_id` int(11) NOT NULL,
  PRIMARY KEY (`disciplines_id`,`domains_id`),
  KEY `IDX_E6B3DFC190D3DF94` (`disciplines_id`),
  KEY `IDX_E6B3DFC13700F4DC` (`domains_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `disorders`
--

CREATE TABLE IF NOT EXISTS `disorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `disordersways`
--

CREATE TABLE IF NOT EXISTS `disordersways` (
  `disorder` int(11) NOT NULL,
  `way` int(11) NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  PRIMARY KEY (`disorder`,`way`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `Ways_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_43C68601ACFE4556` (`Ways_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_542B527C5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `eventsmarkers`
--

CREATE TABLE IF NOT EXISTS `eventsmarkers` (
  `event` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`event`,`marker_id`),
  KEY `IDX_16C473EF474460EB` (`marker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eventsmarkerstypes`
--

CREATE TABLE IF NOT EXISTS `eventsmarkerstypes` (
  `event` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `markerType_id` int(11) NOT NULL,
  PRIMARY KEY (`event`,`markerType_id`),
  KEY `IDX_C1C172031509F007` (`markerType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eventsresources`
--

CREATE TABLE IF NOT EXISTS `eventsresources` (
  `event` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`resource_id`),
  KEY `IDX_36A68AF089329D25` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eventsroutes`
--

CREATE TABLE IF NOT EXISTS `eventsroutes` (
  `event` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_id`),
  KEY `IDX_17CC38C734ECB4E6` (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eventsroutestypes`
--

CREATE TABLE IF NOT EXISTS `eventsroutestypes` (
  `event` int(11) NOT NULL,
  `route_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_type_id`),
  KEY `IDX_6B6DA9033D1FD10B` (`route_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eventszones`
--

CREATE TABLE IF NOT EXISTS `eventszones` (
  `event` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`zone_id`),
  KEY `IDX_F3E265DA9F2C3FAB` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factions`
--

CREATE TABLE IF NOT EXISTS `factions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_12F43A925E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `factions_events`
--

CREATE TABLE IF NOT EXISTS `factions_events` (
  `factions_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`factions_id`,`events_id`),
  KEY `IDX_B863A4008133CE17` (`factions_id`),
  KEY `IDX_B863A4009D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `flux`
--

CREATE TABLE IF NOT EXISTS `flux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `foes`
--

CREATE TABLE IF NOT EXISTS `foes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D36EB845E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `foes_events`
--

CREATE TABLE IF NOT EXISTS `foes_events` (
  `foes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`foes_id`,`events_id`),
  KEY `IDX_F0F98F453DF0F043` (`foes_id`),
  KEY `IDX_F0F98F459D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gmNotes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `gameMaster_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3EE2043514C6E3F4` (`gameMaster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `Books_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8A1C2FB84AECE76` (`Books_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mailssent`
--

CREATE TABLE IF NOT EXISTS `mailssent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `toEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `Mails_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_314D565869C8988A` (`Mails_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `minZoom` tinyint(1) NOT NULL,
  `maxZoom` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E71CA79B5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `markers`
--

CREATE TABLE IF NOT EXISTS `markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faction_id` int(11) DEFAULT NULL,
  `map_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `markerType_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8E34E6AC5E237E06` (`name`),
  KEY `IDX_8E34E6AC4448F8DA` (`faction_id`),
  KEY `IDX_8E34E6AC53C55F64` (`map_id`),
  KEY `IDX_8E34E6AC1509F007` (`markerType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `markerstypes`
--

CREATE TABLE IF NOT EXISTS `markerstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_585032CE5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `miracles`
--

CREATE TABLE IF NOT EXISTS `miracles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `npcs`
--

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_89A280A05E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `npcs_events`
--

CREATE TABLE IF NOT EXISTS `npcs_events` (
  `npcs_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`npcs_id`,`events_id`),
  KEY `IDX_EF85CDEF73DFFBCA` (`npcs_id`),
  KEY `IDX_EF85CDEF9D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ogham`
--

CREATE TABLE IF NOT EXISTS `ogham` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `kingdom` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `coords` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6D97690D5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `resources_routes`
--

CREATE TABLE IF NOT EXISTS `resources_routes` (
  `resources_id` int(11) NOT NULL,
  `routes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routes_id`),
  KEY `IDX_389FB5C1ACFC5BFF` (`resources_id`),
  KEY `IDX_389FB5C1AE2C16DC` (`routes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resources_routestypes`
--

CREATE TABLE IF NOT EXISTS `resources_routestypes` (
  `resources_id` int(11) NOT NULL,
  `routestypes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routestypes_id`),
  KEY `IDX_4639B5C5ACFC5BFF` (`resources_id`),
  KEY `IDX_4639B5C5145B0ACB` (`routestypes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `faction_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `routeType_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3579C7855E237E06` (`name`),
  KEY `IDX_3579C78553C55F64` (`map_id`),
  KEY `IDX_3579C7854448F8DA` (`faction_id`),
  KEY `IDX_3579C785C231A351` (`routeType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `routestypes`
--

CREATE TABLE IF NOT EXISTS `routestypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F37CDE005E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `routestypes_events`
--

CREATE TABLE IF NOT EXISTS `routestypes_events` (
  `routestypes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`routestypes_id`,`events_id`),
  KEY `IDX_6F061AD9145B0ACB` (`routestypes_id`),
  KEY `IDX_6F061AD99D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `routes_markers`
--

CREATE TABLE IF NOT EXISTS `routes_markers` (
  `routes_id` int(11) NOT NULL,
  `markers_id` int(11) NOT NULL,
  PRIMARY KEY (`routes_id`,`markers_id`),
  KEY `IDX_AF2807D1AE2C16DC` (`routes_id`),
  KEY `IDX_AF2807D1D0EEC2B5` (`markers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `setbacks`
--

CREATE TABLE IF NOT EXISTS `setbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `socialclass`
--

CREATE TABLE IF NOT EXISTS `socialclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `social_class_domains`
--

CREATE TABLE IF NOT EXISTS `social_class_domains` (
  `socialclass_id` int(11) NOT NULL,
  `domains_id` int(11) NOT NULL,
  PRIMARY KEY (`socialclass_id`,`domains_id`),
  KEY `IDX_FFB456F511333FF0` (`socialclass_id`),
  KEY `IDX_FFB456F53700F4DC` (`domains_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `steps`
--

CREATE TABLE IF NOT EXISTS `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `traits`
--

CREATE TABLE IF NOT EXISTS `traits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nameFemale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isQuality` tinyint(1) NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `Ways_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E30CA450ACFE4556` (`Ways_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ways`
--

CREATE TABLE IF NOT EXISTS `ways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortName` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `fault` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `weapons`
--

CREATE TABLE IF NOT EXISTS `weapons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dmg` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `contact` tinyint(1) NOT NULL,
  `range` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `weather`
--

CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_836DEAF25E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `weather_events`
--

CREATE TABLE IF NOT EXISTS `weather_events` (
  `weather_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`weather_id`,`events_id`),
  KEY `IDX_BDA0712C8CE675E` (`weather_id`),
  KEY `IDX_BDA0712C9D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `faction_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_440B9E6C5E237E06` (`name`),
  KEY `IDX_440B9E6C53C55F64` (`map_id`),
  KEY `IDX_440B9E6C4448F8DA` (`faction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `artifacts`
--
ALTER TABLE `artifacts`
  ADD CONSTRAINT `FK_AB6FC42BC338ABF2` FOREIGN KEY (`Flux_id`) REFERENCES `flux` (`id`);

--
-- Contraintes pour la table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `FK_757442DEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_757442DE68BCB902` FOREIGN KEY (`traitQuality_id`) REFERENCES `traits` (`id`),
  ADD CONSTRAINT `FK_757442DE6F8C514D` FOREIGN KEY (`CharSocialClass_id`) REFERENCES `charsocialclass` (`id`),
  ADD CONSTRAINT `FK_757442DE87EB36AD` FOREIGN KEY (`disorder_id`) REFERENCES `disorders` (`id`),
  ADD CONSTRAINT `FK_757442DE8F7F0595` FOREIGN KEY (`traitFlaw_id`) REFERENCES `traits` (`id`),
  ADD CONSTRAINT `FK_757442DE98260155` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `FK_757442DEBE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Contraintes pour la table `charmodifications`
--
ALTER TABLE `charmodifications`
  ADD CONSTRAINT `FK_B2932147A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_B29321471136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`);

--
-- Contraintes pour la table `charsocialclass`
--
ALTER TABLE `charsocialclass`
  ADD CONSTRAINT `FK_7B603493E8455DA6` FOREIGN KEY (`socialClass_id`) REFERENCES `socialclass` (`id`),
  ADD CONSTRAINT `FK_7B6034935D359764` FOREIGN KEY (`id_domains1`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_7B603493C43CC6DE` FOREIGN KEY (`id_domains2`) REFERENCES `domains` (`id`);

--
-- Contraintes pour la table `char_armors`
--
ALTER TABLE `char_armors`
  ADD CONSTRAINT `FK_E096864333F27F1` FOREIGN KEY (`armors_id`) REFERENCES `armors` (`id`),
  ADD CONSTRAINT `FK_E096864C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`);

--
-- Contraintes pour la table `char_artifacts`
--
ALTER TABLE `char_artifacts`
  ADD CONSTRAINT `FK_E7C69EB038F3D9E1` FOREIGN KEY (`artifacts_id`) REFERENCES `artifacts` (`id`),
  ADD CONSTRAINT `FK_E7C69EB0C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`);

--
-- Contraintes pour la table `char_miracles`
--
ALTER TABLE `char_miracles`
  ADD CONSTRAINT `FK_52BEE3B8C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `FK_52BEE3B86B117C2B` FOREIGN KEY (`miracles_id`) REFERENCES `miracles` (`id`);

--
-- Contraintes pour la table `char_ogham`
--
ALTER TABLE `char_ogham`
  ADD CONSTRAINT `FK_103DDD013241FF23` FOREIGN KEY (`ogham_id`) REFERENCES `ogham` (`id`),
  ADD CONSTRAINT `FK_103DDD01C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`);

--
-- Contraintes pour la table `char_weapons`
--
ALTER TABLE `char_weapons`
  ADD CONSTRAINT `FK_6D1A0E022EE82581` FOREIGN KEY (`weapons_id`) REFERENCES `weapons` (`id`),
  ADD CONSTRAINT `FK_6D1A0E02C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`);

--
-- Contraintes pour la table `discipline_domains`
--
ALTER TABLE `discipline_domains`
  ADD CONSTRAINT `FK_E6B3DFC13700F4DC` FOREIGN KEY (`domains_id`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_E6B3DFC190D3DF94` FOREIGN KEY (`disciplines_id`) REFERENCES `disciplines` (`id`);

--
-- Contraintes pour la table `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `FK_43C68601ACFE4556` FOREIGN KEY (`Ways_id`) REFERENCES `ways` (`id`);

--
-- Contraintes pour la table `eventsmarkers`
--
ALTER TABLE `eventsmarkers`
  ADD CONSTRAINT `FK_16C473EF474460EB` FOREIGN KEY (`marker_id`) REFERENCES `markers` (`id`);

--
-- Contraintes pour la table `eventsmarkerstypes`
--
ALTER TABLE `eventsmarkerstypes`
  ADD CONSTRAINT `FK_C1C172031509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`);

--
-- Contraintes pour la table `eventsresources`
--
ALTER TABLE `eventsresources`
  ADD CONSTRAINT `FK_36A68AF089329D25` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`);

--
-- Contraintes pour la table `eventsroutes`
--
ALTER TABLE `eventsroutes`
  ADD CONSTRAINT `FK_17CC38C734ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);

--
-- Contraintes pour la table `eventsroutestypes`
--
ALTER TABLE `eventsroutestypes`
  ADD CONSTRAINT `FK_6B6DA9033D1FD10B` FOREIGN KEY (`route_type_id`) REFERENCES `routestypes` (`id`);

--
-- Contraintes pour la table `eventszones`
--
ALTER TABLE `eventszones`
  ADD CONSTRAINT `FK_F3E265DA9F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);

--
-- Contraintes pour la table `factions_events`
--
ALTER TABLE `factions_events`
  ADD CONSTRAINT `FK_B863A4009D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B863A4008133CE17` FOREIGN KEY (`factions_id`) REFERENCES `factions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `foes_events`
--
ALTER TABLE `foes_events`
  ADD CONSTRAINT `FK_F0F98F459D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F0F98F453DF0F043` FOREIGN KEY (`foes_id`) REFERENCES `foes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `FK_3EE2043514C6E3F4` FOREIGN KEY (`gameMaster_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `FK_8A1C2FB84AECE76` FOREIGN KEY (`Books_id`) REFERENCES `books` (`id`);

--
-- Contraintes pour la table `mailssent`
--
ALTER TABLE `mailssent`
  ADD CONSTRAINT `FK_314D565869C8988A` FOREIGN KEY (`Mails_id`) REFERENCES `mails` (`id`);

--
-- Contraintes pour la table `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `FK_8E34E6AC1509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`),
  ADD CONSTRAINT `FK_8E34E6AC4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_8E34E6AC53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

--
-- Contraintes pour la table `npcs_events`
--
ALTER TABLE `npcs_events`
  ADD CONSTRAINT `FK_EF85CDEF9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EF85CDEF73DFFBCA` FOREIGN KEY (`npcs_id`) REFERENCES `npcs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `resources_routes`
--
ALTER TABLE `resources_routes`
  ADD CONSTRAINT `FK_389FB5C1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_389FB5C1ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `resources_routestypes`
--
ALTER TABLE `resources_routestypes`
  ADD CONSTRAINT `FK_4639B5C5145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4639B5C5ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `FK_3579C785C231A351` FOREIGN KEY (`routeType_id`) REFERENCES `routestypes` (`id`),
  ADD CONSTRAINT `FK_3579C7854448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_3579C78553C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

--
-- Contraintes pour la table `routestypes_events`
--
ALTER TABLE `routestypes_events`
  ADD CONSTRAINT `FK_6F061AD99D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6F061AD9145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `routes_markers`
--
ALTER TABLE `routes_markers`
  ADD CONSTRAINT `FK_AF2807D1D0EEC2B5` FOREIGN KEY (`markers_id`) REFERENCES `markers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AF2807D1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `social_class_domains`
--
ALTER TABLE `social_class_domains`
  ADD CONSTRAINT `FK_FFB456F53700F4DC` FOREIGN KEY (`domains_id`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_FFB456F511333FF0` FOREIGN KEY (`socialclass_id`) REFERENCES `socialclass` (`id`);

--
-- Contraintes pour la table `traits`
--
ALTER TABLE `traits`
  ADD CONSTRAINT `FK_E30CA450ACFE4556` FOREIGN KEY (`Ways_id`) REFERENCES `ways` (`id`);

--
-- Contraintes pour la table `weather_events`
--
ALTER TABLE `weather_events`
  ADD CONSTRAINT `FK_BDA0712C9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BDA0712C8CE675E` FOREIGN KEY (`weather_id`) REFERENCES `weather` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `zones`
--
ALTER TABLE `zones`
  ADD CONSTRAINT `FK_440B9E6C4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_440B9E6C53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
