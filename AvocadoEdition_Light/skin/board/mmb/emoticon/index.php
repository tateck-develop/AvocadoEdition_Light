<?
include_once('./_common.php');

// 이모티콘 목록 불러오기
$sql = "select * from {$g5['emoticon_table']} order by me_text asc";
$result = sql_query($sql);
$emotions = array();

for($i=0; $row = sql_fetch_array($result); $i++) {
	$emotions[] = $row;
}

?>
<!doctype html>
<html lang="ko" class='single'>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="HandheldFriendly" content="true">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">

<title>이모티콘 관리</title>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="<?=G5_CSS_URL?>/default.css" rel="stylesheet">
<link href="<?=G5_CSS_URL?>/style.css" rel="stylesheet">
<link href="<?=G5_DATA_URL?>/css/_design.config.css?v=<?=$config['cf_css_version']?>" rel="stylesheet"  />
<link href="./style.css" rel="stylesheet" />

<script src="<?php echo G5_JS_URL ?>/jquery-1.12.3.min.js"></script>

</head>
<body>

<? if($is_admin) { ?><form name="frmEmoticon" method="post" id="frmEmoticon" action="./update.php"  onsubmit="return femoticonlist_submit(this);" enctype="multipart/form-data"><? } ?>

	<div id="emoticon_page">
		<div id="emoticon_content">
			<? if(count($emotions) <= 0) {
					echo "<div class='no-data theme-box'><span>등록된 이모티콘이 없습니다.</span></div>";
				} else { 
			?>
				<ul class="theme-box">
					<? for($i=0; $i < count($emotions); $i++) {
						$row = $emotions[$i];
						echo "<li>";
					 ?>
							<div class="thumb">
								<img src="<?=G5_URL?><?=$row['me_img']?>" alt="" />
							</div>
							<div class="txt">
								<? if($is_admin) { ?>
									<input type="hidden" name="me_id[<?php echo $i ?>]" value="<?php echo $row['me_id'] ?>" id="me_id_<?php echo $i ?>">
									<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
								<? } ?>
								<span><?=$row['me_text']?></span>
							</div>
					<? echo "</li>"; } ?>
				</ul>
			<? } ?>
		</div>
	</div>

	<? if($is_admin) { ?>
		<div id="emoticon_control" class="theme-box">
			<div class="inner">
				<div class="emoticon-add-form">
					<div class="img form-input"><input type="file" name="me_img" accept="image/gif, image/jpeg, image/png"/><img src="" alt="" id="img" /><span><i>+</i></span></div>
					<div class="txt"><input type="text" name="me_text" class="form-input" /></div>
				</div>
				<div class="is-btn-box">
					<input type="submit" class="ui-btn point" name="act_button" value="등록"  onclick="document.pressed=this.value" />
					<input type="submit" class="ui-btn etc" name="act_button" value="삭제" onclick="document.pressed=this.value" />
				</div>
			</div>
		</div>
	<? } ?>
<? if($is_admin) { ?></form>

	<script>
		function femoticonlist_submit(f) {
			if(document.pressed == "삭제") {
				if (!is_checked("chk[]")) {
					alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
					return false;
				}
				if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
					return false;
				}
			}
			return true;
		}

		function handleImgFileSelect(e) {
			var files = e.target.files;
			var filesArr = Array.prototype.slice.call(files);
			filesArr.forEach(function(f) {
				if(!f.type.match("image.*")) {
					alert("이미지가 아닙니다.");
					return;
				}
 
				sel_file = f;
 
				var reader = new FileReader();
				reader.onload = function(e) {
					$("#img").attr("src", e.target.result);
				}
				reader.readAsDataURL(f);
			});
		}

		$(function() {
			$('*[name="me_img"]').on('change', handleImgFileSelect);
		});
	</script>
<? } ?>

</body>
</html>