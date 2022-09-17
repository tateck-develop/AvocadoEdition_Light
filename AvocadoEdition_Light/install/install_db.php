<?php
@set_time_limit(0);
$gmnow = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0

include_once ('../config.php');
include_once ('../lib/common.lib.php');

$title = G5_VERSION." 설치 완료 3/3";
include_once ('./install.inc.php');

//print_r($_POST); exit;

$mysql_host  = $_POST['mysql_host'];
$mysql_user  = $_POST['mysql_user'];
$mysql_pass  = $_POST['mysql_pass'];
$mysql_db    = $_POST['mysql_db'];
$table_prefix= $_POST['table_prefix'];
$admin_id    = $_POST['admin_id'];
$admin_pass  = $_POST['admin_pass'];
$admin_name  = $_POST['admin_name'];
$admin_email = $_POST['admin_email'];
$absolute_password = $_POST['absolute_password'];
$table_url = $_POST['table_url'];

$dblink = sql_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!$dblink) {
?>

<div class="ins_inner">
    <p>MySQL Host, User, Password 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./install_config.php">뒤로가기</a></div>
</div>

<?php
    include_once ('./install.inc2.php');
    exit;
}

$select_db = sql_select_db($mysql_db, $dblink);
if (!$select_db) {
?>

<div class="ins_inner">
    <p>MySQL DB 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./install_config.php">뒤로가기</a></div>
</div>

<?php
    include_once ('./install.inc2.php');
    exit;
}

$mysql_set_mode = 'false';
sql_set_charset('utf8', $dblink);
$result = sql_query(" SELECT @@sql_mode as mode ", true, $dblink);
$row = sql_fetch_array($result);
if($row['mode']) {
    sql_query("SET SESSION sql_mode = ''", true, $dblink);
    $mysql_set_mode = 'true';
}
unset($result);
unset($row);
?>

<div class="ins_inner">
    <h2><?php echo G5_VERSION ?> 설치가 시작되었습니다.</h2>

    <ol>
<?php
// 테이블 생성 ------------------------------------
$file = implode('', file('./gnuboard5.sql'));
eval("\$file = \"$file\";");

$file = preg_replace('/^--.*$/m', '', $file);
$file = preg_replace('/`avo_([^`]+`)/', '`'.$table_prefix.'$1', $file);
$f = explode(';', $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == '') continue;
    sql_query($f[$i], true, $dblink);
}
// 테이블 생성 ------------------------------------
?>

        <li>전체 테이블 생성 완료</li>

<?php
$read_point = 0;
$write_point = 0;
$comment_point = 0;
$download_point = 0;

//-------------------------------------------------------------------------------------------------
// config 테이블 설정

$sql = " insert into `{$table_prefix}config`
            set cf_title = '".G5_VERSION."',
                cf_admin = '$admin_id',
                cf_admin_email = '$admin_email',
                cf_admin_email_name = '".G5_VERSION."',
                cf_use_point = '0',
                cf_use_copy_log = '0',
                cf_login_point = '0',
                cf_memo_send_point = '0',
                cf_cut_name = '15',
                cf_nick_modify = '0',
                cf_new_skin = 'basic',
                cf_new_rows = '10',
                cf_search_skin = 'basic',
                cf_connect_skin = 'basic',
                cf_read_point = '$read_point',
                cf_write_point = '$write_point',
                cf_comment_point = '$comment_point',
                cf_download_point = '$download_point',
                cf_write_pages = '5',
                cf_mobile_pages = '5',
                cf_link_target = '_blank',
                cf_delay_sec = '30',
                cf_filter = '',
                cf_possible_ip = '',
                cf_intercept_ip = '',
                cf_analytics = '',
                cf_member_skin = 'basic',
                cf_mobile_new_skin = 'basic',
                cf_mobile_search_skin = 'basic',
                cf_mobile_connect_skin = 'basic',
                cf_mobile_member_skin = 'basic',
                cf_faq_skin = 'basic',
                cf_mobile_faq_skin = 'basic',
                cf_editor = 'smarteditor2',
                cf_captcha_mp3 = 'basic',
                cf_register_level = '2',
                cf_register_point = '0',
                cf_icon_level = '2',
                cf_leave_day = '30',
                cf_search_part = '10000',
                cf_email_use = '1',
                cf_prohibit_id = 'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객',
                cf_prohibit_email = '',
                cf_new_del = '30',
                cf_memo_del = '180',
                cf_visit_del = '180',
                cf_popular_del = '180',
                cf_use_member_icon = '2',
                cf_member_icon_size = '5000',
                cf_member_icon_width = '22',
                cf_member_icon_height = '22',
                cf_login_minutes = '10',
                cf_image_extension = 'gif|jpg|jpeg|png',
                cf_flash_extension = 'swf',
                cf_movie_extension = 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',
                cf_formmail_is_member = '1',
                cf_page_rows = '15',
                cf_mobile_page_rows = '15',
                cf_cert_limit = '2',
                cf_stipulation = '',
                cf_privacy = '',
				cf_add_fonts = '@font-face {\r\n    font-family: \'PyeongChangPeace-Light\';\r\n    src: url(\'https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2206-02@1.0/PyeongChangPeace-Light.woff2\') format(\'woff2\');\r\n    font-weight: 300;\r\n    font-style: normal;\r\n}\r\n@font-face {\r\n     font-family: \'S-CoreDream-3Light\';\r\n     src: url(\'https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_six@1.2/S-CoreDream-3Light.woff\') format(\'woff\');\r\n     font-weight: normal;\r\n     font-style: normal;\r\n}'
                ";
