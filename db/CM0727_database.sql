SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_ID` mediumint(8) unsigned NOT NULL auto_increment,
  `forename` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(18) NOT NULL,
  `password` varchar(90) NOT NULL,
  PRIMARY KEY  (`user_ID`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

 -- NOTE that the password field uses SHA1 encryption, the password for the admin user here is set to
-- the word 'admin' (in lowercase) then converted to SHA1. When logging in you'll need to do a similar
-- conversion to check for equality.  You can do this either by converting in php and then
-- just testing or in your sql using something like: WHERE PASSWORD = sha1( 'admin' )

INSERT INTO users(`forename`,`surname`, `username`, `password`)
 VALUES ('admin', 'test','admin@test727.com','d033e22ae348aeb5660fc2140aec35850c4da997'); 
 
INSERT INTO users(`forename`,`surname`, `username`, `password`)
 VALUES ('Fred', 'Smith','fred@test727.com','31017a722665e4afce586950f42944a6d331dabf'); 
 
INSERT INTO users(`forename`,`surname`, `username`, `password`)
 VALUES ('Anand', 'Ram','anand@test727.com','b973f774bfeab53233b4f347be114e9ca7b2d00f');
 
INSERT INTO users(`forename`,`surname`, `username`, `password`)
 VALUES ('Mary', 'Simpson','mary@test727.com','5665331b9b819ac358165f8c38970dc8c7ddb47d');
 
--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `topic_ID` mediumint(8) unsigned NOT NULL auto_increment, 
  `topic_title` varchar(255) NOT NULL,
  `user_ID` mediumint(8) unsigned NOT NULL REFERENCES users,
  `created_date` datetime,
  PRIMARY KEY  (`topic_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO topics(`topic_title`, `user_ID`,  `created_date`) VALUES ('General Discussion',1,sysdate());
-- --------------------------------------------------------
 
--
-- Table structure for table `posted_comments`
--

DROP TABLE IF EXISTS `posted_comments`;
CREATE TABLE IF NOT EXISTS `posted_comments` (
  `comment_ID` mediumint(8) unsigned NOT NULL auto_increment, 
  `topic_ID` mediumint(8) unsigned NOT NULL REFERENCES topics, 
  `user_ID` mediumint(8) unsigned NOT NULL REFERENCES users,
  `comment_text` text NOT NULL, 
  `posted_date` datetime NOT NULL,
  PRIMARY KEY  (`comment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP table if EXISTS `topic_content`;
CREATE TABLE `topic_content`(
  `content_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_ID` mediumint(8) unsigned NOT NULL REFERENCES topics,
  `content_type` smallint(4) unsigned NOT NULL,
  `content` text,
  PRIMARY KEY (`content_id`)
)
