<?php
$sub_menu = "100300";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$sql = "ALTER TABLE {$g5['css_table']} CHANGE  `cs_value`  `cs_value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
sql_query($sql);

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '디자인 설정';
include_once ('./admin.head.php');

$design_result = sql_query("select * from {$g5['css_table']}");
$de = array();
for($i=0; $row = sql_fetch_array($design_result); $i++) {
	$de[$row['cs_name']] = $row;
}

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_007">커스텀 코드</a></li>
	<li><a href="#anc_001">화면 디자인</a></li>
	<li><a href="#anc_008">메뉴 디자인</a></li>
	<li><a href="#anc_002">대문 디자인</a></li>
	<li><a href="#anc_003">버튼 디자인</a></li>
	<li><a href="#anc_006">테이블(게시판) 디자인</a></li>
	<li><a href="#anc_004">로드비 디자인</a></li>
	<li><a href="#anc_005">기타 디자인</a></li>
</ul>';



// 폰트 입력용 CSS 추가
if(!isset($config['cf_add_fonts'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_fonts` text NOT NULL AFTER `cf_sms_use` ", true);
}

// 디자인 css 버전 처리용
if(!isset($config['cf_css_version'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_css_version` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

if($config['cf_add_fonts']) {
	$config['cf_add_fonts'] = get_text($config['cf_add_fonts'], 0);
}

$css_index = 0;
$editor_list = array();
?>

<style>
th input[type="text"] {width:100%; margin-top:5px; text-align:center; background:rgba(255,255,255,.4) !important; border:none !important; outline:0; color:#d18686 !important;}
th em {font-style:normal; font-weight:bold; color:#d18686; margin-right:5px;}
th em:before {content:"[";}
th em:after {content:"]";}
th a {display:inline-block; vertical-align:middle; padding:3px 10px; background:#ecc6c6; color:#fff; margin:5px 0 0;}
th a + a {margin-top:3px;}
</style>

<script src="<?=G5_ADMIN_URL?>/js/jquery.minicolors.min.js"></script>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<div class="btn_confirm">
	<a href="./design_guide_preview.php" onclick="popup_window(this.href, 'preview', 'width=700 height=800'); return false;" class="btn ty3" title="가이드 미리보기"><span class="material-icons">preview</span></a>
	<div class="btn">
		<span class="material-icons">save</span>
		<input type="submit" value="저장" class="btn_submit" accesskey="s">
	</div>
</div>


<section id="anc_007">
	<h2 class="h2_frm">커스텀 코드</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						폰트 스타일
						<a href="https://noonnu.cc/index" target="_blank">눈누 폰트</a>
						<a href="https://fonts.google.com/" target="_blank">구글 폰트</a>
					</th>
					<td colspan="2">
						<?php echo help('사이트에서 사용할 폰트 스타일을 정의해주세요. ex) @font-face {....} or @import url(...);') ?>
						<textarea name="cf_add_fonts"><?=$config['cf_add_fonts']?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						추가 script, css
						<a href="https://wsss.tistory.com/category/Mouse/Mouse%20Effect" target="_blank">web's 블로그</a>
						<a href="https://tympanus.net/codrops/" target="_blank">Codrops</a>
					</th>
					<td colspan="2">
						<?php echo help('기본 설정된 파일 경로 및 script, css 를 추가하거나 변경할 수 있습니다.') ?>
						<?php echo help('잘못된 코드가 들어갈 경우, 사이트 전체에 문제가 생길 수 있으므로 주의하여 주시길 바랍니다.') ?>
						<textarea name="cf_add_script" id="cf_add_script"><?php echo get_text($config['cf_add_script']); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>


<section id="anc_001">
	<h2 class="h2_frm">화면 디자인 설정</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<em><?=$css_index?></em>헤더사용
						<input type="text" name="cs_name[<?=$css_index?>]" value="use_header" readonly size="15" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<?php echo help('메뉴 영역 사용에 대한 선택입니다. 내용만 출력하실 경우 사용하지 않음을 선택해 주세요.') ?>
						<select name="cs_value[<?=$css_index?>]">
							<option value="">좌측</option>
							<option value="R" <?=$de['use_header']['cs_value'] == 'R' ? "selected" : ""?>>우측</option>
							<option value="T" <?=$de['use_header']['cs_value'] == 'T' ? "selected" : ""?>>상단</option>
							<option value="B" <?=$de['use_header']['cs_value'] == 'B' ? "selected" : ""?>>하단</option>
							<option value="N" <?=$de['use_header']['cs_value'] == 'N' ? "selected" : ""?>>사용하지 않음</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th scope="row">
						<em><?=$css_index?></em>화면가로영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="content_width" readonly size="15" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<?php echo help('컨텐츠가 보일 가로 크기를 지정해주세요.') ?>
						<input type="number" name="cs_value[<?=$css_index?>]" value="<?=$de['content_width']['cs_value']?>" size="5" style="width:5em;"/>px
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
		<br />
		<table>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>로고
						<input type="text" name="cs_name[<?=$css_index?>]" value="logo" readonly size="15"/>
					</th>
					<td rowspan="2" class="bo-right bo-left txt-center">
						<? if($de['logo']['cs_value']) { ?>
							<img src="<?=$de['logo']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['logo']['cs_value']?>" size="50"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="background" readonly size="15"/>
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['background']['cs_value']) { ?>
							<img src="<?=$de['background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['background']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['background']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['background']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['background']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['background']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['background']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['background']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['background']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center middle"	<?=$de['background']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['background']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['background']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['background']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['background']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['background']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['background']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['background']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>모바일 배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="m_background" readonly size="15"/>
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['m_background']['cs_value']) { ?>
							<img src="<?=$de['m_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['m_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['m_background']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['m_background']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['m_background']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['m_background']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['m_background']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['m_background']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['m_background']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['m_background']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center middle"	<?=$de['m_background']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['m_background']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['m_background']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['m_background']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['m_background']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['m_background']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['m_background']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['m_background']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

<section id="anc_008">
	<h2 class="h2_frm">메뉴 디자인 설정</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<em><?=$css_index?></em>메뉴스킨
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_skin" readonly size="15"/>
					</th>
					<td colspan="2">
						<?php
							if(!$de['menu_skin']['cs_value']) $de['menu_skin']['cs_value'] = 'basic';
							echo help('스킨을 선택하신 후 저장하시면 각 스킨에 설정돤 디자인 설정 항목을 추가로 확인 가능합니다.');
						?>
						<?php echo help('스킨에 따라 없는 경우도 있습니다.') ?>
						<?php echo get_skin_select('menu', '', 'cs_value['.$css_index.']', $de['menu_skin']['cs_value'], ''); ?>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>메뉴 툴팁
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_tooltip" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경
					</td>
					<td>
						메뉴색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['menu_tooltip']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						글자
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['menu_tooltip']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;
						글자모양&nbsp;&nbsp; <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_9']?>" size="30">
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_5']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_6']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_7']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?=$de['menu_tooltip']['cs_etc_8']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="4" scope="row">
						<em><?=$css_index?></em>메뉴 아이콘
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_icon" readonly size="15"/>
					</th>
					<td colspan="2">
						<div class="single-info"><?php echo help('메뉴영역 및 캐릭터 게시판의 각종 프로그램 플러그인 링크 스타일에 함께 적용됩니다.') ?></div>
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						배경
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['menu_icon']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						그라데이션&nbsp;&nbsp;
						0% <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['menu_icon']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						~ 
						100% <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['menu_icon']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['menu_icon']['cs_etc_6'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_7']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_8[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['menu_icon']['cs_etc_8'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['menu_icon']['cs_etc_8'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['menu_icon']['cs_etc_8'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['menu_icon']['cs_etc_8'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_9']?>" size="5"/> px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						아이콘
					</td>
					<td>
						아이콘색상&nbsp;&nbsp; <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?php echo $de['menu_icon']['cs_etc_10'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_11']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						크기&nbsp;&nbsp; <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['menu_icon']['cs_etc_12']?>" size="5"/> px
						&nbsp;&nbsp;
						형태&nbsp;&nbsp;
						<select name="cs_etc_13[<?=$css_index?>]" style="width:100px;">
							<option value="diamond" <?=$de['menu_icon']['cs_etc_13'] == 'diamond' ? "selected" : ""?>>마름모</option>
							<option value="circle" <?=$de['menu_icon']['cs_etc_13'] == 'circle' ? "selected" : ""?>>원형</option>
							<option value="square" <?=$de['menu_icon']['cs_etc_13'] == 'square' ? "selected" : ""?>>사각형</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
		<br />
		<?
			//------- 메뉴 스킨 확장 설정 처리 부분
			@include_once(G5_PATH."/skin/menu/".$de['menu_skin']['cs_value']."/admin.setting.php");
		?>

	</div>
</section>


<section id="anc_002">
	<h2 class="h2_frm">대문디자인</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<em><?=$css_index?></em>대문 사용
						<input type="text" name="cs_name[<?=$css_index?>]" value="intro_use" readonly size="15" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<select name="cs_value[<?=$css_index?>]">
							<option value="">사용</option>
							<option value="N" <?=$de['intro_use']['cs_value'] == 'N' ? "selected" : ""?>>사용하지 않음</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th scope="row" rowspan="3">
						<em><?=$css_index?></em>대문 배경설정
						<input type="text" name="cs_name[<?=$css_index?>]" value="intro_background" readonly size="15" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['intro_background']['cs_value']) { ?>
							<img src="<?=$de['intro_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['intro_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['intro_background']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['intro_background']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['intro_background']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['intro_background']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['intro_background']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['intro_background']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['intro_background']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['intro_background']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center middle"	<?=$de['intro_background']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['intro_background']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['intro_background']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['intro_background']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['intro_background']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['intro_background']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['intro_background']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['intro_background']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th scope="row" rowspan="4">
						<em><?=$css_index?></em>내용 설정
						<input type="text" name="cs_name[<?=$css_index?>]" value="intro" readonly size="15" />
					</th>
					<td rowspan="2" class="bo-right bo-left txt-center">
						<? if($de['intro']['cs_value']) { ?>
							<img src="<?=$de['intro']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['intro']['cs_value']?>" size="50"/>
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						안내문 내용
					</td>
					<td>
						<input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['intro']['cs_etc_1']?>" size="100"/>
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						글자
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['intro']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['intro']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['intro']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;
						글자모양&nbsp;&nbsp; <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['intro']['cs_etc_5']?>" size="30">
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
	</div>
</section>

<section id="anc_003">
	<h2 class="h2_frm">버튼 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 140px;">
			<col style="width: 140px;">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th rowspan="3" scope="row">
					<em><?=$css_index?></em>기본버튼
					<input type="text" name="cs_name[<?=$css_index?>]" value="btn_default" readonly size="15"/>
				</th>
				<td class="bo-right bo-left txt-center">
					일반상태
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

				</td></tr><tr>
				<td class="bo-right bo-left txt-center">
					마우스 오버
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_etc_6'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_7']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_etc_8'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_9']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?php echo $de['btn_default']['cs_etc_10'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_11']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;
				</td></tr><tr>
				<td class="bo-right txt-center">
					모서리 라운드
				</td>
				<td>
					좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_12']?>" size="3"/> px
					&nbsp;&nbsp;
					우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_13']?>" size="3"/> px
					&nbsp;&nbsp;
					우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_14']?>" size="3"/> px
					&nbsp;&nbsp;
					좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_15']?>" size="3"/> px
				</td>
			</tr <? $css_index++; ?>>

			<tr>
				<th rowspan="3" scope="row">
					<em><?=$css_index?></em>포인트버튼
					<input type="text" name="cs_name[<?=$css_index?>]" value="btn_point" readonly size="15"/>
				</th>
				<td class="bo-right bo-left txt-center">
					일반상태
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

				</td></tr><tr>
				<td class="bo-right bo-left txt-center">
					마우스 오버
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_etc_6'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_7']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_etc_8'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_9']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?php echo $de['btn_point']['cs_etc_10'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_11']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;
				</td></tr><tr>
				<td class="bo-right txt-center">
					모서리 라운드
				</td>
				<td>
					좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_12']?>" size="3"/> px
					&nbsp;&nbsp;
					우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_13']?>" size="3"/> px
					&nbsp;&nbsp;
					우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_14']?>" size="3"/> px
					&nbsp;&nbsp;
					좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_15']?>" size="3"/> px
				</td>
			</tr <? $css_index++; ?>>

			<tr>
				<th rowspan="3" scope="row">
					<em><?=$css_index?></em>기타버튼
					<input type="text" name="cs_name[<?=$css_index?>]" value="btn_etc" readonly size="15"/>
				</th>
				<td class="bo-right bo-left txt-center">
					일반상태
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

				</td></tr><tr>
				<td class="bo-right bo-left txt-center">
					마우스 오버
				</td>
				<td>
					배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_etc_6'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_7']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_etc_8'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_9']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;

					라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?php echo $de['btn_etc']['cs_etc_10'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_11']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					&nbsp;&nbsp;
				</td></tr><tr>
				<td class="bo-right txt-center">
					모서리 라운드
				</td>
				<td>
					좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_12']?>" size="3"/> px
					&nbsp;&nbsp;
					우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_13']?>" size="3"/> px
					&nbsp;&nbsp;
					우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_14']?>" size="3"/> px
					&nbsp;&nbsp;
					좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_15']?>" size="3"/> px
				</td>
			</tr <? $css_index++; ?>>

		</tbody>
		</table>
	</div>
</section>


<section id="anc_006">
	<h2 class="h2_frm">테이블(게시판)디자인</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				
				<tr>
					<th rowspan="4" scope="row">
						<em><?=$css_index?></em>공지사항 박스
						<input type="text" name="cs_name[<?=$css_index?>]" value="board_notice" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['board_notice']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						글자
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['board_notice']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['board_notice']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['board_notice']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['board_notice']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['board_notice']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['board_notice']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_board_notice" value="top" <?=strstr($de['board_notice']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_board_notice">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_board_notice" value="bottom" <?=strstr($de['board_notice']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_board_notice">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_board_notice" value="left" <?=strstr($de['board_notice']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_board_notice">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_board_notice" value="right" <?=strstr($de['board_notice']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list_item">우</label>
						
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_9']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_10']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_11']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['board_notice']['cs_etc_12']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>전체테이블
						<input type="text" name="cs_name[<?=$css_index?>]" value="board_table" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						<?php echo help('배경색을 지정할 경우, 전체 테이블 안쪽으로 여백이 생깁니다.') ?>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['board_table']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['board_table']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['board_table']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['board_table']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['board_table']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['board_table']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['board_table']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_board_table" value="top" <?=strstr($de['board_table']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_board_table">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_board_table" value="bottom" <?=strstr($de['board_table']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_board_table">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_board_table" value="left" <?=strstr($de['board_table']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_board_table">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_board_table" value="right" <?=strstr($de['board_table']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_board_table">우</label>
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_9']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_10']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_11']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_12']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>목록 : 제목
						<input type="text" name="cs_name[<?=$css_index?>]" value="list_header" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['list_header']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['list_header']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['list_header']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['list_header']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['list_header']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['list_header']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['list_header']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_list_header" value="top" <?=strstr($de['list_header']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_list_header">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_list_header" value="bottom" <?=strstr($de['list_header']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_list_header">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_list_header" value="left" <?=strstr($de['list_header']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_list_header">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_list_header" value="right" <?=strstr($de['list_header']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_list_header">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>목록 : 내용
						<input type="text" name="cs_name[<?=$css_index?>]" value="list_body" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['list_body']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['list_body']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['list_body']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['list_body']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['list_body']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['list_body']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['list_body']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_list_body" value="top" <?=strstr($de['list_body']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_list_body">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_list_body" value="bottom" <?=strstr($de['list_body']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_list_body">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_list_body" value="left" <?=strstr($de['list_body']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_list_body">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_list_body" value="right" <?=strstr($de['list_body']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_list_body">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>양식 : 제목
						<input type="text" name="cs_name[<?=$css_index?>]" value="form_header" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['form_header']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['form_header']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['form_header']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['form_header']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['form_header']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['form_header']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['form_header']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_form_header" value="top" <?=strstr($de['form_header']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_form_header">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_form_header" value="bottom" <?=strstr($de['form_header']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_form_header">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_form_header" value="left" <?=strstr($de['form_header']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_form_header">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_form_header" value="right" <?=strstr($de['form_header']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_form_header">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>양식 : 내용
						<input type="text" name="cs_name[<?=$css_index?>]" value="form_body" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['form_body']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['form_body']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['form_body']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['form_body']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['form_body']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['form_body']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['form_body']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_form_body" value="top" <?=strstr($de['form_body']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_form_body">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_form_body" value="bottom" <?=strstr($de['form_body']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_form_body">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_form_body" value="left" <?=strstr($de['form_body']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_form_body">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_form_body" value="right" <?=strstr($de['form_body']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_form_body">우</label>
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
	</div>
</section>

<section id="anc_004">
	<h2 class="h2_frm">로드비 게시판 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>페이지 배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_contain_bak" readonly size="15"/>
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['mmb_contain_bak']['cs_value']) { ?>
							<img src="<?=$de['mmb_contain_bak']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_contain_bak']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['mmb_contain_bak']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_contain_bak']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['mmb_contain_bak']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['mmb_contain_bak']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['mmb_contain_bak']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center middle"	<?=$de['mmb_contain_bak']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['mmb_contain_bak']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['mmb_contain_bak']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['mmb_contain_bak']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['mmb_contain_bak']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['mmb_contain_bak']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['mmb_contain_bak']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>리스트영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_list" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_list']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['mmb_list']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['mmb_list']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_list']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_list']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_list']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_list']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_mmb_list" value="top" <?=strstr($de['mmb_list']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_mmb_list">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_mmb_list" value="bottom" <?=strstr($de['mmb_list']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_mmb_list">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_mmb_list" value="left" <?=strstr($de['mmb_list']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_mmb_list">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_mmb_list" value="right" <?=strstr($de['mmb_list']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>게시물 영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_list_item" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_list_item']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['mmb_list_item']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['mmb_list_item']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_list_item']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_list_item']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_list_item']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_list_item']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_mmb_list_item" value="top" <?=strstr($de['mmb_list_item']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_mmb_list_item">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_mmb_list_item" value="bottom" <?=strstr($de['mmb_list_item']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_mmb_list_item">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_mmb_list_item" value="left" <?=strstr($de['mmb_list_item']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_mmb_list_item">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_mmb_list_item" value="right" <?=strstr($de['mmb_list_item']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list_item">우</label>
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						하단여백
					</td>
					<td>
						<input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_9']?>" size="10"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>로그 영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_log" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_log']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['mmb_log']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['mmb_log']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_log']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_log']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_log']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_log']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_mmb_log" value="top" <?=strstr($de['mmb_log']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_mmb_log">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_mmb_log" value="bottom" <?=strstr($de['mmb_log']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_mmb_log">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_mmb_log" value="left" <?=strstr($de['mmb_log']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_mmb_log">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_mmb_log" value="right" <?=strstr($de['mmb_log']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_log">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row">
						<em><?=$css_index?></em>코멘트 영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_reply" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_reply']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['mmb_reply']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['mmb_reply']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_reply']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_reply']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_reply']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_reply']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_mmb_reply" value="top" <?=strstr($de['mmb_reply']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_mmb_reply">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_mmb_reply" value="bottom" <?=strstr($de['mmb_reply']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_mmb_reply">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_mmb_reply" value="left" <?=strstr($de['mmb_reply']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_mmb_reply">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_mmb_reply" value="right" <?=strstr($de['mmb_reply']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list_item">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row">
						<em><?=$css_index?></em>각 코멘트 영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_reply_item" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경/글자
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_reply_item']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['mmb_reply_item']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['mmb_reply_item']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_reply_item']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_reply_item']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_reply_item']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_reply_item']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_mmb_reply_item" value="top" <?=strstr($de['mmb_reply_item']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_mmb_reply_item">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_mmb_reply_item" value="bottom" <?=strstr($de['mmb_reply_item']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_mmb_reply_item">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_mmb_reply_item" value="left" <?=strstr($de['mmb_reply_item']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_mmb_reply_item">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_mmb_reply_item" value="right" <?=strstr($de['mmb_reply_item']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list_item">우</label>
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						하단여백
					</td>
					<td>
						<input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_9']?>" size="10"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[작성자] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_name" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_name']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_name']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_name']['cs_etc_2']?>" size="5"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[로그작성자] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_owner_name" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_owner_name']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_2']?>" size="5"/> px
						&nbsp;&nbsp;
						접두문자&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_3']?>" size="5"/>
						&nbsp;&nbsp;
						접미문자&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_4']?>" size="5"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[날짜] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_datetime" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_datetime']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_datetime']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_datetime']['cs_etc_2']?>" size="5"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[외부링크] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_link" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_link']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_link']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[로그앵커] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_log_ank" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_log_ank']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_log_ank']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>[해시태그] 글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_hash" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['mmb_hash']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_hash']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

<section id="anc_005">
	<h2 class="h2_frm">기타 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 140px;">
				<col>
			</colgroup>
			<tbody>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>기본글자
						<input type="text" name="cs_name[<?=$css_index?>]" value="default_font" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['default_font']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['default_font']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['default_font']['cs_etc_2']?>" size="5"/>px
						&nbsp;&nbsp;
						글자모양&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['default_font']['cs_etc_3']?>" size="40"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>기본색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_default" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['color_default']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['color_default']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>전경색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_bak" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['color_bak']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['color_bak']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row">
						<em><?=$css_index?></em>강조색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_point" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['color_point']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['color_point']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" rowspan="4">
						<em><?=$css_index?></em>입력폼
						<input type="text" name="cs_name[<?=$css_index?>]" value="input_bak" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['input_bak']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						높이&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_2']?>" size="5"/>px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						글자
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?php echo $de['input_bak']['cs_etc_3'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_4']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_5']?>" size="5"/>px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['input_bak']['cs_etc_6'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_7']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_8']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_9']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_10']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_11']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" rowspan="4">
						<em><?=$css_index?></em>기본박스
						<input type="text" name="cs_name[<?=$css_index?>]" value="box_style" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						배경
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['box_style']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						글자
					</td>
					<td>
						글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['box_style']['cs_etc_2'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['box_style']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_6[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['box_style']['cs_etc_6'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['box_style']['cs_etc_6'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['box_style']['cs_etc_6'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['box_style']['cs_etc_6'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_7']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_1_box_style" value="top" <?=strstr($de['box_style']['cs_etc_8'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_8_1_box_style">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_2_box_style" value="bottom" <?=strstr($de['box_style']['cs_etc_8'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_8_2_box_style">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_3_box_style" value="left" <?=strstr($de['box_style']['cs_etc_8'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_8_3_box_style">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_8[<?=$css_index?>][]" id="cs_etc_8_4_box_style" value="right" <?=strstr($de['box_style']['cs_etc_8'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_8_4_mmb_list_item">우</label>
						
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_9']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_10[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_10']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_11[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_11']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_12']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" rowspan="4">
						<em><?=$css_index?></em>스크롤 색상
						<input type="text" name="cs_name[<?=$css_index?>]" value="scrollbar" readonly size="15"/>
					</th>
					<td class="bo-right bo-left txt-center">
						트랙
					</td>
					<td>
						트랙색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['scrollbar']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
						트랙넓이&nbsp;&nbsp;<input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_2']?>" size="3"/> px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						스크롤바
					</td>
					<td>
						스크롤색상&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?php echo $de['scrollbar']['cs_etc_3'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_4']?>" placeholder="0" title="투명도" style="width:45px;"/>%
						&nbsp;&nbsp;
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_5']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_6']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_7']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?=$de['scrollbar']['cs_etc_8']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

</form>

<script>

$(function() {
	$('*[name]').each(function() {
		let title = $(this).attr('name');
		title = title.replace(/\[(.*)\]/gi, "");
		$(this).attr('title', title);
	});
});

function fconfigform_submit(f)
{
	f.action = "./design_form_update.php";
	<?
		if(is_array($editor_list) && count($editor_list) > 0) {
			foreach($editor_list as $edit) {
				echo get_editor_js($edit);
			}
		}
	?>
	return true;
}
$('.colorpicker').minicolors();
</script>

<?php
include_once ('./admin.tail.php');
?>