sql_query($sql, true, $dblink);

// 1:1문의 설정
$sql = " insert into `{$table_prefix}qa_config`
            ( qa_title, qa_category, qa_skin, qa_mobile_skin, qa_use_email, qa_req_email, qa_use_hp, qa_req_hp, qa_use_editor, qa_subject_len, qa_mobile_subject_len, qa_page_rows, qa_mobile_page_rows, qa_image_width, qa_upload_size, qa_insert_content )
          values
            ( '1:1문의', '회원|포인트', 'basic', 'basic', '1', '0', '1', '0', '1', '60', '30', '15', '15', '600', '1048576', '' ) ";
sql_query($sql, true, $dblink);

// 관리자 회원가입
$sql = " insert into `{$table_prefix}member`
            set mb_id = '{$admin_id}',
                 mb_password = '".get_encrypt_string($admin_pass)."',
                 mb_name = '{$admin_name}',
                 mb_nick = '{$admin_name}',
                 mb_email = '{$admin_email}',
                 mb_level = '10',
                 mb_mailling = '1',
                 mb_open = '1',
                 mb_email_certify = '".G5_TIME_YMDHIS."',
                 mb_datetime = '".G5_TIME_YMDHIS."',
                 mb_ip = '{$_SERVER['REMOTE_ADDR']}'
                 ";
sql_query($sql, true, $dblink);

// 게시판 그룹 추가
$sql = " insert into  `{$table_prefix}group`
			set		gr_id = 'home',
					gr_subject = 'HOME',
					gr_device = 'both'";
sql_query($sql, true, $dblink);

