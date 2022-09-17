<?php
if (!defined('_GNUBOARD_')) exit;

// 좌측 메뉴 스타일
add_stylesheet('<link rel="stylesheet" href="'.$menu_skin_url.'/css/style.T.css">', 0);
@include_once($menu_skin_path.'/menu.L.inc.php');
?>