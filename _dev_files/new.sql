
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `corahn_rin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `corahn_rin`;
DROP TABLE IF EXISTS `armors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `protection` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A81653F45E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `artifacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artifacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flux_id` int(11) DEFAULT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `consumption` int(11) NOT NULL,
  `consumptionInterval` int(11) NOT NULL,
  `tank` int(11) NOT NULL,
  `resistance` int(11) NOT NULL,
  `vulnerability` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `handling` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `damage` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AB6FC42B5E237E06` (`name`),
  KEY `IDX_AB6FC42BC85926E` (`flux_id`),
  CONSTRAINT `FK_AB6FC42BC85926E` FOREIGN KEY (`flux_id`) REFERENCES `flux` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `avantages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avantages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nameFemale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `double` int(11) NOT NULL,
  `bonusdisc` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `isDesv` tinyint(1) NOT NULL,
  `isCombatArt` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4936062E5E237E06` (`name`),
  KEY `IDX_4936062E16A2B381` (`book_id`),
  CONSTRAINT `FK_4936062E16A2B381` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8BDA05965E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `disorder_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `inventory` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `money` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:object)',
  `orientation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `geoLiving` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `mentalResist` int(11) NOT NULL,
  `health` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `stamina` int(11) NOT NULL,
  `survival` tinyint(1) NOT NULL,
  `speed` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `rindath` int(11) NOT NULL,
  `exaltation` int(11) NOT NULL,
  `experienceActual` int(11) NOT NULL,
  `experienceSpent` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `traitFlaw_id` int(11) DEFAULT NULL,
  `traitQuality_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_757442DE5E237E06` (`name`),
  KEY `IDX_757442DE87EB36AD` (`disorder_id`),
  KEY `IDX_757442DEBE04EA9` (`job_id`),
  KEY `IDX_757442DE98260155` (`region_id`),
  KEY `IDX_757442DE8F7F0595` (`traitFlaw_id`),
  KEY `IDX_757442DE68BCB902` (`traitQuality_id`),
  KEY `IDX_757442DEA76ED395` (`user_id`),
  KEY `IDX_757442DEE48FD905` (`game_id`),
  CONSTRAINT `FK_757442DEE48FD905` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  CONSTRAINT `FK_757442DE68BCB902` FOREIGN KEY (`traitQuality_id`) REFERENCES `traits` (`id`),
  CONSTRAINT `FK_757442DE87EB36AD` FOREIGN KEY (`disorder_id`) REFERENCES `disorders` (`id`),
  CONSTRAINT `FK_757442DE8F7F0595` FOREIGN KEY (`traitFlaw_id`) REFERENCES `traits` (`id`),
  CONSTRAINT `FK_757442DE98260155` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  CONSTRAINT `FK_757442DEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_757442DEBE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters_armors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters_armors` (
  `characters_id` int(11) NOT NULL,
  `armors_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`armors_id`),
  KEY `IDX_91F54665C70F0E28` (`characters_id`),
  KEY `IDX_91F54665333F27F1` (`armors_id`),
  CONSTRAINT `FK_91F54665333F27F1` FOREIGN KEY (`armors_id`) REFERENCES `armors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_91F54665C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters_artifacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters_artifacts` (
  `characters_id` int(11) NOT NULL,
  `artifacts_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`artifacts_id`),
  KEY `IDX_59084303C70F0E28` (`characters_id`),
  KEY `IDX_5908430338F3D9E1` (`artifacts_id`),
  CONSTRAINT `FK_5908430338F3D9E1` FOREIGN KEY (`artifacts_id`) REFERENCES `artifacts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_59084303C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters_miracles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters_miracles` (
  `characters_id` int(11) NOT NULL,
  `miracles_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`miracles_id`),
  KEY `IDX_977340CAC70F0E28` (`characters_id`),
  KEY `IDX_977340CA6B117C2B` (`miracles_id`),
  CONSTRAINT `FK_977340CA6B117C2B` FOREIGN KEY (`miracles_id`) REFERENCES `miracles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_977340CAC70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters_ogham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters_ogham` (
  `characters_id` int(11) NOT NULL,
  `ogham_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`ogham_id`),
  KEY `IDX_53F77947C70F0E28` (`characters_id`),
  KEY `IDX_53F779473241FF23` (`ogham_id`),
  CONSTRAINT `FK_53F779473241FF23` FOREIGN KEY (`ogham_id`) REFERENCES `ogham` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_53F77947C70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `characters_weapons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters_weapons` (
  `characters_id` int(11) NOT NULL,
  `weapons_id` int(11) NOT NULL,
  PRIMARY KEY (`characters_id`,`weapons_id`),
  KEY `IDX_1A82C2BAC70F0E28` (`characters_id`),
  KEY `IDX_1A82C2BA2EE82581` (`weapons_id`),
  CONSTRAINT `FK_1A82C2BA2EE82581` FOREIGN KEY (`weapons_id`) REFERENCES `weapons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1A82C2BAC70F0E28` FOREIGN KEY (`characters_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charavtgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charavtgs` (
  `character_id` int(11) NOT NULL,
  `avantage_id` int(11) NOT NULL,
  `doubleValue` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`avantage_id`),
  KEY `IDX_F2BCE82A1136BE75` (`character_id`),
  KEY `IDX_F2BCE82AEA96B22C` (`avantage_id`),
  CONSTRAINT `FK_F2BCE82AEA96B22C` FOREIGN KEY (`avantage_id`) REFERENCES `avantages` (`id`),
  CONSTRAINT `FK_F2BCE82A1136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `chardisciplines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chardisciplines` (
  `character_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`discipline_id`),
  KEY `IDX_E8C3FDAF1136BE75` (`character_id`),
  KEY `IDX_E8C3FDAFA5522701` (`discipline_id`),
  CONSTRAINT `FK_E8C3FDAFA5522701` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`),
  CONSTRAINT `FK_E8C3FDAF1136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `chardomains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chardomains` (
  `character_id` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`domain_id`),
  KEY `IDX_9DDAD0F31136BE75` (`character_id`),
  KEY `IDX_9DDAD0F3115F0EE5` (`domain_id`),
  CONSTRAINT `FK_9DDAD0F3115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`),
  CONSTRAINT `FK_9DDAD0F31136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charflux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charflux` (
  `character_id` int(11) NOT NULL,
  `flux` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`flux`),
  KEY `IDX_C9F736AD1136BE75` (`character_id`),
  CONSTRAINT `FK_C9F736AD1136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charmodifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charmodifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `before` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:object)',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B29321471136BE75` (`character_id`),
  KEY `IDX_B2932147A76ED395` (`user_id`),
  CONSTRAINT `FK_B2932147A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_B29321471136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charsetbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charsetbacks` (
  `character_id` int(11) NOT NULL,
  `setback` int(11) NOT NULL,
  `isAvoided` tinyint(1) NOT NULL,
  PRIMARY KEY (`character_id`,`setback`),
  KEY `IDX_C127DB671136BE75` (`character_id`),
  CONSTRAINT `FK_C127DB671136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charsocialclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charsocialclass` (
  `character_id` int(11) NOT NULL,
  `domain1_id` int(11) DEFAULT NULL,
  `domain2_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `socialClass_id` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`socialClass_id`),
  KEY `IDX_7B6034931136BE75` (`character_id`),
  KEY `IDX_7B603493E8455DA6` (`socialClass_id`),
  KEY `IDX_7B60349361D646A` (`domain1_id`),
  KEY `IDX_7B60349314A8CB84` (`domain2_id`),
  CONSTRAINT `FK_7B60349314A8CB84` FOREIGN KEY (`domain2_id`) REFERENCES `domains` (`id`),
  CONSTRAINT `FK_7B6034931136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`),
  CONSTRAINT `FK_7B60349361D646A` FOREIGN KEY (`domain1_id`) REFERENCES `domains` (`id`),
  CONSTRAINT `FK_7B603493E8455DA6` FOREIGN KEY (`socialClass_id`) REFERENCES `socialclass` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charways` (
  `character_id` int(11) NOT NULL,
  `way_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`character_id`,`way_id`),
  KEY `IDX_12ED03801136BE75` (`character_id`),
  KEY `IDX_12ED03808C803113` (`way_id`),
  CONSTRAINT `FK_12ED03808C803113` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`),
  CONSTRAINT `FK_12ED03801136BE75` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `disciplines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rank` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2B81D30F5E237E06` (`name`),
  KEY `IDX_2B81D30F16A2B381` (`book_id`),
  CONSTRAINT `FK_2B81D30F16A2B381` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `disciplines_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disciplines_domains` (
  `disciplines_id` int(11) NOT NULL,
  `domains_id` int(11) NOT NULL,
  PRIMARY KEY (`disciplines_id`,`domains_id`),
  KEY `IDX_FE41FAE890D3DF94` (`disciplines_id`),
  KEY `IDX_FE41FAE83700F4DC` (`domains_id`),
  CONSTRAINT `FK_FE41FAE83700F4DC` FOREIGN KEY (`domains_id`) REFERENCES `domains` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FE41FAE890D3DF94` FOREIGN KEY (`disciplines_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `disorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_23BE6BCE5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `disordersways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disordersways` (
  `disorder` int(11) NOT NULL,
  `way` int(11) NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  PRIMARY KEY (`disorder`,`way`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `way_id` int(11) DEFAULT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_43C686015E237E06` (`name`),
  KEY `IDX_43C686018C803113` (`way_id`),
  CONSTRAINT `FK_43C686018C803113` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_542B527C5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventsmarkers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventsmarkers` (
  `event` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`event`,`marker_id`),
  KEY `IDX_16C473EF474460EB` (`marker_id`),
  CONSTRAINT `FK_16C473EF474460EB` FOREIGN KEY (`marker_id`) REFERENCES `markers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventsmarkerstypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventsmarkerstypes` (
  `event` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  `markerType_id` int(11) NOT NULL,
  PRIMARY KEY (`event`,`markerType_id`),
  KEY `IDX_C1C172031509F007` (`markerType_id`),
  CONSTRAINT `FK_C1C172031509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventsresources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventsresources` (
  `event` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`resource_id`),
  KEY `IDX_36A68AF089329D25` (`resource_id`),
  CONSTRAINT `FK_36A68AF089329D25` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventsroutes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventsroutes` (
  `event` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_id`),
  KEY `IDX_17CC38C734ECB4E6` (`route_id`),
  CONSTRAINT `FK_17CC38C734ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventsroutestypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventsroutestypes` (
  `event` int(11) NOT NULL,
  `route_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`route_type_id`),
  KEY `IDX_6B6DA9033D1FD10B` (`route_type_id`),
  CONSTRAINT `FK_6B6DA9033D1FD10B` FOREIGN KEY (`route_type_id`) REFERENCES `routestypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventszones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventszones` (
  `event` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `percentage` smallint(6) NOT NULL,
  PRIMARY KEY (`event`,`zone_id`),
  KEY `IDX_F3E265DA9F2C3FAB` (`zone_id`),
  CONSTRAINT `FK_F3E265DA9F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_12F43A925E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factions_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factions_events` (
  `factions_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`factions_id`,`events_id`),
  KEY `IDX_B863A4008133CE17` (`factions_id`),
  KEY `IDX_B863A4009D6A1065` (`events_id`),
  CONSTRAINT `FK_B863A4009D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B863A4008133CE17` FOREIGN KEY (`factions_id`) REFERENCES `factions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `flux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D2609E045E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `foes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D36EB845E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `foes_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foes_events` (
  `foes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`foes_id`,`events_id`),
  KEY `IDX_F0F98F453DF0F043` (`foes_id`),
  KEY `IDX_F0F98F459D6A1065` (`events_id`),
  CONSTRAINT `FK_F0F98F459D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F0F98F453DF0F043` FOREIGN KEY (`foes_id`) REFERENCES `foes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gmNotes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `gameMaster_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idgUnique` (`name`,`gameMaster_id`),
  KEY `IDX_3EE2043514C6E3F4` (`gameMaster_id`),
  CONSTRAINT `FK_3EE2043514C6E3F4` FOREIGN KEY (`gameMaster_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8A1C2FB5E237E06` (`name`),
  KEY `IDX_8A1C2FB16A2B381` (`book_id`),
  CONSTRAINT `FK_8A1C2FB16A2B381` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A2990F0177153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mailssent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailssent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) DEFAULT NULL,
  `toName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `toEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_314D5658C8776F01` (`mail_id`),
  CONSTRAINT `FK_314D5658C8776F01` FOREIGN KEY (`mail_id`) REFERENCES `mails` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `maxZoom` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E71CA79B5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markers` (
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
  KEY `IDX_8E34E6AC1509F007` (`markerType_id`),
  CONSTRAINT `FK_8E34E6AC1509F007` FOREIGN KEY (`markerType_id`) REFERENCES `markerstypes` (`id`),
  CONSTRAINT `FK_8E34E6AC4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  CONSTRAINT `FK_8E34E6AC53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `markerstypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markerstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_585032CE5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `miracles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `miracles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_92F426995E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `npcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_89A280A05E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `npcs_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `npcs_events` (
  `npcs_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`npcs_id`,`events_id`),
  KEY `IDX_EF85CDEF73DFFBCA` (`npcs_id`),
  KEY `IDX_EF85CDEF9D6A1065` (`events_id`),
  CONSTRAINT `FK_EF85CDEF9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EF85CDEF73DFFBCA` FOREIGN KEY (`npcs_id`) REFERENCES `npcs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ogham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ogham` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B3512AA45E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `kingdom` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6DDA406F5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6D97690D5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resources_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources_routes` (
  `resources_id` int(11) NOT NULL,
  `routes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routes_id`),
  KEY `IDX_389FB5C1ACFC5BFF` (`resources_id`),
  KEY `IDX_389FB5C1AE2C16DC` (`routes_id`),
  CONSTRAINT `FK_389FB5C1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_389FB5C1ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resources_routestypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources_routestypes` (
  `resources_id` int(11) NOT NULL,
  `routestypes_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`,`routestypes_id`),
  KEY `IDX_4639B5C5ACFC5BFF` (`resources_id`),
  KEY `IDX_4639B5C5145B0ACB` (`routestypes_id`),
  CONSTRAINT `FK_4639B5C5145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4639B5C5ACFC5BFF` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
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
  KEY `IDX_3579C785C231A351` (`routeType_id`),
  CONSTRAINT `FK_3579C785C231A351` FOREIGN KEY (`routeType_id`) REFERENCES `routestypes` (`id`),
  CONSTRAINT `FK_3579C7854448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  CONSTRAINT `FK_3579C78553C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `routes_markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes_markers` (
  `routes_id` int(11) NOT NULL,
  `markers_id` int(11) NOT NULL,
  PRIMARY KEY (`routes_id`,`markers_id`),
  KEY `IDX_AF2807D1AE2C16DC` (`routes_id`),
  KEY `IDX_AF2807D1D0EEC2B5` (`markers_id`),
  CONSTRAINT `FK_AF2807D1D0EEC2B5` FOREIGN KEY (`markers_id`) REFERENCES `markers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_AF2807D1AE2C16DC` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `routestypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routestypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F37CDE005E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `routestypes_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routestypes_events` (
  `routestypes_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`routestypes_id`,`events_id`),
  KEY `IDX_6F061AD9145B0ACB` (`routestypes_id`),
  KEY `IDX_6F061AD99D6A1065` (`events_id`),
  CONSTRAINT `FK_6F061AD99D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6F061AD9145B0ACB` FOREIGN KEY (`routestypes_id`) REFERENCES `routestypes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `setbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_924A54015E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `socialclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `socialclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B8221A335E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `socialclass_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `socialclass_domains` (
  `socialclass_id` int(11) NOT NULL,
  `domains_id` int(11) NOT NULL,
  PRIMARY KEY (`socialclass_id`,`domains_id`),
  KEY `IDX_CFF613F711333FF0` (`socialclass_id`),
  KEY `IDX_CFF613F73700F4DC` (`domains_id`),
  CONSTRAINT `FK_CFF613F73700F4DC` FOREIGN KEY (`domains_id`) REFERENCES `domains` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_CFF613F711333FF0` FOREIGN KEY (`socialclass_id`) REFERENCES `socialclass` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F5E3257643B9FE3C` (`step`),
  UNIQUE KEY `UNIQ_F5E32576989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `traits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `way_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nameFemale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isQuality` tinyint(1) NOT NULL,
  `isMajor` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxUnique` (`name`,`way_id`),
  KEY `IDX_E30CA4508C803113` (`way_id`),
  CONSTRAINT `FK_E30CA4508C803113` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortName` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `fault` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_97AAB29C43A885D` (`shortName`),
  UNIQUE KEY `UNIQ_97AAB295E237E06` (`name`),
  UNIQUE KEY `UNIQ_97AAB299FD0DEA3` (`fault`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `weapons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weapons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `damage` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `melee` tinyint(1) NOT NULL,
  `range` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9DB3827D5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `weather`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_836DEAF25E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `weather_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_events` (
  `weather_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  PRIMARY KEY (`weather_id`,`events_id`),
  KEY `IDX_BDA0712C8CE675E` (`weather_id`),
  KEY `IDX_BDA0712C9D6A1065` (`events_id`),
  CONSTRAINT `FK_BDA0712C9D6A1065` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BDA0712C8CE675E` FOREIGN KEY (`weather_id`) REFERENCES `weather` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones` (
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
  KEY `IDX_440B9E6C4448F8DA` (`faction_id`),
  CONSTRAINT `FK_440B9E6C4448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`),
  CONSTRAINT `FK_440B9E6C53C55F64` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

