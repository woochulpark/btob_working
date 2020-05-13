<?php
include "../include/common.php";

$pass_id=fnFilterString($_REQUEST[pass_id]);
$pass_name=fnFilterString($_REQUEST[pass_name]);
$pass_email=fnFilterString($_REQUEST[pass_email]);

$email=$pass_email;

$email =encode_pass($email,$pass_key);

if(!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

if(!$pass_name or !$pass_email or !$pass_id)
{
	$json_code = array('result'=>'false','msg'=>'아이디/기업명/이메일을 입력하세요.');
	echo json_encode($json_code);
	exit;
}
else{

	$sel_q="select * from toursafe_members where uid='$pass_id' and com_name='$pass_name' and email='$email'";
	$sel_e=mysql_query($sel_q) or die(mysql_error());
	$sel=mysql_fetch_array($sel_e);

	if($sel[no] != "") {

		$new_upw = random_hax(10);
		$pass = strtoupper(hash("sha256", md5($new_upw)));
		mysql_query("update toursafe_members set upw='$pass' where no='$sel[no]'");

		$subject = "안녕하세요 ".$shop_name." 입니다. 회원님께서 요청하신 비밀번호입니다.";
		$content = "
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"ko\">
		<head>
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\" />
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<title></title>
		</head>
		<body style=\"margin:0; padding:0;\">
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"color:#666;\">
		  <tr>
			<td align=\"center\" valign=\"top\"><table width=\"700\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color:#fff; border:1px solid #ccc;\">
				<tr>
				  <td valign=\"top\"  align=\"left\" style='font-size:0px; padding:0 0 20px 20px;'><img src=\"".$site_ssl_b2b."://".$site_url_b2b."/img/common/logo.png\" /></td>
				</tr>
				<tr>
				  <td align=\"left\" style=\"font-size:26px; padding:0 0 20px 20px; line-height:32px; margin:0; font-weight:600; border-bottom:2px solid #f8f8f8;\"><span style=\"color:#000;\">".$pass_name."님</span> 임시 비밀번호가 발급 되었습니다. </td>
				</tr>
				<tr>
				  <td  align=\"left\" style=\"font-size:14px; padding:20px; line-height:22px; margin:0; border-bottom:2px solid #f8f8f8;\"> 요청하신 임시 비밀번호가 발급되었습니다.<br />
					<span style=\"color:#000; font-weight:600;\">".$pass_name."</span> 님 로그인 후, 새로운 비밀번호로 변경 바랍니다. </td>
				</tr>
				<tr>
				  <td  align=\"left\" style=\"font-size:14px; padding:20px; line-height:22px; margin:0; border-bottom:2px solid #f8f8f8;\"> 아이디 : <span style=\"color:#000; font-weight:600;\">".$pass_id."</span><br />
					임시비밀번호 : <span style=\"color:#000; font-weight:600;\">".$new_upw."</span></td>
				</tr>
				<tr>
				  <td  align=\"left\" style=\"font-size:12px; line-height:20px; padding:20px; margin:0; border-bottom:2px solid #f8f8f8;\"><span style=\"color:#000; font-weight:600;\">※ 주의사항</span><br />
					- 로그인 후  회원정보수정에서 새로운 비밀번호로 변경하여 이용하시기 바랍니다. <br />
					- 임시비밀번호는  관리자도 알 수 없도록 암호화되어 있습니다. <br />
					- 개인정보 보호를 위해, ID나 전화번호 등 알기 쉬운 비밀번호를 피해 주시고,<br />
					<span style=\"padding-left:9px;\">가급적 영문이나 숫자 등이 조합된 형태로 변경하시는 것을 권해 드립니다. </span><br />
					<span style=\"padding-left:9px;\">만약, 변경 된 비밀번호로도 로그인 되지 않을 경우, Caps Lock키가 켜져 있었는지 확인하시고, </span><br />
					<span style=\"padding-left:9px;\">그래도 되지 않으신다면 고객지원 센터로 문의해주시길 바랍니다. </span></td>
				</tr>
				<tr>
				  <td align=\"left\" style=\"font-size:14px; padding:20px; font-weight:600; line-height:22px; margin:0;\"><a href=\"".$site_ssl_b2b."://".$site_url_b2b."\" target=\"_blank\" style=\"color:#000; text-decoration:underline;\">[홈페이지 바로가기]</a></td>
				</tr>
				<tr>
				  <td  align=\"left\" style=\"font-size:12px; background-color:#f8f8f8; padding:20px; margin:0;\">COPYRIGHT ⓒ TOURSAFE INC. ALL RIGHTS RESERVED</td>
				</tr>
			  </table></td>
		  </tr>
		</table>
		</body>
		</html>
		";

	$from = $response_mail; 
	$title = $subject;
	$name = $response_name;
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


	if(!@mail($pass_email,addslashes($title),$mailbody,$header)){ 
		$json_code = array('result'=>'false','msg'=>'메일발송에 실패하였습니다. 다시 시도해 주세요. ');
		echo json_encode($json_code);
		exit;
    }

		$json_code = array('result'=>'true');
		echo json_encode($json_code);
		exit;
	} else {
		$json_code = array('result'=>'false','msg'=>'일치하는 회원정보가 없습니다.. ');
		echo json_encode($json_code);
		exit;
	}
}
?>
