<? 
@include_once('./_common.php');


// CSS 설정 가져오기
$css_sql = sql_query("select * from {$g5['css_table']}");
$css = array();
for($i=0; $cs = sql_fetch_array($css_sql); $i++) {
	$css[$cs['cs_name']][0] = $cs['cs_value'];
	$css[$cs['cs_name']][1] = $cs['cs_etc_1'];
	$css[$cs['cs_name']][2] = $cs['cs_etc_2'];
	$css[$cs['cs_name']][3] = $cs['cs_etc_3'];
	$css[$cs['cs_name']][4] = $cs['cs_etc_4'];
	$css[$cs['cs_name']][5] = $cs['cs_etc_5'];
	$css[$cs['cs_name']][6] = $cs['cs_etc_6'];
	$css[$cs['cs_name']][7] = $cs['cs_etc_7'];
	$css[$cs['cs_name']][8] = $cs['cs_etc_8'];
	$css[$cs['cs_name']][9] = $cs['cs_etc_9'];
	$css[$cs['cs_name']][10] = $cs['cs_etc_10'];

	$css[$cs['cs_name']][11] = $cs['cs_etc_11'];
	$css[$cs['cs_name']][12] = $cs['cs_etc_12'];
	$css[$cs['cs_name']][13] = $cs['cs_etc_13'];
	$css[$cs['cs_name']][14] = $cs['cs_etc_14'];
	$css[$cs['cs_name']][15] = $cs['cs_etc_15'];
	$css[$cs['cs_name']][16] = $cs['cs_etc_16'];
	$css[$cs['cs_name']][17] = $cs['cs_etc_17'];
	$css[$cs['cs_name']][18] = $cs['cs_etc_18'];
	$css[$cs['cs_name']][19] = $cs['cs_etc_19'];
	$css[$cs['cs_name']][20] = $cs['cs_etc_20'];
}
$tab_width = 1024;

$is_item_area = false;
$is_comment_area = false;

?>
@charset "utf-8";

/***************************************************************
	Design Manager Setting Style: 자동생성 CSS
---------------------------------------------------------------
	- 최종 수정일 : <?=date('Y-m-d H:i:s')?> 
	- 모바일 사이즈 기준 (공통) : <?=$tab_width?>px
***************************************************************/

<?=stripslashes($cf_add_fonts)?> 


/**************************************************************
	기본 레이아웃
***************************************************************/
<?
	// -- 레이아웃 변수 계산하기
	$content_width = !$css['content_width'][0] ? 1000 : $css['content_width'][0];
	$max_content_width = $content_width + 160;
	$middle_content_width = $content_width + 40;
?>

.fix-layout { <? echo "max-width:{$max_content_width}px; "; ?>}
@media all and (max-width:<?=$max_content_width?>px) {
	.fix-layout { <? echo "max-width:{$middle_content_width}px; "; ?>}
	#body > .fix-layout > .mid-layout {padding-left:20px; padding-right:20px;}
}


/**************************************************************
	기본 폰트 설정
***************************************************************/

* {<? if($css['default_font'][3]) echo "font-family:{$css['default_font'][3]}, sans-serif; "; ?>}
body { <?
	if($css['default_font'][0]) echo "color:".hex2rgba($css['default_font'][0], $css['default_font'][1])."; ";
	if($css['default_font'][2]) echo "font-size:{$css['default_font'][2]}px; ";
	if($css['default_font'][3]) echo "font-family:{$css['default_font'][3]}, sans-serif; ";
?>}
.txt-default { <?
	if($css['color_default'][0]) echo "color:".hex2rgba($css['color_default'][0], $css['color_default'][1])."; ";
?>}
a, .txt-point, .sch_word { <?
	if($css['color_point'][0]) echo "color:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
?>}

.txt-menu-font {<? if($css['menu_tooltip'][9]) echo "font-family:{$css['menu_tooltip'][9]}, sans-serif; "; ?>}


/**************************************************************
	사이트 배경 설정
***************************************************************/

.enterWrapper { <?
	if($css['intro_background'][0]) echo "background-image:url('{$css['intro_background'][0]}'); ";
	if($css['intro_background'][1]) echo "background-color:".hex2rgba($css['intro_background'][1], $css['intro_background'][2])."; ";
	if($css['intro_background'][3]) echo "background-repeat:{$css['intro_background'][3]}; ";
	if($css['intro_background'][4]) echo "background-position:{$css['intro_background'][4]}; ";
	if($css['intro_background'][5]) echo "background-size:{$css['intro_background'][5]}; ";
?>}
.enterWrapper .guide { <?
	if($css['intro'][2]) echo "color:".hex2rgba($css['intro'][2], $css['intro'][3])."; ";
	if($css['intro'][4]) echo "font-size:{$css['intro'][4]}px; ";
	if($css['intro'][5]) echo "font-family:{$css['intro'][5]}, sans-serif; ";
?>}


@media all and (min-width: <?=($tab_width + 1)?>px) { 
	.admin-preview-box,
	html.single:before { <?
		if($css['background'][0]) echo "background-image:url('{$css['background'][0]}'); ";
		if($css['background'][1]) echo "background-color:".hex2rgba($css['background'][1], $css['background'][2])."; ";
		if($css['background'][3]) echo "background-repeat:{$css['background'][3]}; ";
		if($css['background'][4]) echo "background-position:{$css['background'][4]}; ";
		if($css['background'][5]) echo "background-size:{$css['background'][5]}; ";
	?>}
}

