DROP TABLE IF EXISTS `#__gk2_photoslide_groups`;
DROP TABLE IF EXISTS `#__gk2_photoslide_slides`;
DROP TABLE IF EXISTS `#__gk2_photoslide_plugins`;
DROP TABLE IF EXISTS `#__gk2_photoslide_extensions`;

CREATE TABLE `#__gk2_photoslide_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `plugin` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__gk2_photoslide_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `status` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `phpclassfile` varchar(255) NOT NULL,
  `version` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `desc` mediumtext NOT NULL,
  `gfields` mediumtext NOT NULL,
  `sfields` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__gk2_photoslide_slides` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `published` int(1) NOT NULL,
  `access` int(1) NOT NULL,
  `file` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__gk2_photoslide_extensions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `status` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `phpclassfile` varchar(255) NOT NULL,
  `version` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `desc` mediumtext NOT NULL,
  `storage` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;