
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 31 Sty 2017, 10:07
-- Wersja serwera: 10.0.28-MariaDB
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `u498232850_aipro`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'Testowy'),
(2, 'Zmiany na stronie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modify` datetime NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `comment`
--

INSERT INTO `comment` (`id_comment`, `id_user`, `id_news`, `text`, `date_create`, `date_modify`) VALUES
(1, 9, 6, 'Bardzo ciekawy artykuł', '2017-01-08 15:32:25', '0000-00-00 00:00:00'),
(2, 13, 6, 'Napracowałem się przy tym artykule :)', '2017-01-08 16:10:06', '0000-00-00 00:00:00'),
(9, 10, 6, 'Nieprawda, ja piszę o niebo lepsze komentarze!!!!!!!! :''( ;_;', '2017-01-09 11:07:55', '2017-01-09 11:07:55'),
(4, 13, 6, 'testo', '2017-01-08 17:21:31', '2017-01-08 17:21:31'),
(5, 13, 6, 'testowy komentarz', '2017-01-08 17:21:44', '2017-01-08 17:21:44'),
(6, 13, 6, 'testowy komentarz 2', '2017-01-08 17:23:57', '2017-01-08 17:23:57'),
(7, 13, 6, 'testowy komentarz 3', '2017-01-08 17:24:18', '2017-01-08 17:24:18'),
(8, 13, 6, 'zjadłem dzisiaj sromotnika', '2017-01-08 18:12:42', '2017-01-08 18:12:42'),
(10, 13, 6, 'testowy kom', '2017-01-10 09:55:17', '2017-01-10 09:55:17'),
(11, 21, 6, 'test1', '2017-01-31 06:51:36', '2017-01-31 06:51:36'),
(12, 21, 6, 'test2', '2017-01-31 06:51:46', '2017-01-31 06:51:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `edtiable` int(11) NOT NULL DEFAULT '1',
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `user` tinyint(1) NOT NULL DEFAULT '0',
  `news` tinyint(1) NOT NULL DEFAULT '0',
  `comment` tinyint(1) NOT NULL DEFAULT '0',
  `forum` tinyint(1) NOT NULL DEFAULT '0',
  `access_token` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `group`
--

INSERT INTO `group` (`id_group`, `name`, `edtiable`, `administrator`, `user`, `news`, `comment`, `forum`, `access_token`) VALUES
(1, 'Użytkownik', 0, 1, 1, 1, 1, 1, '4e12a4bf886cfd62ed0282a52e748b6a'),
(2, 'Redaktor', 1, 1, 0, 1, 1, 0, 'c0b6efa5466c65faf88d7dea7a6f6825'),
(3, 'Moderator forum', 0, 1, 0, 0, 0, 1, 'c86eb00577f553c8aa460f4f1f718444'),
(4, 'Administrator', 0, 1, 1, 0, 0, 0, '835969b212b584d0449c09827cd16c86'),
(5, 'Właściciel', 0, 1, 1, 1, 1, 1, 'd992a025d12ae7579996555c52966600');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `short_text` text COLLATE utf8_unicode_ci NOT NULL,
  `long_text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modify` datetime NOT NULL,
  PRIMARY KEY (`id_news`),
  KEY `id_user` (`id_user`,`id_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `news`
--

INSERT INTO `news` (`id_news`, `id_user`, `id_category`, `title`, `short_text`, `long_text`, `date_create`, `date_modify`) VALUES
(6, 13, 2, 'Testowy', '<p>str</p>\r\n', '<p>str</p>\r\n', '2016-12-06 09:47:29', '2016-12-06 09:47:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_group` int(11) NOT NULL DEFAULT '1',
  `token` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `date_birth`, `date_create`, `id_group`, `token`) VALUES
(13, 'Testowy Właściciel', 'root@root.pl', '63a9f0ea7bb98050796b649e85481845', '2016-12-01', '2016-12-05 21:07:50', 5, 'adc767a20573978dcf753501c4e14530'),
(12, 'Testowy Administrator', 'admin@admin.pl', '21232f297a57a5a743894a0e4a801fc3', '2016-12-01', '2016-12-05 21:07:50', 4, 'e3344dcc3051012b29a00ed2072bad47'),
(11, 'Testowy Moderator', 'forum@forum.pl', 'bbdbe444288550204c968fe7002a97a9', '2016-12-01', '2016-12-05 21:07:50', 3, NULL),
(10, 'Testowy Redaktor', 'news@news.pl', '508c75c8507a2ae5223dfd2faeb98122', '2016-12-01', '2016-12-05 21:07:50', 2, 'd7633e1bd0ef690ff4e5ad3f508f1213'),
(9, 'Testowy Użytkownik', 'user@user.pl', 'ee11cbb19052e40b07aac0ca060c23ee', '2016-12-01', '2016-12-05 21:07:50', 1, 'cfe2e5a1915ad9c4d762cc759680fc96'),
(21, 'Tt RR', 'trak2016z@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', '0000-00-00', '2017-01-31 06:51:01', 1, 'e90930161d20495a3f3cb3286f239861');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
