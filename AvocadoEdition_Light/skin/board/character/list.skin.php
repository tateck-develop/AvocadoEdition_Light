<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//-- 리스트 정렬을 임의로 조정 하는 기능을 합니다.
include_once($board_skin_path.'/_setting.php');
include_once($board_skin_path.'/list.order.skin.php');

$category_list = get_category_list($bo_table, $sca);
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$color_bak = get_style('color_bak');
$color_bak = hex2rgba($color_bak['cs_value'], $color_bak['cs_etc_1']);
$color_default = get_style('color_default');
$color_default = hex2rgba($color_default['cs_value'], $color_default['cs_etc_1']);

$is_notice = false;
?>

<style>
:root {
	--thumb-bak:<?=$color_bak?>;
	--cover-bak:linear-gradient(0deg, <?=$color_bak?> 0%, transparent 100%);
	--cover-color:<?=$color_default?>;
}
</style>


<!-- 게시판 목록 시작 { -->
<div class="charwrap">
	
	<? if($board['bo_content_head']) { ?>
		<div class="board-notice-box">
			<?=stripslashes($board['bo_content_head']);?>
		</div>
	<? } ?>

	<!-- 게시판 카테고리 시작 { -->
	<?php if ($is_category) { ?>
	<nav  class="board-category">
		<ul>
			<li><a href="./board.php?bo_table=<?=$bo_table?>" class="ui-btn <?=!$sca || $sca == ''? 'point' : 'etc'?>">ALL</a></li>
			<? echo $category_list ?>
		</ul>
	</nav>
	<?php } ?>
	<!-- } 게시판 카테고리 끝 -->
	
	<div class="character-board-wrap">
    	<ul class="character-card-list">
    		<?
    			$gallery_w = $board['bo_image_width'] == 0 ? 250 : $board['bo_image_width'];
    			$gallery_h = $board['bo_gallery_height'] == 0 ? 150 : $board['bo_gallery_height'];
    			$gallery_rato = $gallery_w == 0 || $gallery_h == 0 ? "140" : $gallery_h/$gallery_w*100;
    
    			for($i=0; $i<count($list); $i++) {

					if($list[$i]['is_notice']) {
						include($board_skin_path."/list.couple.skin.php");
						$is_notice = true;
					} else {
						if($is_notice) { break; }
						include($board_skin_path."/list.character.skin.php");
					}
				}
			
			if (count($list) == 0) { echo "<li class=\"empty_list\">등록된 캐릭터가 없습니다.</li>"; } ?>
		</ul>
	</div>


	<div class="btn_confirm">
		<? 
			if($is_notice || $sst == 'wr_id') { 
				if ($list_href || $sst == 'wr_id') {
		?>
				<a href="./board.php?bo_table=<?=$bo_table?>" class="ui-btn etc"><i class="material-icons">list</i> 메인</a>
			<? } else { ?>
				<a href="./board.php?bo_table=<?=$bo_table?>&sst=wr_id" class="ui-btn etc"><i class="material-icons">list</i> 전체 목록</a>
			<? } 
			} else {
				if ($list_href) { ?>
					<a href="<?php echo $list_href ?>" class="ui-btn etc"><i class="material-icons">list</i> 목록</a>
				<?php }
			}
			if ($write_href) { ?>
				<? if($total_count >= 2) { ?>
				<a href="<?php echo $write_href ?>&type=pair" class="ui-btn"><i class="material-icons">edit</i> 페어 등록하기</a>
				<? } ?>
				<a href="<?php echo $write_href ?>&sst=<?=$sst?>" class="ui-btn point"><i class="material-icons">edit</i> 캐릭터 등록하기</a>
			<?php } ?>
	</div>
		
	<!-- 페이지 -->
	<?php echo $write_pages;  ?>
</div>
