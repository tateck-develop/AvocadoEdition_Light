<?
include_once('./_common.php');

// 권한 확인
if(!$is_admin) { 
	if($member['mb_id'] && $write['mb_id'] == $member['mb_id']) {
		exit;
	} else if ($member['mb_level'] < $board['bo_write_level']) {
		exit;
	}
}

sql_query("update {$g5['character_body_table']} set bd_use = '' where wr_id = '{$wr_id}'");
$bd = sql_fetch("select * from {$g5['character_body_table']} where bd_id = '{$bd_id}'");
if($bd['bd_id']) {
	$sql = " update {$g5['character_body_table']}
				set bd_use = '1'
				where bd_id = '{$bd['bd_id']}'";
	sql_query($sql);
}

?>