@media all and (max-width: <?=$tab_width?>px) {
	.admin-preview-box,
	html.single:before { <?
		if($css['m_background'][0]) echo "background-image:url('{$css['m_background'][0]}'); ";
		if($css['m_background'][1]) echo "background-color:".hex2rgba($css['m_background'][1], $css['m_background'][2])."; ";
		if($css['m_background'][3]) echo "background-repeat:{$css['m_background'][3]}; ";
		if($css['m_background'][4]) echo "background-position:{$css['m_background'][4]}; ";
		if($css['m_background'][5]) echo "background-size:{$css['m_background'][5]}; ";
	?>}
}


/**************************************************************
	메뉴 스타일 설정
***************************************************************/

/* 관리자 미리보기 스타일 정의 */
.admin-preview-box .gnbWrap { <? if($css['menu_icon'][12]) echo "font-size:{$css['menu_icon'][12]}px; "; ?>}
.admin-preview-box .gnbWrap .tooltips { <? if($css['menu_tooltip'][9]) echo "font-family:{$css['menu_tooltip'][9]}, sans-serif; "; ?>}

#topCont a .icons,
.icons-link-box .icons,
.admin-preview-box .gnbWrap .icons { <?
	if($css['menu_icon'][10]) echo "color:".hex2rgba($css['menu_icon'][10], $css['menu_icon'][11])."; ";
	if($css['menu_icon'][13] == 'diamond') echo "height:3.3em; ";
?>}

#topCont a .icons:before,
.icons-link-box a .icons:before,
.admin-preview-box .gnbWrap .icons:before { <?
	switch($css['menu_icon'][13]) {
		case "diamond":
			echo "top:50%; left:50%; right:auto; bottom:auto; width:2.1em; height:2.1em; margin:-1.05em 0 0 -1.05em; transform:rotate(-45deg); -webkit-transform:rotate(-45deg); ";
		break;
		case "circle":
			echo "border-radius:100%; ";
		break;
		case "square":
			echo "";
		break;
	}
	if($css['menu_icon'][0]) echo "background-color:".hex2rgba($css['menu_icon'][0], $css['menu_icon'][1])."; ";
	if($css['menu_icon'][2]) echo "background:linear-gradient(0deg, ".hex2rgba($css['menu_icon'][2], $css['menu_icon'][3])." 0%, ".hex2rgba($css['menu_icon'][4], $css['menu_icon'][5])." 100%); ";
	if($css['menu_icon'][6]) echo "border-color:".hex2rgba($css['menu_icon'][6], $css['menu_icon'][7])."; ";
	if($css['menu_icon'][8]) echo "border-style:{$css['menu_icon'][8]}; ";
	if($css['menu_icon'][9]) echo "border-width:{$css['menu_icon'][9]}px; ";
?>}
.admin-preview-box .gnbWrap .tooltips { <?
	if($css['menu_tooltip'][0]) echo "background-color:".hex2rgba($css['menu_tooltip'][0], $css['menu_tooltip'][1])."; ";
	if($css['menu_tooltip'][2]) echo "color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
	if($css['menu_tooltip'][4]) echo "font-size:{$css['menu_tooltip'][4]}px; ";
	if($css['menu_tooltip'][5]) echo "border-top-left-radius:{$css['menu_tooltip'][5]}px; ";
	if($css['menu_tooltip'][6]) echo "border-top-right-radius:{$css['menu_tooltip'][6]}px; ";
	if($css['menu_tooltip'][7]) echo "border-bottom-right-radius:{$css['menu_tooltip'][7]}px; ";
	if($css['menu_tooltip'][8]) echo "border-bottom-left-radius:{$css['menu_tooltip'][8]}px; ";
?>}

/* 사용자단 스타일 정의 */
#header .gnbWrap,
#mo_header .gnbWrap { <? if($css['menu_icon'][12]) echo "font-size:{$css['menu_icon'][12]}px; "; ?>}
#header .gnbWrap .tooltips,
#mo_header .gnbWrap .tooltips { <? if($css['menu_tooltip'][9]) echo "font-family:{$css['menu_tooltip'][9]}, sans-serif; "; ?>}

