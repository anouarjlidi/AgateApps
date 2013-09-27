
-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 12 Septembre 2013 à 10:14
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `event_foes`
--

DROP TABLE IF EXISTS `event_foes`;
CREATE TABLE IF NOT EXISTS `event_foes` (
  `id_foes` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_foes`,`id_events`),
  KEY `FK_event_foes_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_markers`
--

DROP TABLE IF EXISTS `event_markers`;
CREATE TABLE IF NOT EXISTS `event_markers` (
  `percentage` tinyint(4) NOT NULL,
  `id_markers` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_markers`,`id_events`),
  KEY `FK_event_markers_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_marker_types`
--

DROP TABLE IF EXISTS `event_marker_types`;
CREATE TABLE IF NOT EXISTS `event_marker_types` (
  `percentage` tinyint(4) NOT NULL,
  `id_markers_type` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_markers_type`,`id_events`),
  KEY `FK_event_marker_types_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_npcs`
--

DROP TABLE IF EXISTS `event_npcs`;
CREATE TABLE IF NOT EXISTS `event_npcs` (
  `id_npcs` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_npcs`,`id_events`),
  KEY `FK_event_npcs_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_resources`
--

DROP TABLE IF EXISTS `event_resources`;
CREATE TABLE IF NOT EXISTS `event_resources` (
  `percentage` tinyint(4) NOT NULL,
  `id_resources` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_resources`,`id_events`),
  KEY `FK_event_resources_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_routes`
--

DROP TABLE IF EXISTS `event_routes`;
CREATE TABLE IF NOT EXISTS `event_routes` (
  `percentage` tinyint(4) NOT NULL,
  `id_routes` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_routes`,`id_events`),
  KEY `FK_event_routes_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_types_routes`
--

DROP TABLE IF EXISTS `event_types_routes`;
CREATE TABLE IF NOT EXISTS `event_types_routes` (
  `percentage` tinyint(4) NOT NULL,
  `id_types_routes` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_types_routes`,`id_events`),
  KEY `FK_event_types_routes_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_weather`
--

DROP TABLE IF EXISTS `event_weather`;
CREATE TABLE IF NOT EXISTS `event_weather` (
  `id_events` mediumint(11) unsigned NOT NULL,
  `id_weather` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_events`,`id_weather`),
  KEY `FK_event_weather_id_weather` (`id_weather`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_zones`
--

DROP TABLE IF EXISTS `event_zones`;
CREATE TABLE IF NOT EXISTS `event_zones` (
  `percentage` tinyint(4) NOT NULL,
  `id_zones` mediumint(11) unsigned NOT NULL,
  `id_events` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_zones`,`id_events`),
  KEY `FK_event_zones_id_events` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factions`
--

DROP TABLE IF EXISTS `factions`;
CREATE TABLE IF NOT EXISTS `factions` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `foes`
--

DROP TABLE IF EXISTS `foes`;
CREATE TABLE IF NOT EXISTS `foes` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `maps`
--

DROP TABLE IF EXISTS `maps`;
CREATE TABLE IF NOT EXISTS `maps` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `min_zoom` tinyint(4) NOT NULL,
  `max_zoom` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `markers`
--

DROP TABLE IF EXISTS `markers`;
CREATE TABLE IF NOT EXISTS `markers` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` text COLLATE utf8_unicode_ci NOT NULL,
  `id_markers_type` mediumint(11) unsigned NOT NULL,
  `id_factions` mediumint(11) unsigned NOT NULL,
  `id_maps` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_markers_id_markers_type` (`id_markers_type`),
  KEY `FK_markers_id_factions` (`id_factions`),
  KEY `FK_markers_id_maps` (`id_maps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `markers_type`
--

DROP TABLE IF EXISTS `markers_type`;
CREATE TABLE IF NOT EXISTS `markers_type` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `npcs`
--

DROP TABLE IF EXISTS `npcs`;
CREATE TABLE IF NOT EXISTS `npcs` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `resource_routes`
--

