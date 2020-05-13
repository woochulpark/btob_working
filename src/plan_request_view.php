<?php

include "../include/common.php";
include "../include/login_check_ajax.php";

if (!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$num=addslashes(fnFilterString($_POST['num']));

if ($num=="") {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$sql="select * from hana_plan_request where no='".$num."'";
$result=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

	$content=nl2br(stripslashes($row['content']));

$json_code = array('result'=>'true','msg'=>$content);
echo json_encode($json_code);
exit;
?>