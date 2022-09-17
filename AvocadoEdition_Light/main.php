<?php
include_once('./_common.php');
define('_MAIN_', true);

include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/main.css">', 0);
$main_content = get_site_content('site_main');

if(!$main_content) {
	$logo = get_logo();
	$main_content = "";
	if($logo)		$main_content .= "<img src='{$logo}' alt='' />";
}
?>

<div id="main_body">
	<? echo $main_content; ?>
</div>

<script>
$(function() { 
	window.onload = function() {
		$('#body').css('opacity', 1);
	};
});
</script>

<?
include_once(G5_PATH.'/tail.php');
?>