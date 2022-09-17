<?php
if (!defined('_GNUBOARD_')) exit;

// 좌측 메뉴 스타일
add_stylesheet('<link rel="stylesheet" href="'.$menu_skin_url.'/css/style.T.css">', 0);
?>

<style>
.editor-menu {height:<?=$m_h?>px; <?=$background?>}
@media all and (min-width:1025px) {
	#body {padding-top:<?=$m_h?>px;}
}
</style>

<div class="editor-menu">
	<?=$menu_con;?>
</div>