@media all and (min-width: <?=($tab_width + 1)?>px) { 
	#header { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo "top:0; bottom:0; left:20px; ";
			break;
			case "R" : // 우측 배치
				echo "top:0; bottom:0; right:20px; ";
			break;
			case "T" : // 상단 배치
				echo "top:10px; left:0; right:0; ";
			break;
			case "B" : // 하단 배치
				echo "bottom:10px; left:0; right:0; ";
			break;
		}
	?>}
	#header .gnbWrap { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo "top:50%; left:0; transform:translateY(-50%); -webkit-transform:translateY(-50%); ";
			break;
			case "R" : // 우측 배치
				echo "top:50%; right:0; transform:translateY(-50%); -webkit-transform:translateY(-50%); ";
			break;
			case "T" : // 상단 배치
				echo "top:0; left:0; right:0; text-align:center; ";
			break;
			case "B" : // 하단 배치
				echo "bottom:0; left:0; right:0; text-align:center; ";
			break;
		}
	?>}
	#header .gnbWrap li { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo " ";
			break;
			case "R" : // 우측 배치
				echo " ";
			break;
			case "T" : // 상단 배치
				echo "display:inline-block; vertical-align:top; ";
			break;
			case "B" : // 하단 배치
				echo "display:inline-block; vertical-align:top; ";
			break;
		}
	?>}
	#header .gnbWrap li.line { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo "display:block; position:relative; height:.5em; ";
			break;
			case "R" : // 우측 배치
				echo "display:block; position:relative; height:.5em; ";
			break;
			case "T" : // 상단 배치
				echo "display:inline-block; position:relative; width:.5em; ";
			break;
			case "B" : // 하단 배치
				echo "display:inline-block; position:relative; width:.5em; ";
			break;
		}
	?>}
	#header .gnbWrap .tooltips { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo "margin-left:.5em; left:80%; top:50%; transform:translateY(-50%); -webkit-transform:translateY(-50%); ";
			break;
			case "R" : // 우측 배치
				echo "margin-right:.5em; right:80%; top:50%; transform:translateY(-50%); -webkit-transform:translateY(-50%); ";
			break;
			case "T" : // 상단 배치
				echo "margin-top:.5em; top:80%; left:50%; transform:translateX(-50%); -webkit-transform:translateX(-50%); ";
			break;
			case "B" : // 하단 배치
				echo "margin-bottom:.5em; bottom:80%; left:50%; transform:translateX(-50%); -webkit-transform:translateX(-50%); ";
			break;
		}
	?>}
	#header .gnbWrap a:hover .tooltips { <?
		switch($css['use_header'][0]) {
			case "" : // 좌측 배치
				echo "left:100%; ";
			break;
			case "R" : // 우측 배치
				echo "right:100%; ";
			break;
			case "T" : // 상단 배치
				echo "top:100%; ";
			break;
			case "B" : // 하단 배치
				echo "bottom:100%; ";
			break;
		}
	?>}
	
	#header .gnbWrap .icons { <?
		if($css['menu_icon'][10]) echo "color:".hex2rgba($css['menu_icon'][10], $css['menu_icon'][11])."; ";
		if($css['menu_icon'][13] == 'diamond') echo "height:3.3em; ";
	?>}
	#header .gnbWrap .icons:before { <?
		switch($css['menu_icon'][13]) {
			case "diamond":
				echo "top:50%; left:50%; right:auto; bottom:auto; width:2.1em; height:2.1em; margin:-1.05em 0 0 -1.05em; transform:rotate(-45deg); -webkit-transform:rotate(-45deg); ";
			break;
			case "circle":
				echo "border-radius:100%; ";
			break;
			case "square":
				echo "";
			break;
		}
		if($css['menu_icon'][0]) echo "background-color:".hex2rgba($css['menu_icon'][0], $css['menu_icon'][1])."; ";
		if($css['menu_icon'][2]) echo "background:linear-gradient(0deg, ".hex2rgba($css['menu_icon'][2], $css['menu_icon'][3])." 0%, ".hex2rgba($css['menu_icon'][4], $css['menu_icon'][5])." 100%); ";
		if($css['menu_icon'][6]) echo "border-color:".hex2rgba($css['menu_icon'][6], $css['menu_icon'][7])."; ";
		if($css['menu_icon'][8]) echo "border-style:{$css['menu_icon'][8]}; ";
		if($css['menu_icon'][9]) echo "border-width:{$css['menu_icon'][9]}px; ";
	?>}
	#header .gnbWrap .tooltips { <?
		if($css['menu_tooltip'][0]) echo "background-color:".hex2rgba($css['menu_tooltip'][0], $css['menu_tooltip'][1])."; ";
		if($css['menu_tooltip'][2]) echo "color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
		if($css['menu_tooltip'][4]) echo "font-size:{$css['menu_tooltip'][4]}px; ";
		if($css['menu_tooltip'][5]) echo "border-top-left-radius:{$css['menu_tooltip'][5]}px; ";
		if($css['menu_tooltip'][6]) echo "border-top-right-radius:{$css['menu_tooltip'][6]}px; ";
		if($css['menu_tooltip'][7]) echo "border-bottom-right-radius:{$css['menu_tooltip'][7]}px; ";
		if($css['menu_tooltip'][8]) echo "border-bottom-left-radius:{$css['menu_tooltip'][8]}px; ";
	?>}
}
@media all and (max-width: <?=$tab_width?>px) {
	#mo_header { <?
		if($css['menu_tooltip'][0]) echo "background-color:".hex2rgba($css['menu_tooltip'][0], $css['menu_tooltip'][1])."; ";
		if($css['menu_tooltip'][2]) echo "color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
	?>}
	#mo_header .gnbWrap a { <?
		if($css['menu_tooltip'][2]) echo "color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
	?>}
	#mo_header .gnbWrap li.line { <?
		if($css['menu_tooltip'][2]) echo "background-color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
	?>}
	body.open-gnb .control-mobile-menu { <?
		if($css['menu_tooltip'][2]) echo "color:".hex2rgba($css['menu_tooltip'][2], $css['menu_tooltip'][3])."; ";
	?>}
}



/**************************************************************
	스크롤 / 마우스 드래그 블록 색상 지정
***************************************************************/

