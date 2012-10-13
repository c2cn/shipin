SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS ff_admin (
  admin_id smallint(6) unsigned NOT NULL auto_increment,
  admin_name varchar(50) NOT NULL,
  admin_pwd char(32) NOT NULL,
  admin_count smallint(6) NOT NULL,
  admin_ok varchar(50) NOT NULL,
  admin_del bigint(1) NOT NULL,
  admin_ip varchar(40) NOT NULL,
  admin_email varchar(40) NOT NULL,
  admin_logintime int(11) NOT NULL,
  PRIMARY KEY  (admin_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO ff_admin (admin_id, admin_name, admin_pwd, admin_count, admin_ok, admin_del, admin_ip, admin_email, admin_logintime) VALUES
(1, 'admin', '7fef6171469e80d32c0559f88b377245', 0, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 0, '127.0.0.1', 'admin@qq.com', 1311954804);


CREATE TABLE IF NOT EXISTS ff_ads (
  ads_id smallint(4) unsigned NOT NULL auto_increment,
  ads_name varchar(50) NOT NULL,
  ads_content text NOT NULL,
  PRIMARY KEY  (ads_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ff_ads` (`ads_id`, `ads_name`, `ads_content`) VALUES
(1, 'play300', '扩展工具>网站广告管理>play300'),
(2, 'list300', '扩展工具>网站广告管理>list300'),
(3, 'vod960', '扩展工具>网站广告管理>vod960'),
(4, 'vod300', '扩展工具>网站广告管理>vod300'),
(5, 'top960', '扩展工具>网站广告管理>top960'),
(6, 'play960', '扩展工具>网站广告管理>play960'),
(7, 'index960', '扩展工具>网站广告管理>index960');


CREATE TABLE IF NOT EXISTS ff_cm (
  cm_id mediumint(8) unsigned NOT NULL auto_increment,
  cm_cid mediumint(9) NOT NULL,
  cm_sid tinyint(1) NOT NULL default '1',
  cm_uid mediumint(9) NOT NULL default '1',
  cm_content text NOT NULL,
  cm_up mediumint(9) NOT NULL default '0',
  cm_down mediumint(9) NOT NULL default '0',
  cm_ip varchar(20) NOT NULL,
  cm_addtime int(11) NOT NULL,
  cm_status tinyint(1) NOT NULL default '0',
  PRIMARY KEY cm_id (cm_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS ff_collect (
  collect_id smallint(6) unsigned NOT NULL auto_increment,
  collect_title varchar(50) NOT NULL,
  collect_encoding varchar(10) NOT NULL,
  collect_player varchar(50) NOT NULL,
  collect_savepic tinyint(4) NOT NULL,
  collect_order tinyint(4) NOT NULL,
  collect_pagetype tinyint(4) NOT NULL,
  collect_liststr text NOT NULL,
  collect_pagestr text NOT NULL,
  collect_pagesid smallint(6) unsigned NOT NULL,
  collect_pageeid smallint(6) unsigned NOT NULL,
  collect_listurlstr text NOT NULL,
  collect_listlink text NOT NULL,
  collect_listpicstr text NOT NULL,
  collect_cid text NOT NULL,
  collect_listname text NOT NULL,
  collect_name text NOT NULL,
  collect_actor text NOT NULL,
  collect_director text NOT NULL,
  collect_content text NOT NULL,
  collect_pic text NOT NULL,
  collect_area text NOT NULL,
  collect_language text NOT NULL,
  collect_year text NOT NULL,
  collect_continu text NOT NULL,
  collect_urlstr text NOT NULL,
  collect_urlname text NOT NULL,
  collect_urllink text NOT NULL,
  collect_url text NOT NULL,
  collect_replace text NOT NULL,
  PRIMARY KEY  (collect_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS ff_gb (
  gb_id mediumint(8) unsigned NOT NULL auto_increment,
  gb_cid mediumint(8) NOT NULL default '0',
  gb_uid mediumint(9) NOT NULL default '1',
  gb_content text NOT NULL,
  gb_intro text NOT NULL,
  gb_addtime int(11) NOT NULL,
  gb_ip varchar(20) NOT NULL,
  gb_oid tinyint(1) NOT NULL default '0',
  gb_status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (gb_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS ff_link (
  link_id tinyint(4) unsigned NOT NULL auto_increment,
  link_name varchar(255) NOT NULL,
  link_logo varchar(255) NOT NULL,
  link_url varchar(255) NOT NULL,
  link_order tinyint(4) NOT NULL,
  link_type tinyint(1) NOT NULL,
  PRIMARY KEY  (link_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO ff_link (link_id, link_name, link_logo, link_url, link_order, link_type) VALUES
(1, '飞飞影视系统', 'http://', 'http://www.ff84.com', 1, 1),
(2, '电影网站导航', 'http://', 'http://www.8090bo.com', 2, 2);

CREATE TABLE IF NOT EXISTS ff_list (
  list_id smallint(6) unsigned NOT NULL auto_increment,
  list_pid smallint(3) NOT NULL,
  list_oid smallint(3) NOT NULL,
  list_sid tinyint(1) NOT NULL,
  list_name char(20) NOT NULL,
  list_skin char(20) NOT NULL,
  list_dir varchar(90) NOT NULL,
  list_status tinyint(1) NOT NULL default '1',
  list_keywords varchar(255) NOT NULL,
  list_title varchar(50) NOT NULL,
  list_description varchar(255) NOT NULL,
  list_jumpurl varchar(150) NOT NULL,
  PRIMARY KEY  (list_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO ff_list (list_id, list_pid, list_oid, list_sid, list_name, list_skin, list_dir, list_status, list_keywords, list_title, list_description, list_jumpurl) VALUES
(23, 0, 23, 2, '新闻资讯', 'pp_newslist', 'xinwenzixun', 1, '', '', '', ''),
(22, 0, 20, 1, '纪录片', 'pp_vodlist', 'jilupian', 0, '', '', '', ''),
(19, 2, 19, 1, '海外剧', 'pp_vodlist', 'haiwaiju', 1, '', '', '', ''),
(18, 2, 18, 1, '日韩剧', 'pp_vodlist', 'ribenju', 1, '', '', '', ''),
(17, 2, 17, 1, '欧美剧', 'pp_vodlist', 'oumeiju', 1, '', '', '', ''),
(16, 2, 16, 1, '港台剧', 'pp_vodlist', 'xianggangju', 1, '', '', '', ''),
(15, 2, 15, 1, '国产剧', 'pp_vodlist', 'guochanju', 1, '', '', '', ''),
(14, 1, 14, 1, '剧情片', 'pp_vodlist', 'juqingpian', 1, '', '', '', ''),
(13, 1, 13, 1, '战争片', 'pp_vodlist', 'zhanzhengpian', 1, '', '', '', ''),
(12, 1, 12, 1, '恐怖片', 'pp_vodlist', 'kongbupian', 1, '', '', '', ''),
(11, 1, 11, 1, '科幻片', 'pp_vodlist', 'kehuanpian', 1, '', '', '', ''),
(10, 1, 10, 1, '爱情片', 'pp_vodlist', 'aiqingpian', 1, '', '', '', ''),
(9, 1, 9, 1, '喜剧片', 'pp_vodlist', 'xijupian', 1, '', '', '', ''),
(8, 1, 8, 1, '动作片', 'pp_vodlist', 'dongzuopian', 1, '', '', '', ''),
(7, 0, 7, 1, '音乐', 'pp_vodlist', 'yinle', 0, '', '', '', ''),
(6, 0, 6, 1, '游戏', 'pp_vodlist', 'youxi', 0, '', '', '', ''),
(5, 0, 5, 1, '体育', 'pp_vodlist', 'tiyu', 0, '', '', '', ''),
(4, 0, 4, 1, '综艺其它', 'pp_vodlist', 'zongyi', 1, '', '', '', 'http://'),
(3, 0, 3, 1, '动漫', 'pp_vodlist', 'dongman', 1, '', '', '', ''),
(2, 0, 1, 1, '电视剧', 'pp_vodchannel', 'dianshiju', 1, '', '', '', ''),
(1, 0, 2, 1, '电影', 'pp_vodchannel', 'dianying', 1, '', '', '', '');


CREATE TABLE IF NOT EXISTS ff_news (
  news_id mediumint(8) unsigned NOT NULL auto_increment,
  news_cid smallint(6) NOT NULL default '0',
  news_name varchar(255) NOT NULL,
  news_keywords varchar(255) NOT NULL,
  news_color char(8) NOT NULL,
  news_pic varchar(255) NOT NULL,
  news_inputer varchar(50) NOT NULL,
  news_reurl varchar(255) NOT NULL,
  news_remark text NOT NULL,
  news_content text NOT NULL,
  news_hits mediumint(8) NOT NULL,
  news_hits_day mediumint(8) NOT NULL,
  news_hits_week mediumint(8) NOT NULL,
  news_hits_month mediumint(8) NOT NULL,
  news_hits_lasttime int(11) NOT NULL,
  news_stars tinyint(1) NOT NULL,
  news_status tinyint(1) NOT NULL default '1',
  news_up mediumint(8) NOT NULL,
  news_down mediumint(8) NOT NULL,
  news_jumpurl varchar(255) NOT NULL,
  news_letter char(2) NOT NULL,
  news_addtime int(8) NOT NULL,
  news_skin varchar(30) NOT NULL,
  news_gold decimal(3,1) NOT NULL,
  news_golder smallint(6) NOT NULL,
  PRIMARY KEY  (news_id),
  KEY news_cid (news_cid),
  KEY news_up (news_up),
  KEY news_down (news_down),
  KEY news_gold (news_gold),
  KEY news_hits (news_hits,news_cid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS ff_slide (
  slide_id tinyint(3) unsigned NOT NULL auto_increment,
  slide_oid tinyint(3) NOT NULL,
  slide_name varchar(255) NOT NULL,
  slide_pic varchar(255) NOT NULL,
  slide_url varchar(255) NOT NULL,
  slide_content varchar(255) NOT NULL,
  slide_status tinyint(1) NOT NULL,
  PRIMARY KEY  (slide_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS ff_special (
  special_id mediumint(8) unsigned NOT NULL auto_increment,
  special_banner varchar(150) NOT NULL,
  special_logo varchar(150) NOT NULL,
  special_name varchar(150) NOT NULL,
  special_keywords varchar(150) NOT NULL,
  special_description varchar(255) NOT NULL,
  special_color char(8) NOT NULL,
  special_skin varchar(50) NOT NULL,
  special_addtime int(11) NOT NULL,
  special_hits mediumint(8) NOT NULL,
  special_hits_day mediumint(8) NOT NULL,
  special_hits_week mediumint(8) NOT NULL,
  special_hits_month mediumint(8) NOT NULL,
  special_hits_lasttime int(11) NOT NULL,
  special_stars tinyint(1) NOT NULL default '1',
  special_status tinyint(1) NOT NULL,
  special_content text NOT NULL,
  special_up mediumint(8) NOT NULL,
  special_down mediumint(8) NOT NULL,
  special_gold decimal(3,1) NOT NULL,
  special_golder smallint(6) NOT NULL,
  PRIMARY KEY  (special_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS ff_topic (
  topic_did mediumint(9) NOT NULL,
  topic_tid smallint(6) NOT NULL,
  topic_sid tinyint(1) NOT NULL,
  topic_oid smallint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ff_tag (
  tag_id mediumint(8) NOT NULL,
  tag_sid tinyint(1) NOT NULL,
  tag_name varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ff_user (
  user_id mediumint(8) unsigned NOT NULL auto_increment,
  user_name varchar(50) NOT NULL,
  user_pwd char(32) NOT NULL,
  user_money mediumint(9) NOT NULL,
  user_staus tinyint(1) NOT NULL default '1',
  user_pay tinyint(1) NOT NULL,
  user_question varchar(50) NOT NULL,
  user_answer varchar(50) NOT NULL,
  user_type tinyint(1) NOT NULL,
  user_logip varchar(16) NOT NULL,
  user_lognum smallint(5) NOT NULL default '1',
  user_logtime int(10) NOT NULL,
  user_joinip varchar(16) NOT NULL,
  user_jointime int(10) NOT NULL,
  user_duetime int(10) NOT NULL,
  user_qq varchar(20) NOT NULL,
  user_email varchar(50) NOT NULL,
  user_face varchar(50) NOT NULL,
  PRIMARY KEY  (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO ff_user (user_id, user_name, user_pwd, user_money, user_staus, user_pay, user_question, user_answer, user_type, user_logip, user_lognum, user_logtime, user_joinip, user_jointime, user_duetime, user_qq, user_email, user_face) VALUES
(1, '游客', 'bdadsfsaewtgsdgfdsghdsafsa', 1, 1, 1, '1', '1', 1, '127.0.0.1', 1, 1, '127.0.0.1', 12345678, 12345678, '10000', '10000@qq.com', '');

CREATE TABLE IF NOT EXISTS ff_view (
  view_id mediumint(8) unsigned NOT NULL auto_increment,
  view_did mediumint(8) NOT NULL,
  view_uid mediumint(8) NOT NULL,
  view_addtime int(10) NOT NULL,
  PRIMARY KEY  (view_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS ff_vod (
  vod_id mediumint(8) unsigned NOT NULL auto_increment,
  vod_cid smallint(6) NOT NULL default '0',
  vod_name varchar(255) NOT NULL,
  vod_title varchar(255) NOT NULL,
  vod_keywords varchar(255) NOT NULL,
  vod_color char(8) NOT NULL,
  vod_actor varchar(255) NOT NULL,
  vod_director varchar(255) NOT NULL,
  vod_content text NOT NULL,
  vod_pic varchar(255) NOT NULL,
  vod_area char(10) NOT NULL,
  vod_language char(10) NOT NULL,
  vod_year smallint(4) NOT NULL,
  vod_continu varchar(20) NOT NULL default '0',
  vod_addtime int(11) NOT NULL,
  vod_hits mediumint(8) NOT NULL default '0',
  vod_hits_day mediumint(8) NOT NULL,
  vod_hits_week mediumint(8) NOT NULL,
  vod_hits_month mediumint(8) NOT NULL,
  vod_hits_lasttime int(11) NOT NULL,
  vod_stars tinyint(1) NOT NULL default '0',
  vod_status tinyint(1) NOT NULL default '1',
  vod_up mediumint(8) NOT NULL default '0',
  vod_down mediumint(8) NOT NULL default '0',
  vod_play varchar(255) NOT NULL,
  vod_server varchar(255) NOT NULL,
  vod_url longtext NOT NULL,
  vod_inputer varchar(30) NOT NULL,
  vod_reurl varchar(255) NOT NULL,
  vod_jumpurl varchar(150) NOT NULL,
  vod_letter char(2) NOT NULL,
  vod_skin varchar(30) NOT NULL,
  vod_gold decimal(3,1) NOT NULL,
  vod_golder smallint(6) NOT NULL,
  PRIMARY KEY  (vod_id),
  KEY vod_cid (vod_cid),
  KEY vod_up (vod_up),
  KEY vod_down (vod_down),
  KEY vod_addtime (vod_addtime,vod_cid),
  KEY vod_hits (vod_hits,vod_cid),
  KEY vod_gold (vod_gold)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;