DROP TABLE IF EXISTS `resource_routes`;
CREATE TABLE IF NOT EXISTS `resource_routes` (
  `id_resources` mediumint(11) unsigned NOT NULL,
  `id_routes` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_resources`,`id_routes`),
  KEY `FK_resource_routes_id_routes` (`id_routes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resource_types_route`
--

DROP TABLE IF EXISTS `resource_types_route`;
CREATE TABLE IF NOT EXISTS `resource_types_route` (
  `id_resources` mediumint(11) unsigned NOT NULL,
  `id_types_routes` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_resources`,`id_types_routes`),
  KEY `FK_resource_types_route_id_types_routes` (`id_types_routes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` text COLLATE utf8_unicode_ci NOT NULL,
  `id_maps` mediumint(11) unsigned NOT NULL,
  `id_types_routes` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_routes_id_maps` (`id_maps`),
  KEY `FK_routes_id_types_routes` (`id_types_routes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `routes_markers`
--

DROP TABLE IF EXISTS `routes_markers`;
CREATE TABLE IF NOT EXISTS `routes_markers` (
  `coordinates_startpoint` text COLLATE utf8_unicode_ci NOT NULL,
  `id_routes` mediumint(11) unsigned NOT NULL,
  `id_markers` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_routes`,`id_markers`),
  KEY `FK_routes_markers_id_markers` (`id_markers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_routes`
--

DROP TABLE IF EXISTS `types_routes`;
CREATE TABLE IF NOT EXISTS `types_routes` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `weather`
--

DROP TABLE IF EXISTS `weather`;
CREATE TABLE IF NOT EXISTS `weather` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE IF NOT EXISTS `zones` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` text COLLATE utf8_unicode_ci NOT NULL,
  `id_factions` mediumint(11) unsigned NOT NULL,
  `id_maps` mediumint(11) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_zones_id_factions` (`id_factions`),
  KEY `FK_zones_id_maps` (`id_maps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `event_foes`
--
ALTER TABLE `event_foes`
  ADD CONSTRAINT `FK_event_foes_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_foes_id_foes` FOREIGN KEY (`id_foes`) REFERENCES `foes` (`id`);

--
-- Contraintes pour la table `event_markers`
--
ALTER TABLE `event_markers`
  ADD CONSTRAINT `FK_event_markers_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_markers_id_markers` FOREIGN KEY (`id_markers`) REFERENCES `markers` (`id`);

--
-- Contraintes pour la table `event_marker_types`
--
ALTER TABLE `event_marker_types`
  ADD CONSTRAINT `FK_event_marker_types_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_marker_types_id_markers_type` FOREIGN KEY (`id_markers_type`) REFERENCES `markers_type` (`id`);

--
-- Contraintes pour la table `event_npcs`
--
ALTER TABLE `event_npcs`
  ADD CONSTRAINT `FK_event_npcs_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_npcs_id_npcs` FOREIGN KEY (`id_npcs`) REFERENCES `npcs` (`id`);

--
-- Contraintes pour la table `event_resources`
--
ALTER TABLE `event_resources`
  ADD CONSTRAINT `FK_event_resources_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_resources_id_resources` FOREIGN KEY (`id_resources`) REFERENCES `resources` (`id`);

--
-- Contraintes pour la table `event_routes`
--
ALTER TABLE `event_routes`
  ADD CONSTRAINT `FK_event_routes_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_routes_id_routes` FOREIGN KEY (`id_routes`) REFERENCES `routes` (`id`);

--
-- Contraintes pour la table `event_types_routes`
--
ALTER TABLE `event_types_routes`
  ADD CONSTRAINT `FK_event_types_routes_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_types_routes_id_types_routes` FOREIGN KEY (`id_types_routes`) REFERENCES `types_routes` (`id`);

--
-- Contraintes pour la table `event_weather`
--
ALTER TABLE `event_weather`
  ADD CONSTRAINT `FK_event_weather_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_weather_id_weather` FOREIGN KEY (`id_weather`) REFERENCES `weather` (`id`);

--
-- Contraintes pour la table `event_zones`
--
ALTER TABLE `event_zones`
  ADD CONSTRAINT `FK_event_zones_id_events` FOREIGN KEY (`id_events`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_event_zones_id_zones` FOREIGN KEY (`id_zones`) REFERENCES `zones` (`id`);

--
-- Contraintes pour la table `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `FK_markers_id_factions` FOREIGN KEY (`id_factions`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_markers_id_maps` FOREIGN KEY (`id_maps`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `FK_markers_id_markers_type` FOREIGN KEY (`id_markers_type`) REFERENCES `markers_type` (`id`);

--
-- Contraintes pour la table `resource_routes`
--
ALTER TABLE `resource_routes`
  ADD CONSTRAINT `FK_resource_routes_id_resources` FOREIGN KEY (`id_resources`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `FK_resource_routes_id_routes` FOREIGN KEY (`id_routes`) REFERENCES `routes` (`id`);

--
-- Contraintes pour la table `resource_types_route`
--
ALTER TABLE `resource_types_route`
  ADD CONSTRAINT `FK_resource_types_route_id_resources` FOREIGN KEY (`id_resources`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `FK_resource_types_route_id_types_routes` FOREIGN KEY (`id_types_routes`) REFERENCES `types_routes` (`id`);

--
-- Contraintes pour la table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `FK_routes_id_maps` FOREIGN KEY (`id_maps`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `FK_routes_id_types_routes` FOREIGN KEY (`id_types_routes`) REFERENCES `types_routes` (`id`);

--
-- Contraintes pour la table `routes_markers`
--
ALTER TABLE `routes_markers`
  ADD CONSTRAINT `FK_routes_markers_id_markers` FOREIGN KEY (`id_markers`) REFERENCES `markers` (`id`),
  ADD CONSTRAINT `FK_routes_markers_id_routes` FOREIGN KEY (`id_routes`) REFERENCES `routes` (`id`);

--
-- Contraintes pour la table `zones`
--
ALTER TABLE `zones`
  ADD CONSTRAINT `FK_zones_id_factions` FOREIGN KEY (`id_factions`) REFERENCES `factions` (`id`),
  ADD CONSTRAINT `FK_zones_id_maps` FOREIGN KEY (`id_maps`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