*::-webkit-scrollbar { <?
	if($css['scrollbar'][2]) echo "width:{$css['scrollbar'][2]}px; height:{$css['scrollbar'][2]}px; ";
?>}
*::-webkit-scrollbar-track { <?
	if($css['scrollbar'][0]) echo "background-color:".hex2rgba($css['scrollbar'][0], $css['scrollbar'][1])."; ";
?>}
*::-webkit-scrollbar-thumb { <?
	if($css['scrollbar'][3]) echo "background-color:".hex2rgba($css['scrollbar'][3], $css['scrollbar'][4])."; ";
	if($css['scrollbar'][5]) echo "border-top-left-radius:{$css['scrollbar'][5]}px; ";
	if($css['scrollbar'][6]) echo "border-top-right-radius:{$css['scrollbar'][6]}px; ";
	if($css['scrollbar'][7]) echo "border-bottom-right-radius:{$css['scrollbar'][7]}px; ";
	if($css['scrollbar'][8]) echo "border-bottom-left-radius:{$css['scrollbar'][8]}px; ";
?>}

* { <? if($css['color_point'][0]) echo "outline-color:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; "; ?>}

::selection { <?
	if($css['color_point'][0]) echo "background:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
	if($css['color_bak'][0]) echo "color:".hex2rgba($css['color_bak'][0], $css['color_bak'][1])."; ";
?>}
::-moz-selection { <?
	if($css['color_point'][0]) echo "background:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
	if($css['color_bak'][0]) echo "color:".hex2rgba($css['color_bak'][0], $css['color_bak'][1])."; ";
?>}
::-webkit-selection { <?
	if($css['color_point'][0]) echo "background:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
	if($css['color_bak'][0]) echo "color:".hex2rgba($css['color_bak'][0], $css['color_bak'][1])."; ";
?>}


/**************************************************************
	버튼 색상 지정
***************************************************************/

.ui-btn { <?
	if($css['input_bak'][2]) echo "height:{$css['input_bak'][2]}px; ";
	if($css['input_bak'][5]) echo "font-size:{$css['input_bak'][5]}px; ";

	if($css['btn_default'][12]) echo "border-top-left-radius:{$css['btn_default'][12]}px; ";
	if($css['btn_default'][13]) echo "border-top-right-radius:{$css['btn_default'][13]}px; ";
	if($css['btn_default'][14]) echo "border-bottom-right-radius:{$css['btn_default'][14]}px; ";
	if($css['btn_default'][15]) echo "border-bottom-left-radius:{$css['btn_default'][15]}px; ";

	if($css['btn_default'][0]) echo "background-color:".hex2rgba($css['btn_default'][0], $css['btn_default'][1])."; ";
	if($css['btn_default'][2]) echo "color:".hex2rgba($css['btn_default'][2], $css['btn_default'][3])."; ";
	if($css['btn_default'][4]) echo "border-color:".hex2rgba($css['btn_default'][4], $css['btn_default'][5])."; ";
?>}
.ui-btn:hover { <?
	if($css['btn_default'][6]) echo "background-color:".hex2rgba($css['btn_default'][6], $css['btn_default'][7])."; ";
	if($css['btn_default'][8]) echo "color:".hex2rgba($css['btn_default'][8], $css['btn_default'][9])."; ";
	if($css['btn_default'][10]) echo "border-color:".hex2rgba($css['btn_default'][10], $css['btn_default'][11])."; ";
?>}
.ui-btn.point { <?
	if($css['btn_point'][12]) echo "border-top-left-radius:{$css['btn_point'][12]}px; ";
	if($css['btn_point'][13]) echo "border-top-right-radius:{$css['btn_point'][13]}px; ";
	if($css['btn_point'][14]) echo "border-bottom-right-radius:{$css['btn_point'][14]}px; ";
	if($css['btn_point'][15]) echo "border-bottom-left-radius:{$css['btn_point'][15]}px; ";

	if($css['btn_point'][0]) echo "background-color:".hex2rgba($css['btn_point'][0], $css['btn_point'][1])."; ";
	if($css['btn_point'][2]) echo "color:".hex2rgba($css['btn_point'][2], $css['btn_point'][3])."; ";
	if($css['btn_point'][4]) echo "border-color:".hex2rgba($css['btn_point'][4], $css['btn_point'][5])."; ";
?>}
.ui-btn.point:hover { <?
	if($css['btn_point'][6]) echo "background-color:".hex2rgba($css['btn_point'][6], $css['btn_point'][7])."; ";
	if($css['btn_point'][8]) echo "color:".hex2rgba($css['btn_point'][8], $css['btn_point'][9])."; ";
	if($css['btn_point'][10]) echo "border-color:".hex2rgba($css['btn_point'][10], $css['btn_point'][11])."; ";
?>}
.ui-btn.etc { <?
	if($css['btn_etc'][12]) echo "border-top-left-radius:{$css['btn_etc'][12]}px; ";
	if($css['btn_etc'][13]) echo "border-top-right-radius:{$css['btn_etc'][13]}px; ";
	if($css['btn_etc'][14]) echo "border-bottom-right-radius:{$css['btn_etc'][14]}px; ";
	if($css['btn_etc'][15]) echo "border-bottom-left-radius:{$css['btn_etc'][15]}px; ";

	if($css['btn_etc'][0]) echo "background-color:".hex2rgba($css['btn_etc'][0], $css['btn_etc'][1])."; ";
	if($css['btn_etc'][2]) echo "color:".hex2rgba($css['btn_etc'][2], $css['btn_etc'][3])."; ";
	if($css['btn_etc'][4]) echo "border-color:".hex2rgba($css['btn_etc'][4], $css['btn_etc'][5])."; ";
?>}
.ui-btn.etc:hover { <?
	if($css['btn_etc'][6]) echo "background-color:".hex2rgba($css['btn_etc'][6], $css['btn_etc'][7])."; ";
	if($css['btn_etc'][8]) echo "color:".hex2rgba($css['btn_etc'][8], $css['btn_etc'][9])."; ";
	if($css['btn_etc'][10]) echo "border-color:".hex2rgba($css['btn_etc'][10], $css['btn_etc'][11])."; ";
?>}

