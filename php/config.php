<?php
return array(
		'secrectKey'=>'',
		'accessKey'=>'',
		'domain'=>'',
		'bucket'=>'sunzheng',
		'dbhost'=>'127.0.0.1',
		'dbuser'=>'root',
		'dbpwd'=>'root',
		'dbname'=>'shagalaka',
		'table'=>'sh_temp_manager',
);

//临时图片管理表
/*CREATE TABLE IF NOT EXISTS `sh_temp_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL COMMENT '文件全路径',
  `time` bigint(20) unsigned NOT NULL COMMENT '时间',
  `key` varchar(255) NOT NULL,
  `bucket` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='临时文件上传记录表' AUTO_INCREMENT=4 ;
*/