// 디자인 설정 파일
function g5_path_temp()
{
    $result['path'] = str_replace('\\', '/', dirname(__FILE__));
    $tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
    $document_root = str_replace($tilde_remove, '', $_SERVER['SCRIPT_FILENAME']);
    $root = str_replace($document_root, '', $result['path']);
    $port = $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '';
    $http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
    $user = str_replace(str_replace($document_root, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
        $host = preg_replace('/:[0-9]+$/', '', $host);
    $host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
    $result['url'] = $http.$host.$port.$user.$root;
	$result['url'] = str_replace("/install", "", $result['url']);
    return $result;
}

$g5_path = g5_path_temp();

$sql = "INSERT INTO `{$table_prefix}css_config` (`cs_id`, `cs_name`, `cs_value`, `cs_descript`, `cs_etc_1`, `cs_etc_2`, `cs_etc_3`, `cs_etc_4`, `cs_etc_5`, `cs_etc_6`, `cs_etc_7`, `cs_etc_8`, `cs_etc_9`, `cs_etc_10`, `cs_etc_11`, `cs_etc_12`, `cs_etc_13`, `cs_etc_14`, `cs_etc_15`, `cs_etc_16`, `cs_etc_17`, `cs_etc_18`, `cs_etc_19`, `cs_etc_20`) VALUES
(1, 'use_header', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'logo', '".$g5_path['url']."/img/default_site_img/design_logo.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 'background', '".$g5_path['url']."/img/default_site_img/design_background.png', '', '#ffffff', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'm_background', '".$g5_path['url']."/img/default_site_img/design_m_background.png', '', '#ffffff', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 'menu_icon', '#ffffff', '', '60', '', '', '', '', '#ecc6c6', '', 'solid', '1', '#ecc6c6', '', '15', 'diamond', '', '', '', '', '', '', ''),
(6, 'menu_tooltip', '#d6817e', '', '50', '#ffffff', '', '12', '20', '20', '20', '20', '\'PyeongChangPeace-Light\'', '', '', '', '', '', '', '', '', '', '', ''),
(7, 'board_notice', '#ecc6c6', '', '80', '#777777', '', '#ecc6c6', '', 'solid', '1', '||top||bottom||left||right||', '15', '0', '15', '0', '', '', '', '', '', '', '', ''),
(8, 'board_table', '', '', '90', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '', '', '', '', '', ''),
(9, 'list_header', '#ecc6c6', '', '', '#ffffff', '', '#ffffff', '50', 'solid', '1', '||left||right||', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, 'list_body', '#ffffff', '', '50', '#777777', '', '#ecc6c6', '50', 'solid', '1', '||top||bottom||', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'form_header', '#ecc6c6', '', '', '#ffffff', '', '#ffffff', '50', 'solid', '1', '||top||bottom||', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'form_body', '#ffffff', '', '50', '#777777', '', '#ecc6c6', '', 'solid', '1', '||top||bottom||left||right||', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'btn_default', '#ecc6c6', '', '', '#ffffff', '', '#e8b0ae', '', '#e8b0ae', '', '#ffffff', '', '#e69d98', '', '20', '20', '20', '20', '', '', '', '', ''),
(14, 'btn_point', '#b0c4de', '', '', '#ffffff', '', '#b0c4de', '', '#88a9db', '', '#ffffff', '', '#779bdb', '', '20', '20', '20', '20', '', '', '', '', ''),
(15, 'btn_etc', '#eaeaea', '', '', '#777777', '', '#dedede', '', '#dedede', '', '#777777', '', '#cacaca', '', '20', '20', '20', '20', '', '', '', '', ''),
(16, 'mmb_list_item', '', '', '', '', '', '', '', '', '', '', '40', '', '', '', '', '', '', '', '', '', '', ''),
(17, 'mmb_list', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(18, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(19, 'mmb_log', '', '', '', '#777777', '', '#ecc6c6', '', 'solid', '4', '||top||bottom||', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, 'mmb_reply', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, 'mmb_reply_item', '#ffffff', '', '100', '#777777', '', '#ecc6c6', '', 'dotted', '1', '||top||bottom||left||right||', '10', '', '', '', '', '', '', '', '', '', '', ''),
(22, 'mmb_name', '#ecc6c6', '', '', '14', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, 'mmb_owner_name', '#ecc6c6', '', '', '14', '◇', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, 'mmb_datetime', '#c7c7c7', '', '', '11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, 'mmb_link', '#ecc6c6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, 'mmb_log_ank', '#ecc6c6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(27, 'mmb_hash', '#ecc6c6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(28, 'default_font', '#777777', '', '', '13', '\'S-CoreDream-3Light\'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(29, 'color_default', '#ecc6c6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(30, 'color_bak', '#ffffff', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(31, 'color_point', '#b0c4de', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(32, 'input_bak', '#ffffff', '', '20', '30', '#777777', '', '13', '#ecc6c6', '', '20', '20', '20', '20', '', '', '', '', '', '', '', '', ''),
(33, 'mmb_contain_bak', '', '', '#ffffff', '50', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(34, 'box_style', '#ecc6c6', '', '50', '#ffffff', '', '#ecc6c6', '', 'dotted', '2', '||top||bottom||left||right||', '10', '10', '10', '10', '', '', '', '', '', '', '', ''),
(35, 'intro_use', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(36, 'intro_background', '', '', '#ecc6c6', '90', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(37, 'intro', '".$g5_path['url']."/img/default_site_img/design_intro.png', '', 'ENTER →', '#d1d1d1', '', '17', '\'PyeongChangPeace-Light\'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(38, 'scrollbar', '#ffffff', '', '', '5', '#ecc6c6', '', '20', '20', '20', '20', '', '', '', '', '', '', '', '', '', '', '', ''),
(39, 'menu_position', 'B', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(40, 'content_width', '1000', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";

sql_query($sql, true, $dblink);



?>

        <li>DB설정 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 생성
$dir_arr = array (
    $data_path.'/cache',
    $data_path.'/editor',
    $data_path.'/file',
    $data_path.'/log',
    $data_path.'/member',
    $data_path.'/session',
    $data_path.'/content',
    $data_path.'/faq',
    $data_path.'/tmp',
	$data_path.'/site',
);

for ($i=0; $i<count($dir_arr); $i++) {
    @mkdir($dir_arr[$i], G5_DIR_PERMISSION);
    @chmod($dir_arr[$i], G5_DIR_PERMISSION);
}
?>

        <li>데이터 디렉토리 생성 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// DB 설정 파일 생성
$file = '../'.G5_DATA_DIR.'/'.G5_DBCONFIG_FILE;
$f = @fopen($file, 'a');

fwrite($f, "<?php\n");
fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
fwrite($f, "define('G5_MYSQL_HOST', '{$mysql_host}');\n");
fwrite($f, "define('G5_MYSQL_USER', '{$mysql_user}');\n");
fwrite($f, "define('G5_MYSQL_PASSWORD', '{$mysql_pass}');\n");
fwrite($f, "define('G5_MYSQL_DB', '{$mysql_db}');\n");
fwrite($f, "define('G5_MASTER_PW', '{$absolute_password}');\n");

fwrite($f, "define('G5_DB_URL', '{$table_url}');\n");

fwrite($f, "define('G5_MYSQL_SET_MODE', {$mysql_set_mode});\n\n");
fwrite($f, "define('G5_TABLE_PREFIX', '{$table_prefix}');\n\n");

fwrite($f, "\$g5['write_prefix'] = G5_TABLE_PREFIX.'write_'; // 게시판 테이블명 접두사\n\n");
fwrite($f, "\$g5['auth_table'] = G5_TABLE_PREFIX.'auth'; // 관리권한 설정 테이블\n");
fwrite($f, "\$g5['config_table'] = G5_TABLE_PREFIX.'config'; // 기본환경 설정 테이블\n");
fwrite($f, "\$g5['group_table'] = G5_TABLE_PREFIX.'group'; // 게시판 그룹 테이블\n");
fwrite($f, "\$g5['group_member_table'] = G5_TABLE_PREFIX.'group_member'; // 게시판 그룹+회원 테이블\n");
fwrite($f, "\$g5['board_table'] = G5_TABLE_PREFIX.'board'; // 게시판 설정 테이블\n");
fwrite($f, "\$g5['board_file_table'] = G5_TABLE_PREFIX.'board_file'; // 게시판 첨부파일 테이블\n");
fwrite($f, "\$g5['board_good_table'] = G5_TABLE_PREFIX.'board_good'; // 게시물 추천,비추천 테이블\n");
fwrite($f, "\$g5['board_new_table'] = G5_TABLE_PREFIX.'board_new'; // 게시판 새글 테이블\n");
fwrite($f, "\$g5['login_table'] = G5_TABLE_PREFIX.'login'; // 로그인 테이블 (접속자수)\n");
fwrite($f, "\$g5['mail_table'] = G5_TABLE_PREFIX.'mail'; // 회원메일 테이블\n");
fwrite($f, "\$g5['member_table'] = G5_TABLE_PREFIX.'member'; // 회원 테이블\n");
fwrite($f, "\$g5['memo_table'] = G5_TABLE_PREFIX.'memo'; // 메모 테이블\n");
fwrite($f, "\$g5['poll_table'] = G5_TABLE_PREFIX.'poll'; // 투표 테이블\n");
fwrite($f, "\$g5['poll_etc_table'] = G5_TABLE_PREFIX.'poll_etc'; // 투표 기타의견 테이블\n");
fwrite($f, "\$g5['point_table'] = G5_TABLE_PREFIX.'point'; // 포인트 테이블\n");
fwrite($f, "\$g5['popular_table'] = G5_TABLE_PREFIX.'popular'; // 인기검색어 테이블\n");
fwrite($f, "\$g5['scrap_table'] = G5_TABLE_PREFIX.'scrap'; // 게시글 스크랩 테이블\n");
fwrite($f, "\$g5['visit_table'] = G5_TABLE_PREFIX.'visit'; // 방문자 테이블\n");
fwrite($f, "\$g5['visit_sum_table'] = G5_TABLE_PREFIX.'visit_sum'; // 방문자 합계 테이블\n");
fwrite($f, "\$g5['uniqid_table'] = G5_TABLE_PREFIX.'uniqid'; // 유니크한 값을 만드는 테이블\n");
fwrite($f, "\$g5['autosave_table'] = G5_TABLE_PREFIX.'autosave'; // 게시글 작성시 일정시간마다 글을 임시 저장하는 테이블\n");
fwrite($f, "\$g5['cert_history_table'] = G5_TABLE_PREFIX.'cert_history'; // 인증내역 테이블\n");
fwrite($f, "\$g5['qa_config_table'] = G5_TABLE_PREFIX.'qa_config'; // 1:1문의 설정테이블\n");
fwrite($f, "\$g5['qa_content_table'] = G5_TABLE_PREFIX.'qa_content'; // 1:1문의 테이블\n");
fwrite($f, "\$g5['content_table'] = G5_TABLE_PREFIX.'content'; // 내용(컨텐츠)정보 테이블\n");
fwrite($f, "\$g5['faq_table'] = G5_TABLE_PREFIX.'faq'; // 자주하시는 질문 테이블\n");
fwrite($f, "\$g5['faq_master_table'] = G5_TABLE_PREFIX.'faq_master'; // 자주하시는 질문 마스터 테이블\n");
fwrite($f, "\$g5['new_win_table'] = G5_TABLE_PREFIX.'new_win'; // 새창 테이블\n");
fwrite($f, "\$g5['menu_table'] = G5_TABLE_PREFIX.'menu'; // 메뉴관리 테이블\n");
fwrite($f, "\$g5['banner_table'] = G5_TABLE_PREFIX.'banner'; // 배너 테이블\n");
fwrite($f, "\$g5['css_table'] = G5_TABLE_PREFIX.'css_config'; // CSS STYLE 정의 저장하는 테이블\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, G5_FILE_PERMISSION);
?>

        <li>DB설정 파일 생성 완료 (<?php echo $file ?>)</li>

<?php
// data 디렉토리 및 하위 디렉토리에서는 .htaccess .htpasswd .php .phtml .html .htm .inc .cgi .pl 파일을 실행할수 없게함.
$f = fopen($data_path.'/.htaccess', 'w');
$str = <<<EOD
<FilesMatch "\.(htaccess|htpasswd|[Pp][Hh][Pp]|[Pp]?[Hh][Tt][Mm][Ll]?|[Ii][Nn][Cc]|[Cc][Gg][Ii]|[Pp][Ll])">
Order allow,deny
Deny from all
</FilesMatch>
EOD;
fwrite($f, $str);
fclose($f);
//-------------------------------------------------------------------------------------------------


// CSS 설정 파일 생성
$css_data_path = $g5_path['path']."/css";
$css_data_url = $g5_path['url']."/css";

@mkdir($css_data_path, G5_DIR_PERMISSION);
@chmod($css_data_path, G5_DIR_PERMISSION);

$file = '../'.G5_CSS_DIR.'/_design.config.css';
$file_path = $css_data_path.'/_design.config.css';
@unlink($file_path);
$f = @fopen($file, 'a');
?>
<li style="display:none;">
<?
ob_start();
include("../adm/design_form_css.php");
$css = ob_get_contents();
ob_end_flush();
fwrite($f,$css);
fclose($f);
@chmod($file, G5_FILE_PERMISSION);

?>
</li>
    </ol>

    <p>축하합니다. <?php echo G5_VERSION ?> 설치가 완료되었습니다.</p>

</div>

<div class="ins_inner">

    <h2>환경설정 변경은 다음의 과정을 따르십시오.</h2>

    <ol>
        <li>메인화면으로 이동</li>
        <li>관리자 로그인</li>
        <li>관리자 모드 접속</li>
        <li>환경설정 메뉴의 기본환경설정 페이지로 이동</li>
    </ol>

    <div class="inner_btn">
        <a href="../adm/">아보카도 에디션 관리자 페이지로 이동</a>
    </div>

</div>

<?php
include_once ('./install.inc2.php');
?>