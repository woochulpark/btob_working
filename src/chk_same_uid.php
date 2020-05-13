<?php
include "../include/common.php";

if(!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$val = preg_replace("/\s+/", "", $uid);

$cnt = sql_cnt("toursafe_members"," and uid='$val'");
if($val == 'admin' || $val == 'best_admin'){
	$json_code = array('result'=>'false','msg'=>'사용할 수 없는 아이디 입니다.');
	echo json_encode($json_code);
	exit;
} else {
	if($cnt > 0) // 정보가 있으면 ID 다시 기입
	{
		$json_code = array('result'=>'false','msg'=>'이미 가입된 아이디 입니다.');
		echo json_encode($json_code);
		exit;
	}
	else
	{
		$json_code = array('result'=>'true','msg'=>'가입이 가능한 아이디 입니다.');
		echo json_encode($json_code);
		exit;
	}
}
?>
