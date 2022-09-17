<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($write['wr_type'] == 'pair') {
	goto_url($list_href.$qstr);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$color_bak = get_style('color_bak');
$color_line_color = $color_bak['cs_value'];
$color_bak_off = hex2rgba($color_bak['cs_value'], 30);
$color_bak_over = hex2rgba($color_bak['cs_value'], 5);

$default_font = get_style('default_font');
$default_font = hex2rgba($default_font['cs_value'], $default_font['cs_etc_1']);
?>

<style>
:root {
	--pannel-line:<?=$color_line_color?>;
	--pannel-bak:<?=$color_bak_off?>;
	--pannel-bak-over:<?=$color_bak_over?>;
}
</style>

<div class="characterViewer">
	
	<? if($write['wr_2']) { ?>
		<div class="ch-body" onclick="$(this).toggleClass('pop');">
			<div class="img">
				<div><em style="background-image:url(<?=$write['wr_2']?>);"></em><img src="<?=$write['wr_2']?>" alt="" onerror="this.remove();"/></div>
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
					<a href="<?php echo $list_href ?><?=$qstr?>" class="ui-btn etc"><i class="material-icons">list</i> 목록</a>
				</div>

				<hr class="line" />

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


