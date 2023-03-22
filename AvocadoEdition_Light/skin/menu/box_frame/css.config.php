<?php
if (!defined('_GNUBOARD_')) exit;

$box_f_size = get_style("box_frame_size");
$box_f_img = get_style("box_frame_img");
$box_f_line = get_style("box_frame_line");
$box_f_bak = get_style("box_frame_bak");

$header_inside = $box_f_size['cs_etc_10'] ? true : false;

$b_w = $box_f_size['cs_value'] ? $box_f_size['cs_value'] : 1000;
$b_h = $box_f_size['cs_etc_1'] ? $box_f_size['cs_etc_1'] : 20;

$p_t = $box_f_size['cs_etc_2'] ? $box_f_size['cs_etc_2'] : 20;
$p_b = $box_f_size['cs_etc_3'] ? $box_f_size['cs_etc_3'] : 20;
$p_l = $box_f_size['cs_etc_4'] ? $box_f_size['cs_etc_4'] : 20;
$p_r = $box_f_size['cs_etc_5'] ? $box_f_size['cs_etc_5'] : 20;

$mp_t = $box_f_size['cs_etc_6'] ? $box_f_size['cs_etc_6'] : 10;
$mp_b = $box_f_size['cs_etc_7'] ? $box_f_size['cs_etc_7'] : 10;
$mp_l = $box_f_size['cs_etc_8'] ? $box_f_size['cs_etc_8'] : 10;
$mp_r = $box_f_size['cs_etc_9'] ? $box_f_size['cs_etc_9'] : 10;

$f_img_url = $box_f_img['cs_value'];
$f_img_sli = $box_f_img['cs_etc_1'] != "" ? $box_f_img['cs_etc_1'] : 0;
$f_img_rep = $box_f_img['cs_etc_2'] != "" ? $box_f_img['cs_etc_2'] : "repeat";
$f_img_out = $box_f_img['cs_etc_3'] != "" ? $box_f_img['cs_etc_3'] : 0;

?>

<style>
<?
	/**************************************************
		Design Setting
		--------------------------------
		#design_frameBox:before 이미지 테두리 프레임
		#design_frameBox:after 일반 테두리 프레임
	**************************************************/
?>

@media all and (min-width:1025px) {html.single #header {display:block !important;}}

#design_frameBox {display:block; position:fixed; top:50%; left:50%; z-index:0; box-sizing:border-box;}
#design_frameBox:before {content:""; display:block; position:absolute; top:0; left:0; right:0; bottom:0; z-index:-1;}
#design_frameBox:after {content:""; display:block; position:absolute; top:0; left:0; right:0; bottom:0; z-index:-2;}

#body {display:block; position:relative; width:100%; height:100% !important; overflow:auto; box-sizing:border-box;}
#body > .fix-layout > .mid-layout {padding:10px !important;}

<?
	/**************************************************
		설정값에 따른 변동 부분
	**************************************************/
?>

#design_frameBox {<? echo "width:{$b_w}px; height:{$b_h}px; margin-left:-".($b_w/2)."px; margin-top:-".($b_h/2)."px; padding:{$p_t}px {$p_r}px {$p_b}px {$p_l}px;"; ?>}

@media all and (max-width:<?=($b_w+20)?>px) {#design_frameBox {left:10px; right:10px; width:auto; margin-left:0;}}
@media all and (max-height:<?=($b_h+20)?>px) {#design_frameBox {top:10px; bottom:10px; height:auto; margin-top:0;}}
@media all and (max-width:1024px) {	#design_frameBox {<? echo "padding:{$mp_t}px {$mp_r}px {$mp_b}px {$mp_l}px;"; ?>}}

<? if($f_img_url) { // 이미지 테두리가 적용되어 있을 경우 ?>
	#design_frameBox:before {<?
		echo "border:{$f_img_sli}px solid;";
		echo "border-image:url({$f_img_url}) {$f_img_sli} / {$f_img_sli}px / {$f_img_out}px {$f_img_rep};";
	?>}
	#design_frameBox:after {border:none !important;}
<? } ?>

#design_frameBox:after {<?
	if($box_f_line['cs_value']) echo "border-color:".hex2rgba($box_f_line['cs_value'], $box_f_line['cs_etc_1'])."; ";
	$box_f_line['border'] = explode("||", $box_f_line['cs_etc_4']);
	for($i=0; $i < count($box_f_line['border']); $i++) {
		if($box_f_line['border'][$i]) {
			if($box_f_line['cs_etc_2']) echo "border-{$box_f_line['border'][$i]}-style:{$box_f_line['cs_etc_2']}; ";
			if($box_f_line['cs_etc_3']) echo "border-{$box_f_line['border'][$i]}-width:{$box_f_line['cs_etc_3']}px; ";
		}
	}
	if($box_f_line['cs_etc_5']) echo "border-top-left-radius:{$box_f_line['cs_etc_5']}px; ";
	if($box_f_line['cs_etc_6']) echo "border-top-right-radius:{$box_f_line['cs_etc_6']}px; ";
	if($box_f_line['cs_etc_7']) echo "border-bottom-right-radius:{$box_f_line['cs_etc_7']}px; ";
	if($box_f_line['cs_etc_8']) echo "border-bottom-left-radius:{$box_f_line['cs_etc_8']}px; ";

	if($box_f_bak['cs_value']) echo "background-image:url('{$box_f_bak['cs_value']}'); ";
	if($box_f_bak['cs_etc_1']) echo "background-color:".hex2rgba($box_f_bak['cs_etc_1'], $box_f_bak['cs_etc_2'])."; ";
	if($box_f_bak['cs_etc_3']) echo "background-repeat:{$box_f_bak['cs_etc_3']}; ";
	if($box_f_bak['cs_etc_4']) echo "background-position:{$box_f_bak['cs_etc_4']}; ";
	if($box_f_bak['cs_etc_5']) echo "background-size:{$box_f_bak['cs_etc_5']}; ";
?>}

#design_frameBox .characterViewer {position:relative; height:100%;}
#design_frameBox .characterViewer .ch-body {position:absolute; overflow:hidden;}
#design_frameBox .characterViewer .ch-body.pop {position:fixed !important; overflow:auto !important;}
#design_frameBox .characterViewer .ch-body ~ .ch-pannel {position:absolute;}


</style>
<script>$(function() {$("#body").wrap("<div id='design_frameBox'></div>");});</script>
