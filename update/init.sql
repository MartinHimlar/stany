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
(1,	'Domů',	'<p>Dovolujeme si V&aacute;m nab&iacute;dnout p&aacute;rty stany vhodn&eacute; pro zastře&scaron;en&iacute; Va&scaron;ich akc&iacute;.<br /><br />Stany jsou vhodn&eacute; pro v&yacute;stavy a veletrhy, firemn&iacute; prezentace, showroomy, městsk&eacute; či obecn&iacute; akce, oslavy, svatby, VIP akce. K zaji&scaron;těn&iacute; př&iacute;stře&scaron;&iacute; pro div&aacute;ky na festivalech, sportovn&iacute;ch či kulturn&iacute;ch akc&iacute;ch. Mohou sloužit i jako skladovac&iacute; prostory nebo zastře&scaron;en&iacute; staveb nebo stavebn&iacute;ho materi&aacute;lu.<br /><br />Ke každ&eacute;mu z&aacute;kazn&iacute;kovi přistupujeme individu&aacute;lně a př&aacute;telsky. Stač&iacute; pouze zaslat popt&aacute;vku na <a title=\"partystanyvalasek@email.cz\" href=\"mailto:partystanyvalasek@email.cz\">email</a> a my obratem za&scaron;leme nab&iacute;dku &scaron;itou V&aacute;m na m&iacute;ru.</p>',	'domu',	1,	1,	'',	1),
(2,	'Kontakty',	'<p>Radim Val&aacute;&scaron;ek<br />+420 734 159 520<br /><a title=\"partystanyvalasek@email.cz\" href=\"mailto:partystanyvalasek@email.cz\">partystanyvalasek@email.cz</a><br />IČ : 87898845, DIČ : CZ8710246050</p>',	'kontakty',	1,	1,	'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2574.3116302256617!2d18.317382015713395!3d49.817807879393065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4713fcbe6440612d%3A0x56a54d9a6f62d32d!2zUMOBUlRZIFNUQU5ZIFZhbMOhxaFlaw!5e0!3m2!1scs!2scz!4v1487242030481',	5),
(3,	'Fotogalerie',	'',	'fotogalerie',	1,	1,	'',	2),
(4,	'Ceník',	'<h2>Cen&iacute;k</h2>\r\n<hr class=\"jumbotron-hr\" />\r\n<table class=\"table\" style=\"margin-left: auto; margin-right: auto;\">\r\n<thead class=\"thead-default\">\r\n<tr>\r\n<th>Velikost stanu</th>\r\n<th>Cena za m&sup2;</th>\r\n<th>Cena</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>10x5 m (50m&sup2;)</td>\r\n<td>120 Kč/m&sup2;</td>\r\n<td>6 000 Kč</td>\r\n</tr>\r\n<tr>\r\n<td>10x10 m (100m&sup2;)</td>\r\n<td>110 Kč/m&sup2;</td>\r\n<td>11 000 Kč</td>\r\n</tr>\r\n<tr>\r\n<td>10x15 m (150m&sup2;)</td>\r\n<td>105 Kč/m&sup2;</td>\r\n<td>15 750 Kč</td>\r\n</tr>\r\n<tr>\r\n<td>10x20 m (200m&sup2;)</td>\r\n<td>100 Kč/m&sup2;</td>\r\n<td>20 000 Kč</td>\r\n</tr>\r\n<tr>\r\n<td>10x25 m (250m&sup2;)</td>\r\n<td>95 Kč/m&sup2;</td>\r\n<td>23 750 Kč</td>\r\n</tr>\r\n<tr>\r\n<td>10x30 m (300m&sup2;)</td>\r\n<td>90 Kč/m&sup2;</td>\r\n<td>27 000 Kč</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div class=\"text-center\" style=\"text-align: center;\"><strong><u>Ve&scaron;ker&eacute; ceny jsou uvedeny bez DPH a mohou se měnit dle dohody s klientem.</u></strong></div>\r\n<div>\r\n<p><strong>Dlouhodob&yacute; pron&aacute;jem</strong><br />Za dlouhodob&yacute; pron&aacute;jem jsou považov&aacute;ny 4 dny a v&iacute;ce, cena je ře&scaron;ena individu&aacute;lně.</p>\r\n<p><strong>Cena zahrnuje</strong><br />Mont&aacute;ž, kotven&iacute;, pron&aacute;jem, demont&aacute;ž, při dlouhodob&eacute;m pron&aacute;jmu kontrola stavu stanu.</p>\r\n<p><strong>Cena nezahrnuje</strong><br />Dopravu, extr&eacute;mn&iacute; či&scaron;těn&iacute;.</p>\r\n<p><strong>Doprava</strong> (&uacute;čtuje se k ceně stanu po akci, dle re&aacute;lně odjet&yacute;ch km, sklad v Ostravě Radvanic&iacute;ch)<br />Iveco Daily: 10 Kč/km<br />Man 12t, DAF 12t: 20 Kč/km (použ&iacute;v&aacute; se při vět&scaron;&iacute;m množstv&iacute; stanů)<br />Mont&aacute;žn&iacute; t&yacute;m: 6 Kč/km (použ&iacute;v&aacute; se při vět&scaron;&iacute;m množstv&iacute; stanů)</p>\r\n<p><strong>Doplňkov&eacute; vybaven&iacute;</strong><br />Podlaha, koberce: dle dohody<br />Pron&aacute;jem topen&iacute;: 1600 Kč (včetně plynov&eacute; n&aacute;plně)<br />Z&aacute;brana 2x1 metr: 100 Kč /ks<br />Stůl a 2 lavice pro 8 os.: 150Kč/ks<br />Z&aacute;řivkov&eacute; osvětlen&iacute;: 150 Kč/ks</p>\r\n</div>',	'cenik',	0,	1,	'',	3);

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

-- 2017-02-28 15:46:43