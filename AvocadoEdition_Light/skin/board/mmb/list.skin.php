<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once($board_skin_path.'/emoticon/_setting.emoticon.php');
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

set_session('ss_bo_table', $_REQUEST['bo_table']);
set_session('ss_wr_id', $_REQUEST['wr_id']);

$category_list = get_category_list($bo_table, $sca);

$owner_front = get_style('mmb_owner_name', 'cs_etc_3');		// 자기 로그 접두문자
$owner_front = $owner_front['cs_etc_3'];
$owner_behind = get_style('mmb_owner_name', 'cs_etc_4');		// 자기 로그 접미문자
$owner_behind = $owner_behind['cs_etc_4'];

?>

<div id="load_log_board">

	<? if($board['bo_content_head']) { ?>
		<div class="board-notice-box">
			<?=stripslashes($board['bo_content_head']);?>
		</div>
	<? } ?>

	<!-- 게시판 카테고리 시작 { -->
	<?php if ($is_category) { ?>
	<nav  class="board-category">
		<ul>
			<li><a href="./board.php?bo_table=<?=$bo_table?>" class="ui-btn <?=!$sca || $sca == ''? 'point' : 'etc'?>">ALL</a></li>
			<? echo $category_list ?>
		</ul>
	</nav>
	<?php } ?>
	<!-- } 게시판 카테고리 끝 -->
	
	<div class="ui-mmb-button">
	<?php if ($write_href) { ?>
		<a href="<?php echo $write_href ?>" class="ui-btn point">등록하기</a>
	<? } ?>
		<a href="<?php echo $list_href ?>" class="ui-btn">새로고침</a>
		<a href="<?php echo $board_skin_url ?>/emoticon/" class="ui-btn etc new_win">이모티콘</a>
	</div>

	<? if($write_pages) { ?><?php echo $write_pages; ?><? } ?>


	<!-- 리스트 시작 -->
	<div id="log_list" class="none-trans">
	<?
		for ($i=0; $i<count($list); $i++) {
			$list_item = $list[$i];
			include($board_skin_path."/list.log.skin.php");
		}
		if (count($list) == 0) { echo "<div class=\"empty_list\">등록된 로그가 없습니다.</div>"; } 
	?>
	</div>

	<? if($write_pages) { ?>
	<div class="ui-paging">
		<?php echo $write_pages;  ?>
	</div>
<? } ?>

	<div class="searc-sub-box">

		<form name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sop" value="and">
			<input type="hidden" name="hash" value="<?=$hash?>">

			<div class="ui-search-box">
				<fieldset class="sch_category select-box">
					<select name="sfl" id="sfl">
						<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>코멘트</option>
						<option value="hash"<?php echo get_selected($sfl, 'hash'); ?>>해시</option>
						<option value="log"<?php echo get_selected($sfl, 'log'); ?>>번호</option>
					</select>
				</fieldset>
				<fieldset class="sch_text">
					<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="frm_input" maxlength="20">
				</fieldset>
				<fieldset class="sch_button">
					<button type="submit" class="ui-btn point">검색</button>
				</fieldset>
			</div>
			
		</form>
	</div>

</div>

<script>
var avo_mb_id = "<?=$member['mb_id']?>";
var avo_board_skin_path = "<?=$board_skin_path?>";
var avo_board_skin_url = "<?=$board_skin_url?>";

var save_before = '';
var save_html = '';

function fviewcomment_submit(f)
{
	set_comment_token(f);
	var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			content = data.content;
		}
	});

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		f.wr_content.focus();
		return false;
	}
	
	if (!f.wr_content.value) {
		alert("댓글을 입력하여 주십시오.");
		return false;
	}

	if (typeof(f.wr_name) != 'undefined')
	{
		f.wr_name.value = f.wr_name.value.replace(pattern, "");
		if (f.wr_name.value == '')
		{
			alert('이름이 입력되지 않았습니다.');
			f.wr_name.focus();
			return false;
		}
	}

	if (typeof(f.wr_password) != 'undefined')
	{
		f.wr_password.value = f.wr_password.value.replace(pattern, "");
		if (f.wr_password.value == '')
		{
			alert('비밀번호가 입력되지 않았습니다.');
			f.wr_password.focus();
			return false;
		}
	}

	return true;
}

function comment_delete()
{
	return confirm("이 댓글을 삭제하시겠습니까?");
}

function comment_box(co_id, wr_id) { 

	if($('#c_'+co_id).find('.modify_area').is(':visible')) {
		$('.modify_area').hide();
		$('.original_comment_area').show();
		co_id = '';
		wr_id = '';
	} else {
		$('.modify_area').hide();
		$('.original_comment_area').show();

		$('#c_'+co_id).find('.modify_area').show();
		$('#c_'+co_id).find('.original_comment_area').hide();
		$('#save_co_comment_'+co_id).focus();
	}

	var modify_form = document.getElementById('frm_modify_comment');
	modify_form.wr_id.value = wr_id;
	modify_form.comment_id.value = co_id;
}

function modify_commnet(co_id) { 
	var modify_form = document.getElementById('frm_modify_comment');
	var wr_content = $('#save_co_comment_'+co_id).val();

	modify_form.wr_content.value = wr_content;
	$('#frm_modify_comment').submit();
}

</script>

<form name="modify_comment" id="frm_modify_comment"  action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="cu">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">

	<input type="hidden" name="comment_id" value="">
	<input type="hidden" name="wr_id" value="">
	<textarea name="wr_content" style="display: none;"></textarea>
	<button type="submit" style="display: none;"></button>
</form>

<script src="<?php echo $board_skin_url ?>/js/load.board.js"></script>