a.ui-btn { <?
	if($css['input_bak'][2]) echo "line-height:".($css['input_bak'][2]-2)."px; ";
?>}
.ui-btn.small { <?
	if($css['input_bak'][2]) echo "height:".($css['input_bak'][2]-10)."px; ";
?>}
a.ui-btn.small { <?
	if($css['input_bak'][2]) echo "line-height:".($css['input_bak'][2]-10)."px; ";
?>}
.ui-btn.big { <?
	if($css['input_bak'][5]) echo "font-size:".($css['input_bak'][5]+3)."px; ";
	if($css['input_bak'][2]) echo "height:".($css['input_bak'][2]+10)."px; ";
?>}
a.ui-btn.big { <?
	if($css['input_bak'][2]) echo "line-height:".($css['input_bak'][2]+8)."px; ";
?>}


/**************************************************************
	검색박스 영역
***************************************************************/

#bo_sch { <? if($css['input_bak'][2]) echo "margin-top:".($css['input_bak'][2])."px; ";?>}
#bo_sch button { <? if($css['input_bak'][2]) echo "width:".($css['input_bak'][2])."px; height:".($css['input_bak'][2])."px; font-size:".($css['input_bak'][2]/2)."px; ";?>}


/**************************************************************
	글 상세보기 영역
***************************************************************/

#bo_list,
#bo_w,
#bo_v { <?
	if($css['board_table'][0]) echo "padding:1.5em; background-color:".hex2rgba($css['board_table'][0], $css['board_table'][1])."; ";
	if($css['board_table'][2]) echo "color:".hex2rgba($css['board_table'][2], $css['board_table'][3])."; ";
	if($css['board_table'][4]) echo "border-color:".hex2rgba($css['board_table'][4], $css['board_table'][5])."; ";
	$css['board_table']['border'] = explode("||", $css['board_table'][8]);
	for($i=0; $i < count($css['board_table']['border']); $i++) {
		if($css['board_table']['border'][$i]) {
			if($css['board_table'][6]) echo "border-{$css['board_table']['border'][$i]}-style:{$css['board_table'][6]}; ";
			if($css['board_table'][7]) echo "border-{$css['board_table']['border'][$i]}-width:{$css['board_table'][7]}px; ";
		}
	}

	if($css['board_table'][9]) echo "border-top-left-radius:{$css['board_table'][9]}px; ";
	if($css['board_table'][10]) echo "border-top-right-radius:{$css['board_table'][10]}px; ";
	if($css['board_table'][11]) echo "border-bottom-right-radius:{$css['board_table'][11]}px; ";
	if($css['board_table'][12]) echo "border-bottom-left-radius:{$css['board_table'][12]}px; ";
?>}

#bo_v .board-title,
#bo_v .board-info,
#bo_v #bo_vc,
#bo_v #bo_v_bot { <?
	if($css['form_body'][4]) echo "border-color:".hex2rgba($css['form_body'][4], $css['form_body'][5])."; ";
?>}
#bo_v .board-title,
#bo_v .board-info { <?
	if($css['form_body'][6]) echo "border-bottom-style:{$css['form_body'][6]}; ";
	if($css['form_body'][7]) echo "border-bottom-width:{$css['form_body'][7]}px; ";
?>}
#bo_v #bo_vc,
#bo_v #bo_v_bot { <?
	if($css['form_body'][6]) echo "border-top-style:{$css['form_body'][6]}; ";
	if($css['form_body'][7]) echo "border-top-width:{$css['form_body'][7]}px; ";
?>}

#bo_v .board-title > * { <?
	if($css['color_point'][0]) echo "color:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
?>}
#bo_v #bo_vc .is-reply { <?
	if($css['form_body'][4]) echo "border-color:".hex2rgba($css['form_body'][4], $css['form_body'][5])."; ";
?>}



/**************************************************************
	페이징 스타일 설정
***************************************************************/

.pg_wrap { <?
	if($css['input_bak'][5]) echo "font-size:{$css['input_bak'][5]}px; ";
?>}
.pg_wrap .pg_page { <?
	if($css['default_font'][0]) echo "color:".hex2rgba($css['default_font'][0], $css['default_font'][1])."; ";
?>}
.pg_wrap .pg_page:hover { <?
	if($css['color_point'][0]) echo "color:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
?>}
.pg_wrap .pg_control { <?
	if($css['color_default'][0]) echo "color:".hex2rgba($css['color_default'][0], $css['color_default'][1])."; ";
?>}
.pg_wrap .pg_current { <?
	if($css['color_point'][0]) echo "color:".hex2rgba($css['color_point'][0], $css['color_point'][1])."; ";
?>}


/**************************************************************
	구분선 설정
***************************************************************/

hr.line	{ <?
	if($css['default_font'][0]) echo "background:".hex2rgba($css['default_font'][0], $css['default_font'][1])."; ";	
?>}


/**************************************************************
	인풋 타입
***************************************************************/

.form-input,
input[type="file"],
input[type="text"],
input[type="number"],
input[type="password"],
select { <?
	if($css['input_bak'][2]) echo "height:{$css['input_bak'][2]}px; ";
?>}

