<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//include_once($board_skin_path."/moonday.php"); // 석봉운님의 음력날짜 함수

if (preg_match('/%/', $width)) {
  $col_width = "14%"; //표의 가로 폭이 100보다 크면 픽셀값입력
} else{
  $col_width = round($width/7); //표의 가로 폭이 100보다 작거나 같으면 백분율 값을 입력
}
$col_height= 30 ;//내용 들어갈 사각공간의 세로길이를 가로 폭과 같도록
$today = getdate(); 
$b_mon = $today['mon']; 
$b_day = $today['mday']; 
$b_year = $today['year']; 
if ($year < 1) { // 오늘의 달력 일때
  $month = $b_mon;
  $mday = $b_day;
  $year = $b_year;
}

if(!$year) 	$year = date("Y");
$file_index = $board_skin_path."/day"; ### 기념일 폴더 위치 지정

### 양력 기념일 파일 지정 : 해당년도 파일이 없으면 기본파일(solar.txt)을 불러온다
//$dayfile = file($file_index."/solar.txt");

$lastday=array(0,31,28,31,30,31,30,31,31,30,31,30,31);
if ($year%4 == 0) $lastday[2] = 29;
$dayoftheweek = date("w", mktime (0,0,0,$month,1,$year));

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
if($month=="1")$month_m="January";
if($month=="2")$month_m="February";
if($month=="3")$month_m="March";
if($month=="4")$month_m="April";
if($month=="5")$month_m="May";
if($month=="6")$month_m="June";
if($month=="7")$month_m="July";
if($month=="8")$month_m="August";
if($month=="9")$month_m="September";
if($month=="10")$month_m="October";
if($month=="11")$month_m="November";
if($month=="12")$month_m="December";
?> 
<div id="bo_list">
<div class="theme-box cal-nav"> 
<h2>
	<a href="<?php echo G5_BBS_URL."/board.php?bo_table=".$bo_table; ?>" onfocus="this.blur()"><span title="<?php echo $year ?>년 <?php echo $month ?>월"><?=$month_m?></span>
	</a>
</h2> 
</div>
<table border="0" cellspacing="1" class="theme-list">
<thead>
  <tr align="center">     
	<th class="sun">S</th>
	<th>M</th>
	<th>T</th>
	<th>W</th>
	<th>T</th>
	<th>F</th>
	<th class="sat">S</th>
  </tr>
