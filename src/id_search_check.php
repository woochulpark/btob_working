<?php
include "../include/common.php";

$id_name=fnFilterString($_REQUEST[id_name]);
$id_email=fnFilterString($_REQUEST[id_email]);

$email=$id_email;

$email =encode_pass($email,$pass_key);

if(!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

if(!$id_name or !$id_email)
{
	$json_code = array('result'=>'false','msg'=>'기업명/이메일을 입력하세요.');
	echo json_encode($json_code);
	exit;
}
else{

	$sel_q="select * from toursafe_members where com_name='$id_name' and email='$email'";
	$sel_e=mysql_query($sel_q) or die(mysql_error());
	$sel=mysql_fetch_array($sel_e);

	if($sel[no] != "") {

		$json_code = array('result'=>'true','msg'=>$sel['uid']);
		echo json_encode($json_code);
		exit;
	} else {
		$json_code = array('result'=>'false','msg'=>'일치하는 회원정보가 없습니다..');
		echo json_encode($json_code);
		exit;
	}
}
?>
