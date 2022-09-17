<?php
include_once('./_common.php');
define('_INDEX_', true);

$enter = get_style('intro_use');
$enter = $enter['cs_value'];

if(!$is_member && !$config['cf_open']) { 
	// 멤버가 아니고, 사이트 오픈이 되어 있지 않은 경우 로그인 페이지로 점프 시키기
	goto_url(G5_BBS_URL.'/login.php');

} else { 
	if($config['cf_open']) {
		// 사이트 오픈이 되어 있을 경우
		if($is_member) {
			// 사이트 오픈이 되어 있고, 로그인이 끝났을 경우
			if (G5_IS_MOBILE) {
				include_once(G5_PATH.'/main.php');
				exit;
			}
			$index_url = "./main.php";
		} else {
			if($enter == '') {
				// 사이트 오픈이 되어 있고, 로그인이 안되어 있을 경우
				if (G5_IS_MOBILE) {
					include_once(G5_PATH.'/enter.php');
					exit;
				}
				$index_url = "./enter.php";
			} else {
				if (G5_IS_MOBILE) {
					include_once(G5_PATH.'/main.php');
					exit;
				}
				$index_url = "./main.php";
			}
		}
		
	}

	if($index_url == "") {$index_url = "./enter.php";}

	include_once(G5_PATH.'/head.sub.php');
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/index.css">', 0);

	include_once(G5_PATH."/menu.php");
?>

	
	<!-- 콘텐츠 시작 -->
	<div id="wrapper">
		<iframe src="<?=$index_url?>" name="frm_main" id="main" border="0" frameborder="0" marginheight="0" marginwidth="0" topmargin="0" scrolling="auto" allowTransparency="true"></iframe>
	</div>
<script>
	$(document.body).on("keydown", this, function (event) {
		if (event.keyCode == 116) {
			document.getElementById('main').contentDocument.location.reload(true);
			return false;
		}
	});
	$('#header .change-link').attr('target', 'frm_main');

	function show_menu() {
		$('#header').show();
	}
</script>

<?php
	include_once(G5_PATH.'/tail.sub.php');
}
?>