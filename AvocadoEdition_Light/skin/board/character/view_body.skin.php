<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$body_cnt = sql_fetch("select count(*) as cnt from {$g5['character_body_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}'");
$body_cnt = $body_cnt['cnt'];

if($body_cnt > 0) { 
?>
	<div class="chaBodyList">
		<div class="control">
			<button type="button" class="prev txt-point"><span class="material-icons">arrow_back_ios</span></button>
			<button type="button" class="next txt-point"><span class="material-icons">arrow_forward_ios</span></button>
		</div>
		<div class="slider">
			<div class="swiper-container">
				<ul class="swiper-wrapper">
					<?
						$body_list = sql_query("select * from {$g5['character_body_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' order by bd_id asc");
						for($i=0; $bd = sql_fetch_array($body_list); $i++) {
							if($i==0 && $write['wr_2'] != '') {
					?>
						<li class="swiper-slide">
							<a href="#"; onclick="fn_viewer_chBody('', '<?=$write['wr_2']?>', this); return false;" class="theme-box"><img src="<?=$write['wr_2']?>" alt="" /></a>
						</li>
					<?
							}
					?>
						<li class="swiper-slide">
							<a href="#"; onclick="fn_viewer_chBody('<?=$bd['bd_id']?>', '<?=$bd['bd_url']?>', this); return false;" class="theme-box"><img src="<?=$bd['bd_url']?>" alt="" /></a>
						</li>
					<?
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<script src="<?php echo $board_skin_url ?>/js/swiper.js"></script>
	<script>
		fn_slider_chaBodyList();
		var slider_chaBodyList = null;
		function fn_slider_chaBodyList() {
			/* 중복 호출될 경우 이전에 생성된 슬라이더를 1회 초기화한 이후에 진행한다.*/
			if(slider_chaBodyList != null) {
				slider_chaBodyList.destroy(true, true);
				slider_chaBodyList = null;
			}

			/* 슬라이더 생성 : 자세한 옵션은 데모 페이지 확인 */
			slider_chaBodyList = new Swiper('.chaBodyList .slider .swiper-container', {
				slidesPerView: 'auto',
				spaceBetween: 10,
				navigation: {
					prevEl: '.chaBodyList .prev',
					nextEl: '.chaBodyList .next'
				},
			});
		}

		<? if($update_href) { ?>
			var control_idx = "";
			var originam_url = "<?=$write['wr_2']?>";

			function fn_set_chBody(type, bo_table, wr_id) {
				var url = skin_url;
				var formData = new FormData();
				formData.append("bo_table", bo_table);
				formData.append("wr_id", wr_id);
				formData.append("bd_id", control_idx);

				if(type == 'del') {
					if(confirm("해당 데이터를 정말 삭제하시겠습니까?")) {
						$('.loading').addClass('mask');
						$.ajax({
							cache : false,
							url : url + "/proc/del_body.php", // 요기에
							type : 'POST',
							processData: false,
							contentType: false,
							data : formData, 
							success: function(data) {
								// Toss
								var response = data;
								$('.char-body-list').empty().append(response);
								$('.ch-body .img img').attr('src', originam_url);
								$('#control_body_box').empty();
							},
							error: function(data, status, err) {},
							complete: function() { 
								// Complete
								$('.loading').removeClass('mask');
							}
						});
					} 
				}
				if(type == 'set') {
					if(confirm("해당 데이터를 기본 전신으로 설정하시겠습니까?")) {
						$('.loading').addClass('mask');
						$.ajax({
							cache : false,
							url : url + "/proc/set_body.php", // 요기에
							type : 'POST',
							processData: false,
							contentType: false,
							data : formData, 
							success: function(data) {
								$('#control_body_box').empty();
							},
							error: function(data, status, err) {},
							complete: function() { 
								// Complete
								$('.loading').removeClass('mask');
							}
						});
					}
				}

			}
		<? } ?>

		function fn_viewer_chBody(idx, img, obj) {
			var control_html = '';

			<? if($update_href) { ?>
				if(idx) {
					// 추가된 전신 정보
					var control_html = '<div class="body-control"><a href="javascript:fn_set_chBody(\'set\', \'<?=$bo_table?>\', \'<?=$wr_id?>\');" class="ui-btn">기본설정</a><a href="javascript:fn_set_chBody(\'del\', \'<?=$bo_table?>\', \'<?=$wr_id?>\');" class="ui-btn etc">삭제</a></div>';
				} else {
					var control_html = '<div class="body-control"><a href="javascript:fn_set_chBody(\'set\', \'<?=$bo_table?>\', \'<?=$wr_id?>\');" class="ui-btn">기본설정</a></div>';
				}
				control_idx = idx;
				$('#control_body_box').html(control_html);
			<? } ?>

			if(img) {
				$('.ch-body .img img').attr('src', img);
				$('.ch-body .img em').css('background-image', 'url('+img+')');
			}

			$('.chaBodyList .checked').removeClass('checked');
			$(obj).addClass('checked');
		}
	</script>

	<div id="control_body_box"></div>

	<hr class='line' />
<? } ?>
