<?
include "../include/common.php";
include "../include/login_check_ajax.php";

$msg=array();
$x=0;

if (!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$start_date = addslashes(fnFilterString($_POST['start_date']));
$start_hour = addslashes(fnFilterString($_POST['start_hour']));

$end_date = addslashes(fnFilterString($_POST['end_date']));
$end_hour = addslashes(fnFilterString($_POST['end_hour']));

$birth_date = addslashes(fnFilterString($_POST['birth_date']));
$sex = addslashes(fnFilterString($_POST['sex']));
$name = addslashes(fnFilterString($_POST['name']));

$jumin_1 = addslashes(fnFilterString($_POST['jumin_1']));
$jumin_2 = addslashes(fnFilterString($_POST['jumin_2']));

$jumin_check=resnoCheck($jumin_1,$jumin_2);

if ($jumin_check==false) {
	$json_code = array('result'=>'false','msg'=>'주민등록번호를 확인해 주세요.');
	echo json_encode($json_code);
	exit;
}

$jumin_1 =encode_pass($jumin_1,$pass_key);
$jumin_2 =encode_pass($jumin_2,$pass_key);

$hphone = addslashes(fnFilterString($_POST['hphone1'])).addslashes(fnFilterString($_POST['hphone2'])).addslashes(fnFilterString($_POST['hphone3']));
$hphone=encode_pass($hphone,$pass_key);

$email = addslashes(fnFilterString($_POST['email1']))."@".addslashes(fnFilterString($_POST['email2']));
$email =encode_pass($email,$pass_key);

$cur_nation = addslashes(fnFilterString($_POST['cur_nation']));
$trip_purpose = addslashes(fnFilterString($_POST['trip_purpose']));
$nation = addslashes(fnFilterString($_POST['nation']));
$nation_etc = addslashes(fnFilterString($_POST['nation_etc']));
$content = addslashes(fnFilterString($_POST['content']));

$sql_insert="insert into hana_study_abroad set
			member_no='".$row_mem_info['no']."',
			start_date='".$start_date."',
			start_hour='".$start_hour."',
			end_date='".$end_date."',
			end_hour='".$end_hour."',
			birth_date='".$birth_date."',
			sex='".$sex."',
			name='".$name."',
			jumin_1='".$jumin_1."',
			jumin_2='".$jumin_2."',
			hphone='".$hphone."',
			email='".$email."',
			cur_nation='".$cur_nation."',
			trip_purpose='".$trip_purpose."',
			nation='".$nation."',
			nation_etc='".$nation_etc."',
			content='".$content."',
			regdate='".time()."'

		";	
$sql_success=mysql_query($sql_insert);

if ($sql_success) {
	$json_code = array('result'=>'true','msg'=>'success');
	echo json_encode($json_code);
	exit;
} else {
	$json_code = array('result'=>'false','msg'=>'다시시도해 주세요.');
	echo json_encode($json_code);
	exit;
}

?>
