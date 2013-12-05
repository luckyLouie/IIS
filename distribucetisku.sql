-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Čtv 05. pro 2013, 02:10
-- Verze serveru: 5.6.12-log
-- Verze PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `distribucetisku`
--
CREATE DATABASE IF NOT EXISTS `distribucetisku` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `dodavatel`
--

INSERT INTO `dodavatel` (`id_dodavatele`, `jmeno`, `prijmeni`, `adresa`, `psc`, `kontaktni_udaj`) VALUES
(1, 'Alexandr', 'Novinov', 'Houbničkova 3', '763 02', '725368754'),
(2, 'Petr', 'Hazeč', 'Atomová 663', '763 01', '777927349');

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
  KEY `id_platby` (`id_platby`),
  KEY `id_faktury` (`id_faktury`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=11008 ;

--
-- Vypisuji data pro tabulku `faktury`
--

INSERT INTO `faktury` (`id_faktury`, `datum_vystaveni`, `datum_splatnosti`, `vysledna_cena`, `id_platby`) VALUES
(11007, '2012-07-01', '2013-10-31', 806, 1),
(11006, '2012-05-01', '2013-07-13', 806, 1),
(11005, '2012-02-01', '2013-04-13', 806, 1),
(11004, '2012-11-01', '2013-01-31', 806, 1),
(11003, '2012-07-14', '2012-08-13', 806, 2),
(11002, '2011-07-14', '2011-08-13', 672, 2),
(11001, '2010-07-14', '2010-08-13', 403, 2);

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
  `id_platby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_odberu`),
  KEY `id_zakaznika` (`id_zakaznika`),
  KEY `ISSN` (`ISSN`),
  KEY `id_platby` (`id_platby`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `odber`
--

INSERT INTO `odber` (`id_odberu`, `den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`, `id_platby`) VALUES
(4, 'Sobota', '2013-01-19', '2014-01-18', 3, '9234-1023', 4),
(3, 'Pondělí', '2012-03-01', '2014-02-28', 2, '1111-1523', 3),
(5, 'Úterý', '2012-11-01', '2013-10-31', 1, '7344-0002', 2),
(2, 'Středa', '2012-11-01', '2013-10-31', 1, '7344-0001', 1),
(1, 'Pátek', '2013-12-25', '2020-12-24', 4, '9234-1033', 5),
(8, 'Pondělí', '2010-08-14', '2020-08-13', 4, '9234-1023', 5),
(7, 'Čtvrtek', '2010-08-14', '2020-08-13', 4, '9234-1023', 5),
(6, 'Neděle', '2013-01-19', '2014-01-18', 3, '7344-0002', 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `platby`
--

CREATE TABLE IF NOT EXISTS `platby` (
  `id_platby` int(11) NOT NULL AUTO_INCREMENT,
  `obdobi` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `zpusob_platby` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_platby`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `platby`
--

INSERT INTO `platby` (`id_platby`, `obdobi`, `zpusob_platby`) VALUES
(3, 'půlročně', 'převodem'),
(2, 'čtvrtletně', 'složenkou'),
(1, 'čtvrtletně', 'převodem'),
(5, 'ročně', 'převodem'),
(4, 'měsíčně', 'převodem');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `preruseni_odberu`
--

INSERT INTO `preruseni_odberu` (`id_preruseni`, `preruseni_od`, `preruseni_do`, `id_odberu`) VALUES
(1, '2014-10-14', '2014-11-13', 1);

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
  PRIMARY KEY (`ISSN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `tiskovina`
--

INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`) VALUES
('7344-0001', 99, 'Svět sýrových hlav', 'Středa', 'Mnami', 'Hudlor'),
('9234-1033', 33, 'Francouzské traktory', 'Pátek', 'RUStech', 'Amurica'),
('9234-1023', 33, 'Ukrajinské traktory', 'Pondělí', 'RUStech', 'Amurica'),
('7344-0002', 149, 'Erotické postupy', 'Středa', 'Mnami', 'Hudlor'),
('1111-1523', 15, 'Prúvodce blaznivinama', 'Pondělí', 'OKO', 'Zuby');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `passwd` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `type` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES
('admin', 'admin', 0, 0),
('roaduser', 'user', 1, 1),
('roaduser1', 'user', 1, 2),
('user1', 'user', 2, 1),
('user2', 'user', 2, 2),
('user3', 'user', 2, 3),
('user4', 'user', 2, 4),
('user5', 'user', 2, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=21 ;

--
-- Vypisuji data pro tabulku `zakaznik`
--

INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES
(4, 'Ukolen', 'Hulmiho', NULL, 'Vlhká 123', '763 02', '0382856299/0100', '573240914', 1),
(1, 'Emanuel', 'Vylezdír', 'Ing.', 'Atomová 666', '763 01', '5226634789/0500', '577777032', 2),
(2, 'Naolej', 'Jujulie', NULL, 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '573455431', 2),
(3, 'Fík', 'Maxipes', NULL, 'Červená bouda 1', '763 02', '0382856299/0100', '573240914', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