.form-input,
input[type="file"],
input[type="text"],
input[type="number"],
input[type="password"],
textarea,
select { <?
	$css['input_bak'][4] = $css['input_bak'][4] == "" ? 0 : $css['input_bak'][4];
	if($css['input_bak'][0]) echo "background-color:".hex2rgba($css['input_bak'][0], $css['input_bak'][1])."; ";
	if($css['input_bak'][6]) echo "border-color:".hex2rgba($css['input_bak'][6], $css['input_bak'][7])."; ";
	if($css['input_bak'][3]) echo "color:".hex2rgba($css['input_bak'][3], $css['input_bak'][4])."; ";

	if($css['input_bak'][5]) echo "font-size:{$css['input_bak'][5]}px; ";
	if($css['input_bak'][8]) echo "border-top-left-radius:{$css['input_bak'][8]}px; ";
	if($css['input_bak'][9]) echo "border-top-right-radius:{$css['input_bak'][9]}px; ";
	if($css['input_bak'][10]) echo "border-bottom-right-radius:{$css['input_bak'][10]}px; ";
	if($css['input_bak'][11]) echo "border-bottom-left-radius:{$css['input_bak'][11]}px; ";
?>}

*::placeholder { <?if($css['input_bak'][3]) echo "color:".hex2rgba($css['input_bak'][3], ($css['input_bak'][4]+50))."; ";?>}


/**************************************************************
	기본박스 설정
***************************************************************/

.theme-box { <?
	if($css['box_style'][0]) echo "background-color:".hex2rgba($css['box_style'][0], $css['box_style'][1])."; ";
	if($css['box_style'][2]) echo "color:".hex2rgba($css['box_style'][2], $css['box_style'][3])."; ";
	if($css['box_style'][4]) echo "border-color:".hex2rgba($css['box_style'][4], $css['box_style'][5])."; ";

	if($css['box_style'][9]) echo "border-top-left-radius:{$css['box_style'][9]}px; ";
	if($css['box_style'][10]) echo "border-top-right-radius:{$css['box_style'][10]}px; ";
	if($css['box_style'][11]) echo "border-bottom-right-radius:{$css['box_style'][11]}px; ";
	if($css['box_style'][12]) echo "border-bottom-left-radius:{$css['box_style'][12]}px; ";

	$css['box_style']['border'] = explode("||", $css['box_style'][8]);
	for($i=0; $i < count($css['box_style']['border']); $i++) {
		if($css['box_style']['border'][$i]) {
			if($css['box_style'][6]) echo "border-{$css['box_style']['border'][$i]}-style:{$css['box_style'][6]}; ";
			if($css['box_style'][7]) echo "border-{$css['box_style']['border'][$i]}-width:{$css['box_style'][7]}px; ";
		}
	}
?>}

.board-notice-box { <?
	if($css['board_notice'][0]) echo "background-color:".hex2rgba($css['board_notice'][0], $css['board_notice'][1])."; ";
	if($css['board_notice'][2]) echo "color:".hex2rgba($css['board_notice'][2], $css['board_notice'][3])."; ";
	if($css['board_notice'][4]) echo "border-color:".hex2rgba($css['board_notice'][4], $css['board_notice'][5])."; ";

	if($css['board_notice'][9]) echo "border-top-left-radius:{$css['board_notice'][9]}px; ";
	if($css['board_notice'][10]) echo "border-top-right-radius:{$css['board_notice'][10]}px; ";
	if($css['board_notice'][11]) echo "border-bottom-right-radius:{$css['board_notice'][11]}px; ";
	if($css['board_notice'][12]) echo "border-bottom-left-radius:{$css['board_notice'][12]}px; ";

	$css['board_notice']['border'] = explode("||", $css['board_notice'][8]);
	for($i=0; $i < count($css['board_notice']['border']); $i++) {
		if($css['board_notice']['border'][$i]) {
			if($css['board_notice'][6]) echo "border-{$css['board_notice']['border'][$i]}-style:{$css['board_notice'][6]}; ";
			if($css['board_notice'][7]) echo "border-{$css['board_notice']['border'][$i]}-width:{$css['board_notice'][7]}px; ";
		}
	}
?>}


/**************************************************************
	테이블 설정
***************************************************************/

.theme-list thead th { <?
	if($css['list_header'][0]) echo "background-color:".hex2rgba($css['list_header'][0], $css['list_header'][1])."; ";
	if($css['list_header'][2]) echo "color:".hex2rgba($css['list_header'][2], $css['list_header'][3])."; ";
	if($css['list_header'][4]) echo "border-color:".hex2rgba($css['list_header'][4], $css['list_header'][5])."; ";
	$css['list_header']['border'] = explode("||", $css['list_header'][8]);
	for($i=0; $i < count($css['list_header']['border']); $i++) {
		if($css['list_header']['border'][$i]) {
			if($css['list_header'][6]) echo "border-{$css['list_header']['border'][$i]}-style:{$css['list_header'][6]}; ";
			if($css['list_header'][7]) echo "border-{$css['list_header']['border'][$i]}-width:{$css['list_header'][7]}px; ";
		}
	}
?>}
.theme-list tbody th,
.theme-list tbody td { <?
	if($css['list_body'][0]) echo "background-color:".hex2rgba($css['list_body'][0], $css['list_body'][1])."; ";
	if($css['list_body'][2]) echo "color:".hex2rgba($css['list_body'][2], $css['list_body'][3])."; ";
	if($css['list_body'][4]) echo "border-color:".hex2rgba($css['list_body'][4], $css['list_body'][5])."; ";
	$css['list_body']['border'] = explode("||", $css['list_body'][8]);
	for($i=0; $i < count($css['list_body']['border']); $i++) {
		if($css['list_body']['border'][$i]) {
			if($css['list_body'][6]) echo "border-{$css['list_body']['border'][$i]}-style:{$css['list_body'][6]}; ";
			if($css['list_body'][7]) echo "border-{$css['list_body']['border'][$i]}-width:{$css['list_body'][7]}px; ";
		}
	}
?>}

