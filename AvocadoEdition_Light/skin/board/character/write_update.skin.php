<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once($board_skin_path.'/_setting.php');
// 두상 및 전신 저장 처리

$sql_article = " wr_ing = '{$wr_ing}',
				wr_4_txt = '{$wr_4_txt}',
                wr_5_txt = '{$wr_5_txt}',
                wr_6_txt = '{$wr_6_txt}',
                wr_7_txt = '{$wr_7_txt}',
                wr_8_txt = '{$wr_8_txt}',
                wr_9_txt = '{$wr_9_txt}',
                wr_10_txt = '{$wr_10_txt}'";


if($type == 'pair') {

	$sql_article .= " , wr_type = '{$type}'";

	// 이미지 등록
	// -- 배경
	if($wr_1 != $wr_1_prev && strpos($wr_1_prev, "{$bo_table}/pair_{$wr_id}_")) {
		// wr_1 값이 빈 값이 아니고 wr_1이 이전에 직접 등록한 데이터일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $wr_1_prev);
		@unlink($prev_file_path);
	}
	if($_FILES['wr_1_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['wr_1_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "pair_{$wr_id}_".time().".".$exp;
		upload_file($_FILES['wr_1_file']['tmp_name'], $image_name, $character_image_path);
		$wr_1 = $character_image_url."/".$image_name;
	}
	$sql_article .= " , wr_1 = '{$wr_1}'";

} else {
	// 이미지 등록
	// -- 두상
	if($wr_1 != $wr_1_prev && strpos($wr_1_prev, "{$bo_table}/header_{$wr_id}_")) {
		// wr_1 값이 빈 값이 아니고 wr_1이 이전에 직접 등록한 데이터일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $wr_1_prev);
		@unlink($prev_file_path);
	}
	if($_FILES['wr_1_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['wr_1_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "header_{$wr_id}_".time().".".$exp;
		upload_file($_FILES['wr_1_file']['tmp_name'], $image_name, $character_image_path);
		$wr_1 = $character_image_url."/".$image_name;
	}
	$sql_article .= " , wr_1 = '{$wr_1}'";

	// -- 전신
	if($wr_2 != $wr_2_prev && strpos($wr_2_prev, "{$bo_table}/body_{$wr_id}_")) {
		// wr_2 값이 빈 값이 아니고 wr_2이 이전에 직접 등록한 데이터일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $wr_2_prev);
		@unlink($prev_file_path);
	}
	if($_FILES['wr_2_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['wr_2_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "body_{$wr_id}_".time().".".$exp;
		upload_file($_FILES['wr_2_file']['tmp_name'], $image_name, $character_image_path);
		$wr_2 = $character_image_url."/".$image_name;
	}
	$sql_article .= " , wr_2 = '{$wr_2}'";
}


$sql = " update {$write_table}
			set {$sql_article}
		where wr_id = '{$wr_id}' ";
sql_query($sql);

?>
