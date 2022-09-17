<?php
$sub_menu = "300200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

$html_title = '게시판그룹';
$gr_id_attr = '';
$sound_only = '';
if ($w == '') {
    $gr_id_attr = 'required';
    $sound_only = '<strong class="sound_only"> 필수</strong>';
    $gr['gr_use_access'] = 0;
    $html_title .= ' 생성';
} else if ($w == 'u') {
    $gr_id_attr = 'readonly';
    $gr = sql_fetch(" select * from {$g5['group_table']} where gr_id = '$gr_id' ");
    $html_title .= ' 수정';
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

if (!isset($group['gr_device'])) {
    sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `gr_device` ENUM('both','pc','mobile') NOT NULL DEFAULT 'both' AFTER `gr_subject` ", false);
}


$g5['title'] = $html_title;
include_once('./admin.head.php');
?>

<div class="local_desc01 local_desc">
    <p>
        게시판을 생성하시려면 1개 이상의 게시판그룹이 필요합니다.<br>
        게시판그룹을 이용하시면 더 효과적으로 게시판을 관리할 수 있습니다.
    </p>
</div>

<form name="fboardgroup" id="fboardgroup" action="./boardgroup_form_update.php" onsubmit="return fboardgroup_check(this);" method="post" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="gr_device" value="both">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col style="width:120px;">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="gr_id">그룹 ID<?php echo $sound_only ?></label></th>
        <td><input type="text" name="gr_id" value="<?php echo $group['gr_id'] ?>" id="gr_id" <?php echo $gr_id_attr; ?> class="<?php echo $gr_id_attr; ?> alnum_ frm_input" maxlength="10">
            <?php
            if ($w=='')
                echo '영문자, 숫자, _ 만 가능 (공백없이)';
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="gr_subject">그룹 제목<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="gr_subject" value="<?php echo get_text($group['gr_subject']) ?>" id="gr_subject" required class="required frm_input" size="80">
            <?php
            if ($w == 'u')
                echo '<a href="./board_form.php?gr_id='.$gr_id.'" class="btn_frmline">게시판생성</a>';
            ?>
        </td>
    </tr>
    <?php for ($i=1;$i<=10;$i++) { ?>
    <tr>
        <th scope="row">여분필드<?php echo $i ?></th>
        <td class="td_extra">
            <label for="gr_<?php echo $i ?>_subj">여분필드 <?php echo $i ?> 제목</label>
            <input type="text" name="gr_<?php echo $i ?>_subj" value="<?php echo get_text($group['gr_'.$i.'_subj']) ?>" id="gr_<?php echo $i ?>_subj" class="frm_input">
            <label for="gr_<?php echo $i ?>">여분필드 <?php echo $i ?> 내용</label>
            <input type="text" name="gr_<?php echo $i ?>" value="<?php echo $gr['gr_'.$i] ?>" id="gr_<?php echo $i ?>" class="frm_input">
        </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
	<a href="./boardgroup_list.php" title="목록" class="btn ty2"><span class="material-icons">list</span></a>
	<div class="btn">
		<span class="material-icons">save</span>
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
	</div>
</div>

</form>

<script>
function fboardgroup_check(f)
{
    f.action = './boardgroup_form_update.php';
    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
