<?php

include "../include/common.php";

if (!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$plan_type=addslashes(fnFilterString($_POST['plan_type']));
$tripType=addslashes(fnFilterString($_POST['tripType']));

if ($plan_type=="") {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
	$b2b_type_table = 'plan_code_type_btob';
} else {
	$b2b_type_table = 'plan_code_type_mg';
}

$sql="select * from ".$b2b_type_table." where trip_type='".$tripType."' and plan_type='".$plan_type."' ";
$result=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

$json_code = array('result'=>'true','msg'=>nl2br(stripslashes($row['content'])),'msg_title'=>nl2br(stripslashes($row['title'])));
echo json_encode($json_code);
exit;
?>