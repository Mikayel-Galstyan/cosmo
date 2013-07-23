-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2013 at 01:05 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teeflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `status`) VALUES
(4, 'test_club', 1),
(5, 'fasdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `center` text NOT NULL,
  `width` int(4) NOT NULL DEFAULT '640',
  `height` int(4) NOT NULL DEFAULT '640',
  `location` text NOT NULL,
  `map_image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `club_id` (`club_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `club_id`, `name`, `center`, `width`, `height`, `location`, `map_image`, `status`) VALUES
(13, 4, 'test', '', 640, 640, 'null', '5483aa444c2d789799674f60d7cf71b4.png', 1),
(14, 5, 'xcvxcv', '', 640, 640, 'null', '24d27e3e8974546ab696a62337ef9734.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `polygon_id` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`),
  KEY `player_id_2` (`player_id`),
  KEY `polygon_id` (`polygon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holes`
--

CREATE TABLE IF NOT EXISTS `holes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `holes`
--

INSERT INTO `holes` (`id`, `course_id`, `name`, `order`) VALUES
(10, 13, 'hole_1', 0),
(11, 13, 'hole_2', 1),
(12, 13, 'hole_3', 2),
(13, 13, 'asdasd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `polygon_id` int(11) NOT NULL,
  `group` tinyint(1) NOT NULL DEFAULT '0',
  `players_count` int(3) NOT NULL DEFAULT '1',
  `players_id` varchar(512) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_polygon_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL,
  `avgtime` int(11) DEFAULT '0',
  `plygon_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `polygon_id` (`polygon_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `polygons`
--

CREATE TABLE IF NOT EXISTS `polygons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `hole_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:Tee-off-sector, 1:Fairway-sector, 2:Green-sector',
  `hole` text,
  `pois` text,
  `tops` text,
  `image_tops` text NOT NULL,
  `images` text COMMENT '{"240x320":"image_name","320x480":"image_name","480x800":"image_name","600x1024":"image_name","720x1280":"image_name","800x1280":"image_name","640x960":"image_name","640x1136":"image_name"}',
  `order` int(11) unsigned NOT NULL DEFAULT '0',
  `min_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'define time in seconds',
  `max_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'define time in seconds',
  PRIMARY KEY (`id`),
  KEY `graph_id` (`course_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1061 ;

--
-- Dumping data for table `polygons`
--

INSERT INTO `polygons` (`id`, `course_id`, `hole_id`, `name`, `type`, `hole`, `pois`, `tops`, `image_tops`, `images`, `order`, `min_time`, `max_time`) VALUES
(1053, 13, 10, 'polygon_1', 0, '[]', '[]', '{"1":{"lat":"85.423038","long":"4.895105"},"2":{"lat":"93.883792","long":"16.550117"},"3":{"lat":"75.942915","long":"13.228438"}}', '84.0000018,142.99999722,284.00000772,60.00000048,226.99999608,236.00000385', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1054, 13, 10, 'polygon_2', 0, '[]', '[]', '{"1":{"lat":"94.597350","long":"21.212121"},"2":{"lat":"95.208970","long":"32.167832"},"3":{"lat":"76.758410","long":"32.109557"},"4":{"lat":"76.044852","long":"20.104895"}}', '363.99999636,52.9999965,551.99999712,47.0000043,550.99999812,227.9999979,344.9999982,235.00000188', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1055, 13, 11, 'polygon_3', 0, '[]', '[]', '{"1":{"lat":"93.985729","long":"35.372960"},"2":{"lat":"93.781855","long":"46.853147"},"3":{"lat":"79.510703","long":"46.328671"},"4":{"lat":"79.306830","long":"36.072261"}}', '606.9999936,58.99999851,804.00000252,61.00000245,794.99999436,201.00000357,618.99999876,202.9999977', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1056, 13, 11, 'polygon_4', 0, '[]', '[]', '{"1":{"lat":"93.577982","long":"49.184149"},"2":{"lat":"93.679918","long":"58.682984"},"3":{"lat":"80.428135","long":"58.333333"},"4":{"lat":"79.510703","long":"48.601399"}}', '843.99999684,62.99999658,1007.00000544,62.00000442,1000.99999428,191.99999565,834.00000684,201.00000357', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1057, 13, 10, 'polygon_5', 0, '[]', '[]', '{"1":{"lat":"93.068298","long":"62.587413"},"2":{"lat":"93.781855","long":"71.736597"},"3":{"lat":"79.816514","long":"71.678322"},"4":{"lat":"79.510703","long":"62.354312"}}', '1074.00000708,67.99999662,1231.00000452,61.00000245,1230.00000552,197.99999766,1069.99999392,201.00000357', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1058, 13, 12, 'polygon_6', 0, '[]', '[]', '{"1":{"lat":"93.068298","long":"74.650350"},"2":{"lat":"92.762487","long":"82.226107"},"3":{"lat":"81.753313","long":"82.167832"},"4":{"lat":"81.447503","long":"74.825175"}}', '1281.000006,67.99999662,1410.99999612,71.00000253,1409.99999712,178.99999947,1284.000003,181.99999557', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1059, 13, 12, 'polygon_7', 0, '[]', '[]', '{"1":{"lat":"62.181448","long":"5.303030"},"2":{"lat":"62.793068","long":"10.606061"},"3":{"lat":"52.395515","long":"11.013986"},"4":{"lat":"51.172273","long":"4.836830"},"5":{"lat":"57.594292","long":"2.797203"}}', '90.9999948,370.99999512,182.00000676,365.00000292,188.99999976,466.99999785,83.0000028,479.00000187,48.00000348,415.99999548', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0),
(1060, 13, 12, 'polygon_8', 0, '[]', '[]', '{"1":{"lat":"62.793068","long":"18.822844"},"2":{"lat":"68.705403","long":"37.296037"},"3":{"lat":"41.896024","long":"25.815851"}}', '323.00000304,365.00000292,639.99999492,306.99999657,443.00000316,570.00000456', '{"240x320":"","320x480":"","480x800":"","600x1024":"","720x1280":"","800x1280":"","640x960":"","640x1136":""}', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `password` varchar(150) NOT NULL,
  `password_salt` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `last_name`, `first_name`, `date`, `password`, `password_salt`) VALUES
(1, 'admin', '', '', 'admin', '2011-04-19 11:51:02', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`polygon_id`) REFERENCES `polygons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `holes`
--
ALTER TABLE `holes`
  ADD CONSTRAINT `holes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `polygons`
--
ALTER TABLE `polygons`
  ADD CONSTRAINT `polygons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
