<?php
$sub_menu = "100100";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$mb = get_member($cf_admin);
if (!$mb['mb_id'])
    alert('최고관리자 회원아이디가 존재하지 않습니다.');
check_admin_token();

$site_style_path = G5_DATA_PATH."/site";
$site_style_url = G5_DATA_URL."/site";

@mkdir($site_style_path, G5_DIR_PERMISSION);
@chmod($site_style_path, G5_DIR_PERMISSION);

// 이미지 등록 시, 이미지를 업로드한 뒤 - 해당 이미지 경로를 삽입
if ($_FILES['cf_site_img_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['cf_site_img_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "site_prevew_image.".$exp;
	upload_file($_FILES['cf_site_img_file']['tmp_name'], $image_name, $site_style_path);
	$_POST['cf_site_img'] = $site_style_url."/".$image_name;
}
if ($_FILES['cf_favicon_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['cf_favicon_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "site_favicon.".$exp;
	upload_file($_FILES['cf_favicon_file']['tmp_name'], $image_name, $site_style_path);
	$_POST['cf_favicon'] = $site_style_url."/".$image_name;
}
if ($_FILES['cf_cursor_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['cf_cursor_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "site_favicon.".$exp;
	upload_file($_FILES['cf_cursor_file']['tmp_name'], $image_name, $site_style_path);
	$_POST['cf_cursor'] = $site_style_url."/".$image_name;
}



$sql = " update {$g5['config_table']}
			set cf_admin			= '{$_POST['cf_admin']}',
				cf_use_http			= '{$_POST['cf_use_http']}',
				cf_open				= '{$_POST['cf_open']}',
				cf_title			= '{$_POST['cf_title']}',
				cf_site_descript	= '{$_POST['cf_site_descript']}',
				cf_favicon			= '{$_POST['cf_favicon']}',
				cf_cursor			= '{$_POST['cf_cursor']}',
				cf_site_img			= '{$_POST['cf_site_img']}',
				cf_bgm				= '{$_POST['cf_bgm']}',
				cf_possible_ip		= '".trim($_POST['cf_possible_ip'])."',
				cf_intercept_ip		= '".trim($_POST['cf_intercept_ip'])."',
				
				cf_delay_sec		= '{$_POST['cf_delay_sec']}',
				cf_link_target		= '{$_POST['cf_link_target']}',
				cf_filter			= '{$_POST['cf_filter']}',
				cf_member_skin		= '{$_POST['cf_member_skin']}',
				cf_register_level	= '{$_POST['cf_register_level']}',
				cf_prohibit_id		= '{$_POST['cf_prohibit_id']}',
				cf_1				= '{$_POST['cf_1']}'";
sql_query($sql);

goto_url('./site_config_form.php', false);
?>