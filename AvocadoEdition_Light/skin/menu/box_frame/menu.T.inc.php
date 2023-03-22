<?php
if (!defined('_GNUBOARD_')) exit;

//if (defined('_INDEX_')) return;

/* *************************************
	:: 좌측 메뉴 스타일 ::
-----------------------------------------
	좌측메뉴로 설정했을 경우 출력되는 영역입니다.

	- Menu Link 에서 class="change-link" 를 적용하는 경우
	- 메뉴가 유지되며 링크가 이동됩니다.
************************************* */
add_stylesheet('<link rel="stylesheet" href="'.$menu_skin_url.'/css/style.T.css">', 0);

?>
<style>
<? if($header_inside) { // 메뉴가 박스 안쪽에 위치해야 할 경우 ?>
	@media all and (min-width:1025px) { #header {<? echo "top:50%; margin-top:-".(($b_h/2) - 20)."px;"; ?>}}
	@media all and (max-height:<?=($b_h+20)?>px) and (min-width:1025px) { #header {top:20px; margin-top:0px;}}
<? } ?>
</style>

<? @include_once($menu_skin_path.'/menu.cmm.inc.php'); ?>