<?php
if (!defined('_GNUBOARD_')) exit;

/* ******************************************************************************
※ 관리자의 디자인 정보를 저장하는 영역과 직결되는 곳입니다.
※ 코드가 잘못될 경우 전체 디자인 설정 값들이 꼬일 수 있으니 해당 페이지 작업 시 주의해 주시길 바랍니다.
--------------------------------------------------------------------------------
- cs_name : 고유 키값. 해당 속성을 불러올 때 사용할 수 있습니다.
- cs_value, cs_etc_1 ~ cs_etc_20 : 각 속성값을 저장하는 영역입니다.
****************************************************************************** */
?>

<h3>자유 배경 메뉴 설정</h3>
<table>
	<colgroup>
		<col style="width: 140px;">
		<col style="width: 140px;">
		<col>
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">
				<em><?=$css_index?></em>크기설정
				<input type="text" name="cs_name[<?=$css_index?>]" value="menu_size" readonly size="15"/>
			</th>
			<td colspan="2">
				<?php echo help('가로 사이즈는 좌측/우측 메뉴일 경우 적용됩니다. 세로 사이즈는 상단/하단 메뉴일 경우 적용됩니다.') ?>

				가로 : <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['menu_size']['cs_value'] ?>" size="5"/>px
				&nbsp;&nbsp;
				세로 : <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['menu_size']['cs_etc_1'] ?>" size="5"/>px
			</td>

		</tr <? $css_index++; ?>>

		<tr>
			<th rowspan="3" scope="row">
				<em><?=$css_index?></em>메뉴 배경
				<input type="text" name="cs_name[<?=$css_index?>]" value="menu_bak" readonly size="15"/>
			</th>
			<td rowspan="3" class="bo-right bo-left txt-center">
				<? if($de['menu_bak']['cs_value']) { ?>
					<img src="<?=$de['menu_bak']['cs_value']?>" class="prev_thumb"/>
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
			</td></tr><tr>
			<td>
				외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['menu_bak']['cs_value']?>" size="50"/>				
			</td></tr><tr>
			<td>
				배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['menu_bak']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['menu_bak']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
				&nbsp;&nbsp;

				배경반복&nbsp;&nbsp;
				<select name="cs_etc_3[<?=$css_index?>]">
					<option value="">반복</option>
					<option value="no-repeat" <?=$de['menu_bak']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
					<option value="repeat-x"  <?=$de['menu_bak']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
					<option value="repeat-y"  <?=$de['menu_bak']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
				</select>
				&nbsp;&nbsp;

				배경위치&nbsp;&nbsp;
				<select name="cs_etc_4[<?=$css_index?>]">
					<option value="">왼쪽 상단</option>
					<option value="left middle"		<?=$de['menu_bak']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
					<option value="left bottom"		<?=$de['menu_bak']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

					<option value="center top"		<?=$de['menu_bak']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
					<option value="center middle"	<?=$de['menu_bak']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
					<option value="center bottom"	<?=$de['menu_bak']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

					<option value="right top"		<?=$de['menu_bak']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
					<option value="right middle"	<?=$de['menu_bak']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
					<option value="right bottom"	<?=$de['menu_bak']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
				</select>
				&nbsp;&nbsp;

				배경크기&nbsp;&nbsp;
				<select name="cs_etc_5[<?=$css_index?>]">
					<option value="">원본크기</option>
					<option value="contain"		<?=$de['menu_bak']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
					<option value="cover"		<?=$de['menu_bak']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
					<option value="100% 100%"	<?=$de['menu_bak']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
				</select>
				&nbsp;&nbsp;
			</td>
		</tr <? $css_index++; ?>>

		<tr>
			<th rowspan="3" scope="row">
				<em><?=$css_index?></em>메뉴텍스트
				<input type="text" name="cs_name[<?=$css_index?>]" value="menu_text_link" readonly size="15"/>
			</th>
			<td class="bo-right bo-left txt-center">
				일반상태
			</td>
			<td>
				글자색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['menu_text_link']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['cs_etc_1']['cs_etc_3']?>" placeholder="0" title="투명도" style="width:45px;"/>%
				&nbsp;&nbsp;
				글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['menu_text_link']['cs_etc_2']?>" size="5"/> px
				&nbsp;&nbsp;
				글자모양&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['menu_text_link']['cs_etc_3']?>" size="30">
			</td></tr><tr>
			<td class="bo-right bo-left txt-center">
				마우스 오버
			</td>
			<td>
				글자색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['menu_text_link']['cs_etc_4'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['menu_text_link']['cs_etc_5']?>" placeholder="0" title="투명도" style="width:45px;"/>%
				&nbsp;&nbsp;
				글자크기&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['menu_text_link']['cs_etc_6']?>" size="5"/> px
			</td>
		</tr <? $css_index++; ?>>

	</tbody>
</table>