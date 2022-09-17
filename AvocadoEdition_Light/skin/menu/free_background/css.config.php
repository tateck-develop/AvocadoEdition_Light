<?php
if (!defined('_GNUBOARD_')) exit;

$menu_size = get_style("menu_size");
$menu_bak = get_style("menu_bak");
$menu_text_link = get_style("menu_text_link");

$m_w = $menu_size['cs_value'];
$m_h = $menu_size['cs_etc_1'];

$background = "";
if($menu_bak['cs_value']) $background .= "background-image:url('{$menu_bak['cs_value']}'); ";
if($menu_bak['cs_etc_1']) $background .= "background-color:".hex2rgba($menu_bak['cs_etc_1'], $menu_bak['cs_etc_2'])."; ";
if($menu_bak['cs_etc_3']) $background .= "background-repeat:{$menu_bak['cs_etc_3']}; ";
if($menu_bak['cs_etc_4']) $background .= "background-position:{$menu_bak['cs_etc_4']}; ";
if($menu_bak['cs_etc_5']) $background .= "background-size:{$menu_bak['cs_etc_5']}; ";

$link_color = "";
if($menu_text_link['cs_value']) $link_color .= "background-color:".hex2rgba($menu_text_link['cs_value'], $menu_text_link['cs_etc_1'])."; ";

$menu_default = "";
if($menu_text_link['cs_value']) $menu_default .= "color:".hex2rgba($menu_text_link['cs_value'], $menu_text_link['cs_etc_1'])."; ";
if($menu_text_link['cs_etc_2']) $menu_default .= "font-size:{$menu_text_link['cs_etc_2']}px; ";
if($menu_text_link['cs_etc_3']) $menu_default .= "font-family:{$menu_text_link['cs_etc_3']}, sans-serif; ";

$menu_over = "";
if($menu_text_link['cs_etc_4']) $menu_over .= "color:".hex2rgba($menu_text_link['cs_etc_4'], $menu_text_link['cs_etc_5'])."; ";
if($menu_text_link['cs_etc_6']) $menu_over .= "font-size:{$menu_text_link['cs_etc_6']}px; ";


?>