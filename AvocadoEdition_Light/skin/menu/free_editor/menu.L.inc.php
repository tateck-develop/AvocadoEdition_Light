<?php
if (!defined('_GNUBOARD_')) exit;

// 좌측 메뉴 스타일
add_stylesheet('<link rel="stylesheet" href="'.$menu_skin_url.'/css/style.L.css">', 0);
?>

<style>
.editor-menu {width:<?=$m_w?>px; <?=$background?>}
@media all and (min-width:1025px) {
	#body {margin-left:<?=$m_w?>px;}
}
</style>

<div class="editor-menu">
	<?=$menu_con;?>
</div>