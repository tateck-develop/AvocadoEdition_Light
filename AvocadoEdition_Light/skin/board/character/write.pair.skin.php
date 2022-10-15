<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php'); // 달력

// 게시물 목록을 불러온다.

$character_list = sql_query("select wr_id, wr_subject from {$write_table} where wr_type != 'pair' and wr_is_comment = 0 order by wr_subject");
$character_ids = array();

for($i=0; $row = sql_fetch_array($character_list); $i++) {
	$character_ids[$i] = $row;
}
?>

<input type="hidden" name="notice" value="1">
<input type="hidden" name="ca_name" value="공지">
<tr>
	<th scope="row">시작일자</th>
	<td>
		<input type="text" name="wr_subject" value="<?php echo $subject ?>" required class="frm_input required datepicker" size="12" maxlength="255">
	</td>
</tr>
<tr>
	<th scope="row">정렬순서</th>
	<td>
		<input type="text" name="wr_ing" value="<?php echo $write['wr_ing'] ?>" class="frm_input" size="5" maxlength="255">
	</td>
</tr>
</tbody>
</table>

<script type="text/javascript">
//<![CDATA[
$(function(){
		$(".datepicker").datepicker({
			dateFormat: "yy-mm-dd",
			onSelect:function(dateText, inst) {
				console.log(dateText);
				console.log(inst);
			}
		});
});
//]]>
</script><!-- 달력 끝 -->
<br />
<table class="theme-form">
	<colgroup>
		<col style="width: 90px;" />
		<col style="width: 70px;" />
		<col />
	</colgroup>
	<tbody>
		<tr>
			<th rowspan="2">
				좌측
			</th>
			<td>
				캐릭터
			</td>
			<td>
				<select name="wr_2">
					<?
						for($i=0; $i < count($character_ids); $i++) { 
							echo "<option value='{$character_ids[$i]['wr_id']}' ";
							if($write['wr_2'] == $character_ids[$i]['wr_id']) echo "selected";
							echo ">{$character_ids[$i]['wr_subject']}</option>";
						}
					?>
				</select>
			</td></tr><tr>
			<td>관계명</td>
			<td>
				<input type="text" name="wr_4" value="<?php echo $write['wr_4'] ?>" class="frm_input" size="30" maxlength="255">
			</td>
		</tr>

		<tr>
			<th rowspan="2">
				우측
			</th>
			<td>
				캐릭터
			</td>
			<td>
				<select name="wr_3">
					<?
						for($i=0; $i < count($character_ids); $i++) { 
							echo "<option value='{$character_ids[$i]['wr_id']}' ";
							if($write['wr_3'] == $character_ids[$i]['wr_id']) echo "selected";
							echo ">{$character_ids[$i]['wr_subject']}</option>";
						}
					?>
				</select>
			</td></tr><tr>
			<td>관계명</td>
			<td>
				<input type="text" name="wr_5" value="<?php echo $write['wr_5'] ?>" class="frm_input" size="30" maxlength="255">
			</td>
		</tr>
	</tbody>
</table>
<br />
<table class="theme-form">
	<colgroup>
		<col style="width: 90px;" />
		<col style="width: 70px;" />
		<col />
	</colgroup>
	<tbody>
		<tr>
			<th rowspan="2" scope="row">배경</th>
			<td>외부경로</td>
			<td>
				<input type="hidden" name="wr_1_prev" value="<?php echo $write['wr_1'] ?>" />
				<input type="text" name="wr_1" value="<?php echo $write['wr_1'] ?>" class="frm_input" size="30" maxlength="255">
			</td>
		</tr>
		<tr>
			<td>업로드</td>
			<td>
				<input type="file" name="wr_1_file" title="파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
			</td>
		</tr>
	</tbody>
</table>
<table class="theme-form">
	<colgroup>
		<col style="width: 90px;" />
		<col />
	</colgroup>
	<tbody>
		<tr>