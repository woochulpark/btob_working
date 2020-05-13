<?php

include "../include/common.php";
include "../include/plan_check_ajax.php"; 

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

$sql="select 
		*
	  from
		hana_plan_member
	  where
		no='".$num."'
		and name='".$_SESSION['login_check_key_name']."'
		and jumin_1='".$_SESSION['login_check_key_1']."'
		and jumin_2='".$_SESSION['login_check_key_2']."'
	 ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if ($row['no']=="") {
	$json_code = array('result'=>'false','msg'=>'신청내역이 없습니다.');
	echo json_encode($json_code);
	exit;
}

$cur_time=time();
$start_time=strtotime($row['start_date']." ".$row['start_hour']."0000");
		
if (($start_time-$cur_time)<"7200") {
	$json_code = array('result'=>'false','msg'=>'여행 2시간 전까지 취소 가능합니다.');
	echo json_encode($json_code);
	exit;
}

$sql="update 
		hana_plan_member
	  set
		plan_state='2'
	  where
		no='".$num."'
		and name='".$_SESSION['login_check_key_name']."'
		and jumin_1='".$_SESSION['login_check_key_1']."'
		and jumin_2='".$_SESSION['login_check_key_2']."'
	 ";
$result=mysql_query($sql);

$json_code = array('result'=>'true','msg'=>"취소되었습니다.");
echo json_encode($json_code);
exit;
?>