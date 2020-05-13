<?php

include "../include/common.php";
include "../include/login_check_ajax.php"; 

if (!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$code=addslashes(fnFilterString($_POST['code']));
$trip_type=addslashes(fnFilterString($_POST['trip_type']));

if ($code=="" || $trip_type=="") {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$msg=array();
$plan_array=array();
$x=0;

if ($row_mem_info['mem_type']=="2") {

	if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
		$b2b_code_table = 'plan_code_btob';
	} else {
		$b2b_code_table = 'plan_code_mg';
	}

	$sql="select * from ".$b2b_code_table." where plan_code='".$code."' ";
} else {
	$sql="select * from plan_code_hana where plan_code='".$code."' and member_no='".$row_mem_info['no']."'";
}
$result=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

for ($i=1;$i<27;$i++) { 
	$plan_array['type_'.$i]=$row['type_'.$i];
}

if ($row_mem_info['mem_type']=="2") {

	if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
		$b2b_type_table = 'plan_code_type_btob';
	} else {
		$b2b_type_table = 'plan_code_type_mg';
	}

	$sql_title="select * from ".$b2b_type_table." where trip_type='".$trip_type."'";
} else {
	$sql_title="select * from plan_code_type_hana where trip_type='".$trip_type."' and member_no='".$row_mem_info['no']."'";
}

$result_title=mysql_query($sql_title);
while($row_title=mysql_fetch_array($result_title)) {
	
	$msg[$x]['content']=stripslashes($row_title['title']);
	
	if ($plan_array[$row_title['plan_type']]!='' && $plan_array[$row_title['plan_type']]!='0') {
		$table_price=kor_won($plan_array[$row_title['plan_type']]);
	} else {
		$table_price="";
	}

	$msg[$x]['price']=$table_price;

	$x++;
}

$json_code = array('result'=>'true','msg'=>$msg,'msg_title'=>stripslashes($row['plan_title']));
echo json_encode($json_code);
exit;
?>