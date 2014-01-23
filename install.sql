SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `psm_events` (
  `title` tinytext NOT NULL COMMENT 'title of event, "@" if title should refer to `scenes` instead',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for the event',
  `loc` tinytext NOT NULL COMMENT 'location',
  `dtstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date of last revision',
  `dtstart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date when the event starts',
  `dtend` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date when the event ends',
  `userid` smallint(6) NOT NULL COMMENT 'ID of user who last revised, corresponds to `id` in cal_users',
  `comments` text NOT NULL COMMENT 'misc notes about event',
  `scenes` text NOT NULL COMMENT 'comma-separated list of scenes to be rehearsed',
  `allday` tinyint(1) NOT NULL COMMENT 'if 1, then start and end times are irrelevant',
  `showscenes` tinyint(1) NOT NULL COMMENT 'if true, scenes are visible in the event details',
  `status` tinyint(4) NOT NULL COMMENT '1=tentative, 2=confirmed, 3=cancelled',
  `other_roles` tinytext NOT NULL COMMENT 'IDs of roles being called that are not already included by the scenes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='stores calendar events' ;

CREATE TABLE IF NOT EXISTS `psm_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `scenes` text NOT NULL,
  `roletype` tinyint(4) NOT NULL COMMENT '1=cast, 2=crew',
  `showInScenes` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'should role be visible in scene breakdown?',
  `showInDirectory` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'should role be visible on the contact sheet?',
  `showInCalDropdown` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'should role be visible in the calendar''s roles dropdown?',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='stores roles (actors/whatever)' ;

CREATE TABLE IF NOT EXISTS `psm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `permission` int(11) NOT NULL COMMENT '0=normal, 1=edit events, 2=admin',
  `firstname` tinytext NOT NULL,
  `lastname` tinytext NOT NULL,
  `roles` tinytext NOT NULL,
  `phone_mobile` tinytext NOT NULL,
  `phone_home` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `theme` tinytext NOT NULL COMMENT 'stores custom theme colors',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `username` (`username`),
  FULLTEXT KEY `lastname` (`lastname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='stores people' ;

INSERT INTO `psm_users` (`id`, `username`, `password`, `permission`, `firstname`, `lastname`, `roles`, `phone_mobile`, `phone_home`, `email`, `theme`) VALUES (NULL, 'admin', 'stinger', '2', 'Admin', '', '', '', '', '', '@');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