.theme-form tbody th { <?
	if($css['form_header'][0]) echo "background-color:".hex2rgba($css['form_header'][0], $css['form_header'][1])."; ";
	if($css['form_header'][2]) echo "color:".hex2rgba($css['form_header'][2], $css['form_header'][3])."; ";
	if($css['form_header'][4]) echo "border-color:".hex2rgba($css['form_header'][4], $css['form_header'][5])."; ";
	$css['form_header']['border'] = explode("||", $css['form_header'][8]);
	for($i=0; $i < count($css['form_header']['border']); $i++) {
		if($css['form_header']['border'][$i]) {
			if($css['form_header'][6]) echo "border-{$css['form_header']['border'][$i]}-style:{$css['form_header'][6]}; ";
			if($css['form_header'][7]) echo "border-{$css['form_header']['border'][$i]}-width:{$css['form_header'][7]}px; ";
		}
	}
?>}
.theme-form tbody td { <?
	if($css['form_body'][0]) echo "background-color:".hex2rgba($css['form_body'][0], $css['form_body'][1])."; ";
	if($css['form_body'][2]) echo "color:".hex2rgba($css['form_body'][2], $css['form_body'][3])."; ";
	if($css['form_body'][4]) echo "border-color:".hex2rgba($css['form_body'][4], $css['form_body'][5])."; ";
	$css['form_body']['border'] = explode("||", $css['form_body'][8]);
	for($i=0; $i < count($css['form_body']['border']); $i++) {
		if($css['form_body']['border'][$i]) {
			if($css['form_body'][6]) echo "border-{$css['form_body']['border'][$i]}-style:{$css['form_body'][6]}; ";
			if($css['form_body'][7]) echo "border-{$css['form_body']['border'][$i]}-width:{$css['form_body'][7]}px; ";
		}
	}
?>}




/**************************************************************
	로드비 게시판 설정
***************************************************************/

#load_log_board { <?
	if($css['mmb_contain_bak'][0]) echo "background-image:url('{$css['mmb_contain_bak'][0]}'); ";
	if($css['mmb_contain_bak'][1]) echo "background-color:".hex2rgba($css['mmb_contain_bak'][1], $css['mmb_contain_bak'][2])."; ";
	if($css['mmb_contain_bak'][3]) echo "background-repeat:{$css['mmb_contain_bak'][3]}; ";
	if($css['mmb_contain_bak'][4]) echo "background-position:{$css['mmb_contain_bak'][4]}; ";
	if($css['mmb_contain_bak'][5]) echo "background-size:{$css['mmb_contain_bak'][5]}; ";
?>}

#log_list { <?
	if($css['mmb_list'][0]) echo "background-color:".hex2rgba($css['mmb_list'][0], $css['mmb_list'][1])."; ";
	if($css['mmb_list'][2]) echo "color:".hex2rgba($css['mmb_list'][2], $css['mmb_list'][3])."; ";
	if($css['mmb_list'][4]) echo "border-color:".hex2rgba($css['mmb_list'][4], $css['mmb_list'][5])."; ";
	$css['mmb_list']['border'] = explode("||", $css['mmb_list'][8]);
	for($i=0; $i < count($css['mmb_list']['border']); $i++) {
		if($css['mmb_list']['border'][$i]) {
			if($css['mmb_list'][6]) echo "border-{$css['mmb_list']['border'][$i]}-style:{$css['mmb_list'][6]}; ";
			if($css['mmb_list'][7]) echo "border-{$css['mmb_list']['border'][$i]}-width:{$css['mmb_list'][7]}px; ";
		}
	}
?>}

#log_list .item { <?
	if($css['mmb_list_item'][0]) $is_item_area = true;
	if($css['mmb_list_item'][0]) echo "background-color:".hex2rgba($css['mmb_list_item'][0], $css['mmb_list_item'][1])."; ";
	if($css['mmb_list_item'][2]) echo "color:".hex2rgba($css['mmb_list_item'][2], $css['mmb_list_item'][3])."; ";
	if($css['mmb_list_item'][4]) echo "border-color:".hex2rgba($css['mmb_list_item'][4], $css['mmb_list_item'][5])."; ";
	$css['mmb_list_item']['border'] = explode("||", $css['mmb_list_item'][8]);
	for($i=0; $i < count($css['mmb_list_item']['border']); $i++) {
		if($css['mmb_list_item']['border'][$i]) {
			if($css['mmb_list_item'][6]) echo "border-{$css['mmb_list_item']['border'][$i]}-style:{$css['mmb_list_item'][6]}; ";
			if($css['mmb_list_item'][7]) echo "border-{$css['mmb_list_item']['border'][$i]}-width:{$css['mmb_list_item'][7]}px; ";
		}
	}
	if($css['mmb_list_item'][9]) echo "margin-bottom:{$css['mmb_list_item'][9]}px; ";