</thead>
<tbody>
<?php
$cday = 1;
$sel_mon = sprintf("%02d",$month);
$table_name="avo_write_".$bo_table;
$query = "SELECT * FROM $table_name WHERE left(wr_1,6) <= '$year$sel_mon' and left(wr_2,6) >= '$year$sel_mon' ORDER BY wr_id ASC";
$result = sql_query($query);
$j=0; // layer id
// 내용을 보여주는 부분
while ($row = sql_fetch_array($result)) {  // 제목글 뽑아서 링크 문자열 만들기..
  if( substr($row[wr_1],0,6) <  $year.$sel_mon ) {
	 $start_day =1; 
	 $start_day= (int)$start_day;
  } else {
	 $start_day = substr($row[wr_1],6,2);
     $start_day= (int)$start_day;
  }

  if( substr($row[wr_2],0,6) >  $year.$sel_mon ) {
	 $end_day = $lastday[$month];
	 $end_day= (int)$end_day;
  } else {
	 $end_day = substr($row[wr_2],6,2);
	 $end_day= (int)$end_day;
  }

  // 아이디에 따라 다른 아이콘이미지 출력 하고 싶을때 ///주석을 해제
  $imgown = 'icon';

  for ($i = $start_day ; $i <= $end_day;  $i++) {
    if (strlen($row[wr_3]) > 0) {  // 입력된 아이콘 값이 있을 때
      $imgown = $row[wr_3] ;
	}

    $j++; // layer ID

// subject length cut
 
      $showLayer=" onmouseover=\"PopupShow('".$j."')\" onmouseout=\"PopupHide('".$j."')\" "; 
    $html_day[$i].= "<a style='display:block;'  class='txt-default ".$imgown."'href='".G5_BBS_URL."/board.php?bo_table=$bo_table&year=$year&month=$month&wr_id=$row[wr_id]&sc_no=$sc_no' id='subject_".$j."' ".$showLayer.">".$i."</a>";
?>
       <!-- 뷰 팝업레이어 -->
    <div id="popup_<?php echo $j ?>" class="popup_layer"> 
	<?php
    $html = 0;
    if (strstr($row[wr_option], "html1"))
      $html = 1;
    else if (strstr($row[wr_option], "html2"))
      $html = 2;

      $viewlist = cut_str(conv_content($row[wr_content], $html),200,"…"); 
       echo "<p class='popup_title'>".$row['wr_subject']."</p><p class='popup_cont'>".$viewlist."</p>";
	?>
    </div>
<?php 	
		$sc_id = $row[wr_id];
    }
  }

  // 달력의 틀을 보여주는 부분

  $temp = 7- (($lastday[$month]+$dayoftheweek)%7);

  if ($temp == 7) $temp = 0;
     $lastcount = $lastday[$month]+$dayoftheweek + $temp;

  for ($iz = 1; $iz <= $lastcount; $iz++) { // 42번을 칠하게 된다.
    $bgcolor = "days";  // 쭉 흰색으로 칠하고
    if ($b_year==$year && $b_mon==$month && $b_day==$cday) $bgcolor = "today";      //  "#DFFDDF"; // 오늘날짜 연두색으로 표기
    if (($iz%7) == 1) echo ("<tr>"); // 주당 7개씩 한쎌씩을 쌓는다.
    if ($dayoftheweek < $iz  &&  $iz <= $lastday[$month]+$dayoftheweek)	{
	// 전체 루프안에서 숫자가 들어가는 셀들만 해당됨
	// 즉 11월 달에서 1일부터 30 일까지만 해당
	$daytext = "$cday";   // $cday 는 숫자 예> 11월달은 1~ 30일 까지
	//$daytext 은 셀에 써질 날짜 숫자 넣을 공간

	// 여기까지 숫자와 들어갈 내용에 대한 변수들의 세팅이 끝나고 
	// 이제 여기 부터 직접 셀이 그려지면서 그 안에 내용이 들어 간다.
	echo ("<td width=$col_width height=$col_height class='$bgcolor' valign='top'>");

	$fr_date = $year.sprintf("%02d",$month).sprintf("%02d",$cday);

	// 기념일 파일 내용 비교위한 변수 선언, 월과 일을 두자리 포맷으로 고정
	if (strlen($month) == 1) { 
		$monthp = "0".$month ;
	} else {
		$monthp = $month ; 
	}
	if (strlen($cday) == 1) {
		$cdayp = "0".$cday ;
	} else { 
		$cdayp = $cday ; 
	}
	$memday = $year.$monthp.$cdayp;
	$daycont = "" ;

	// 기념일(양력) 표시
	/*
	for($i=0 ; $i < sizeof($dayfile) ; $i++) {  // 파일 첫 행부터 끝행까지 루프
		$arrDay = explode("|", $dayfile[$i]);
		if($memday == $year.$arrDay[0]) {
			$daycont = $arrDay[1]; 
			$daycontcolor = $arrDay[2];
			if(substr($arrDay[2],0,3)=="red") $daycolor = "red"; // 공휴일은 날짜를 빨간색으로 표시
		}
	}
	*/
	/*
    // 석봉운님의 음력날짜 변수선언
    $myarray = soltolun($year,$month,$cday);
    if ($myarray[day]==1 || $myarray[day]==11 || $myarray[day]==21) {
      $moonday ="<font color='gray'>&nbsp;(음)$myarray[month].$myarray[day]$myarray[leap]</font>";
    } else {
      $moonday="";
    }
	
	include($file_index."/lunar.txt"); ### 음력 기념일 파일 지정

    if ($annivmoonday&&$daycont) $blank="<br />"; // 음력절기와 양력기념일이 동시에 있으면 한칸 띔
    else $blank="";
	*/ 
    if (!$html_day[$cday]) {  
      echo $daytext;
    }
    echo $html_day[$cday];
    echo ("</td>");  // 한칸을 마무리
    $cday++; // 날짜를 카운팅
  } 
  // 유효날짜가 아니면 그냥 회색을 칠한다.
  else { echo ("     <td width=$col_width height=$col_height class='noday'>&nbsp;</td>"); }
  if (($iz%7) == 0) echo ("  </tr>");
   
} // 반복구문이 끝남
?>
</tbody>
</table>
</div> 

<script language="JavaScript">
<!--
// 미리보기 팝업 보이기
function PopupShow(n) {
	var position = $("#subject_"+n).position(); 
	$("#popup_"+n).animate({left:position.left-10+"px", top:position.top+30+"px"},0);
	$("#popup_"+n).show();
}

// 미리보기 팝업 숨기기
function PopupHide(n) {
	$("#popup_"+n).hide();
}
//-->
</script>
