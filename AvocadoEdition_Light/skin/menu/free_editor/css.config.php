<?php
if (!defined('_GNUBOARD_')) exit;

$menu_size = get_style("menu_size");
$menu_content = get_style("menu_content");

$m_w = $menu_size['cs_value'];
$m_h = $menu_size['cs_etc_1'];

$menu_con = conv_content($menu_content['cs_value'], 1, '');
?>