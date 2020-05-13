<?php
include "../include/common.php";
$nationCode = addslashes(fnFilterString($_POST['nation']));

$DB_name = "nation";

$sql="select use_type from {$DB_name} where no='{$nationCode}'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if ($row['use_type']!='Y') {
	$json_code = array('result'=>'false','msg'=>'여행 불가지역입니다. .');
	echo json_encode($json_code);
	exit;
} else {

 $json_code = array('result'=>'true','msg'=>'여행가능 지역입니다.' );
		echo json_encode($json_code);
		exit;
}	
?>