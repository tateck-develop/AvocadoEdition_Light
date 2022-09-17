<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$left = sql_fetch("select * from {$write_table} where wr_id = '{$list[$i]['wr_2']}'");
$right = sql_fetch("select * from {$write_table} where wr_id = '{$list[$i]['wr_3']}'");

$left_src = "";
$left_img_content = "";
if($left['wr_1']) { $left_src = $left['wr_1']; }
if($left_src) { $left_img_content = '<em style="background-image:url(\''.$left_src.'\');"></em>'; }

$right_src = "";
$right_img_content = "";
if($right['wr_1']) { $right_src = $right['wr_1']; }
if($right_src) { $right_img_content = '<em style="background-image:url(\''.$right_src.'\');"></em>'; }

$dday = "";

$startDate = strtotime($list[$i]['wr_subject']);
$endDate = strtotime(date('Y-m-d'));
$dday = ($endDate - $startDate)/(60*60*24)+1;

$p_gallery_w = $gallery_w + 20;

?>

<li class="pair-group">
	<div class="pair-bak-box" style="background-image:url(<?=$list[$i]['wr_1']?>);">
		
		<div class="row">
			<div class="ch-box" style="width:<?=$p_gallery_w?>px;">
				<div class="character-card-frame">
					<div class="pad" style="padding-top:<?=$gallery_rato?>%;"></div>
					<a class="pic" href="./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i]['wr_2']?>">
						<?=$left_img_content?>
					</a>
				</div>
			</div><?

			?><div class="ch-box" style="width:<?=$p_gallery_w?>px;">
				<div class="character-card-frame">
					<div class="pad" style="padding-top:<?=$gallery_rato?>%;"></div>
					<a class="pic" href="./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i]['wr_3']?>">
						<?=$right_img_content?>
					</a>
				</div>
			</div>

			<div class="dday" title="DATE.<?=$list[$i]['wr_subject']?>">
				<div class="bak ui-btn point"></div>
				<div class="days">
					<div class="mid">
						<div>
							<p class="ui-btn point txt-menu-font"><?=$dday?></p>
							<span class="ui-btn point">DAYS</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="ch-box" style="width:<?=$p_gallery_w?>px;">
				<? if($list[$i]['wr_4']) { ?>
					<div class="ui-btn relation-name">
						<?=$list[$i]['wr_4']?>
					</div>
				<? } ?>
				<div class="txt-default ch-name">
					<?=$left['wr_subject']?>
				</div>
			</div><?

			?><div class="ch-box" style="width:<?=$p_gallery_w?>px;">
				<? if($list[$i]['wr_5']) { ?>
					<div class="ui-btn relation-name">
						<?=$list[$i]['wr_5']?>
					</div>
				<? } ?>
				<div class="txt-default ch-name">
					<?=$right['wr_subject']?>
				</div>
			</div>
		</div>
	</div>

	<? if($list[$i]['mb_id'] == $member['mb_id']) { ?>
	<div class="txt-center">
		<a href="./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i]['wr_id']?>&w=u" class="ui-btn"><i class="material-icons">settings</i> 수정하기</a>
	</div>
	<? } ?>
</li>