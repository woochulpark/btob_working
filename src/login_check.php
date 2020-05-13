<?php
include "../include/common.php";

$uid=addslashes($login_uid);
$upw=addslashes($login_upw);

$pass = strtoupper(hash("sha256", md5($upw)));

if(!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

if(!$uid or !$upw)
{
	$json_code = array('result'=>'false','msg'=>'아이디/비밀번호를 입력하세요.');
	echo json_encode($json_code);
	exit;
}
else{

	$sel_q="select * 
			from toursafe_members 
			where 
				uid='".$uid."' 
				and upw='$pass'";
	$sel_e=mysql_query($sel_q) or die(mysql_error());
	$sel=mysql_fetch_array($sel_e);

	if($sel[no] != "") {


		if ($sel['mem_state']=="1") {
			$json_code = array('result'=>'false','msg'=>'관리자 승인 대기중 입니다.');
			echo json_encode($json_code);
			exit;
		}

		$sear_no = $sel['no'];
		
		$search_opt_que = "select type_check_1, type_check_2, type_check_3 from site_option where member_no = '{$sear_no}' ";
		
		$search_opt_res = mysql_query($search_opt_que) or die (mysql_error());
		$search_rows=mysql_fetch_array($search_opt_res);


		session_start("s_mem_id");
		$_SESSION['s_mem_id']=$uid;
		$_SESSION['s_mem_no'] =  $sel['no'];
		$_SESSION['s_mem_type1'] = $search_rows['type_check_1'];
		$_SESSION['s_mem_type2'] = $search_rows['type_check_2'];
		$_SESSION['s_mem_type3'] = $search_rows['type_check_3'];
		$_SESSION['s_mem_type'] = ($sel['mem_type'] == '2') ? "B2B":"B2C";
		$_SESSION['s_mem_insu1'] = $sel['insuran1'];// 사용 보험사1 (DB) 
		$_SESSION['s_mem_insu2'] = $sel['insuran2'];// 사용 보험사2 (ACE)
		$_SESSION['s_mem_long1'] = $sel['insuran6'];// 사용 보험사 장기1 (meritz) 
		$_SESSION['s_mem_long2'] = $sel['insuran7'];// 사용 보험사 장기2 (hanhwa)
		$_SESSION['s_mem_com'] = $sel['com_name']; //회원사명

		$ins_q="insert into toursafe_login_log set
			uid='".$uid."',
			login_ip='".$_SERVER[REMOTE_ADDR]."',
			login_regdate='".time()."'
			";
		$result = mysql_query($ins_q);

		$sql_update="update toursafe_members set
						last_login='".time()."'
					where uid='".$uid."' 
					";
		$result = mysql_query($sql_update);

		$json_code = array('result'=>'true','msg'=>'1');
		echo json_encode($json_code);
		exit;
	} else {
		$json_code = array('result'=>'false','msg'=>'아이디/비밀번호를 확인 해 주세요.');
		echo json_encode($json_code);
		exit;
	}
}
?>
