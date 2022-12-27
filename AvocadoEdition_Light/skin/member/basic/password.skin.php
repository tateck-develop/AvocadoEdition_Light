<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 비밀번호 확인 시작 { -->
<div id="password_box" class="theme-box">

	<h1>비밀번호 확인</h1>
	<hr class="line" />
	<div class="descript">
		<p>
			<?php if ($w == 'u') { ?>
			<strong class="txt-point">작성자만 글을 수정할 수 있습니다.</strong>
			작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 수정할 수 있습니다.
			<?php } else if ($w == 'd' || $w == 'x') {  ?>
			<strong class="txt-point">작성자만 글을 삭제할 수 있습니다.</strong>
			작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 삭제할 수 있습니다.
			<?php } else {  ?>
			<strong class="txt-point">비밀글 기능으로 보호된 글입니다.</strong>
			작성자와 관리자만 열람하실 수 있습니다. 본인이라면 비밀번호를 입력하세요.
			<?php }  ?>
		</p>
		<div class="pass-form">
			<form name="fboardpassword" action="<?php echo $action;  ?>" method="post">
				<input type="hidden" name="w" value="<?php echo $w ?>">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
				<input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">

				<fieldset class="box-pw">
					<input type="password" name="wr_password" id="password_wr_password" required class="frm_input required" size="15" maxLength="20">
				</fieldset>

				<fieldset class="box-btn">
					<button type="submit" class="point ui-btn">확인</button>
				</fieldset>
			</form>
		</div>
	</div>
	<hr class="line" />
	<div class="btn_confirm">
		<a href="<?php echo $return_url ?>" class="ui-btn">이전으로 돌아가기</a>
	</div>

</div>
<!-- } 비밀번호 확인 끝 -->