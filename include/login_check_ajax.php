<?php
if($_SESSION['s_mem_id']=="") {
	$json_code = array('result'=>'false','msg'=>'로그인 후 이용해 주세요.');
	echo json_encode($json_code);
	exit;
}

$sql_mem_info="select * from toursafe_members where uid='".$_SESSION['s_mem_id']."'";
$result_mem_info=mysql_query($sql_mem_info);
$row_mem_info=mysql_fetch_array($result_mem_info);

if ($row_mem_info['no']=="") {
	$json_code = array('result'=>'false','msg'=>'회원 정보가 없습니다.');
	echo json_encode($json_code);
	exit;
}


if ($row_mem_info['mem_state']=="1") {
	$json_code = array('result'=>'false','msg'=>'관리자 승인 대기중 입니다.');
	echo json_encode($json_code);
	exit;
}

?>