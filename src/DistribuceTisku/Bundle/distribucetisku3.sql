-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Čtvrtek 05. prosince 2013, 23:07
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `odber`
--

INSERT INTO `odber` (`id_odberu`, `den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`, `id_platby`) VALUES
(3, 'Pondělí', '2012-03-01', '2014-02-28', 2, '1111-1523', 3),
(4, 'Sobota', '2013-01-19', '2014-01-18', 3, '9234-1023', 4),
(6, 'Neděle', '2013-01-19', '2014-01-18', 3, '7344-0002', 4),
(9, 'Neděle', '2008-01-01', '2008-01-01', 21, '7344-0001', NULL),
(10, 'Pátek', '2008-01-01', '2008-01-01', 3, '7344-0002', NULL),
(11, 'Pondělí', '2008-01-01', '2008-01-01', 2, '7344-0002', NULL),
(12, 'Neděle', '2008-01-01', '2008-01-01', 21, '7344-0001', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

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
  PRIMARY KEY (`ISSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `tiskovina`
--

INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`) VALUES
('1111-1523', 15, 'Prúvodce blaznivinama', 'Pondělí', 'OKO', 'Zuby'),
('7344-0001', 99, 'Svět sýrových hlav', 'Středa', 'Mnami', 'Hudlor'),
('7344-0002', 149, 'Erotické postupy', 'Středa', 'Mnami', 'Hudlor'),
('7344-0002s', 0, '149', 'Pátek', 'Mnami', 'Amurica'),
('9234-1023', 33, 'Ukrajinské traktory', 'Pondělí', 'RUStech', 'Amurica'),
('9234-1033', 33, 'Francouzské traktory', 'Pátek', 'RUStech', 'Amurica');

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
('lojza', '123456', 2, 24),
('pepik', '123456', 0, 21),
('roaduser1', 'user', 1, 2),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=40 ;

--
-- Vypisuji data pro tabulku `zakaznik`
--

INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES
(2, 'NaolejaEdit2', 'ead', '', 'Mandarinkové nám. 23d', '763 01', '6347023648/0100', '444888777', 2),
(3, 'FíkEdit', 'Maxipes', '', 'Červená bouda 19d', '76309', '0382856299/01009', '57324091419', 1),
(21, 'Pepik', 'asdadad', 'ad', 'ad', '54', '5', '5', 1),
(24, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(25, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(26, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
(27, 'FíkEdit', 'ead', '', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1),
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
(39, 'FíkEdit', 'ead', 'd', 'Mandarinkové nám. 23', '763 01', '6347023648/0100', '57324091419', 1);

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
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `zakaznik` (`id_zakaznika`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `zakaznik`
--
ALTER TABLE `zakaznik`
  ADD CONSTRAINT `zakaznik_ibfk_1` FOREIGN KEY (`id_dodavatele`) REFERENCES `dodavatel` (`id_dodavatele`) ON DELETE CASCADE ON UPDATE CASCADE;
