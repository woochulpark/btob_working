<?php
include "../include/common.php";

$search_name=addslashes(fnFilterString(strip_tags($_POST['search_name'])));
$search_jumin_1=addslashes(fnFilterString(strip_tags($_POST['search_jumin_1'])));
$search_jumin_2=addslashes(fnFilterString(strip_tags($_POST['search_jumin_2'])));

if($search_name=="" || $search_jumin_1=="" || $search_jumin_2=="") {
	$json_code = array('result'=>'false','msg'=>'정보를 정확히 입력하세요.');
	echo json_encode($json_code);
	exit;
} else {

	$jumin_1 =encode_pass($search_jumin_1,$pass_key);
	$jumin_2 =encode_pass($search_jumin_2,$pass_key);

	$sel_q="select * from hana_plan_member where name='".$search_name."' and jumin_1='".$jumin_1."' and jumin_2='".$jumin_2."'";
	$sel_e=mysql_query($sel_q) or die(mysql_error());
	$sel=mysql_fetch_array($sel_e);

	if($sel[no] != "") {
		session_start("login_check_key_name, login_check_key_1,login_check_key_2");
		$_SESSION['login_check_key_name']=$search_name;
		$_SESSION['login_check_key_1']=$jumin_1;
		$_SESSION['login_check_key_2']=$jumin_2;

		$json_code = array('result'=>'true','msg'=>'');
		echo json_encode($json_code);
		exit;
	} else {
		$json_code = array('result'=>'false','msg'=>'');
		echo json_encode($json_code);
		exit;
	}
}
?>
