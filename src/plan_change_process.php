<?php

include "../include/common.php";
include "../include/login_check_ajax.php";


$select_num		= addslashes(fnFilterString($_POST['select_num']));
$change_type	= addslashes(fnFilterString($_POST['change_type']));
$content				= addslashes(fnFilterString($_POST['content']));
$jumin1				= addslashes(fnFilterString($_POST['jumin_1']));
$jumin2				= addslashes(fnFilterString($_POST['jumin_2']));

if ($select_num=="" || $change_type=="" || $content=="") {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$sql="insert hana_plan_request set
		plan_no='{$select_num}',
		member_no='{$row_mem_info['no']}',
		jumin_1 = '{$jumin1}',
		jumin_2 = '{$jumin2}',
		change_type='{$change_type}',
		change_state='1',
		content='{$content}',
		regdate='{time()}'
	";
mysql_query($sql);
//echo $sql;
$sql="update hana_plan set
		plan_list_state='{$change_type}'
	  where no='{$select_num}'
	";
mysql_query($sql);

//echo $sql;
$mailContent = $content;
$message = (iconv('utf-8','euc-kr',$mailContent));

//$mailTo = "gs.cho@bis.co.kr, woori.yim@bis.co.kr, sungsil.lee@bis.co.kr";
//$mailTo = "gs.cho@bis.co.kr";
$mailTo = "woochul.park@bis.co.kr";
//$mailFrom = "dfight@test.co.kr";
$fromName = (iconv('utf-8','euc-kr','TourSafe'));
$mailTitle = "[투어세이프B2B] ".$row_mem_info['com_name']." ".$plan_state_text_array[$change_type]." 요청입니다.";

$boundary = "----".uniqid("part"); // 구분자 생성

// --- 헤더작성 --- //
$header = "Return-Path: $mailFrom\r\n"; // 반송 이메일 주소
$header .= "From: ".$fromName."<".$mailFrom.">\r\n"; // 송신자명, 송신자 이메일 주소
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: Multipart/alternative; boundary = \"$boundary\"";

// --- 이메일 본문 생성 --- //
$mailbody = "--$boundary\r\n";
$mailbody .= "Content-Type: text/html; charset=\"ks_c_5601-1987\"\r\n";
$mailbody .= "Content-Transfer-Encoding: base64\r\n\r\n";
$mailbody .= base64_encode(nl2br($message))."\r\n\r\n";

$mailbody .= "--$boundary--\r\n\r\n";


mail($mailTo,$mailTitle,$mailbody,$header);
    

$json_code = array('result'=>'true','msg'=>'신청되었습니다.');
echo json_encode($json_code);
exit;

?>