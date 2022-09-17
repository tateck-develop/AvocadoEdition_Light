<?php
$menu['menu900'] = array (
    array('900000', '기타관리', G5_ADMIN_URL.'/session_file_delete.php', ''),
    array('900100', '세션파일 일괄삭제',G5_ADMIN_URL.'/session_file_delete.php', 'cf_session', 1),
	array('900200', '캐시파일 일괄삭제',G5_ADMIN_URL.'/cache_file_delete.php',   'cf_cache', 1),
	array('900300', '홈페이지 상세관리',G5_ADMIN_URL.'/config_form.php',   'cf_thumbnail', 1)
);
?>