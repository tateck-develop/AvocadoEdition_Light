<?
	include_once('./_common.php');
	if($is_member & !$config['cf_open']) {
		goto_url(G5_URL.'/main.php');
	}

	/*********** Logo Data ************/
	$logo = get_logo();
	$logo_data = "";
	if($logo)		$logo_data .= "<img src='{$logo}' />";
	/*********************************/
	
	/*********** Intro Data ************/
	$intro = get_style('intro');
	if($intro['cs_value'])	$logo_data = "<img src='{$intro['cs_value']}' alt='' />";

	/*********************************/
?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="title" content="<?=$g5['title']?>">
	<meta name="keywords" content="<?=$config['cf_site_descript']?>">
	<meta name="description" content="<?=$config['cf_site_descript']?>">

	<meta property="og:title" content="<?=$g5['title']?>">
	<meta property="og:description" content="<?=$config['cf_site_descript']?>">
	<meta property="og:url" content="<?=G5_URL?>">

	<title><?=$g5['title']?></title>

	<link rel="shortcut icon" href="<?=$config['cf_favicon']?>">
	<link rel="icon" href="<?=$config['cf_favicon']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_CSS_URL?>/enter.css?v=<?=$config['cf_css_version']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_DATA_URL?>/css/_design.config.css?v=<?=$config['cf_css_version']?>" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
	if(!parent || parent==this) $('html').addClass('single'); 
	</script>
</head>
<body>


<div class="enterWrapper">
	<div class="inner">
		<div class="index-logo">
			<a href="./main.php" onclick="fn_show_index_menu();">
				<?=$logo_data?>
				<p class="guide"><?=$intro['cs_etc_1']?></p>
			</a>
		</div>
	</div>
</div>

<script>

window.onload=function() {
	$('html').addClass('on')
	setTimeout(function() { $('html').addClass('active') }, 800);
};

function fn_show_index_menu() {
	if(parent && parent !== this) parent.show_menu();
}

</script>

</body>
</html>
