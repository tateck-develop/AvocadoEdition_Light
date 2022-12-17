<?php
$g5['emoticon_table'] = G5_TABLE_PREFIX.'emoticon';

@mkdir(G5_DATA_PATH.'/emoticon', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/emoticon', G5_DIR_PERMISSION);

// 이모티콘 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['emoticon_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['emoticon_table']}` (
		  `me_id` int(11) NOT NULL AUTO_INCREMENT,
		  `me_text` varchar(255) NOT NULL DEFAULT '',
		  `me_img` varchar(255) NOT NULL DEFAULT '',
		  PRIMARY KEY (`me_id`)
	) ", false);
}



?>