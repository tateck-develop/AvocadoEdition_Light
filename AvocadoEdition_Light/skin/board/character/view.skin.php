<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once($board_skin_path.'/_setting.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($write['wr_type'] == 'pair') {
	goto_url($list_href.$qstr);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/js/css/swiper.css">', 0);

$body_cnt = sql_fetch("select count(*) as cnt from {$g5['character_body_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}'");
$body_cnt = $body_cnt['cnt'];

$check_body = $write['wr_2'];
if($body_cnt > 0) {
	$check_bodys = sql_fetch("select bd_url from {$g5['character_body_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bd_use = '1'");
	$check_body = $check_bodys['bd_url'] ? $check_bodys['bd_url'] : $check_body;
}


$color_bak = get_style('color_bak');
$color_line_color = $color_bak['cs_value'];
$color_bak_off = hex2rgba($color_bak['cs_value'], 30);
$color_bak_over = hex2rgba($color_bak['cs_value'], 5);

$default_font = get_style('default_font');
$default_font = hex2rgba($default_font['cs_value'], $default_font['cs_etc_1']);
?>
<script>
	var skin_path = "<?=$board['bo_skin']?>";
	var skin_url = g5_url + "/skin/board/" + skin_path;
</script>
<style>
:root {
	--pannel-line:<?=$color_line_color?>;
	--pannel-bak:<?=$color_bak_off?>;
	--pannel-bak-over:<?=$color_bak_over?>;
}
</style>
<div class="loading">
	<div>
		<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
		<p>Loading...</p>
	</div>
</div>
<div class="characterViewer">
	
	<? if($write['wr_2']) { ?>
		<div class="ch-body" onclick="$(this).toggleClass('pop');">
			<div class="img">
				<div><em style="background-image:url(<?=$check_body?>);"></em><img src="<?=$check_body?>" alt="" onerror="this.remove();"/></div>
			</div>
		</div>
	<? } ?>

	<div class="extend-icon-links">
		<div class="icons-link-box link-box">
			<?
				$extend_link_file = array();
				$tmp = dir(G5_PATH."/plugin/board");
				while ($entry = $tmp->read()) {
					// php 파일만 include 함
					if (preg_match("/(\.php)$/i", $entry))
						$extend_file[] = $entry;
				}
				if(!empty($extend_file) && is_array($extend_file)) {
					natsort($extend_file);
					foreach($extend_file as $file) {
						include_once(G5_PATH."/plugin/board/".$file);
					}
				}
				unset($extend_file);
			?>
		</div>
	</div>

	<div class="ch-pannel">
		<div class="inner">
			<div class="mid">
				<div class="name-box txt-point">
					<? if($write['wr_3']){?><span><?=$write['wr_3']?></span><? } ?>
					<strong><?=$write['wr_subject']?></strong>
				</div>
				<? if($write['wr_content']) { ?>
					<div class="info">
						<?=$write['wr_content']?>
					</div>
				<? } ?>

				<hr class="line" />

				<div class="control">
					<?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="ui-btn etc"><i class="material-icons">edit</i> 수정</a><?php } ?>
					<?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="ui-btn etc" onclick="del(this.href); return false;"><i class="material-icons">delete</i> 삭제</a><?php } ?>
					<?php if ($update_href && $write['wr_2'] != '') { ?><a href="javascript:$('.body-add-form').toggle();" class="ui-btn point"><i class="material-icons">checkroom</i> 전신추가</a><? } ?>
					<a href="<?php echo $list_href ?><?=$qstr?>" class="ui-btn etc"><i class="material-icons">list</i> 목록</a>
				</div>
				<?php if ($update_href && $write['wr_2'] != '') { ?>
					<div class="body-add-form theme-box">
						<form method="post" id="frm_add_body" enctype="multipart/form-data" autocomplete="off">
							<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
							<input type="hidden" name="wr_id" value="<?=$wr_id?>" />

							<input type="radio" name="add_new_body_type" id="add_new_body_type1" value="url" checked/>
							<label for="add_new_body_type1">URL등록</label>

							<input type="radio" name="add_new_body_type" id="add_new_body_type2" value="file" />
							<label for="add_new_body_type2">FILE등록</label>

							<div class="input-box">
								<input type="text" name="add_new_body" value="" />
								<input type="file" name="add_new_body_file" title="용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" accept="image/*"/>
								<button type="button" onclick="fn_body_add_form('frm_add_body');" class="ui-btn">등록</button>
							</div>
						</form>
					</div>
					<script>
						function fn_body_add_form(frm) {
							var form = $("#" + frm)[0];
							var formData = new FormData(form);
							var url = skin_url;
							$('.loading').addClass('mask');

							$.ajax({
								cache : false,
								url : url + "/proc/add_body.php", // 요기에
								type : 'POST',
								processData: false,
								contentType: false,
								data : formData, 
								success: function(data) {
									// Toss
									var response = data;
									$('.char-body-list').empty().append(response);
									form.reset();
								},
								error: function(data, status, err) {
									console.log("error!!");
								},
								complete: function() { 
									// Complete
									$('.loading').removeClass('mask');
								}
							});
						}
					</script>
				<? } ?>


				<hr class="line" />
				<div class='char-body-list'>
				<? if($body_cnt > 0 && $write['wr_2'] != '') { 
						// 전신 리스트 출력 (단, 추가로 등록한 전신이 있을 경우에만)
						include_once($board_skin_path."/view_body.skin.php");
					}
				?>
				</div>

				<? if ($write['wr_4']) { ?><div class="sub-title txt-default"><?=$write['wr_4']?></div><? } ?>
				<? if ($write['wr_4_txt']) { ?><div class="descript"><?=nl2br($write['wr_4_txt'])?></div><? } ?>

				<? if ($write['wr_5']) { ?><div class="sub-title txt-default"><?=$write['wr_5']?></div><? } ?>
				<? if ($write['wr_5_txt']) { ?><div class="descript"><?=nl2br($write['wr_5_txt'])?></div><? } ?>

				<? if ($write['wr_6']) { ?><div class="sub-title txt-default"><?=$write['wr_6']?></div><? } ?>
				<? if ($write['wr_6_txt']) { ?><div class="descript"><?=nl2br($write['wr_6_txt'])?></div><? } ?>

				<? if ($write['wr_7']) { ?><div class="sub-title txt-default"><?=$write['wr_7']?></div><? } ?>
				<? if ($write['wr_7_txt']) { ?><div class="descript"><?=nl2br($write['wr_7_txt'])?></div><? } ?>

				<? if ($write['wr_8']) { ?><div class="sub-title txt-default"><?=$write['wr_8']?></div><? } ?>
				<? if ($write['wr_8_txt']) { ?><div class="descript"><?=nl2br($write['wr_8_txt'])?></div><? } ?>

			</div>
		</div>
	</div>

</div>


