<?
if (!defined('_GNUBOARD_')) exit;
?>

<ul class="gnbWrap">
	<li>
		<a href="<?=G5_URL?>/main.php" class="change-link">
			<span class="icons"><span><i class="material-icons">home</i></span></span>
			<span class="tooltips">HOME</span>
		</a>
	</li>
	<li class="line"></li>
	<?
		$menu_sql = " select * from {$g5['menu_table']} where me_use = '1' order by me_order*1 asc, me_id asc";
		$menu = sql_query($menu_sql);

		for($i=0; $me = sql_fetch_array($menu); $i++) {
			$target = "";
			if($me['me_target'] == 'self') {
				$me['me_target'] = '';
			}

			if($me['me_name'] == '구분선') { 
				echo "<li class='line'></li>";
			} else {
	?>
			<li>
				<a href="<?php echo $me['me_link']?>" <? if($me['me_target']) { ?>target="_<?=$me['me_target']?>"<? } ?>  class="change-link">
					<span class="icons"><span><i class="material-icons"><?=$me['me_icon']?></i></span></span>
					<span class="tooltips"><?=$me['me_name']?></span>
				</a>
			</li>

	<? }} ?>

	<li class="line"></li>
	<? if(!$is_member) { //멤버가 아닐 경우 ?>
		<li>
			<a href="<?=G5_BBS_URL?>/login.php">
				<span class="icons"><span><i class="material-icons">login</i></span></span>
				<span class="tooltips">LOGIN</span>
			</a>
		</li>
		<? if($is_add_register) { //회원가입이 가능한 경우 ?>
			<li>
				<a href="<?=G5_BBS_URL?>/register.php" class="change-link">
					<span class="icons"><span><i class="material-icons">person_add</i></span></span>
					<span class="tooltips">JOIN</span>
				</a>
			</li>
		<? } ?>
	<? } else { //멤버일 경우 ?>
		<li>
			<a href="<?=G5_BBS_URL?>/logout.php">
				<span class="icons"><span><i class="material-icons">logout</i></span></span>
				<span class="tooltips">LOGOUT</span>
			</a>
		</li>
		<? if($is_admin) { ?>
		<li>
			<a href="<?=G5_URL?>/adm" target="_blank">
				<span class="icons"><span><i class="material-icons">settings</i></span></span>
				<span class="tooltips">ADMIN</span>
			</a>
		</li>
		<? } else { ?>
			<li>
				<a href="<?=G5_BBS_URL?>/member_confirm.php?url=register_form.php" class="change-link">
					<span class="icons"><span><i class="material-icons">settings</i></span></span>
					<span class="tooltips">정보수정</span>
				</a>
			</li>
		<? } ?>
	<? } ?>

	<? if(defined('_INDEX_') && $config['cf_bgm']) { ?>
		<li class="bgm-btn">
			<div id="site_bgm_box">
				<iframe src="./bgm.php?action=play" name="bgm_frame" id="bgm_frame" border="0" frameborder="0" marginheight="0" marginwidth="0" topmargin="0" scrolling="no" allowTransparency="true"></iframe>
			</div>

			<a href="<?=G5_URL?>/bgm.php?action=play" target="bgm_frame"  onclick="return fn_control_bgm('play')" class="control-bgm-play" style="display:none;">
				<span class="icons"><span><i class="material-icons">music_off</i></span></span>
				<span class="tooltips">BGM ON</span>
			</a>
			<a href="<?=G5_URL?>/bgm.php" target="bgm_frame" onclick="return fn_control_bgm('stop')" class="control-bgm-stop">
				<span class="icons"><span><i class="material-icons">music_note</i></span></span>
				<span class="tooltips">BGM OFF</span>
			</a>
		</li>
	<? } ?>
</ul>