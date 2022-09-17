<?php
$sub_menu = "300100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['board_table']} a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
	$sql_common .= " , {$g5['group_table']} b ";
	$sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		case "bo_table" :
			$sql_search .= " ($sfl like '$stx%') ";
			break;
		case "a.gr_id" :
			$sql_search .= " ($sfl = '$stx') ";
			break;
		default :
			$sql_search .= " ($sfl like '%$stx%') ";
			break;
	}
	$sql_search .= " ) ";
}

if (!$sst) {
	$sst  = "a.gr_id, a.bo_table";
	$sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '게시판관리';
include_once('./admin.head.php');

$colspan = 11;
?>

<style>
td input[type="text"],
td select {display:block; width:100%;}
</style>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	생성된 게시판수 <?php echo number_format($total_count) ?>개
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
	<option value="bo_table"<?php echo get_selected($_GET['sfl'], "bo_table", true); ?>>TABLE</option>
	<option value="bo_subject"<?php echo get_selected($_GET['sfl'], "bo_subject"); ?>>제목</option>
	<option value="a.gr_id"<?php echo get_selected($_GET['sfl'], "a.gr_id"); ?>>그룹ID</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<br />


<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<thead>
	<tr>
		<th scope="col" style="width:45px;">
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th scope="col" style="width:100px;"><?php echo subject_sort_link('a.gr_id') ?>그룹</a></th>
		<th scope="col" style="width:100px;"><?php echo subject_sort_link('bo_table') ?>TABLE</a></th>
		<th scope="col" style="width:150px;"><?php echo subject_sort_link('bo_skin', '', 'desc') ?>스킨</a></th>
		<th scope="col"><?php echo subject_sort_link('bo_subject') ?>제목</a></th>
		<th scope="col" style="width:80px;">목록보기</th>
		<th scope="col" style="width:80px;">글읽기</th>
		<th scope="col" style="width:80px;">글쓰기</th>
		<th scope="col" style="width:80px;">글답변</th>
		<th scope="col" style="width:80px;">댓글쓰기</th>
		<th scope="col" style="width:60px;">관리</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$one_update = '<a href="./board_form.php?w=u&amp;bo_table='.$row['bo_table'].'&amp;'.$qstr.'">수정</a>';
		$one_copy = '<a href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy" target="win_board_copy">복사</a>';

		$bg = 'bg'.($i%2);
	?>

	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>
		<td>
			<?php if ($is_admin == 'super'){ ?>
				<?php echo get_group_select("gr_id[$i]", $row['gr_id']) ?>
			<?php }else{ ?>
				<input type="hidden" name="gr_id[<?php echo $i ?>]" value="<?php echo $row['gr_id'] ?>"><?php echo $row['gr_subject'] ?>
			<?php } ?>
		</td>
		<td>
			<input type="hidden" name="board_table[<?php echo $i ?>]" value="<?php echo $row['bo_table'] ?>">
			<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>"><?php echo $row['bo_table'] ?></a>
		</td>
		<td>
			<?php echo get_skin_select('board', 'bo_skin_'.$i, "bo_skin[$i]", $row['bo_skin']); ?>
		</td>
		<td>
			<input type="text" name="bo_subject[<?php echo $i ?>]" value="<?php echo get_text($row['bo_subject']) ?>" id="bo_subject_<?php echo $i ?>" required class="required frm_input bo_subject full_input" size="25">
		</td>
		<td>
			<?php echo get_member_level_select('bo_list_level['.$i.']', 1, 10, $row['bo_list_level']) ?>
		</td>
		<td>
			<?php echo get_member_level_select('bo_read_level['.$i.']', 1, 10, $row['bo_read_level']) ?>
		</td>
		<td>
			<?php echo get_member_level_select('bo_write_level['.$i.']', 1, 10, $row['bo_write_level']) ?>
		</td>
		<td>
			<?php echo get_member_level_select('bo_reply_level['.$i.']', 1, 10, $row['bo_reply_level']) ?>
		</td>
		<td>
			<?php echo get_member_level_select('bo_comment_level['.$i.']', 1, 10, $row['bo_comment_level']) ?>
		</td>
		<td>
			<?php echo $one_update ?>
			<?php echo $one_copy ?>
		</td>
	</tr>
	<?php
	}
	if ($i == 0)
		echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>


<div class="btn_confirm">
	<div class="btn ty3">
		<span class="material-icons">build</span>
		<input type="submit" name="act_button" value="선택수정" title="선택수정" onclick="document.pressed=this.value">
	</div>
	<div class="btn ty2">
		<span class="material-icons">delete</span>
		<input type="submit" name="act_button" value="선택삭제" title="선택삭제" onclick="document.pressed=this.value">
	</div>
	<?php if ($is_admin == 'super') { ?>
		<a href="./board_form.php" title="게시판 추가" class="btn"><span class="material-icons">add</span></a>
	<?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<script>
function fboardlist_submit(f)
{
	if (!is_checked("chk[]")) {
		alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택삭제") {
		if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
			return false;
		}
	}

	return true;
}

$(function(){
	$(".board_copy").click(function(){
		window.open(this.href, "win_board_copy", "left=100,top=100,width=550,height=450");
		return false;
	});
});
</script>

<?php
include_once('./admin.tail.php');
?>