?>}

#log_list .item .item-inner .ui-pic { <?
	if($css['mmb_log'][0]) echo "background-color:".hex2rgba($css['mmb_log'][0], $css['mmb_log'][1])."; ";
	if($css['mmb_log'][2]) echo "color:".hex2rgba($css['mmb_log'][2], $css['mmb_log'][3])."; ";
	if($css['mmb_log'][4]) echo "border-color:".hex2rgba($css['mmb_log'][4], $css['mmb_log'][5])."; ";
	$css['mmb_log']['border'] = explode("||", $css['mmb_log'][8]);
	for($i=0; $i < count($css['mmb_log']['border']); $i++) {
		if($css['mmb_log']['border'][$i]) {
			if($css['mmb_log'][6]) echo "border-{$css['mmb_log']['border'][$i]}-style:{$css['mmb_log'][6]}; ";
			if($css['mmb_log'][7]) echo "border-{$css['mmb_log']['border'][$i]}-width:{$css['mmb_log'][7]}px; ";
		}
	}
?>}

#log_list .item .item-inner .item-comment { <?
	if($css['mmb_reply_item'][0]) $is_comment_area = true;
	if($css['mmb_reply_item'][0]) echo "background-color:".hex2rgba($css['mmb_reply_item'][0], $css['mmb_reply_item'][1])."; ";
	if($css['mmb_reply_item'][2]) echo "color:".hex2rgba($css['mmb_reply_item'][2], $css['mmb_reply_item'][3])."; ";
	if($css['mmb_reply_item'][4]) echo "border-color:".hex2rgba($css['mmb_reply_item'][4], $css['mmb_reply_item'][5])."; ";
	$css['mmb_reply_item']['border'] = explode("||", $css['mmb_reply_item'][8]);
	for($i=0; $i < count($css['mmb_reply_item']['border']); $i++) {
		if($css['mmb_reply_item']['border'][$i]) {
			if($css['mmb_reply_item'][6]) echo "border-{$css['mmb_reply_item']['border'][$i]}-style:{$css['mmb_reply_item'][6]}; ";
			if($css['mmb_reply_item'][7]) echo "border-{$css['mmb_reply_item']['border'][$i]}-width:{$css['mmb_reply_item'][7]}px; ";
		}
	}
	if($css['mmb_reply_item'][9]) echo "margin-bottom:{$css['mmb_reply_item'][9]}px; ";
?>}

#log_list .item .item-inner .ui-comment { <?
	if($css['mmb_reply'][0]) $is_comment_area = true;
	if($css['mmb_reply'][0]) echo "background-color:".hex2rgba($css['mmb_reply'][0], $css['mmb_reply'][1])."; ";
	if($css['mmb_reply'][2]) echo "color:".hex2rgba($css['mmb_reply'][2], $css['mmb_reply'][3])."; ";
	if($css['mmb_reply'][4]) echo "border-color:".hex2rgba($css['mmb_reply'][4], $css['mmb_reply'][5])."; ";
	$css['mmb_reply']['border'] = explode("||", $css['mmb_reply'][8]);
	for($i=0; $i < count($css['mmb_reply']['border']); $i++) {
		if($css['mmb_reply']['border'][$i]) {
			if($css['mmb_reply'][6]) echo "border-{$css['mmb_reply']['border'][$i]}-style:{$css['mmb_reply'][6]}; ";
			if($css['mmb_reply'][7]) echo "border-{$css['mmb_reply']['border'][$i]}-width:{$css['mmb_reply'][7]}px; ";
		}
	}
	if($is_item_area && $is_comment_area) echo "padding-left:15px; padding-right:15px;";
?>}

#log_list .item .item-inner .co-header p,
#log_list .item .item-inner .co-header p a { <?
	if($css['mmb_name'][0]) echo "color:".hex2rgba($css['mmb_name'][0], $css['mmb_name'][1])."; ";
	if($css['mmb_name'][2]) echo "font-size:{$css['mmb_name'][2]}px; ";
?>}

#log_list .item .item-inner .co-header p.owner,
#log_list .item .item-inner .co-header p.owner a { <?
	if($css['mmb_owner_name'][0]) echo "color:".hex2rgba($css['mmb_owner_name'][0], $css['mmb_owner_name'][1])."; ";
	if($css['mmb_owner_name'][2]) echo "font-size:{$css['mmb_owner_name'][2]}px; ";
?>}

#log_list .item .item-inner .co-footer .date { <?
	if($css['mmb_datetime'][0]) echo "color:".hex2rgba($css['mmb_datetime'][0], $css['mmb_datetime'][1])."; ";
	if($css['mmb_datetime'][2]) echo "font-size:{$css['mmb_datetime'][2]}px; ";
?>}

#log_list .item .item-inner .co-content .other-site-link { <?
	if($css['mmb_link'][0]) echo "color:".hex2rgba($css['mmb_link'][0], $css['mmb_link'][1])."; ";
?>}

#log_list .item .item-inner .co-content .link_hash_tag { <?
	if($css['mmb_hash'][0]) echo "color:".hex2rgba($css['mmb_hash'][0], $css['mmb_hash'][1])."; ";
?>}

#log_list .item .item-inner .co-content .log_link_tag { <?
	if($css['mmb_log_ank'][0]) echo "color:".hex2rgba($css['mmb_log_ank'][0], $css['mmb_log_ank'][1])."; ";
?>}
