-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2014 at 05:36 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nudb`
--

-- --------------------------------------------------------

--
-- Table structure for table `posted_comments`
--

CREATE TABLE IF NOT EXISTS `posted_comments` (
  `comment_ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_ID` mediumint(8) unsigned NOT NULL,
  `user_ID` mediumint(8) unsigned NOT NULL,
  `comment_text` text NOT NULL,
  `posted_date` datetime NOT NULL,
  PRIMARY KEY (`comment_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `posted_comments`
--

INSERT INTO `posted_comments` (`comment_ID`, `topic_ID`, `user_ID`, `comment_text`, `posted_date`) VALUES
(1, 1, 4, 'asdfasdf', '2014-01-05 03:52:00'),
(2, 1, 4, 'another comment', '2014-01-05 04:00:40'),
(3, 1, 6, 'bobs comment', '2014-01-05 04:41:44'),
(4, 1, 6, 'another+bob%27s+comment', '2014-01-05 04:44:06'),
(5, 2, 6, 'bob%27s+comment', '2014-01-05 04:48:42'),
(6, 4, 4, 'mary+commented+something..+%21%21', '2014-01-05 09:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `user_ID` mediumint(8) unsigned NOT NULL,
  `role` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`user_ID`, `role`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 4),
(6, 4),
(7, 3),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `topic_ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(255) NOT NULL,
  `user_ID` mediumint(8) unsigned NOT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`topic_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_ID`, `topic_title`, `user_ID`, `created_date`) VALUES
(1, 'General Discussion', 1, '2013-12-27 16:00:36'),
(2, 'php sessions: using php''s isset function', 3, '2014-01-02 00:00:00'),
(3, 'A Dog of a Story: Why Kim Jong Un Probably Did Not Feed His Uncle to 120 ...', 3, '2013-12-25 00:00:00'),
(4, 'somethin', 7, '2014-01-05 06:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `topics_approved`
--

CREATE TABLE IF NOT EXISTS `topics_approved` (
  `topic_ID` mediumint(8) NOT NULL,
  `approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics_approved`
--

INSERT INTO `topics_approved` (`topic_ID`, `approved`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `topic_content`
--

CREATE TABLE IF NOT EXISTS `topic_content` (
  `content_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_ID` mediumint(8) unsigned NOT NULL,
  `content_type` smallint(4) unsigned NOT NULL,
  `content` text,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `topic_content`
--

INSERT INTO `topic_content` (`content_id`, `topic_ID`, `content_type`, `content`) VALUES
(1, 1, 1, 'Now that you are able to store and retrieve data from the $_SESSION array, we can explore some of the real functionality of sessions. When you create a variable and store it in a session, you probably want to use it in the future. However, before you use a session variable it is necessary that you check to see if it exists already!\r\n\r\nThis is where PHP''s isset function comes in handy. isset is a function that takes any variable you want to use and checks to see if it has been set. That is, it has already been assigned a value.\r\n\r\nWith our previous example, we can create a very simple pageview counter by using isset to check if the pageview variable has already been created. If it has we can increment our counter. If it doesn''t exist we can create a pageview counter and set it to one. Here is the code to get this job done:'),
(2, 1, 2, 'http://www.planet-source-code.com/vb/2010Redesign/images/LangugeHomePages/PHP.png'),
(3, 2, 1, 'Now that you are able to store and retrieve data from the $_SESSION array, we can explore some of the real functionality of sessions. When you create a variable and store it in a session, you probably want to use it in the future. However, before you use a session variable it is necessary that you check to see if it exists already!\r\n\r\nThis is where PHP''s isset function comes in handy. isset is a function that takes any variable you want to use and checks to see if it has been set. That is, it has already been assigned a value.\r\n\r\nWith our previous example, we can create a very simple pageview counter by using isset to check if the pageview variable has already been created. If it has we can increment our counter. If it doesn''t exist we can create a pageview counter and set it to one. Here is the code to get this job done:'),
(4, 3, 1, 'Kim Jong Un’s late uncle was “worse than a dog,” according to the blustery state media account of his purge. But was he killed by a pack of half-starved dogs?\r\n\r\nThat’s the claim of Beijing-linked Hong Kong newspaper, Wen Wei Po, which on Dec. 12 reported that the instead of being executed by a firing squad, as is typical, Jang was stripped naked, thrown in a cage with five of his associates, and devoured by 120 hounds as Kim Jong Un and 300 officials watched. The dogs preyed on the prisoners “until they were completely eaten up,” according to the Straits Times, a Singaporean newspaper, who picked up the story on Dec. 24.\r\n\r\n\r\n\r\nRead more: North Korea: Did Kim Jong Un Feed His Uncle to the Dogs? | TIME.com http://world.time.com/2014/01/03/a-dog-of-a-story-why-kim-jong-un-probably-did-not-feed-his-uncle-to-120-hounds/#ixzz2pMYK0XGb'),
(5, 4, 1, 'somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg somethingggg ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forename` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(18) NOT NULL,
  `password` varchar(90) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `forename`, `surname`, `username`, `password`) VALUES
(1, 'admin', 'test', 'admin@test727.com', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 'Fred', 'Smith', 'fred@test727.com', '31017a722665e4afce586950f42944a6d331dabf'),
(3, 'Anand', 'Ram', 'anand@test727.com', 'b973f774bfeab53233b4f347be114e9ca7b2d00f'),
(4, 'Mary', 'Simpson', 'mary@test727.com', '5665331b9b819ac358165f8c38970dc8c7ddb47d'),
(5, 'kiran', 'k', 'kiran@test727.com', '050989490f1fb728fd7e7866c9af0974d3d32470'),
(6, 'bob', 'marley', 'bob@test727.com', '48181acd22b3edaebc8a447868a7df7ce629920a'),
(7, 'michael', 'cobb', 'mic@test727.com', '17b9e1c64588c7fa6419b4d29dc1f4426279ba01'),
(8, 'sid', 'qwerty', 'sid@test727.com', 'da58b0c134ced9fa3847c7d85a083541cd9a0663'),
(9, 'asdf', 'asdfas', 'asdf@test727.com', 'asdfasdf');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
