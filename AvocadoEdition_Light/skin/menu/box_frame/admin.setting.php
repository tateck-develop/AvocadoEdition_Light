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

<h3>박스 프레임 설정</h3>
<table>
	<colgroup>
		<col style="width: 140px;">
		<col style="width: 140px;">
		<col>
	</colgroup>
	<tbody>
		<tr>
			<th scope="row" rowspan="3">
				<em><?=$css_index?></em>프레임 크기
				<input type="text" name="cs_name[<?=$css_index?>]" value="box_frame_size" readonly size="15"/>
			</th>
			<td class="bo-right txt-center">크기</td>
			<td>
				<?php echo help('전체 페이지를 감쌀 가로 세로 사이즈를 지정해 주세요.') ?>
				가로 : <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_value'] ?>" size="5"/> px
				&nbsp;&nbsp;
				세로 : <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_1'] ?>" size="5"/> px
			</td></tr><tr>
			<td class="bo-right txt-center">PC 여백</td>
			<td>
				상 : <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_2'] ?>" size="5"/> px
				&nbsp;&nbsp;
				하 : <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_3'] ?>" size="5"/> px
				&nbsp;&nbsp;
				좌 : <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_4'] ?>" size="5"/> px
				&nbsp;&nbsp;
				우 : <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_5'] ?>" size="5"/> px
			</td></tr><tr>
			<td class="bo-right txt-center">모바일 여백</td>
			<td>
				상 : <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_6'] ?>" size="5"/> px
				&nbsp;&nbsp;
				하 : <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_7'] ?>" size="5"/> px
				&nbsp;&nbsp;
				좌 : <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_8'] ?>" size="5"/> px
				&nbsp;&nbsp;
				우 : <input type="text" name="cs_etc_9[<?=$css_index?>]" value="<?php echo $de['box_frame_size']['cs_etc_9'] ?>" size="5"/> px
			</td></tr>
		</tr <? $css_index++; ?>>

		<tr>
			<th rowspan="4" scope="row">
				<em><?=$css_index?></em>테두리 : 이미지
				<input type="text" name="cs_name[<?=$css_index?>]" value="box_frame_img" readonly size="15"/>

				<a href="https://webcode.tools/generators/css/border-image" target="_blank">참고예제</a>
			</th>
			<td colspan="2">
				<div class="single-info">
					<?php echo help('이미지로 설정된 테두리가 우선적으로 적용됩니다. 단순 테두리를 사용하고 싶으실 경우, 이미지 경로를 제거해주세요.') ?>
					
				</div>
			</td></tr><tr>
			<td rowspan="3" class="bo-right bo-left txt-center">
				<? if($de['box_frame_img']['cs_value']) { ?>
					<img src="<?=$de['box_frame_img']['cs_value']?>" class="prev_thumb"/>
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
			</td></tr><tr>
			<td>
				외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['box_frame_img']['cs_value']?>" size="50"/>				
			</td></tr><tr>
			<td>
				조각크기 <span style="color:#ff4742; font-weight:600;">(Slice)</span>&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['box_frame_img']['cs_etc_1'] ?>" size="5" maxlength="255" /> px
				&nbsp;&nbsp;

				반복속성 <span style="color:#ff4742; font-weight:600;">(Repeat)</span>&nbsp;&nbsp;
				<select name="cs_etc_2[<?=$css_index?>]">
					<option value="stretch">늘이기</option>
					<option value="repeat" <?=$de['box_frame_img']['cs_etc_2'] == 'repeat' ? "selected" : ""?>>반복하기</option>
					<option value="round"  <?=$de['box_frame_img']['cs_etc_2'] == 'round' ? "selected" : ""?>>이어지기</option>
					<option value="space"  <?=$de['box_frame_img']['cs_etc_2'] == 'space' ? "selected" : ""?>>간격두고 이어지기</option>
				</select>
				&nbsp;&nbsp;

				확장영역 <span style="color:#ff4742; font-weight:600;">(Outset)</span>&nbsp;&nbsp;
				<input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?php echo $de['box_frame_img']['cs_etc_3'] ?>" size="5" maxlength="255" /> px
				&nbsp;&nbsp;
			</td>
		</tr <? $css_index++; ?>>

		<tr>
			<th rowspan="2" scope="row">
				<em><?=$css_index?></em>테두리 : 일반
				<input type="text" name="cs_name[<?=$css_index?>]" value="box_frame_line" readonly size="15"/>
			</th>
			<td class="bo-right bo-left txt-center">
				라인
			</td>
			<td>
				라인색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?php echo $de['box_frame_line']['cs_value'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_1']?>" placeholder="0" title="투명도" style="width:45px;"/>%
				&nbsp;&nbsp;

				라인타입&nbsp;&nbsp;
				<select name="cs_etc_2[<?=$css_index?>]" style="width: 84px;">
					<option value="">라인없음</option>
					<option value="solid" <?=$de['box_frame_line']['cs_etc_2'] == 'solid' ? "selected" : ""?>>실선</option>
					<option value="dotted" <?=$de['box_frame_line']['cs_etc_2'] == 'dotted' ? "selected" : ""?>>점선</option>
					<option value="dashed" <?=$de['box_frame_line']['cs_etc_2'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
					<option value="double" <?=$de['box_frame_line']['cs_etc_2'] == 'double' ? "selected" : ""?>>이중선</option>
				</select>
				&nbsp;&nbsp;

				라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_3']?>" size="5"/> px
				&nbsp;&nbsp;&nbsp;&nbsp;

				<input type="checkbox" name="cs_etc_4[<?=$css_index?>][]" id="cs_etc_4_1_box_frame_line" value="top" <?=strstr($de['box_frame_line']['cs_etc_4'], 'top') ? "checked" : ""?> />
				<label for="cs_etc_4_1_box_frame_line">상&nbsp;</label>

				<input type="checkbox" name="cs_etc_4[<?=$css_index?>][]" id="cs_etc_4_2_box_frame_line" value="bottom" <?=strstr($de['box_frame_line']['cs_etc_4'], 'bottom') ? "checked" : ""?> />
				<label for="cs_etc_4_2_box_frame_line">하&nbsp;</label>

				<input type="checkbox" name="cs_etc_4[<?=$css_index?>][]" id="cs_etc_4_3_box_frame_line" value="left" <?=strstr($de['box_frame_line']['cs_etc_4'], 'left') ? "checked" : ""?> />
				<label for="cs_etc_4_3_box_frame_line">좌&nbsp;</label>

				<input type="checkbox" name="cs_etc_4[<?=$css_index?>][]" id="cs_etc_4_4_box_frame_line" value="right" <?=strstr($de['box_frame_line']['cs_etc_4'], 'right') ? "checked" : ""?> />
				<label for="cs_etc_4_4_mmb_list_item">우</label>
				
			</td></tr><tr>
			<td class="bo-right txt-center">
				모서리 라운드
			</td>
			<td>
				좌측상단 <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_5']?>" size="3"/> px
				&nbsp;&nbsp;
				우측상단 <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_6']?>" size="3"/> px
				&nbsp;&nbsp;
				우측하단 <input type="text" name="cs_etc_7[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_7']?>" size="3"/> px
				&nbsp;&nbsp;
				좌측하단 <input type="text" name="cs_etc_8[<?=$css_index?>]" value="<?=$de['box_frame_line']['cs_etc_8']?>" size="3"/> px
			</td>
		</tr <? $css_index++; ?>>

		<tr>
			<th rowspan="3" scope="row">
				<em><?=$css_index?></em>프레임 배경
				<input type="text" name="cs_name[<?=$css_index?>]" value="box_frame_bak" readonly size="15"/>
			</th>
			<td rowspan="3" class="bo-right bo-left txt-center">
				<? if($de['box_frame_bak']['cs_value']) { ?>
					<img src="<?=$de['box_frame_bak']['cs_value']?>" class="prev_thumb"/>
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
			</td></tr><tr>
			<td>
				외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['box_frame_bak']['cs_value']?>" size="50"/>				
			</td></tr><tr>
			<td>
				배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?php echo $de['box_frame_bak']['cs_etc_1'] ?>" class="colorpicker" size="30" maxlength="255" placeholder="#색상코드" /><input type="number" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['box_frame_bak']['cs_etc_2']?>" placeholder="0" title="투명도" style="width:45px;"/>%
				&nbsp;&nbsp;

				배경반복&nbsp;&nbsp;
				<select name="cs_etc_3[<?=$css_index?>]">
					<option value="">반복</option>
					<option value="no-repeat" <?=$de['box_frame_bak']['cs_etc_3'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
					<option value="repeat-x"  <?=$de['box_frame_bak']['cs_etc_3'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
					<option value="repeat-y"  <?=$de['box_frame_bak']['cs_etc_3'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
				</select>
				&nbsp;&nbsp;

				배경위치&nbsp;&nbsp;
				<select name="cs_etc_4[<?=$css_index?>]">
					<option value="">왼쪽 상단</option>
					<option value="left middle"		<?=$de['box_frame_bak']['cs_etc_4'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
					<option value="left bottom"		<?=$de['box_frame_bak']['cs_etc_4'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

					<option value="center top"		<?=$de['box_frame_bak']['cs_etc_4'] == 'center top' ? "selected" : ""?>>중간 상단</option>
					<option value="center middle"	<?=$de['box_frame_bak']['cs_etc_4'] == 'center middle' ? "selected" : ""?>>중간 중단</option>
					<option value="center bottom"	<?=$de['box_frame_bak']['cs_etc_4'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

					<option value="right top"		<?=$de['box_frame_bak']['cs_etc_4'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
					<option value="right middle"	<?=$de['box_frame_bak']['cs_etc_4'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
					<option value="right bottom"	<?=$de['box_frame_bak']['cs_etc_4'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
				</select>
				&nbsp;&nbsp;

				배경크기&nbsp;&nbsp;
				<select name="cs_etc_5[<?=$css_index?>]">
					<option value="">원본크기</option>
					<option value="contain"		<?=$de['box_frame_bak']['cs_etc_5'] == 'contain' ? "selected" : ""?>>맞춤</option>
					<option value="cover"		<?=$de['box_frame_bak']['cs_etc_5'] == 'cover' ? "selected" : ""?>>꽉참</option>
					<option value="100% 100%"	<?=$de['box_frame_bak']['cs_etc_5'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
				</select>
				&nbsp;&nbsp;
			</td>
		</tr <? $css_index++; ?>>

	</tbody>
</table>