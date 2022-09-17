<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$customer_sql = "";
$temp_wr_id = $wr_id;
if(!$wr_num) $wr_num = $write['wr_num'];


if($w == 'u') { 
	include_once($board_skin_path.'/write_update.inc.php');
	$sql = " update {$write_table}
				set wr_id = '{$wr_id}'
				{$customer_sql}
			  where wr_id = '{$wr_id}' ";
	sql_query($sql);
}

if ($file_upload_msg) {
	alert($file_upload_msg, G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table);
} else {
	goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.$qstr."#log_".$wr_id);
}
?>
