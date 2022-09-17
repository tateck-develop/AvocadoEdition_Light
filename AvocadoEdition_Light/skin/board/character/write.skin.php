<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path.'/_setting.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

if(!isset($write['wr_1_txt'])) {
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_1_txt` text NOT NULL AFTER `wr_1` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_2_txt` text NOT NULL AFTER `wr_2` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_3_txt` text NOT NULL AFTER `wr_3` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_4_txt` text NOT NULL AFTER `wr_4` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_5_txt` text NOT NULL AFTER `wr_5` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_6_txt` text NOT NULL AFTER `wr_6` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_7_txt` text NOT NULL AFTER `wr_7` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_8_txt` text NOT NULL AFTER `wr_8` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_9_txt` text NOT NULL AFTER `wr_9` ");
    sql_query(" ALTER TABLE `{$write_table}` ADD `wr_10_txt` text NOT NULL AFTER `wr_10` ");
}

if($w==''){
	$total_count = $board['bo_count_write'];
	if($type == 'pair' && $total_count < 2) {
		alert("페어로 등록할 수 있는 캐릭터의 수가 적습니다.");
	}
} else {
	$type = $write['wr_type'];

	$delete_href = '';
	set_session('ss_delete_token', $token = uniqid(time()));
	$delete_href ='./delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
}
?>


<section id="bo_w">
	
	<? if($board['bo_content_head']) { ?>
		<div class="board-notice-box">
			<?=stripslashes($board['bo_content_head']);?>
		</div>
	<? } ?>

	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<? echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<? echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<? echo $w ?>">
	<input type="hidden" name="bo_table" value="<? echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<? echo $wr_id ?>">
	<input type="hidden" name="sca" value="<? echo $sca ?>">
	<input type="hidden" name="sfl" value="<? echo $sfl ?>">
	<input type="hidden" name="stx" value="<? echo $stx ?>">
	<input type="hidden" name="spt" value="<? echo $spt ?>">
	<input type="hidden" name="sst" value="<? echo $sst ?>">
	<input type="hidden" name="sod" value="<? echo $sod ?>">
	<input type="hidden" name="page" value="<? echo $page ?>">
	<input type="hidden" name="type" value="<? echo $type ?>">
	<?
	$option = '';
	$option_hidden = '';
	if ($is_html || $is_secret || $is_mail) {
		$option = '';
		
		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
			}
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}

		if ($is_mail) {
			$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
		}
	}

	echo $option_hidden;
	?>

	<table class="theme-form">
		<colgroup>
			<col style="width: 90px;" />
			<col />
		</colgroup>
		<tbody>
		<? if ($is_name) { ?>
		<tr>
			<th scope="row"><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="wr_name" value="<? echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
		</tr>
		<? } ?>

		<? if ($is_password) { ?>
		<tr>
			<th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
			<td><input type="password" name="wr_password" id="wr_password" <? echo $password_required ?> class="frm_input <? echo $password_required ?>" maxlength="20"></td>
		</tr>
		<? } ?>

		<? if ($is_email) { ?>
		<tr>
			<th scope="row"><label for="wr_email">이메일</label></th>
			<td><input type="text" name="wr_email" value="<? echo $email ?>" id="wr_email" class="frm_input email" size="50" maxlength="100"></td>
		</tr>
		<? } ?>

		<? if ($is_homepage) { ?>
		<tr>
			<th scope="row"><label for="wr_homepage">홈페이지</label></th>
			<td><input type="text" name="wr_homepage" value="<? echo $homepage ?>" id="wr_homepage" class="frm_input" size="50"></td>
		</tr>
		<? } ?>

		<? if ($option) { ?>
		<tr>
			<th scope="row">옵션</th>
			<td><? echo $option ?></td>
		</tr>
		<? } ?>

		<? if ($is_category) { ?>
		<tr>
			<th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
			<td>
				<select name="ca_name" id="ca_name" required class="required" >
					<option value="">선택하세요</option>
					<? echo $category_option ?>
				</select>
			</td>
		</tr>
		<? }

			if($type == 'pair') { 
				include_once($board_skin_path."/write.pair.skin.php");
			} else {
				include_once($board_skin_path."/write.character.skin.php");
			}
			
		if ($is_guest) { //자동등록방지  ?>
		<tr>
			<th scope="row">자동등록방지</th>
			<td>
				<? echo $captcha_html ?>
			</td>
		</tr>
		<? } ?>

		</tbody>
	</table>

	<div class="btn_confirm">
		<button type="submit" id="btn_submit" accesskey="s" class="ui-btn point"><i class="material-icons">edit</i> 작성</button>
		<?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="ui-btn etc" onclick="del(this.href); return false;"><i class="material-icons">delete</i> 삭제</a><?php } ?>
		<a href="./board.php?bo_table=<? echo $bo_table ?>&sst=<?=$sst?>" class="ui-btn"><i class="material-icons">list</i> 목록</a>
	</div>
	</form>

	<script>
	function fwrite_submit(f) {
		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": f.wr_subject.value,
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		<? echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
		document.getElementById("btn_submit").disabled = "disabled";
		return true;
	}
	</script>
</section>
<!-- } 게시물 작성/수정 끝 -->
