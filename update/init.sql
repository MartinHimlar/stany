-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `photogallery`;
CREATE TABLE `photogallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `order` int(5) DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `sites`;
CREATE TABLE `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `map_url` text COLLATE utf8_czech_ci,
  `order` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `sites` (`id`, `title`, `content`, `url`, `default`, `active`, `map_url`, `order`) VALUES
(1,	'Domů',	'<p>Dovolujeme si V&aacute;m nab&iacute;dnout p&aacute;rty stany vhodn&eacute; pro zastře&scaron;en&iacute; Va&scaron;ich akc&iacute;.<br /><br />Stany jsou vhodn&eacute; pro v&yacute;stavy a veletrhy, firemn&iacute; prezentace, showroomy, městsk&eacute; či obecn&iacute; akce, oslavy, svatby, VIP akce. K zaji&scaron;těn&iacute; př&iacute;stře&scaron;&iacute; pro div&aacute;ky na festivalech, sportovn&iacute;ch či kulturn&iacute;ch akc&iacute;ch. Mohou sloužit i jako skladovac&iacute; prostory nebo zastře&scaron;en&iacute; staveb nebo stavebn&iacute;ho materi&aacute;lu.<br /><br />Ke každ&eacute;mu z&aacute;kazn&iacute;kovi přistupujeme individu&aacute;lně a př&aacute;telsky. Stač&iacute; pouze zaslat popt&aacute;vku na <a title=\"partystanyvalasek@email.cz\" href=\"mailto:partystanyvalasek@email.cz\">email</a> a my obratem za&scaron;leme nab&iacute;dku &scaron;itou V&aacute;m na m&iacute;ru.</p>',	'domu',	1,	0,	'',	1),
(2,	'Kontakty',	'<p>Radim Val&aacute;&scaron;ek<br />+420 734 159 520<br /><a title=\"partystanyvalasek@email.cz\" href=\"mailto:partystanyvalasek@email.cz\">partystanyvalasek@email.cz</a><br />IČ : 87898845, DIČ : CZ8710246050</p>',	'kontakty',	1,	0,	'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2574.3116302256617!2d18.317382015713395!3d49.817807879393065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4713fcbe6440612d%3A0x56a54d9a6f62d32d!2zUMOBUlRZIFNUQU5ZIFZhbMOhxaFlaw!5e0!3m2!1scs!2scz!4v1487242030481',	3),
(3,	'Fotogalerie',	'',	'fotogalerie',	1,	0,	'',	2),
(7,	'rwertr ts',	'<p>fs gdf gsdfgsdf sgd</p>',	'rwertr-ts',	0,	1,	'',	5);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `public` tinyint(4) NOT NULL DEFAULT '1',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `nickname`, `password`, `public`, `email`, `name`, `surname`) VALUES
(1,	'admin',	'$2y$10$V9HcKBgX5SgFyYZiLX9v2.6b46hbjKV9pQ86gjJ/sxeelE2gxwM1i',	1,	'm.himlar@gmail.com',	'Martin',	'Himlar');

-- 2017-02-23 18:53:43
