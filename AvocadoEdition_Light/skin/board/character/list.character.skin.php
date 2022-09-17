<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$src = "";
$img_content = "";
$thumb_class = "";
if($list[$i]['wr_1']) { 
	$src = $list[$i]['wr_1'];
}
if($src) {
	$img_content = '<em style="background-image:url(\''.$src.'\');"></em>';
} else {
	$thumb_class = "fix";
}

?>

<li style="width:<?=$gallery_w?>px;">
	<div class="character-card-frame">
		<div class="pad" style="padding-top:<?=$gallery_rato?>%;"></div>
		<a class="pic <?=$thumb_class?>" href="<?php echo $list[$i]['href'] ?>">
			<?php
				
				echo $img_content;
			?>
			<span class="cover <?=$thumb_class?>">
				<span>
					<span>
						<strong class="sub-subject"><?=$list[$i]['wr_3']?></strong>
						<strong class="subject"><?=$list[$i]['wr_subject']?></strong>
					</span>
				</span>
			</span>
		</a>
	</div>
</li>