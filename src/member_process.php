<?php
include "../include/common.php";

if(!chkToken($_POST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$DB_name = "toursafe_members";
$uid=addslashes(fnFilterString($_POST['b2bid']));
$upw=addslashes(fnFilterString($_POST['b2bpw']));
$com_no=addslashes(fnFilterString($_POST['com_no']));
$com_name=addslashes(fnFilterString($_POST['com_name']));
$com_date=addslashes(fnFilterString($_POST['open_com_d']));
//$email=addslashes(fnFilterString($_POST['email']));

$hphone1=addslashes(fnFilterString($_POST['sel_phone']));
$hphone2=addslashes(fnFilterString($_POST['phone_front']));
$hphone3=addslashes(fnFilterString($_POST['phone_back']));
$fax_num =addslashes(fnFilterString($_POST['faxnum']));
$mailf = addslashes(fnFilterString($_POST['mail_front']));
$mailb = addslashes(fnFilterString($_POST['mail_back']));
$zip_code = addslashes(fnFilterString($_POST['contPost']));
$addrf= addslashes(fnFilterString($_POST['joinAddr']));
$addrb= addslashes(fnFilterString($_POST['joinAddrDetail']));
$hphone = $hphone1.$hphone2.$hphone3;
$email = $mailf."@".$mailb;
$regdate=time();

$pass = strtoupper(hash("sha256", md5($upw)));

$sql="select * from ".$DB_name." where uid='".$uid."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if ($row['no']!='') {
	$json_code = array('result'=>'false','msg'=>'이미 등록된 아이디 입니다.');
	echo json_encode($json_code);
	exit;
}

$f_chk = false;
$img_path = $_SERVER['DOCUMENT_ROOT']."/fileupload/btob";


if(isset($_FILES['com_file_img']['name'])	){
	
	$img_name = $_FILES['com_file_img']['name'];
	if($_FILES['com_file_img']['error'] < 1 ){
		
		if($_FILES['com_file_img']['size'] < 210000000){

			$both_file = explode(".",$_FILES['com_file_img']['name']);
			$save_img_name = date("YmdHis",time());
			$chg_img_name = $save_img_name.".".$both_file[1];
			$sv_img_path = $img_path."/".$chg_img_name;
			  if(preg_match("#.jpg#i",$img_name) || preg_match("#.gif#i",$img_name) || preg_match("#.png#i",$img_name) || preg_match("#.jpeg#i",$img_name) ){

				if(move_uploaded_file($_FILES['com_file_img']['tmp_name'],$sv_img_path)){
					
					$f_chk = true;
				}
			  }
		}
	}
} 
$add_que = '';
if(!$f_chk){
	$json_code = array('result'=>'false','msg'=>'파일 업로드중 오류가 발생하였습니다. 업로드 가능한 파일은 img 파일입니다. 다시 시도해 주시기 바랍니다.');
	echo json_encode($json_code);
	exit;
} else {
	$save_file_name = $chg_img_name;
	$safe_front_name = $img_name;

	$add_que = " , file_real_name = '".$save_file_name."', file_name = '".$safe_front_name."' ";

}

	$email =encode_pass($email,$pass_key);
	$hphone =encode_pass($hphone,$pass_key);
	$enc_fax = encode_pass($fax_num,$pass_key);
//$DB_name1 = 'toursafe_members1';
	$ins_q="insert into ".$DB_name." set
			uid='".$uid."',
			mem_type='".$mem_type."',
			mem_state='1',
			upw='".$pass."',
			com_no='".$com_no."',
			com_name='".$com_name."',
			email='".$email."',
			hphone='".$hphone."',
			regdate='".$regdate."',
			fax_contact = '".$enc_fax."',
			com_open_date = '".$com_date."',
			post_no = '".$zip_code."',
			post_addr = '".$addrf."',
			post_addr_detail = '".$addrb."'
			";
			
	$result = mysql_query($ins_q.$add_que);
	
	if ($result==false) {
		$json_code = array('result'=>'false','msg'=>'다시 시도해 주세요.');
		echo json_encode($json_code);
		exit;
	} else {
	    
	    $hphonedec=trim(decode_pass($hphone,$pass_key));
	    
	    //$emailTo= "gs.cho@bis.co.kr, seoksoo.ko@bis.co.kr, tony.kim@bis.co.kr, hansol.im@bis.co.kr";
		$emailTo= " james.shim@bis.co.kr, tony.kim@bis.co.kr, hansol.im@bis.co.kr";
	    
	    $subject = "[투어세이프 B2B] ".$com_name." 가입승인 요청";
	    $content = $com_name."님으로부터 가입승인 요청메일이 도착하였습니다.\r\n";
	    $content.= "아이디 : ".$uid."\r\n";
	    $content.= "이메일 : ".$email."\r\n";  
	    $content.= "연락처 : ".$hphonedec."\r\n";
	    
	    //$from = "gs.cho@bis.co.kr";
		$from = "woochul.park@bis.co.kr";
	    $title = $subject;
	    $name = "toursafe";
	    $body = ($content);
	    
	    
	    $title = "=?utf-8?B?".base64_encode($title)."?=";
	    $name = "=?utf-8?B?".base64_encode($name)."?=";
	    
	    $boundary = "----".uniqid("part"); // 이메일 내용 구분자 설정
	    
	    $header .= "Return-Path: $from\r\n"; // 반송 이메일 주소
	    $header .= "From: ".$name."<".$from.">\n"; // 보내는 사람 이메일 주소
	    $header .= "MIME-Version: 1.0\r\n"; // MIME 버전 표시
	    $header .= "Content-Type: Multipart/mixed; boundary = \"$boundary\""; // 구분자가 $boundary 임을 알려줌
	    
	    ## 여기부터는 이메일 본문 생성 ##
	    $mailbody .= "This is a multi-part message in MIME format.\r\n\r\n"; // 메세지
	    $mailbody .= "--$boundary\r\n"; // 내용 구분 시작
	    
	    //내용이 일반 텍스트와 html 을 사용하며 한글이라고 알려줌
	    $mailbody .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
	    
	    //암호화 방식을 알려줌
	    $mailbody .= "Content-Transfer-Encoding: base64\r\n\r\n";
	    
	    //이메일 내용을 암호화 해서 추가
	    $mailbody .= base64_encode($body)."\r\n\r\n";
	    
	    //mail($emailTo,addslashes($title),$mailbody,$header,'-f'.$from);
	    
	    $json_code = array('result'=>'true','msg'=>$uid);
		echo json_encode($json_code);
		exit;
	}
?>