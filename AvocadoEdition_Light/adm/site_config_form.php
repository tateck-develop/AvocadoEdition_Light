<?php
$sub_menu = "100100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');


if (!isset($config['cf_use_http'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_use_http` INT(11) NOT NULL DEFAULT '0' AFTER `cf_10` ", true);
}

if (!isset($config['cf_add_script'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_script` TEXT NOT NULL AFTER `cf_admin_email_name` ", true);
}

if (!isset($config['cf_mobile_new_skin'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `cf_memo_send_point`,
					ADD `cf_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_new_skin`,
					ADD `cf_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_search_skin`,
					ADD `cf_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_connect_skin` ", true);
}

if (isset($config['cf_gcaptcha_mp3'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					CHANGE `cf_gcaptcha_mp3` `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if (!isset($config['cf_captcha_mp3'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_mobile_member_skin` ", true);
}

if(!isset($config['cf_editor'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_googl_shorturl_apikey'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_mobile_pages'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `cf_write_pages` ", true);
	sql_query(" UPDATE `{$g5['config_table']}` SET cf_mobile_pages = '5' ", true);
}

if(!isset($config['cf_facebook_appid'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_facebook_appid` VARCHAR(255) NOT NULL AFTER `cf_googl_shorturl_apikey`,
					ADD `cf_facebook_secret` VARCHAR(255) NOT NULL AFTER `cf_facebook_appid`,
					ADD `cf_twitter_key` VARCHAR(255) NOT NULL AFTER `cf_facebook_secret`,
					ADD `cf_twitter_secret` VARCHAR(255) NOT NULL AFTER `cf_twitter_key` ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['uniqid_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['uniqid_table']}` (
				  `uq_id` bigint(20) unsigned NOT NULL,
				  `uq_ip` varchar(255) NOT NULL,
				  PRIMARY KEY (`uq_id`)
				) ", false);
}

if(!sql_query(" SELECT uq_ip from {$g5['uniqid_table']} limit 1 ", false)) {
	sql_query(" ALTER TABLE {$g5['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['autosave_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['autosave_table']}` (
				  `as_id` int(11) NOT NULL AUTO_INCREMENT,
				  `mb_id` varchar(20) NOT NULL,
				  `as_uid` bigint(20) unsigned NOT NULL,
				  `as_subject` varchar(255) NOT NULL,
				  `as_content` text NOT NULL,
				  `as_datetime` datetime NOT NULL,
				  PRIMARY KEY (`as_id`),
				  UNIQUE KEY `as_uid` (`as_uid`),
				  KEY `mb_id` (`mb_id`)
				) ", false);
}

if(!isset($config['cf_admin_email'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_admin_email` VARCHAR(255) NOT NULL AFTER `cf_admin` ", true);
}

if(!isset($config['cf_admin_email_name'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_admin_email_name` VARCHAR(255) NOT NULL AFTER `cf_admin_email` ", true);
}

if(!isset($config['cf_cert_use'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `cf_editor`,
					ADD `cf_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_use`,
					ADD `cf_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_ipin`,
					ADD `cf_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_hp`,
					ADD `cf_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcb_cd`,
					ADD `cf_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `cf_cert_kcp_cd` ", true);
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
	sql_query(" update {$g5['member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
	sql_query(" update {$g5['member_table']} set mb_certify = '' where mb_certify = '0' ");
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['cert_history_table']}` (
				  `cr_id` int(11) NOT NULL auto_increment,
				  `mb_id` varchar(255) NOT NULL DEFAULT '',
				  `cr_company` varchar(255) NOT NULL DEFAULT '',
				  `cr_method` varchar(255) NOT NULL DEFAULT '',
				  `cr_ip` varchar(255) NOT NULL DEFAULT '',
				  `cr_date` date NOT NULL DEFAULT '0000-00-00',
				  `cr_time` time NOT NULL DEFAULT '00:00:00',
				  PRIMARY KEY (`cr_id`),
				  KEY `mb_id` (`mb_id`)
				)", true);
}

if(!isset($config['cf_analytics'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_analytics` TEXT NOT NULL AFTER `cf_intercept_ip` ", true);
}

if(!isset($config['cf_add_meta'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_meta` TEXT NOT NULL AFTER `cf_analytics` ", true);
}

if (!isset($config['cf_syndi_token'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_syndi_token` VARCHAR(255) NOT NULL AFTER `cf_add_meta` ", true);
}

if (!isset($config['cf_syndi_except'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_syndi_except` TEXT NOT NULL AFTER `cf_syndi_token` ", true);
}

if(!isset($config['cf_sms_use'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_limit`,
					ADD `cf_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use`,
					ADD `cf_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_id`,
					ADD `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_pw`,
					ADD `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_ip` ", true);
}

if(!isset($config['cf_mobile_page_rows'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `cf_page_rows` ", true);
}

if(!isset($config['cf_cert_req'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_cert_limit` ", true);
}

if(!isset($config['cf_faq_skin'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_connect_skin`,
					ADD `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_mobile_connect_skin` ", true);
}

// LG유플러스 본인확인 필드 추가
if(!isset($config['cf_lg_mid'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcp_cd`,
					ADD `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_lg_mid` ", true);
}

if(!isset($config['cf_optimize_date'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_optimize_date` date NOT NULL default '0000-00-00' AFTER `cf_popular_del` ", true);
}

// 카카오톡링크 api 키
if(!isset($config['cf_kakao_js_apikey'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `cf_googl_shorturl_apikey` ", true);
}

// SMS 전송유형 필드 추가
if(!isset($config['cf_sms_type'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 커서 등록 추가
if(!isset($config['cf_cursor'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_cursor` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 접속자 정보 필드 추가
if(!sql_query(" select vi_browser from {$g5['visit_table']} limit 1 ")) {
	sql_query(" ALTER TABLE `{$g5['visit_table']}`
					ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
					ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
					ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '환경설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본환경</a></li>
	<li><a href="#anc_002">게시판/회원</a></li>
	<li><a href="#anc_010">레이아웃 추가설정</a></li>
</ul>';

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
	$userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<div class="btn_confirm">
	<div class="btn">
		<span class="material-icons">save</span>
		<input type="submit" value="저장" class="btn_submit" accesskey="s">
	</div>
</div>

<section id="anc_001">
	<h2 class="h2_frm">홈페이지 기본환경 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>홈페이지 기본환경 설정</caption>
		<colgroup>
			<col style="width:150px;">
			<col style="width:400px;">
			<col style="width:150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
			<td><?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?></td>
			<th scope="row">공개설정</th>
			<td>
				<input type="checkbox" name="cf_open" value="1" id="cf_open" <?php echo $config['cf_open']?'checked':''; ?>>
				<label for="cf_open">사이트공개</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_1" value="1" id="cf_1" <?php echo $config['cf_1']?'checked':''; ?>>
				<label for="cf_1">계정생성 가능</label>
			</td>
		</tr>
		<tr>
			<th scope="row">홈페이지 제목</th>
			<td><input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required" size="40"></td>
			<th>사이트설명</th>
			<td>
				<input type="text" name="cf_site_descript" value="<?php echo $config['cf_site_descript'] ?>" size="50" />
			</td>
		</tr>
		<tr>
			<th>접속설정</th>
			<td colspan="3">
				<?php echo help('로그인이 제대로 안된다거나 화면이 안나오다 나올때 설정하세요') ?>
				<input type="checkbox" name="cf_use_http" value="1" id="cf_use_http" <?php echo $config['cf_use_http']?'checked':''; ?>>
				<label for="cf_use_http">http://로 고정하기</label>
			</td>
		</tr>
		<tr>
			<th>파비콘</th>
			<td colspan="3">
				<?php echo help('파비콘 확장자는 ico 로 등록해 주셔야 적용됩니다.') ?>
				직접등록&nbsp;&nbsp; <input type="file" name="cf_favicon_file" value="" size="50" style="border:1px solid #ddd;">
				&nbsp;&nbsp;
				외부경로&nbsp;&nbsp; <input type="text" name="cf_favicon" value="<?=$config['cf_favicon']?>" size="50"/>
			</td>
		</tr>
		<tr>
			<th>커서</th>
			<td colspan="3">
				<?php echo help('홈페이지의 커서로 사용할 이미지를 등록해주세요.') ?>
				직접등록&nbsp;&nbsp; <input type="file" name="cf_cursor_file" value="" size="50">
				&nbsp;&nbsp;
				외부경로&nbsp;&nbsp; <input type="text" name="cf_cursor" value="<?=$config['cf_cursor']?>" size="50"/>
			</td>
		</tr>
		<tr>
			<th>사이트이미지</th>
			<td colspan="3">
				<?php echo help('사이트 링크 추가시, SNS에서 미리보기로 뜨는 썸네일 이미지를 등록합니다. 290px * 160px 파일로 업로드해 주시길 바랍니다.') ?>
				직접등록&nbsp;&nbsp; <input type="file" name="cf_site_img_file" value="" size="50">
				&nbsp;&nbsp;
				외부경로&nbsp;&nbsp; <input type="text" name="cf_site_img" value="<?=$config['cf_site_img']?>" size="50"/>
			</td>
		</tr>
		
		<tr>
			<th scope="row"><label for="site_back">배경음악</label></th>
			<td colspan="3">
				<?php echo help('유튜브 재생목록 아이디 (https://www.youtube.com/watch?list=재생목록고유아이디) 를 입력해 주세요.') ?>
				<input type="text" name="cf_bgm" value="<?php echo $config['cf_bgm'] ?>" id="cf_bgm" size="50">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
			<td colspan="3">
				<?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
				<textarea name="cf_possible_ip" id="cf_possible_ip" rows="2" style="height:100px;"><?php echo $config['cf_possible_ip'] ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
			<td colspan="3">
				<?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
				<textarea name="cf_intercept_ip" id="cf_intercept_ip" rows="2" style="height:100px;"><?php echo $config['cf_intercept_ip'] ?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">게시판/회원 기본 설정</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>게시판 기본 설정</caption>
		<colgroup>
			<col style="width:150px;">
			<col style="width:400px;">
			<col style="width:150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required class="required numeric frm_input" size="3"> 초 지난후 가능</td>
			<th scope="row"><label for="cf_link_target">새창 링크</label></th>
			<td>
				<?php echo help('글내용중 자동 링크되는 타켓을 지정합니다.') ?>
				<select name="cf_link_target" id="cf_link_target">
					<option value="_blank"<?php echo get_selected($config['cf_link_target'], '_blank') ?>>_blank</option>
					<option value="_self"<?php echo get_selected($config['cf_link_target'], '_self') ?>>_self</option>
					<option value="_top"<?php echo get_selected($config['cf_link_target'], '_top') ?>>_top</option>
					<option value="_new"<?php echo get_selected($config['cf_link_target'], '_new') ?>>_new</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th scope="row"><label for="cf_filter">단어 필터링</label></th>
			<td colspan="3">
				<?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
				<textarea name="cf_filter" id="cf_filter" rows="7"><?php echo $config['cf_filter'] ?></textarea>
			 </td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_member_skin">회원 스킨<strong class="sound_only">필수</strong></label></th>
			<td>
				<?php echo get_skin_select('member', 'cf_member_skin', 'cf_member_skin', $config['cf_member_skin'], 'required'); ?>
			</td>
			<th scope="row"><label for="cf_register_level">회원가입시 권한</label></th>
			<td><?php echo get_member_level_select('cf_register_level', 1, 9, $config['cf_register_level']) ?></td>
		</tr>
		<tr>
			<th scope="row" id="th310"><label for="cf_leave_day">회원탈퇴후 삭제일</label></th>
			<td colspan="3"><input type="text" name="cf_leave_day" value="<?php echo $config['cf_leave_day'] ?>" id="cf_leave_day" class="frm_input" size="2"> 일 후 자동 삭제</td>
		</tr>
		
		<tr>
			<th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
			<td colspan="3">
				<?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
				<textarea name="cf_prohibit_id" id="cf_prohibit_id" rows="3" style="height:100px;"><?php echo $config['cf_prohibit_id'] ?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function fconfigform_submit(f)
{
	f.action = "./site_config_form_update.php";
	return true;
}
</script>
<?
include_once ('./admin.tail.php');
?>
