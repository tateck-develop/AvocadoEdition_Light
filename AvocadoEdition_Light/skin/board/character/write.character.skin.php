<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == '') {
	$write['wr_4'] = '외관';
	$write['wr_5'] = '성격';
	$write['wr_6'] = '특징';
	$write['wr_7'] = '기타';
}
?>

<tr>
	<th scope="row">캐릭터 이름</th>
	<td>
		<input type="text" name="wr_subject" value="<?php echo $subject ?>" required class="frm_input required" size="50" maxlength="255">
	</td>
</tr>
<tr>
	<th scope="row">타이틀</th>
	<td>
		<input type="text" name="wr_3" value="<?php echo $write['wr_3'] ?>" class="frm_input" size="30" maxlength="255">
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
<br />
<table class="theme-form">
<colgroup>
	<col style="width: 90px;" />
	<col style="width: 80px;" />
	<col />
</colgroup>
<tbody>
<tr>
	<th rowspan="2" scope="row">두상</th>
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
<tr>
	<th rowspan="2" scope="row">전신</th>
	<td>외부경로</td>
	<td>
		<input type="hidden" name="wr_2_prev" value="<?php echo $write['wr_2'] ?>" />
		<input type="text" name="wr_2" value="<?php echo $write['wr_2'] ?>" class="frm_input" size="30" maxlength="255">
	</td>
</tr>
<tr>
	<td>업로드</td>
	<td>
		<input type="file" name="wr_2_file" title="파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
	</td>
</tr>
</tbody>
</table>
<br />
<table class="theme-form">
<colgroup>
	<col style="width: 90px;" />
	<col />
</colgroup>
<tbody>
<tr>
	<th scope="row">기본정보</th>
	<td>
		 <input type="text" name="wr_content" placeholder="나이, 성별 등" value="<?php echo $write['wr_content'] ?>" class="frm_input" size="50" maxlength="255">
	</td>
</tr>
<tr>
	<th scope="row"><input type="text" name="wr_4" value="<?php echo $write['wr_4'] ?>" class="frm_input full" /></th>
	<td>
		 <textarea name="wr_4_txt"><?=$write['wr_4_txt']?></textarea>
	</td>
</tr>
<tr>
	<th scope="row"><input type="text" name="wr_5" value="<?php echo $write['wr_5'] ?>" class="frm_input full" /></th>
	<td>
		 <textarea name="wr_5_txt"><?=$write['wr_5_txt']?></textarea>
	</td>
</tr>
<tr>
	<th scope="row"><input type="text" name="wr_6" value="<?php echo $write['wr_6'] ?>" class="frm_input full" /></th>
	<td>
		 <textarea name="wr_6_txt"><?=$write['wr_6_txt']?></textarea>
	</td>
</tr>
<tr>
	<th scope="row"><input type="text" name="wr_7" value="<?php echo $write['wr_7'] ?>" class="frm_input full" /></th>
	<td>
		 <textarea name="wr_7_txt"><?=$write['wr_7_txt']?></textarea>
	</td>
</tr>
<tr>
	<th scope="row"><input type="text" name="wr_8" value="<?php echo $write['wr_8'] ?>" class="frm_input full" /></th>
	<td>
		 <textarea name="wr_8_txt"><?=$write['wr_8_txt']?></textarea>
	</td>
</tr>