<?php
$sub_menu = "100250";
include_once('./_common.php');

$sql_common = " co_html             = '1',
                co_tag_filter_use   = '0' ";

// -- 메인 정보 가져오기
$sql = " select co_id from {$g5['content_table']} where co_id = 'site_main' ";
$main_co = sql_fetch($sql);
if(!$main_co['co_id']) {
	// Insert
	$sql = " insert {$g5['content_table']}
				set co_id = 'site_main',
					co_content          = '{$main_content}',
					{$sql_common} ";
	sql_query($sql);
} else {
	// Update
	$sql = " update {$g5['content_table']}
				set co_content          = '{$main_content}',
					{$sql_common}
			  where co_id = 'site_main' ";
	sql_query($sql);
}


goto_url('./viewer_form.php', false);
?>