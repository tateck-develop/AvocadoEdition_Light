<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$character_image_path = G5_DATA_PATH."/file/".$bo_table;
$character_image_url = G5_DATA_URL."/file/".$bo_table;

@mkdir($character_image_path, G5_DIR_PERMISSION);
@chmod($character_image_path, G5_DIR_PERMISSION);


$version = "1.1";
$g5['character_body_table'] = G5_TABLE_PREFIX.'board_ch_body';
if(!sql_query(" DESC {$g5['character_body_table']} ")) {
	// 전신 이미지 저장하는 테이블이 생성되어 있지 않을 경우
	// 테이블을 생성합니다.

	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['character_body_table']}` (
		`bd_id` int(11) NOT NULL AUTO_INCREMENT,
		`bo_table` varchar(255) NOT NULL default '',
		`wr_id` int(11) NOT NULL default '0',
		`bd_url` varchar(255) NOT NULL default '',
		`bd_use` int(11) NOT NULL default '0',
		PRIMARY KEY (`bd_id`)
	) ", false);
}