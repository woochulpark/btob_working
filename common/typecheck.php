<?php
include "../include/common.php";

$type=addslashes(fnFilterString($_GET['type']));

if ($type=="") {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$sql="select * from site_option";
$result=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

if ($type=="1") {
	if ($row['type_check_1']!="Y") {
		$json_code = array('result'=>'false','msg'=>'지금은 신청할수 없습니다.');
		echo json_encode($json_code);
		exit;
	}
} elseif ($type=="2") {
	if ($row['type_check_2']!="Y") {
		$json_code = array('result'=>'false','msg'=>'지금은 신청할수 없습니다.');
		echo json_encode($json_code);
		exit;
	}
} elseif ($type=="3") {
	if ($row['type_check_3']!="Y") {
		$json_code = array('result'=>'false','msg'=>'지금은 신청할수 없습니다.');
		echo json_encode($json_code);
		exit;
	}
}

$session_val=time()."_".$type."_".$_SERVER[REMOTE_ADDR];
$session_key =encode_pass($session_val,$pass_key);

session_start("s_session_key");
$_SESSION['s_session_key']=$session_key;


?>
<? if ($type=="1" || $type=="2") { ?>
<script>
	location.href="../main/main.php";
</script>
<? } else { ?>
<script>
	location.href="../study_abroad/01.php";
</script>
<? } ?>