<?
include_once('./_common.php');

if(!$is_admin) alert("권한이 없습니다.");

if ($_POST['act_button'] == "등록") {
	if ($img = $_FILES['me_img']['name']) {
		if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
			alert("이모티콘 이미지가 gif, jpg, png 파일이 아닙니다.");
		} else {
			$emoticon_path = G5_DATA_PATH.'/emoticon';
			$emoticon_image_code = time();
			$emoticon_image_path = "{$emoticon_path}/{$emoticon_image_code}";
			$emoticon_image_url = "/data/emoticon/{$emoticon_image_code}";

			move_uploaded_file($_FILES['me_img']['tmp_name'], $emoticon_image_path);
			chmod($emoticon_image_path, 0606);
			$sql_common = " , me_img = '{$emoticon_image_url}' ";
		}
	}
	if($me_text != "") { 
		sql_query(" insert into {$g5['emoticon_table']} set me_text = '{$me_text}'".$sql_common);
	}
} else if ($_POST['act_button'] == "삭제") {

	for ($i=0; $i<count($_POST['chk']); $i++) {
		$k = $_POST['chk'][$i];
		$sql = " select * from {$g5['emoticon_table']} where me_id = '{$_POST['me_id'][$k]}' ";
		$row = sql_fetch($sql);
		if(!$row['me_id']) continue;

		// 이모티콘 내역삭제
		$sql = " delete from {$g5['emoticon_table']} where me_id = '{$_POST['me_id'][$k]}' ";
		sql_query($sql);
		// 이모티콘 이미지 삭제
		@unlink(G5_PATH.$row['me_img']);
	}
}

goto_url('./index.php');
?>