<?php
$sub_menu = "100400";
include_once('./_common.php');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');


$sql = " select * from {$g5['menu_table']} order by me_order*1, me_id ";
$result = sql_query($sql);

$g5['title'] = "메뉴설정";
include_once('./admin.head.php');
$colspan = 8;
?>

<div class="local_desc01 local_desc">
	<p><strong>주의!</strong> 메뉴설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.</p>
</div>
<div class="local_desc01 local_desc">
	<p>아이콘 항목에 사용할 구글 아이콘 이름을 입력해주세요. ( ex. <span style="color:red">&lt;span class="material-icons"&gt;<strong>home</strong>&lt;/span&gt;</span> ▶ <strong>home</strong> 만 입력하기 )</p>
</div>

<form name="fmenulist" id="fmenulist" method="post" action="./menu_list_update.php" onsubmit="return fmenulist_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="">

<div class="btn_confirm">
	<a href="https://fonts.google.com/icons?icon.query=house&icon.set=Material+Icons" target="_blank"  class="btn ty3" title="구글 아이콘 목록 보기"><span class="material-icons">app_registration</span></a>
	<button type="button" onclick="return add_menu();" class="ty2"><span class="material-icons">add</span></button>
	<div class="btn">
		<span class="material-icons">save</span>
		<input type="submit" value="저장" class="btn_submit" accesskey="s">
	</div>
</div>

<div id="menulist" class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width:140px;">
		<col style="width:50px;">
		<col style="width:150px;">
		<col> 
		<col style="width:100px;">
		<col style="width:80px;">
		<col style="width:80px;">
		<col style="width:80px;">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">메뉴</th>
		<th scope="col" colspan="2">아이콘</th>
		<th scope="col">링크</th>
		<th scope="col">새창</th>
		<th scope="col">순서</th>
		<th scope="col">사용</th> 
		<th scope="col">관리</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'bg'.($i%2);
		$sub_menu_class = '';
		if(strlen($row['me_code']) == 4) {
			$sub_menu_class = ' sub_menu_class';
			$sub_menu_info = '<span class="sound_only">'.$row['me_name'].'의 서브</span>';
			$sub_menu_ico = '<span class="sub_menu_ico"></span>';
		}

		$search  = array('"', "'");
		$replace = array('&#034;', '&#039;');
		$me_name = str_replace($search, $replace, $row['me_name']);
	?>
	<tr class="<?php echo $bg; ?> menu_list menu_group_<?php echo substr($row['me_code'], 0, 2); ?>" data-name="<?php echo $me_name; ?>">

		<td class="td_category<?php echo $sub_menu_class; ?>">
			<input type="hidden" name="code[]" value="<?php echo substr($row['me_code'], 0, 2) ?>" /> 
			<input type="hidden" name="me_level[]" value="<?php echo $row['me_level'] ?>" /> 
			<input type="text" name="me_name[]" value="<?php echo $me_name; ?>" required class="required frm_input full_input" />
		</td>
		<td>
			<i class="material-icons"><?=$row['me_icon']?></i>
		</td>
		<td class="txt-left"> 
			<input type="text" name="me_icon[]" value="<?php echo get_text($row['me_icon']) ?>" class=" frm_input full_input" />
		</td>
		<td> 
			<input type="text" name="me_link[]" value="<?php echo $row['me_link'] ?>" id="me_link_<?php echo $i; ?>" class="frm_input full_input" />
		</td>
		<td class="td_mng"> 
			<select name="me_target[]" class=" frm_input full_input">
				<option value="self"<?php echo get_selected($row['me_target'], 'self', true); ?>>현재창</option>
				<option value="blank"<?php echo get_selected($row['me_target'], 'blank', true); ?>>새창</option> 
			</select>
		</td>
		<td class="td_num order"> 
			<input type="text" name="me_order[]" value="<?php echo $row['me_order'] ?>" id="me_order_<?php echo $i; ?>" class="frm_input full_input">
		</td>
		
		<td class="td_mng"> 
			<input type="checkbox" name="me_use[]" id="me_use_<?php echo $i; ?>" value="1" <?=$row['me_use']==1 ? "checked":"";?>> 
		</td> 
		<td class="td_mng"> 
			<button type="button" class="btn_del_menu"><span class='material-icons'>delete</span></button>
		</td>
	</tr>
	<?php
	}

	if ($i==0)
		echo '<tr id="empty_menu_list"><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>

</form>

<script>
$(function() {
    $(document).on("click", ".btn_add_submenu", function() {
        var code = $(this).closest("tr").find("input[name='code[]']").val().substr(0, 2);
        add_submenu(code);
    });

    $(document).on("click", ".btn_del_menu", function() {
        if(!confirm("메뉴를 삭제하시겠습니까?"))
            return false;

        var $tr = $(this).closest("tr");
        if($tr.find("td.sub_menu_class").size() > 0) {
            $tr.remove();
        } else {
            var code = $(this).closest("tr").find("input[name='code[]']").val().substr(0, 2);
            $("tr.menu_group_"+code).remove();
        }

        if($("#menulist tr.menu_list").size() < 1) {
            var list = "<tr id=\"empty_menu_list\"><td colspan=\"<?php echo $colspan; ?>\" class=\"empty_table\">자료가 없습니다.</td></tr>\n";
            $("#menulist table tbody").append(list);
        } else {
            $("#menulist tr.menu_list").each(function(index) {
                $(this).removeClass("bg0 bg1")
                    .addClass("bg"+(index % 2));
            });
        }
    });
});

function add_menu()
{
    var max_code = base_convert(0, 10, 36);
    $("#menulist tr.menu_list").each(function() {
        var me_code = $(this).find("input[name='code[]']").val().substr(0, 2);
        if(max_code < me_code)
            max_code = me_code;
    });

    var url = "./menu_form.php?code="+max_code+"&new=new";
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function add_submenu(code)
{
    var url = "./menu_form.php?code="+code;
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function base_convert(number, frombase, tobase) {
  //  discuss at: http://phpjs.org/functions/base_convert/
  // original by: Philippe Baumann
  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
  //   example 1: base_convert('A37334', 16, 2);
  //   returns 1: '101000110111001100110100'

  return parseInt(number + '', frombase | 0)
    .toString(tobase | 0);
}

function fmenulist_submit(f)
{
    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
