-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `ITU`;
CREATE DATABASE `ITU` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `ITU`;

DROP TABLE IF EXISTS `CLIENT`;
CREATE TABLE `CLIENT` (
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `ID` int(32) NOT NULL AUTO_INCREMENT,
  `surname` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` varchar(9) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` binary(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `CLIENT` (`name`, `ID`, `surname`, `phone`, `email`, `password`) VALUES
('Mark',	1,	'Otto',	'736182739',	'markotto@gmail.com',	UNHEX('6E017B5464F820A6C1BB5E9F6D711A667A80D8EA'));

DROP TABLE IF EXISTS `DATABASE`;
CREATE TABLE `DATABASE` (
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` binary(20) NOT NULL,
  `server` varchar(32) COLLATE utf8_bin NOT NULL,
  `webhosting` int(32) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `webhosting` (`webhosting`),
  CONSTRAINT `DATABASE_ibfk_1` FOREIGN KEY (`webhosting`) REFERENCES `WEBHOSTING` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `DNSRECORD`;
CREATE TABLE `DNSRECORD` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `TTL` int(8) NOT NULL,
  `type` int(8) NOT NULL,
  `IPv4` varchar(32) COLLATE utf8_bin NOT NULL,
  `IPv6` varchar(32) COLLATE utf8_bin NOT NULL,
  `domain` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`),
  CONSTRAINT `DNSRECORD_ibfk_1` FOREIGN KEY (`domain`) REFERENCES `DOMAIN` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `DOMAIN`;
CREATE TABLE `DOMAIN` (
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `expiration` date NOT NULL,
  `state` int(8) NOT NULL,
  `tld` varchar(32) COLLATE utf8_bin NOT NULL,
  `client` int(32) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `client` (`client`),
  CONSTRAINT `DOMAIN_ibfk_1` FOREIGN KEY (`client`) REFERENCES `CLIENT` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `FTPACCOUNT`;
CREATE TABLE `FTPACCOUNT` (
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` binary(20) NOT NULL,
  `directory` varchar(32) COLLATE utf8_bin NOT NULL,
  `permissions` int(32) NOT NULL,
  `server` varchar(32) COLLATE utf8_bin NOT NULL,
  `webhosting` int(32) NOT NULL,
  KEY `webhosting` (`webhosting`),
  CONSTRAINT `FTPACCOUNT_ibfk_1` FOREIGN KEY (`webhosting`) REFERENCES `WEBHOSTING` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `MAILBOX`;
CREATE TABLE `MAILBOX` (
  `alias` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` binary(20) NOT NULL,
  `type` int(8) NOT NULL,
  `webhosting` int(32) NOT NULL,
  KEY `webhosting` (`webhosting`),
  CONSTRAINT `MAILBOX_ibfk_1` FOREIGN KEY (`webhosting`) REFERENCES `WEBHOSTING` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `WEBHOSTING`;
CREATE TABLE `WEBHOSTING` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `expiration` date NOT NULL,
  `type` int(8) NOT NULL,
  `state` int(8) NOT NULL,
  `client` int(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client` (`client`),
  CONSTRAINT `WEBHOSTING_ibfk_1` FOREIGN KEY (`client`) REFERENCES `CLIENT` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- 2014-11-16 20:51:09
