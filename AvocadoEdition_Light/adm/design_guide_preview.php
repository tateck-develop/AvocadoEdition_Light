<?
	include_once('./_common.php');
?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="title" content="<?=$g5['title']?>">
	<meta name="keywords" content="<?=$config['cf_site_descript']?>">
	<meta name="description" content="<?=$config['cf_site_descript']?>">

	<meta property="og:title" content="<?=$g5['title']?>">
	<meta property="og:description" content="<?=$config['cf_site_descript']?>">
	<meta property="og:url" content="<?=G5_URL?>">

	<title><?=$g5['title']?></title>

	<link rel="shortcut icon" href="<?=$config['cf_favicon']?>">
	<link rel="icon" href="<?=$config['cf_favicon']?>">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_CSS_URL?>/default.css?v=<?=$config['cf_css_version']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_CSS_URL?>/style.css?v=<?=$config['cf_css_version']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_URL?>/adm/css/guide.css?v=<?=$config['cf_css_version']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_DATA_URL?>/css/_design.config.css?v=<?=$config['cf_css_version']?>" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
	if(!parent || parent==this) $('html').addClass('single'); 
	</script>
</head>
<body>

<h1>현재 디자인 설정 보기</h1>
<div class="previewWrap">
	<h2>◆ 텍스트</h2>
	<div class="admin-preview-box">
		<p>전체 기본 텍스트 스타일을 확인합니다.</p>
		<p class="txt-default">기본색 텍스트 스타일을 확인합니다.</p>
		<p class="txt-point">강조색 텍스트 스타일을 확인합니다.</p>
	</div>

	<h2>◆ 메뉴</h2>
	<div class="admin-preview-box">
		<div class="gnbWrap">
			<span class="link">
				<span class="icons"><span><i class="material-icons">home</i></span></span>
				<span class="tooltips">HOME</span>
			</span>
		</div>
	</div>

	<h2>◆ 버튼</h2>
	<div class="admin-preview-box">
		<a href="#" class="ui-btn">a링크 버튼</a>
		<a href="#" class="ui-btn point">a링크 버튼 (강조)</a>
		<a href="#" class="ui-btn etc">a링크 버튼 (기타)</a>
		<br />
		<button type="button" class="ui-btn">BUTTON</button>
		<button type="button" class="ui-btn point">BUTTON (강조)</button>
		<button type="button" class="ui-btn etc">BUTTON (기타)</button>
		<br />
		<a href="#" class="ui-btn small">작은 버튼</a>
		<a href="#" class="ui-btn small point">작은 버튼</a>
		<a href="#" class="ui-btn small etc">작은 버튼</a>
	</div>

	<h2>◆ 기본박스</h2>
	<div class="admin-preview-box">
		<div class="theme-box">
			테마 박스 예제
		</div>
	</div>

	<h2>◆ 공지사항 박스</h2>
	<div class="admin-preview-box">
		<div class="board-notice-box">
			공지사항 박스 예제
		</div>
	</div>

	<h2>◆ 입력폼 예시</h2>
	<div class="admin-preview-box">
		<input type="number" value="0" placeholder="0" /> <br />
		<input type="text" placeholder="NUMBER 입력폼" /> <br />
		<input type="file" placeholder="NUMBER 입력폼" /> <br />
		<select><option value="">옵션명</option>
		<textarea placeholder="긴글 텍스트 입력 테스트"></textarea>
	</div>

	<h2>◆ 목록테이블</h2>
	<div class="admin-preview-box">
		<table class="theme-list">
			<thead>
				<tr>
					<th>목록 : 제목</th>
					<th>목록 : 제목</th>
					<th>목록 : 제목</th>
					<th>목록 : 제목</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
				</tr>
				<tr>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
				</tr>
				<tr>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
					<td>목록 : 내용</td>
				</tr>
			</tbody>
		</table>
	</div>

	<h2>◆ 작성테이블</h2>
	<div class="admin-preview-box">
		<table class="theme-form">
			<colgroup>
				<col style="width: 100px;" />
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th>양식 : 제목</th>
					<td>양식 : 네용</td>
				</tr>
				<tr>
					<th>양식 : 제목</th>
					<td>양식 : 네용</td>
				</tr>
				<tr>
					<th>양식 : 제목</th>
					<td>양식 : 네용</td>
				</tr>
				<tr>
					<th>양식 : 제목</th>
					<td>양식 : 네용</td>
				</tr>
			</tbody>
		</table>
	</div>

	<h2>◆ 페이지</h2>
	<div class="admin-preview-box">
		<?=get_paging(10, 3, 120, "")?>
	</div>
</div>
</body>
</html>
