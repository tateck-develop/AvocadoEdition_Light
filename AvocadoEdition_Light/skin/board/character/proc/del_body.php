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

$update_href = true;

// 삭제 원하는 DB 정보 가져오기
$bd = sql_fetch("select * from {$g5['character_body_table']} where bd_id = '{$bd_id}'");
if($bd['bd_url']) {
	$prev_file_path = str_replace(G5_URL, G5_PATH, $bd['bd_url']);
	@unlink($prev_file_path);

	$sql = "delete from {$g5['character_body_table']} where bd_id = '{$bd_id}'";
	sql_query($sql);
}

include($board_skin_path."/view_body.skin.php");

?>