<?php
if (!defined('_GNUBOARD_')) exit;
?>

<h3>에디터 메뉴 설정</h3>
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

		<?
			// 에디터 배열에 메뉴영역 추가하기
			array_push($editor_list, 'cs_value['.$css_index.']');
		?>
		<tr>
			<th scope="row">
				<em><?=$css_index?></em>메뉴 내용
				<input type="text" name="cs_name[<?=$css_index?>]" value="menu_content" readonly size="15"/>
			</th>
			<td colspan="2">
				<?php echo help('메뉴 들어갈 내용을 자유롭게 작성해 주시길 바랍니다.') ?>
				<?php echo editor_html('cs_value['.$css_index.']', get_text($de['menu_content']['cs_value'], 0)); ?>
			</td>
		</tr <? $css_index++; ?>>

	</tbody>
</table>