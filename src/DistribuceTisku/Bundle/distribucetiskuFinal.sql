-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Neděle 08. prosince 2013, 13:47
-- Verze MySQL: 5.1.53
-- Verze PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `distribucetisku`
--
CREATE DATABASE `distribucetisku` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `distribucetisku`;

-- --------------------------------------------------------

--
-- Struktura tabulky `dodavatel`
--

CREATE TABLE IF NOT EXISTS `dodavatel` (
  `id_dodavatele` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `psc` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `kontaktni_udaj` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_dodavatele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=14 ;

--
-- Vypisuji data pro tabulku `dodavatel`
--

INSERT INTO `dodavatel` (`id_dodavatele`, `jmeno`, `prijmeni`, `adresa`, `psc`, `kontaktni_udaj`) VALUES
(1, 'Alexandr', 'Novinov', 'Houbničkova 3', '763 02', '725368754'),
(2, 'Petr', 'Hazeč', 'Atomová 663', '763 01', '777927349'),
(4, 'd', 'd', 'd', 'd', ''),
(8, 'daf', 'd', 'd', 'd', ''),
(11, 'adsadsads', 'd', 'd', 'd', ''),
(12, 'name dodavatele2', 'prijmeni dovatelele2', 'Uzkaa', '74859', '147852369'),
(13, 'Tester ', 'Asdads', 'asdasd', 'asd', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `faktury`
--

CREATE TABLE IF NOT EXISTS `faktury` (
  `id_faktury` int(11) NOT NULL AUTO_INCREMENT,
  `datum_vystaveni` date NOT NULL,
  `datum_splatnosti` date NOT NULL,
  `vysledna_cena` double NOT NULL,
  `id_platby` int(11) NOT NULL,
  PRIMARY KEY (`id_faktury`),
  KEY `id_platby` (`id_platby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=11008 ;

--
-- Vypisuji data pro tabulku `faktury`
--

INSERT INTO `faktury` (`id_faktury`, `datum_vystaveni`, `datum_splatnosti`, `vysledna_cena`, `id_platby`) VALUES
(11001, '2010-07-14', '2010-08-13', 403, 2),
(11002, '2011-07-14', '2011-08-13', 672, 2),
(11003, '2012-07-14', '2012-08-13', 806, 2),
(11004, '2012-11-01', '2013-01-31', 806, 1),
(11005, '2012-02-01', '2013-04-13', 806, 1),
(11006, '2012-05-01', '2013-07-13', 806, 1),
(11007, '2012-07-01', '2013-10-31', 806, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `oblast`
--

CREATE TABLE IF NOT EXISTS `oblast` (
  `id_oblast` int(11) NOT NULL AUTO_INCREMENT,
  `psc` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `nazev` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `posta` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_oblast`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=195 ;

--
-- Vypisuji data pro tabulku `oblast`
--

INSERT INTO `oblast` (`id_oblast`, `psc`, `nazev`, `posta`) VALUES
(1, '2500', '\r\nBohunice (část)', 'Brno 25'),
(2, '1900', 'Bohunice (část)', 'Brno 19'),
(3, '1900', 'Bohunice (část)', 'Brno 19'),
(4, '3000', '\r\nBohunice (část)', 'Brno 30'),
(5, '3900', '\r\nBohunice (část)', 'Brno 39'),
(6, '2500', '\r\nBosonohy (část)', 'Brno 25'),
(7, '4200', '\r\nBosonohy (část)', 'Brno 42'),
(8, '2000', '\r\nBrněnské Ivanovice (část)', 'Brno 20'),
(9, '1700', '\r\nBrněnské Ivanovice (část)', 'Brno 17'),
(10, '1900', '\r\nBrno-Bohunice (část) x)', 'Brno 19'),
(11, '2500', '\r\nBrno-Bohunice (část) x)', 'Brno 25'),
(12, '3000', '\r\nBrno-Bohunice (část) x)', 'Brno 30'),
(13, '3900', '\r\nBrno-Bohunice (část) x)', 'Brno 39'),
(14, '4200', '\r\nBrno-Bosonohy (část) x)', 'Brno 42'),
(15, '2500', '\r\nBrno-Bosonohy (část) x)', 'Brno 25'),
(16, '1700', '\r\nBrno-Brněnské Ivanovice (čás', 'Brno 17'),
(17, '2000', '\r\nBrno-Brněnské Ivanovice (čás', 'Brno 20'),
(18, '2400', '\r\nBrno-Bystrc (část) x)', 'Brno 24'),
(19, '3500', '\r\nBrno-Bystrc (část) x)', 'Brno 35'),
(20, '4300', '\r\nBrno-Chrlice (část) x)', 'Brno 43'),
(21, '2000', '\r\nBrno-Chrlice (část) x)', 'Brno 20'),
(22, '2700', '\r\nBrno-Černovice (část) x)', 'Brno 27'),
(23, '0200', '\r\nBrno-Černovice (část) x)', 'Brno 2'),
(24, '1800', '\r\nBrno-Černovice (část) x)', 'Brno 18'),
(25, '1700', '\r\nBrno-Dolní Heršpice (část) x', 'Brno 17'),
(26, '1900', '\r\nBrno-Dolní Heršpice (část) x', 'Brno 19'),
(27, '2000', '\r\nBrno-Dvorska x)', 'Brno 20'),
(28, '1700', '\r\nBrno-Holásky (část) x)', 'Brno 17'),
(29, '2000', '\r\nBrno-Holásky (část) x)', 'Brno 20'),
(30, '1700', '\r\nBrno-Horní Heršpice (část) x', 'Brno 17'),
(31, '1900', '\r\nBrno-Horní Heršpice (část) x', 'Brno 19'),
(32, '1400', '\r\nBrno-Husovice (část) x)', 'Brno 14'),
(33, '3800', '\r\nBrno-Husovice (část) x)', 'Brno 38'),
(34, '1300', '\r\nBrno-Husovice (část) x)', 'Brno 13'),
(35, '2100', '\r\nBrno-Ivanovice x)', 'Brno 21'),
(36, '2100', '\r\nBrno-Jehnice x)', 'Brno 21'),
(37, '6434', '\r\nBrno-Kníničky (část) x)', 'Kuřim'),
(38, '3500', '\r\nBrno-Kníničky (část) x)', 'Brno 35'),
(39, '6401', '\r\nBrno-Kohoutovice (část) x)', 'Bílovice nad Svitavou'),
(40, '2300', '\r\nBrno-Kohoutovice (část) x)', 'Brno 23'),
(41, '0200', '\r\nBrno-Komárov (část) x)', 'Brno 2'),
(42, '1700', '\r\nBrno-Komárov (část) x)', 'Brno 17'),
(43, '3500', '\r\nBrno-Komín (část) x)', 'Brno 35'),
(44, '2400', '\r\nBrno-Komín (část) x)', 'Brno 24'),
(45, '1600', '\r\nBrno-Komín (část) x)', 'Brno 16'),
(46, '0200', '\r\nBrno-Královo Pole (část) x)', 'Brno 2'),
(47, '1200', '\r\nBrno-Královo Pole (část) x)', 'Brno 12'),
(48, '1600', '\r\nBrno-Královo Pole (část) x)', 'Brno 16'),
(49, '3800', '\r\nBrno-Lesná (část) x)', 'Brno 38'),
(50, '1400', '\r\nBrno-Lesná (část) x)', 'Brno 14'),
(51, '1200', '\r\nBrno-Lesná (část) x)', 'Brno 12'),
(52, '2800', '\r\nBrno-Líšeň x)', 'Brno 28'),
(53, '1200', '\r\nBrno-Medlánky (část) x)', 'Brno 12'),
(54, '2100', '\r\nBrno-Medlánky (část) x)', 'Brno 21'),
(55, '0200', '\r\nBrno-město', 'Brno 2'),
(56, '2100', '\r\nBrno-Mokrá Hora x)', 'Brno 21'),
(57, '4400', '\r\nBrno-Obřany (část) x)', 'Brno 44'),
(58, '1400', '\r\nBrno-Obřany (část) x)', 'Brno 14'),
(59, '2100', '\r\nBrno-Ořešín x)', 'Brno 21'),
(60, '3700', '\r\nBrno-Pisárky x)', 'Brno 37'),
(61, '0200', '\r\nBrno-Ponava (část) x)', 'Brno 2'),
(62, '1200', '\r\nBrno-Ponava (část) x)', 'Brno 12'),
(63, '1900', '\r\nBrno-Přízřenice x)', 'Brno 19'),
(64, '1200', '\r\nBrno-Řečkovice (část) x)', 'Brno 12'),
(65, '2100', '\r\nBrno-Řečkovice (část) x)', 'Brno 21'),
(66, '1200', '\r\nBrno-Sadová x)', 'Brno 12'),
(67, '2700', '\r\nBrno-Slatina x)', 'Brno 27'),
(68, '4400', '\r\nBrno-Soběšice x)', 'Brno 44'),
(69, '3900', '\r\nBrno-Staré Brno (část) x)', 'Brno 39'),
(70, '0300', '\r\nBrno-Staré Brno (část) x)', 'Brno 3'),
(71, '0200', '\r\nBrno-Staré Brno (část) x)', 'Brno 2'),
(72, '2500', '\r\nBrno-Starý Lískovec x)', 'Brno 25'),
(73, '0200', '\r\nBrno-Stránice (část) x)', 'Brno 2'),
(74, '1600', '\r\nBrno-Stránice (část) x)', 'Brno 16'),
(75, '3900', '\r\nBrno-Štýřice (část) x)', 'Brno 39'),
(76, '1900', '\r\nBrno-Štýřice (část) x)', 'Brno 19'),
(77, '0200', '\r\nBrno-Trnitá (část) x)', 'Brno 2'),
(78, '1700', '\r\nBrno-Trnitá (část) x)', 'Brno 17'),
(79, '1700', '\r\nBrno-Tuřany (část) x)', 'Brno 17'),
(80, '2000', '\r\nBrno-Tuřany (část) x)', 'Brno 20'),
(81, '2700', '\r\nBrno-Tuřany (část) x)', 'Brno 27'),
(82, '4400', '\r\nBrno-Útěchov x)', 'Brno 44'),
(83, '0200', '\r\nBrno-Veveří (část) x)', 'Brno 2'),
(84, '1600', '\r\nBrno-Veveří (část) x)', 'Brno 16'),
(85, '0200', '\r\nBrno-Zábrdovice (část) x)', 'Brno 2'),
(86, '1500', '\r\nBrno-Zábrdovice (část) x)', 'Brno 15'),
(87, '3700', '\r\nBrno-Žabovřesky (část) x)', 'Brno 37'),
(88, '1600', '\r\nBrno-Žabovřesky (část) x)', 'Brno 16'),
(89, '0200', '\r\nBrno-Žabovřesky (část) x)', 'Brno 2'),
(90, '3500', '\r\nBrno-Žebětín (část) x)', 'Brno 35'),
(91, '4100', '\r\nBrno-Žebětín (část) x)', 'Brno 41'),
(92, '2400', '\r\nBystrc (část)', 'Brno 24'),
(93, '3500', '\r\nBystrc (část)', 'Brno 35'),
(94, '4300', '\r\nChrlice (část)', 'Brno 43'),
(95, '2000', '\r\nChrlice (část)', 'Brno 20'),
(96, '1300', '\r\nČerná Pole (Brno-sever) (čás', 'Brno 13'),
(97, '1400', '\r\nČerná Pole (Brno-sever) (čás', 'Brno 14'),
(98, '0200', '\r\nČerná Pole (Brno-sever) (čás', 'Brno 2'),
(99, '0200', '\r\nČerná Pole (Brno-střed)', 'Brno 2'),
(100, '2700', '\r\nČernovice (část)', 'Brno 27'),
(101, '0200', '\r\nČernovice (část)', 'Brno 2'),
(102, '1800', '\r\nČernovice (část)', 'Brno 18'),
(103, '1700', '\r\nDolní Heršpice (část)', 'Brno 17'),
(104, '1900', '\r\nDolní Heršpice (část)', 'Brno 19'),
(105, '2000', '\r\nDvorska', 'Brno 20'),
(106, '1700', '\r\nHolásky (část)', 'Brno 17'),
(107, '2000', '\r\nHolásky (část)', 'Brno 20'),
(108, '1900', '\r\nHorní Heršpice (část)', 'Brno 19'),
(109, '1700', '\r\nHorní Heršpice (část)', 'Brno 17'),
(110, '1300', '\r\nHusovice (část)', 'Brno 13'),
(111, '1400', '\r\nHusovice (část)', 'Brno 14'),
(112, '3800', '\r\nHusovice (část)', 'Brno 38'),
(113, '2100', '\r\nIvanovice', 'Brno 21'),
(114, '2100', '\r\nJehnice', 'Brno 21'),
(115, '3700', '\r\nJundrov (Brno-Jundrov)', 'Brno 37'),
(116, '6434', '\r\nKníničky (část)', 'Kuřim'),
(117, '3500', '\r\nKníničky (část)', 'Brno 35'),
(118, '2300', '\r\nKohoutovice (část)', 'Brno 23'),
(119, '6401', '\r\nKohoutovice (část)', 'Bílovice nad Svitavou'),
(120, '0200', '\r\nKomárov (část)', 'Brno 2'),
(121, '1700', '\r\nKomárov (část)', 'Brno 17'),
(122, '3500', '\r\nKomín (část)', 'Brno 35'),
(123, '2400', '\r\nKomín (část)', 'Brno 24'),
(124, '1600', '\r\nKomín (část)', 'Brno 16'),
(125, '0200', '\r\nKrálovo Pole (část)', 'Brno 2'),
(126, '1200', '\r\nKrálovo Pole (část)', 'Brno 12'),
(127, '1600', '\r\nKrálovo Pole (část)', 'Brno 16'),
(128, '3800', '\r\nLesná (část)', 'Brno 38'),
(129, '1400', '\r\nLesná (část)', 'Brno 14'),
(130, '1200', '\r\nLesná (část)', 'Brno 12'),
(131, '2800', '\r\nLíšeň', 'Brno 28'),
(132, '1400', '\r\nMaloměřice (Brno-Maloměřice ', 'Brno 14'),
(133, '1500', '\r\nMaloměřice (Brno-Maloměřice ', 'Brno 15'),
(134, '1200', '\r\nMedlánky (část)', 'Brno 12'),
(135, '2100', '\r\nMedlánky (část)', 'Brno 21'),
(136, '2100', '\r\nMokrá Hora', 'Brno 21'),
(137, '2500', '\r\nNový Lískovec (část)', 'Brno 25'),
(138, '3400', '\r\nNový Lískovec (část)', 'Brno 34'),
(139, '1400', '\r\nObřany (část)', 'Brno 14'),
(140, '4400', '\r\nObřany (část)', 'Brno 44'),
(141, '2100', '\r\nOřešín', 'Brno 21'),
(142, '3700', '\r\nPisárky (Brno-Jundrov)', 'Brno 37'),
(143, '0300', '\r\nPisárky (Brno-Kohoutovice) (', 'Brno 3'),
(144, '2300', '\r\nPisárky (Brno-Kohoutovice) (', 'Brno 23'),
(145, '3700', '\r\nPisárky (Brno-Kohoutovice) (', 'Brno 37'),
(146, '3900', '\r\nPisárky (Brno-střed) (část)', 'Brno 39'),
(147, '3700', '\r\nPisárky (Brno-střed) (část)', 'Brno 37'),
(148, '3400', '\r\nPisárky (Brno-střed) (část)', 'Brno 34'),
(149, '0300', '\r\nPisárky (Brno-střed) (část)', 'Brno 3'),
(150, '0200', '\r\nPisárky (Brno-střed) (část)', 'Brno 2'),
(151, '0200', '\r\nPonava (část)', 'Brno 2'),
(152, '1200', '\r\nPonava (část)', 'Brno 12'),
(153, '1900', '\r\nPřízřenice', 'Brno 19'),
(154, '2100', '\r\nŘečkovice (část)', 'Brno 21'),
(155, '1200', '\r\nŘečkovice (část)', 'Brno 12'),
(156, '1200', '\r\nSadová', 'Brno 12'),
(157, '2700', '\r\nSlatina', 'Brno 27'),
(158, '4400', '\r\nSoběšice', 'Brno 44'),
(159, '3900', '\r\nStaré Brno (část)', 'Brno 39'),
(160, '0300', '\r\nStaré Brno (část)', 'Brno 3'),
(161, '0200', '\r\nStaré Brno (část)', 'Brno 2'),
(162, '2500', '\r\nStarý Lískovec', 'Brno 25'),
(163, '0200', '\r\nStránice (část)', 'Brno 2'),
(164, '1600', '\r\nStránice (část)', 'Brno 16'),
(165, '3900', '\r\nŠtýřice (část)', 'Brno 39'),
(166, '1900', '\r\nŠtýřice (část)', 'Brno 19'),
(167, '0200', '\r\nTrnitá (Brno-jih) (část)', 'Brno 2'),
(168, '1800', '\r\nTrnitá (Brno-jih) (část)', 'Brno 18'),
(169, '0200', '\r\nTrnitá (Brno-střed) (část)', 'Brno 2'),
(170, '1700', '\r\nTrnitá (Brno-střed) (část)', 'Brno 17'),
(171, '2700', '\r\nTuřany (část)', 'Brno 27'),
(172, '2000', '\r\nTuřany (část)', 'Brno 20'),
(173, '1700', '\r\nTuřany (část)', 'Brno 17'),
(174, '4400', '\r\nÚtěchov', 'Brno 44'),
(175, '0200', '\r\nVeveří (část)', 'Brno 2'),
(176, '1600', '\r\nVeveří (část)', 'Brno 16'),
(177, '1400', '\r\nZábrdovice (Brno-sever) (čás', 'Brno 14'),
(178, '1300', '\r\nZábrdovice (Brno-sever) (čás', 'Brno 13'),
(179, '0200', '\r\nZábrdovice (Brno-sever) (čás', 'Brno 2'),
(180, '0200', '\r\nZábrdovice (Brno-střed) (čás', 'Brno 2'),
(181, '1500', '\r\nZábrdovice (Brno-střed) (čás', 'Brno 15'),
(182, '0200', '\r\nZábrdovice (Brno-Židenice) (', 'Brno 2'),
(183, '1500', '\r\nZábrdovice (Brno-Židenice) (', 'Brno 15'),
(184, '3700', '\r\nŽabovřesky (část)', 'Brno 37'),
(185, '1600', '\r\nŽabovřesky (část)', 'Brno 16'),
(186, '0200', '\r\nŽabovřesky (část)', 'Brno 2'),
(187, '3500', '\r\nŽebětín (část)', 'Brno 35'),
(188, '4100', '\r\nŽebětín (část)', 'Brno 41'),
(189, '2800', '\r\nŽidenice (Brno-Vinohrady) (č', 'Brno 28'),
(190, '3600', '\r\nŽidenice (Brno-Vinohrady) (č', 'Brno 36'),
(191, '1500', '\r\nŽidenice (Brno-Židenice) (čá', 'Brno 15'),
(192, '1800', '\r\nŽidenice (Brno-Židenice) (čá', 'Brno 18'),
(193, '2800', '\r\nŽidenice (Brno-Židenice) (čá', 'Brno 28'),
(194, '3600', '\r\nŽidenice (Brno-Židenice) (čá', 'Brno 36');

-- --------------------------------------------------------

--
-- Struktura tabulky `odber`
--

CREATE TABLE IF NOT EXISTS `odber` (
  `id_odberu` int(11) NOT NULL AUTO_INCREMENT,
  `den_odberu` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `odber_od` date NOT NULL,
  `odber_do` date NOT NULL,
  `id_zakaznika` int(11) NOT NULL,
  `ISSN` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `id_platby` int(11) DEFAULT '1',
  PRIMARY KEY (`id_odberu`),
  KEY `id_zakaznika` (`id_zakaznika`),
  KEY `ISSN` (`ISSN`),
  KEY `id_platby` (`id_platby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=30 ;

--
-- Vypisuji data pro tabulku `odber`
--

INSERT INTO `odber` (`id_odberu`, `den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`, `id_platby`) VALUES
(3, 'Pondělí', '2008-01-01', '2008-01-01', 2, '7344-0001', 3),
(4, 'Sobota', '2013-01-19', '2014-01-18', 3, '9234-1023', 4),
(6, 'Pondělí', '2008-01-01', '2008-01-01', 3, '7344-0002', 4),
(9, 'Středa', '2008-01-01', '2008-01-01', 21, '7344-0001', 2),
(10, 'Úterý', '2008-01-01', '2008-01-01', 3, '7344-0002', 4),
(11, 'Neděle', '2008-01-01', '2008-01-01', 2, '7344-0002', 5),
(12, 'Neděle', '2008-01-01', '2008-01-01', 21, '7344-0001', 5),
(13, 'Neděle', '2018-11-16', '2008-01-01', 2, '1111-1523', NULL),
(14, 'Pátek', '2010-03-04', '2012-04-06', 21, '7344-0002', NULL),
(15, 'Pondělí', '2008-01-01', '2008-01-01', 28, '1111-1523', NULL),
(16, 'Neděle', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(17, 'Neděle', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(18, 'Středa', '2008-01-01', '2008-01-01', 2, '7344-0002', NULL),
(19, 'Neděle', '2008-01-01', '2008-01-01', 2, '9234-1033', NULL),
(20, 'Neděle', '2008-01-01', '2008-01-01', 2, '9234-1033', NULL),
(21, 'Neděle', '2008-01-01', '2008-01-01', 2, '7344-0002s', NULL),
(22, 'Neděle', '2010-03-16', '2010-03-17', 2, '9234-1033', NULL),
(23, 'Čtvrtek', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(24, 'Neděle', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(25, 'Pondělí', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(26, 'Pondělí', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(27, 'Pondělí', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(28, 'Pondělí', '2008-01-01', '2008-01-01', 2, '1111-1523', NULL),
(29, 'Úterý', '2008-01-01', '2008-01-01', 2, '9234-1033', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `platby`
--

CREATE TABLE IF NOT EXISTS `platby` (
  `id_platby` int(11) NOT NULL AUTO_INCREMENT,
  `obdobi` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `zpusob_platby` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_platby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `platby`
--

INSERT INTO `platby` (`id_platby`, `obdobi`, `zpusob_platby`) VALUES
(1, 'čtvrtletně', 'převodem'),
(2, 'čtvrtletně', 'složenkou'),
(3, 'půlročně', 'převodem'),
(4, 'měsíčně', 'převodem'),
(5, 'ročně', 'převodem');

-- --------------------------------------------------------

--
-- Struktura tabulky `preruseni_odberu`
--

CREATE TABLE IF NOT EXISTS `preruseni_odberu` (
  `id_preruseni` int(11) NOT NULL AUTO_INCREMENT,
  `preruseni_od` date NOT NULL,
  `preruseni_do` date NOT NULL,
  `id_odberu` int(11) NOT NULL,
  PRIMARY KEY (`id_preruseni`),
  KEY `id_odberu` (`id_odberu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=15 ;

--
-- Vypisuji data pro tabulku `preruseni_odberu`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `tiskovina`
--

CREATE TABLE IF NOT EXISTS `tiskovina` (
  `ISSN` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `cena` double NOT NULL,
  `titul` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `den_vydani` varchar(15) COLLATE utf8_czech_ci DEFAULT NULL,
  `nakladatelstvi` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `vydavatel` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `typ` varchar(10) COLLATE utf8_czech_ci NOT NULL DEFAULT 'Týdeník',
  PRIMARY KEY (`ISSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `tiskovina`
--

INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`, `typ`) VALUES
('1111-1523', 15, 'Prúvodce blaznivinama', 'Pondělí', 'OKO', 'Zuby', 'týdeník'),
('7344-0001', 99, 'Svět sýrových hlav', 'Středa', 'Mnami', 'Hudlor', 'týdeník'),
('7344-0002', 999, 'Erotické postupy', 'Středa', 'RUStech', 'Hudlor8', ''),
('7344-00024', 800, '33', 'Neděle', 'd', 'd', 'měsičník'),
('7344-0002d', 0, '33', 'Středa', 'RUStech', 'Amurica', 'měsičník'),
('7344-0002s', 50, '149', 'Pátek', 'Mnami', 'Amurica', ''),
('9234-1023', 33, 'Ukrajinské traktory', 'Pondělí', 'RUStech', 'Amurica', 'týdeník'),
('9234-1033', 33, 'Francouzské traktory', 'Pátek', 'RUStech', 'Amurica', 'týdeník'),
('9234-10335', 0, '99', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `passwd` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `type` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES
('aaaaaaaaaa', 'Array', 1, 12),
('admin', 'admin', 2, 45),
('asd', '123456', 2, 24),
('asdasdadsf', 'Array', 2, 63),
('asdcd', '123456', 2, 24),
('ccyyy', '1', 2, 71),
('dadsasd', 'Array', 2, 24),
('dadsdasd', 'Array', 1, 11),
('dasdd', 'Array', 1, 3),
('dodavatel', '123456', 1, 12),
('lojza', '123456', 2, 24),
('pepik', '123456', 0, 21),
('pepik9', 'Array', 2, 56),
('pepikaa', 'Array', 2, 24),
('pepikasd', 'Array', 2, 55),
('pepikgfh', 'Array', 2, 24),
('popouzzhh', 'Array', 1, 13),
('ppeppe', '123456', 2, 72),
('user2', 'user', 2, 2),
('user3', 'user', 2, 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `zakaznik`
--

CREATE TABLE IF NOT EXISTS `zakaznik` (
  `id_zakaznika` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `titul` varchar(15) COLLATE utf8_czech_ci DEFAULT NULL,
  `adresa` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `psc` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `bankovni_spojeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `kontaktni_udaj` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `id_dodavatele` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_zakaznika`),
  KEY `id_dodavatele` (`id_dodavatele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=73 ;

--
-- Vypisuji data pro tabulku `zakaznik`
--

INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES
(2, 'User2', 'profi', 'Ing.', 'Mandarinkové nám. 23d', '166', '6347023648/0108', '444888779', 12),
(3, 'FíkEdit999', 'Maxipes', '', 'Červená bouda 19', '76309', '0382856299/01009', '57324091419', 1),
(21, 'Pepik', 'asdadad', 'ad', 'ad', '54', '5', '5', 1),
(24, 'FíkEditsda', 'ead', '', 'Mandarinkové nám. 23', '1', '6347023648/0100', '57324091419', 12),
(25, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(26, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '0200', '6347023648/0100', '57324091419', 1),
(27, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '2500', '6347023648/0100', '57324091419', 1),
(28, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(29, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(30, 'FíkEdit', 'ead', '', 'Atomová 999', '76309', '6347023648/0100', '57324091419', 1),
(31, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(32, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '76309', '6347023648/0100', '5', 1),
(33, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(34, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(35, 'FíkEdit', 'ead', 'Bc.', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(36, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(37, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(38, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(39, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(45, 'admin', 'admin', '', 'd', '124', 'd', 'd', 1),
(52, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(54, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(55, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23d', '763 04', '5226634789/0500', '5', 1),
(56, 'admin', 'admin', 'ad', 'Mandarinkové nám. 23d', '763 01', '6347023648/0100', '57324091419', 1),
(57, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 12),
(58, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '', '', 1),
(63, 'NaolejaD', 'eadd', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(71, 'qqqqqqqqqqqqqqqq', 'asdads', '', 'Mandarinkové nám. 23', '17', '6347023648/0100', '', 4),
(72, 'pppppppppppp', 'ead', '', 'Mandarinkové nám. 23', '4', '', '', 1);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `faktury`
--
ALTER TABLE `faktury`
  ADD CONSTRAINT `faktury_ibfk_1` FOREIGN KEY (`id_platby`) REFERENCES `platby` (`id_platby`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `odber`
--
ALTER TABLE `odber`
  ADD CONSTRAINT `odber_ibfk_3` FOREIGN KEY (`id_platby`) REFERENCES `platby` (`id_platby`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odber_ibfk_1` FOREIGN KEY (`id_zakaznika`) REFERENCES `zakaznik` (`id_zakaznika`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odber_ibfk_2` FOREIGN KEY (`ISSN`) REFERENCES `tiskovina` (`ISSN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `preruseni_odberu`
--
ALTER TABLE `preruseni_odberu`
  ADD CONSTRAINT `preruseni_odberu_ibfk_1` FOREIGN KEY (`id_odberu`) REFERENCES `odber` (`id_odberu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `zakaznik`
--
ALTER TABLE `zakaznik`
  ADD CONSTRAINT `zakaznik_ibfk_1` FOREIGN KEY (`id_dodavatele`) REFERENCES `dodavatel` (`id_dodavatele`) ON DELETE CASCADE ON UPDATE CASCADE;
