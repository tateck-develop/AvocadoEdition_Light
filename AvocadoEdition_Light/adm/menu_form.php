<?php
$sub_menu = "100400";
include_once('./_common.php');

if ($is_admin != 'super')
	alert_close('최고관리자만 접근 가능합니다.');

$g5['title'] = '메뉴 추가';
include_once(G5_PATH.'/head.sub.php');

// 코드
if($new == 'new' || !$code) {
	$code = base_convert(substr($code,0, 2), 36, 10);
	$code += 36;
	$code = base_convert($code, 10, 36);
}
?>
<style>
	body{min-width:100%;}
</style>

<div id="menu_frm" class="new_win">
	<h1><?php echo $g5['title']; ?></h1>

	<form name="fmenuform" id="fmenuform" enctype="multipart/form-data">

	<div class="new_win_desc">
		<label for="me_type">대상선택</label>
		<select name="me_type" id="me_type">
			<option value="">직접입력</option> 
			<option value="board">게시판</option>
			<option value="content">페이지</option>
		</select>
	</div>

	<div class="win-guide">구분선을 추가하실 경우, 메뉴 명에 <em>구분선</em>이라고 입력 후 추가 해주세요.</div>

	<div id="menu_result"></div>

	</form>

</div>

<script>
$(function() {
	$("#menu_result").load(
		"./menu_form_search.php"
	);

	$("#me_type").on("change", function() {
		var type = $(this).val();

		$("#menu_result").empty().load(
			"./menu_form_search.php",
			{ type : type }
		);
	});

	$(document).on("click", "#add_manual", function() {
		var me_name = $.trim($("#me_name").val());
		var me_link = $.trim($("#me_link").val());

		add_menu_list(me_name, me_link, "<?php echo $code; ?>");
	});

	$(document).on("click", ".add_select", function() {
		var me_name = $.trim($(this).siblings("input[name='subject[]']").val());
		var me_link = $.trim($(this).siblings("input[name='link[]']").val());

		add_menu_list(me_name, me_link, "<?php echo $code; ?>");
	});
});

function add_menu_list(name, link, code)
{
	var $menulist = $("#menulist", opener.document);
	var ms = new Date().getTime();
	var sub_menu_class;
	<?php if($new == 'new') { ?>
	sub_menu_class = " class=\"td_category\"";
	<?php } else { ?>
	sub_menu_class = " class=\"td_category sub_menu_class\"";
	<?php } ?>

	var list = "";
	list += "<tr class=\"menu_list menu_group_<?php echo $code; ?>\" data-name='"+name+"'>";
	list += "<td"+sub_menu_class+">"; 
	list += "	<input type=\"hidden\" name=\"code[]\" value=\"<?php echo $code; ?>\" />";
	list += "	<input type=\"hidden\" name=\"me_level[]\" value=\"\" />";
	list += "	<input type=\"text\" name=\"me_name[]\" value=\""+name+"\" id=\"me_name_"+ms+"\" required class=\"required frm_input full_input\" />";
	list += "</td>";
	list += "<td></td>"; 
	list += "<td>"; 
	list += "	<input type=\"text\" name=\"me_icon[]\" class=\"frm_input full_input\" />";
	list += "</td>";
	list += "<td>"; 
	list += "	<input type=\"text\" name=\"me_link[]\" value=\""+link+"\" class=\"frm_input full_input\" />";
	list += "</td>";
	list += "<td class=\"td_mng\">"; 
	list += "	<select name=\"me_target[]\">";
	list += "		<option value=\"self\">현재창</option>";
	list += "		<option value=\"blank\">새창</option>"; 
	list += "	</select>";
	list += "</td>";
	list += "<td class=\"td_numsmall  order\">";
	list += "	<input type=\"text\" name=\"me_order[]\" value=\"0\" required class=\"required frm_input\" size=\"5\">";
	list += "</td>";
	list += "<td class=\"td_numsmall\">";
	list += "	<input type=\"checkbox\" name=\"me_use[]\" value=\"1\" class=\"frm_input\" checked>";
	list += "</td>";
	list += "<td class=\"td_mngsmall\">";
	list += "	<button type=\"button\" class=\"btn_del_menu\"><span class=''><span class='material-icons'>delete</span></button>";
	list += "</td>";
	list += "</tr>";

	var $menu_last = null;

	if(code)
		$menu_last = $menulist.find("tr.menu_group_"+code+":last");
	else
		$menu_last = $menulist.find("tr.menu_list:last");

	if($menu_last.size() > 0) {
		$menu_last.after(list);
	} else {
		if($menulist.find("#empty_menu_list").size() > 0)
			$menulist.find("#empty_menu_list").remove();

		$menulist.find("table tbody").append(list);
	}

	$menulist.find("tr.menu_list").each(function(index) {
		$(this).removeClass("bg0 bg1")
			.addClass("bg"+(index % 2));
	});

	window.close();
}
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>