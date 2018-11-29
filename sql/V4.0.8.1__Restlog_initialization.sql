
CREATE TABLE `restlog_auditlog` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(200) NOT NULL DEFAULT '',
  `method` varchar(10) NOT NULL DEFAULT '',
  `resource` varchar(250) NOT NULL DEFAULT '',
  `user` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `request_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time` int(11) DEFAULT 0,
  `request_len` int(11) DEFAULT 0,
  `response_len` int(11) DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `page_class_idx` (`tenant`,`user`),
  KEY `user_foreignkey_idx` (`user`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `restlog_restcount` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `rest_count` int(11) DEFAULT 0,
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
