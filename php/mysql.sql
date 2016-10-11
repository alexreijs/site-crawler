-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 04 jul 2016 om 15:34
-- Serverversie: 5.5.46
-- PHP-Versie: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `site-crawler`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

--
-- Gegevens worden uitgevoerd voor tabel `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'Sanoma'),
(2, 'Improve Digital'),
(3, 'Google'),
(4, 'Krux'),
(5, 'AT Internet'),
(6, 'Adform'),
(7, 'Meetrics'),
(8, 'AdTech'),
(9, 'AdScience'),
(10, 'DoubleClick'),
(11, 'Yieldlab'),
(12, 'Mediaplex'),
(13, 'Falk Technologies'),
(14, 'TheTradeDesk'),
(15, 'Casale Media'),
(16, 'Media Innovation Group'),
(17, 'Skimlinks'),
(18, 'Rook Media'),
(19, 'SnapWidget (Instagram)'),
(20, 'RadiumOne'),
(21, 'RapLeaf (TowerData)'),
(22, 'Neustar Inc.'),
(23, 'SmartClip'),
(24, 'Tapad'),
(25, 'Vimeo'),
(26, 'Instansive (Instagram)'),
(27, 'Videoplaza'),
(28, 'Federated Media Publishing'),
(29, 'AdMeta AB'),
(30, 'Pulsepoint (Contextweb)'),
(31, 'PubMatic'),
(32, 'StickyAds'),
(33, 'Flxpxl'),
(34, 'Criteo'),
(35, 'Rubicon'),
(36, 'Bidswitch'),
(37, 'ScoreCard Research'),
(38, 'Sizmek'),
(39, 'OpenX'),
(40, 'AppNexus'),
(41, 'Delta Projects'),
(42, 'Weborama'),
(43, 'Lotame'),
(44, 'Sitestat (ComScore)'),
(45, 'New Relic'),
(46, 'LiveRail'),
(47, 'Media Optimizer (Adobe)'),
(48, 'AdScale'),
(49, 'Internet Billboard'),
(50, 'Datalogix'),
(51, 'BidTheatre'),
(52, 'LiveChat Inc.'),
(53, 'Digilant'),
(54, 'Adap.tv'),
(55, 'AddThis'),
(56, 'ShareThis'),
(57, 'Neustar AdAdvisor'),
(58, 'Yahoo'),
(59, 'Dotomi'),
(60, 'Eyeota'),
(61, 'Adrime (Weborama)'),
(62, 'AudienceScience'),
(63, 'Platform 161'),
(64, 'IPONWEB'),
(65, 'Bing'),
(66, 'Spotify'),
(67, 'SMART Advserver'),
(68, 'SpotXchange'),
(69, 'MediaMath'),
(70, 'Yieldr'),
(71, 'Adlantic'),
(72, 'BARB'),
(73, 'Pinterest'),
(74, 'Turn Inc.'),
(75, 'Youtube'),
(76, 'Twitter'),
(77, 'Brightcrove'),
(78, 'Chartbeat'),
(79, 'Google Analytics'),
(80, 'Google Adsense'),
(81, 'Visual Website Optimizer'),
(82, 'Sanoma Consent Manager'),
(83, 'Bluekai'),
(84, 'RFI Hub'),
(85, 'Media6Degrees'),
(86, 'AdSymptotic'),
(87, 'Twimg'),
(88, 'MSN'),
(89, 'Ligatus'),
(90, 'Blog Lovin'),
(91, 'AddToAny'),
(92, 'Monsterboard'),
(93, 'Gigya'),
(94, 'InterCom'),
(95, 'PageFair'),
(96, 'Site-owned'),
(97, 'Optimizely'),
(98, 'Sanoma Adblock Checker'),
(99, 'Google Adwords'),
(100, 'Hotjar'),
(101, 'Facebook Connect'),
(102, 'Sprinkle'),
(103, 'Blendle'),
(104, 'Instragram');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `consent_types`
--

CREATE TABLE IF NOT EXISTS `consent_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `consent_types`
--

INSERT INTO `consent_types` (`id`, `type`) VALUES
(1, 'stats'),
(2, 'ads'),
(3, 'interests'),
(4, 'social'),
(5, 'videoplaza'),
(6, 'functional');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL,
  `url` text NOT NULL,
  `cookie_consent` int(1) NOT NULL,
  `screenshots` int(1) NOT NULL,
  `cookies` int(1) NOT NULL,
  `resources` int(1) NOT NULL,
  `banners` int(1) NOT NULL,
  `errors` int(1) NOT NULL,
  `libraries` int(1) NOT NULL,
  `deeplinks` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `jobs`
