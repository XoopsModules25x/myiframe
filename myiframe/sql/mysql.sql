CREATE TABLE myiframe (
  frame_frameid int(8) NOT NULL auto_increment,
  frame_created int(10) unsigned NOT NULL default '0',
  frame_uid mediumint(8) unsigned NOT NULL default '0',
  frame_description varchar(255) NOT NULL default '',
  frame_width varchar(15) NOT NULL default '',
  frame_height varchar(15) NOT NULL default '',
  frame_align smallint(2) NOT NULL default '0',
  frame_frameborder smallint(3) NOT NULL default '0',
  frame_marginwidth smallint(3) NOT NULL default '0',
  frame_marginheight smallint(3) NOT NULL default '0',
  frame_scrolling smallint(1) NOT NULL default '0',
  frame_hits int(8) unsigned NOT NULL default '0',
  frame_url varchar(255) NOT NULL default '',
  PRIMARY KEY  (frame_frameid)
) ENGINE=MyISAM;
