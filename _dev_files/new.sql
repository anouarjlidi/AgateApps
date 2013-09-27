
DROP DATABASE IF EXISTS `corahn_rin`;
CREATE DATABASE `corahn_rin` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `corahn_rin`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `armors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `protection` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `artifacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_flux` int(11) DEFAULT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `consumption_value` int(11) NOT NULL,
  `consuption_interval` int(11) NOT NULL,
  `tank` int(11) NOT NULL,
  `resistance` int(11) NOT NULL,
  `vulnerability` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `handling` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `damage` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_299E4688F9722D38` (`id_flux`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `avdesv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_female` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `can_be_doubled` tinyint(1) NOT NULL,
  `bonusdisc` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `is_desv` tinyint(1) NOT NULL,
  `is_combat_art` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_char_social_class` int(11) DEFAULT NULL,
  `id_disorders` int(11) DEFAULT NULL,
  `id_jobs` int(11) DEFAULT NULL,
  `id_regions` int(11) DEFAULT NULL,
  `id_traits_flaw` int(11) DEFAULT NULL,
  `id_traits_quality` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `inventory` longtext COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `orientation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `geo_living` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `mental_resist` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `stamina` int(11) NOT NULL,
  `survival` tinyint(1) NOT NULL,
  `speed` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `rindath` int(11) NOT NULL,
  `exaltation` int(11) NOT NULL,
  `experience_actual` int(11) NOT NULL,
  `experience_spent` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A29410E50C5E72D` (`id_char_social_class`),
  KEY `IDX_3A29410E217A554A` (`id_disorders`),
  KEY `IDX_3A29410E23B371C7` (`id_jobs`),
  KEY `IDX_3A29410E7CFAD083` (`id_regions`),
  KEY `IDX_3A29410E89BBD117` (`id_traits_flaw`),
  KEY `IDX_3A29410E68C567C` (`id_traits_quality`),
  KEY `IDX_3A29410EFA06E4D9` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `char_armors` (
  `id_characters` int(11) NOT NULL,
  `id_armors` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_armors`),
  KEY `IDX_E0968649FA3C1D9` (`id_characters`),
  KEY `IDX_E096864898DE32F` (`id_armors`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_artifacts` (
  `id_characters` int(11) NOT NULL,
  `id_artifacts` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_artifacts`),
  KEY `IDX_E7C69EB09FA3C1D9` (`id_characters`),
  KEY `IDX_E7C69EB0A9ABFAAF` (`id_artifacts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_avtgs` (
  `id_characters` int(11) NOT NULL,
  `id_avdesv` int(11) NOT NULL,
  `is_doubled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_avdesv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_disciplines` (
  `id_characters` int(11) NOT NULL,
  `id_disciplines` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_disciplines`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_domains` (
  `id_characters` int(11) NOT NULL,
  `id_domains` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_domains`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_flux` (
  `id_characters` int(11) NOT NULL,
  `id_avdesv` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_avdesv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_miracles` (
  `id_miracles` int(11) NOT NULL,
  `id_characters` int(11) NOT NULL,
  PRIMARY KEY (`id_miracles`,`id_characters`),
  KEY `IDX_52BEE3B83B59A85A` (`id_miracles`),
  KEY `IDX_52BEE3B89FA3C1D9` (`id_characters`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_modifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_characters` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `content_before` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_after` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CB8794FB9FA3C1D9` (`id_characters`),
  KEY `IDX_CB8794FBFA06E4D9` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `char_ogham` (
  `id_characters` int(11) NOT NULL,
  `id_ogham` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_ogham`),
  KEY `IDX_103DDD019FA3C1D9` (`id_characters`),
  KEY `IDX_103DDD019C154490` (`id_ogham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_setbacks` (
  `id_characters` int(11) NOT NULL,
  `id_setbacks` int(11) NOT NULL,
  `is_doubled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_setbacks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_social_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_domains1` int(11) DEFAULT NULL,
  `id_domains2` int(11) DEFAULT NULL,
  `id_social_class` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A1F28F3A5D359764` (`id_domains1`),
  KEY `IDX_A1F28F3AC43CC6DE` (`id_domains2`),
  KEY `IDX_A1F28F3A841AD87F` (`id_social_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `char_ways` (
  `id_characters` int(11) NOT NULL,
  `id_ways` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_ways`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `char_weapons` (
  `id_characters` int(11) NOT NULL,
  `id_weapons` int(11) NOT NULL,
  PRIMARY KEY (`id_characters`,`id_weapons`),
  KEY `IDX_6D1A0E029FA3C1D9` (`id_characters`),
  KEY `IDX_6D1A0E028C931291` (`id_weapons`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `disciplines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rank` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `discipline_domains` (
  `id_disciplines` int(11) NOT NULL,
  `id_domains` int(11) NOT NULL,
  PRIMARY KEY (`id_disciplines`,`id_domains`),
  KEY `IDX_E6B3DFC1B50F912F` (`id_disciplines`),
  KEY `IDX_E6B3DFC152E616ED` (`id_domains`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `disorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `disorders_ways` (
  `id_disorders` int(11) NOT NULL,
  `id_ways` int(11) NOT NULL,
  `is_major` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_disorders`,`id_ways`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ways` int(11) DEFAULT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C7BBF9D22681815` (`id_ways`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eventsmarkers` (
  `event` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`event`,`marker_id`),
  KEY `IDX_16C473EF474460EB` (`marker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eventsmarkerstypes` (
  `event` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `markerType_id` int(11) NOT NULL,
  PRIMARY KEY (`event`,`markerType_id`),
  KEY `IDX_C1C172031509F007` (`markerType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eventsresources` (
  `event` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`resource_id`),
  KEY `IDX_36A68AF089329D25` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eventsroutes` (
  `event` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_id`),
  KEY `IDX_17CC38C734ECB4E6` (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eventsroutestypes` (
  `event` int(11) NOT NULL,
  `route_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_type_id`),
  KEY `IDX_6B6DA9033D1FD10B` (`route_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eventszones` (
  `event` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`zone_id`),
  KEY `IDX_F3E265DA9F2C3FAB` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `factions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `factions_events` (
  `factions_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`factions_id`,`events_id`),
  KEY `IDX_B863A4008133CE17` (`factions_id`),
  KEY `IDX_B863A4009D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `flux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `foes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `foes_events` (
  `foes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`foes_id`,`events_id`),
  KEY `IDX_F0F98F453DF0F043` (`foes_id`),
  KEY `IDX_F0F98F459D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_users_gm` int(11) DEFAULT NULL,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gm_notes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FF232B3115455713` (`is_users_gm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_books` int(11) DEFAULT NULL,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A8936DC5A49E6BA2` (`id_books`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mails_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mails` int(11) DEFAULT NULL,
  `to_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A34C3D908DDD6135` (`id_mails`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `minZoom` tinyint(1) NOT NULL,
  `maxZoom` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  KEY `IDX_8E34E6AC4448F8DA` (`faction_id`),
  KEY `IDX_8E34E6AC53C55F64` (`map_id`),
  KEY `IDX_8E34E6AC1509F007` (`markerType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `markerstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `miracles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `is_major` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `npcs_events` (
  `npcs_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`npcs_id`,`events_id`),
  KEY `IDX_EF85CDEF73DFFBCA` (`npcs_id`),
  KEY `IDX_EF85CDEF9D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `ogham` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `kingdom` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `coords` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `resources_routes` (
  `resources_id` int(11) NOT NULL,
  `routes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routes_id`),
  KEY `IDX_389FB5C1ACFC5BFF` (`resources_id`),
  KEY `IDX_389FB5C1AE2C16DC` (`routes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `resources_routestypes` (
  `resources_id` int(11) NOT NULL,
  `routestypes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routestypes_id`),
  KEY `IDX_4639B5C5ACFC5BFF` (`resources_id`),
  KEY `IDX_4639B5C5145B0ACB` (`routestypes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `IDX_3579C78553C55F64` (`map_id`),
  KEY `IDX_3579C7854448F8DA` (`faction_id`),
  KEY `IDX_3579C785C231A351` (`routeType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `routestypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `routestypes_events` (
  `routestypes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`routestypes_id`,`events_id`),
  KEY `IDX_6F061AD9145B0ACB` (`routestypes_id`),
  KEY `IDX_6F061AD99D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `routes_markers` (
  `routes_id` int(11) NOT NULL,
  `markers_id` int(11) NOT NULL,
  PRIMARY KEY (`routes_id`,`markers_id`),
  KEY `IDX_AF2807D1AE2C16DC` (`routes_id`),
  KEY `IDX_AF2807D1D0EEC2B5` (`markers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `setbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `social_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `social_class_domains` (
  `id_social_class` int(11) NOT NULL,
  `id_domains` int(11) NOT NULL,
  PRIMARY KEY (`id_social_class`,`id_domains`),
  KEY `IDX_FFB456F5841AD87F` (`id_social_class`),
  KEY `IDX_FFB456F552E616ED` (`id_domains`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `traits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ways` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_female` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_quality` tinyint(1) NOT NULL,
  `is_major` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E4A0A16622681815` (`id_ways`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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

CREATE TABLE IF NOT EXISTS `ways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `fault` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `weapons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dmg` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `contact` tinyint(1) NOT NULL,
  `range` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `weather_events` (
  `weather_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`weather_id`,`events_id`),
  KEY `IDX_BDA0712C8CE675E` (`weather_id`),
  KEY `IDX_BDA0712C9D6A1065` (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `faction_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_440B9E6C53C55F64` (`map_id`),
  KEY `IDX_440B9E6C4448F8DA` (`faction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `artifacts`
  ADD CONSTRAINT `FK_299E4688F9722D38` FOREIGN KEY (`id_flux`) REFERENCES `flux` (`id`);

ALTER TABLE `characters`
  ADD CONSTRAINT `FK_3A29410EFA06E4D9` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_3A29410E217A554A` FOREIGN KEY (`id_disorders`) REFERENCES `disorders` (`id`),
  ADD CONSTRAINT `FK_3A29410E23B371C7` FOREIGN KEY (`id_jobs`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `FK_3A29410E50C5E72D` FOREIGN KEY (`id_char_social_class`) REFERENCES `char_social_class` (`id`),
  ADD CONSTRAINT `FK_3A29410E68C567C` FOREIGN KEY (`id_traits_quality`) REFERENCES `traits` (`id`),
  ADD CONSTRAINT `FK_3A29410E7CFAD083` FOREIGN KEY (`id_regions`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `FK_3A29410E89BBD117` FOREIGN KEY (`id_traits_flaw`) REFERENCES `traits` (`id`);

ALTER TABLE `char_armors`
  ADD CONSTRAINT `FK_E096864898DE32F` FOREIGN KEY (`id_armors`) REFERENCES `armors` (`id`),
  ADD CONSTRAINT `FK_E0968649FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`);

ALTER TABLE `char_artifacts`
  ADD CONSTRAINT `FK_E7C69EB0A9ABFAAF` FOREIGN KEY (`id_artifacts`) REFERENCES `artifacts` (`id`),
  ADD CONSTRAINT `FK_E7C69EB09FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`);

ALTER TABLE `char_miracles`
  ADD CONSTRAINT `FK_52BEE3B89FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `FK_52BEE3B83B59A85A` FOREIGN KEY (`id_miracles`) REFERENCES `miracles` (`id`);

ALTER TABLE `char_modifications`
  ADD CONSTRAINT `FK_CB8794FBFA06E4D9` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_CB8794FB9FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`);

ALTER TABLE `char_ogham`
  ADD CONSTRAINT `FK_103DDD019C154490` FOREIGN KEY (`id_ogham`) REFERENCES `ogham` (`id`),
  ADD CONSTRAINT `FK_103DDD019FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`);

ALTER TABLE `char_social_class`
  ADD CONSTRAINT `FK_A1F28F3A841AD87F` FOREIGN KEY (`id_social_class`) REFERENCES `social_class` (`id`),
  ADD CONSTRAINT `FK_A1F28F3A5D359764` FOREIGN KEY (`id_domains1`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_A1F28F3AC43CC6DE` FOREIGN KEY (`id_domains2`) REFERENCES `domains` (`id`);

ALTER TABLE `char_weapons`
  ADD CONSTRAINT `FK_6D1A0E028C931291` FOREIGN KEY (`id_weapons`) REFERENCES `weapons` (`id`),
  ADD CONSTRAINT `FK_6D1A0E029FA3C1D9` FOREIGN KEY (`id_characters`) REFERENCES `characters` (`id`);

ALTER TABLE `discipline_domains`
  ADD CONSTRAINT `FK_E6B3DFC152E616ED` FOREIGN KEY (`id_domains`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_E6B3DFC1B50F912F` FOREIGN KEY (`id_disciplines`) REFERENCES `disciplines` (`id`);

ALTER TABLE `domains`
  ADD CONSTRAINT `FK_8C7BBF9D22681815` FOREIGN KEY (`id_ways`) REFERENCES `ways` (`id`);

ALTER TABLE `eventsmarkers`
  ADD CONSTRAINT `FK_16C473EF474460EB` FOREIGN KEY (`marker_id`) REFERENCES `markers` (`id`);

ALTER TABLE `eventsmarkerstypes`
  ADD CONSTRAINT `FK_C1C172031509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`);

ALTER TABLE `eventsresources`
  ADD CONSTRAINT `FK_36A68AF089329D25` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`);

ALTER TABLE `eventsroutes`
  ADD CONSTRAINT `FK_17CC38C734ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);

ALTER TABLE `eventsroutestypes`
  ADD CONSTRAINT `FK_6B6DA9033D1FD10B` FOREIGN KEY (`route_type_id`) REFERENCES `routestypes` (`id`);

ALTER TABLE `eventszones`
  ADD CONSTRAINT `FK_F3E265DA9F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);

ALTER TABLE `factions_events`
  ADD CONSTRAINT `FK_B863A4009D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B863A4008133CE17` FOREIGN KEY (`factions_id`) REFERENCES `factions` (`id`) ON DELETE CASCADE;

ALTER TABLE `foes_events`
  ADD CONSTRAINT `FK_F0F98F459D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F0F98F453DF0F043` FOREIGN KEY (`foes_id`) REFERENCES `foes` (`id`) ON DELETE CASCADE;

ALTER TABLE `games`
  ADD CONSTRAINT `FK_FF232B3115455713` FOREIGN KEY (`is_users_gm`) REFERENCES `users` (`id`);

ALTER TABLE `jobs`
  ADD CONSTRAINT `FK_A8936DC5A49E6BA2` FOREIGN KEY (`id_books`) REFERENCES `books` (`id`);

ALTER TABLE `mails_sent`
  ADD CONSTRAINT `FK_A34C3D908DDD6135` FOREIGN KEY (`id_mails`) REFERENCES `mails` (`id`);

ALTER TABLE `markers`
  ADD CONSTRAINT `FK_8E34E6AC1509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`),
  ADD CONSTRAINT `FK_8E34E6AC4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_8E34E6AC53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

ALTER TABLE `npcs_events`
  ADD CONSTRAINT `FK_EF85CDEF9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EF85CDEF73DFFBCA` FOREIGN KEY (`npcs_id`) REFERENCES `npcs` (`id`) ON DELETE CASCADE;

ALTER TABLE `resources_routes`
  ADD CONSTRAINT `FK_389FB5C1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_389FB5C1ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE;

ALTER TABLE `resources_routestypes`
  ADD CONSTRAINT `FK_4639B5C5145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4639B5C5ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE;

ALTER TABLE `routes`
  ADD CONSTRAINT `FK_3579C785C231A351` FOREIGN KEY (`routeType_id`) REFERENCES `routestypes` (`id`),
  ADD CONSTRAINT `FK_3579C7854448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_3579C78553C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

ALTER TABLE `routestypes_events`
  ADD CONSTRAINT `FK_6F061AD99D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6F061AD9145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE;

ALTER TABLE `routes_markers`
  ADD CONSTRAINT `FK_AF2807D1D0EEC2B5` FOREIGN KEY (`markers_id`) REFERENCES `markers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AF2807D1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE;

ALTER TABLE `social_class_domains`
  ADD CONSTRAINT `FK_FFB456F552E616ED` FOREIGN KEY (`id_domains`) REFERENCES `domains` (`id`),
  ADD CONSTRAINT `FK_FFB456F5841AD87F` FOREIGN KEY (`id_social_class`) REFERENCES `social_class` (`id`);

ALTER TABLE `traits`
  ADD CONSTRAINT `FK_E4A0A16622681815` FOREIGN KEY (`id_ways`) REFERENCES `ways` (`id`);

ALTER TABLE `weather_events`
  ADD CONSTRAINT `FK_BDA0712C9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BDA0712C8CE675E` FOREIGN KEY (`weather_id`) REFERENCES `weather` (`id`) ON DELETE CASCADE;

ALTER TABLE `zones`
  ADD CONSTRAINT `FK_440B9E6C4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_440B9E6C53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
