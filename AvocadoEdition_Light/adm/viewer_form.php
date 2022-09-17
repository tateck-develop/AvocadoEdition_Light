<?php
$sub_menu = "100250";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '메인 편집';
include_once ('./admin.head.php');

// -- 내용관리의 기능을 통해 메뉴와 메인 내용을 가져온다.
// -- 메인 정보 가져오기
$sql = " select * from {$g5['content_table']} where co_id = 'site_main' ";
$main_co = sql_fetch($sql);


?>


<form name="fviewerform" id="fviewerform" method="post" onsubmit="return fviewerform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<div class="btn_confirm">
	<div class="btn">
		<span class="material-icons">save</span>
		<input type="submit" value="저장" class="btn_submit" accesskey="s">
	</div>
</div>

<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col>
	</colgroup>
	<tbody>
	<tr>
		<td>
			<?php echo help('메인영역에 들어갈 내용을 자유롭게 작성해 주시길 바랍니다.') ?>
			<?php echo editor_html('main_content', get_text($main_co['co_content'], 0)); ?>
		</td>
	</tr>

	</tbody>
	</table>
</div>

</form>

<script>
function fviewerform_submit(f)
{
	f.action = "./viewer_form_update.php";

	<?php echo get_editor_js('main_content'); ?>
	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>

