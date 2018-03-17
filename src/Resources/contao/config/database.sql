--
-- Table `tl_bk_colonies`
--
CREATE TABLE `tl_bk_colonies` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `hive_number` varchar(32) NOT NULL default '',
  `hive_notice` varchar(32) NOT NULL default '',
  `breed` varchar(32) NOT NULL default '',
  `main_site` varchar(32) NOT NULL default '',
  `date` varchar(10) NOT NULL default '',
  `nativity_id` int(10) unsigned NOT NULL default '0',
  `nativity` varchar(128) NOT NULL default '',
  `notice` text NULL,
  `death` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_bk_hivemap`
--
CREATE TABLE `tl_bk_hivemap` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `date` varchar(10) NOT NULL default '',
  `description` text NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