--

INSERT INTO `jobs` (`id`, `date`, `status`, `url`, `cookie_consent`, `screenshots`, `cookies`, `resources`, `banners`, `errors`, `libraries`, `deeplinks`) VALUES
(1, '2016-07-04 15:31:56', 2, 'http://www.nu.nl;http://www.startpagina.nl;http://www.kijk.nl', 1, 0, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `consent_type_id` int(11) NOT NULL,
  `operator` int(11) NOT NULL,
  `priority` int(5) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Gegevens worden uitgevoerd voor tabel `rules`
--

INSERT INTO `rules` (`id`, `location`, `name`, `company_id`, `consent_type_id`, `operator`, `priority`, `type`) VALUES
(1, 'krx', '', 4, 3, 1, 1, '1'),
(2, 'xiti', '', 5, 1, 1, 1, '1'),
(3, 'adform', '', 6, 2, 1, 1, '1'),
(4, 'meetrics', '', 7, 1, 1, 1, '1'),
(5, 'adtech', '', 8, 2, 1, 1, '1'),
(6, 'adscience', '', 9, 2, 1, 1, '1'),
(7, 'doubleclick', '', 10, 2, 1, 1, '1'),
(8, 'yieldlab', '', 11, 2, 1, 1, '1'),
(9, 'mediaplex', '', 12, 2, 1, 1, '1'),
(10, 'angsrvr', '', 13, 2, 1, 1, '1'),
(11, 'adsrvr', '', 14, 2, 1, 1, '1'),
(12, 'casalemedia', '', 15, 2, 1, 1, '1'),
(13, 'mookie1', '', 16, 2, 1, 1, '1'),
(14, 'skimresources', '', 17, 2, 1, 1, '1'),
(15, 'rifhub', '', 18, 2, 1, 1, '1'),
(16, 'snapwidget', '', 19, 4, 1, 1, '1'),
(17, 'gwallet', '', 20, 2, 1, 1, '1'),
(18, 'rlcdn', '', 21, 1, 1, 1, '1'),
(19, 'agkn.com', '', 22, 3, 1, 1, '1'),
(20, 'smartclip', '', 23, 2, 1, 1, '1'),
(21, 'tapad', '', 24, 2, 1, 1, '1'),
(22, 'vimeo', '', 25, 2, 1, 1, '1'),
(23, 'instansive', '', 26, 4, 1, 1, '1'),
(24, 'videoplaza', '', 27, 5, 1, 1, '1'),
(25, 'lijit', '', 28, 2, 1, 1, '1'),
(26, 'atemda', '', 29, 2, 1, 1, '1'),
(27, 'contextweb', '', 30, 2, 1, 1, '1'),
(28, 'pubmatic', '', 31, 2, 1, 1, '1'),
(29, 'stickyadstv', '', 32, 2, 1, 1, '1'),
(30, 'flx1', '', 33, 3, 1, 1, '1'),
(31, 'criteo', '', 34, 2, 1, 1, '1'),
(32, 'rubiconproject', '', 35, 2, 1, 1, '1'),
(33, 'bidswitch', '', 36, 2, 1, 1, '1'),
(34, 'scorecardresearch', '', 37, 1, 1, 1, '1'),
(35, 'serving-sys', '', 38, 2, 1, 1, '1'),
(36, 'openx', '', 39, 2, 1, 1, '1'),
(37, 'adnxs.com', '', 40, 2, 1, 1, '1'),
(38, 'de17a', '', 41, 2, 1, 1, '1'),
(39, 'weborama', '', 42, 2, 1, 1, '1'),
(40, 'crwdcntrl', '', 43, 1, 1, 1, '1'),
(41, 'sitestat.com', '', 44, 1, 1, 1, '1'),
(42, 'nr-data', '', 45, 1, 1, 1, '1'),
(43, 'liverail', '', 46, 2, 1, 1, '1'),
(44, 'demdex', '', 47, 2, 1, 1, '1'),
(45, 'adscale', '', 48, 2, 1, 1, '1'),
(46, 'ibillboard', '', 49, 2, 1, 1, '1'),
(47, 'nexac', '', 50, 2, 1, 1, '1'),
(48, 'bidtheatre', '', 51, 2, 1, 1, '1'),
(49, 'livechatinc', '', 52, 6, 1, 1, '1'),
(50, 'wtp101', '', 53, 2, 1, 1, '1'),
(51, 'adaptv', '', 54, 2, 1, 1, '1'),
(52, 'addthis', '', 55, 4, 1, 1, '1'),
(53, 'sharethis', '', 56, 4, 1, 1, '1'),
(54, 'adadvisor', '', 57, 3, 1, 1, '1'),
(55, 'yahoo', '', 58, 2, 1, 1, '1'),
(56, 'dotomi', '', 59, 2, 1, 1, '1'),
(57, 'eyeota', '', 60, 2, 1, 1, '1'),
(58, 'adrcntr', '', 61, 2, 1, 1, '1'),
(59, 'revsci', '', 62, 2, 1, 1, '1'),
(60, 'creative-serving', '', 63, 2, 1, 1, '1'),
(61, 'bidswitch', '', 64, 2, 1, 1, '1'),
(62, 'bing.com', '', 65, 4, 1, 1, '1'),
(63, 'spotify.com', '', 66, 4, 1, 1, '1'),
(64, 'smartadserver', '', 67, 2, 1, 1, '1'),
(65, 'spotxchange', '', 68, 2, 1, 1, '1'),
(66, 'mathtag', '', 69, 2, 1, 1, '1'),
(67, '254a', '', 70, 2, 1, 1, '1'),
(68, 'ad-serverparc', '', 71, 2, 1, 1, '1'),
(69, '2cnt.net', '', 72, 3, 1, 1, '1'),
(70, 'pinterest', '', 73, 4, 1, 1, '1'),
(71, 'turn', '', 74, 2, 1, 1, '1'),
(72, 'youtube', '', 75, 4, 1, 1, '1'),
(73, 'twitter', '', 76, 4, 1, 1, '1'),
(74, '360yield.com', '', 2, 2, 1, 1, '1'),
(75, 'google.com', '', 3, 2, 1, 1, '1'),
(76, '', '^__insp_', 77, 2, 1, 1, '1'),
(77, '', 'chartbeat', 78, 1, 1, 1, '1'),
(78, '', '(session|sess|ss)-?id', 96, 6, 1, 1, '1'),
(79, '', 'SanomaWeb', 96, 6, 1, 1, '1'),
(80, '', 'sanoma', 1, 2, 1, 10, '1'),
(81, '', '^__utm[a-z]{1}', 79, 1, 1, 1, '1'),
(82, '', '^_gat?', 79, 1, 1, 1, '1'),
(83, '', '^__gads', 80, 2, 1, 1, '1'),
(84, '', '^_vis_opt', 81, 1, 1, 1, '1'),
(85, '', 'consentBarViewCount', 82, 6, 1, 1, '1'),
(86, '', 'site_consent', 82, 6, 1, 1, '1'),
(87, 'bluekai', '', 83, 3, 1, 1, '1'),
(88, 'rfihub', '', 84, 2, 1, 1, '1'),
(89, 'media6degrees', '', 85, 3, 1, 1, '1'),
(90, 'adsymptotic', '', 86, 2, 1, 1, '1'),
(91, 'twimg', '', 87, 4, 1, 1, '1'),
(92, 'msn', '', 88, 2, 1, 1, '1'),
(93, 'ligatus', '', 89, 2, 1, 1, '1'),
(94, 'bloglovin', '', 90, 4, 1, 1, '1'),
(95, 'addtoany', '', 91, 4, 1, 1, '1'),
(96, 'cookie.monster', '', 92, 3, 1, 1, '1'),
(97, 'gigya', '', 93, 3, 1, 1, '1'),
(98, 'intercomcdn', '', 94, 3, 1, 1, '1'),
(99, 'pagefair', '', 95, 1, 1, 1, '1'),
(100, '', '^optimizely', 97, 1, 1, 1, '1'),
(101, 'cts\\.snmmd\\.nl\\/lib\\/js\\/advertising\\.js', '', 98, 2, 1, 1, '2'),
(102, 'googleadservices.com/pagead/conversion.js', '', 99, 2, 1, 1, '2'),
(103, 'hotjar', '', 100, 1, 1, 1, '2'),
(104, 'adform', '', 6, 2, 1, 1, '2'),
(105, 'ytimg', '', 75, 4, 1, 1, '2'),
(106, 'youtube', '', 75, 4, 1, 1, '2'),
(107, 'visualwebsiteoptimizer.com', '', 81, 1, 1, 1, '2'),
(108, 'connect.facebook.net', '', 101, 3, 1, 1, '2'),
(109, 'sprinkle', '', 102, 2, 1, 1, '2'),
(110, 'twitter', '', 76, 4, 1, 1, '2'),
(111, 'blendle', '', 103, 3, 1, 1, '2'),
(112, 'instagram', '', 104, 4, 1, 1, '2'),
(113, '\\/consent\\.js', '', 82, 6, 1, 1, '2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

