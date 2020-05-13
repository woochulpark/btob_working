<?php

include "../include/common.php";
include "../include/hana_check_ajax.php";

$sex=addslashes(fnFilterString($_POST['sex']));
$age=addslashes(fnFilterString($_POST['age']));

$msg=array();
$x=0;

if (!chkToken($_REQUEST['auth_token'])) {
	$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
	echo json_encode($json_code);
	exit;
}

$sql="select * from plan_code_price_hana where trip_type='".$tripType."' and sex='".$sex."' and  age='".$age."'";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)) {
	$term_day=$row['term_day'];
	$price=$row['price'];

	if ($tripType=="1") {
		if ($term_day=="3" || $term_day=="5" || $term_day=="7" || $term_day=="10" || $term_day=="14" || $term_day=="30") {
			
			if ($msg[$term_day]['high_price']=="") {
				$msg[$term_day]['high_price']=$price;
			} elseif ($msg[$term_day]['high_price'] < $price) {
				$msg[$term_day]['high_price']=$price;
			} 

			if ($msg[$term_day]['low_price']=="") {
				$msg[$term_day]['low_price']=$price;
			} elseif ($msg[$term_day]['low_price'] > $price) {
				$msg[$term_day]['low_price']=$price;
			} 

		}
	} elseif ($tripType=="2") {
		if ($age > 79) {
			if ($term_day=="3" || $term_day=="5" || $term_day=="7" || $term_day=="10" || $term_day=="14" || $term_day=="30") {
				if ($msg[$term_day]['high_price']=="") {
					$msg[$term_day]['high_price']=$price;
				} elseif ($msg[$term_day]['high_price'] < $price) {
					$msg[$term_day]['high_price']=$price;
				} 

				if ($msg[$term_day]['low_price']=="") {
					$msg[$term_day]['low_price']=$price;
				} elseif ($msg[$term_day]['low_price'] > $price) {
					$msg[$term_day]['low_price']=$price;
				} 
			}
		} else {
			if ($term_day=="3" || $term_day=="5" || $term_day=="7" || $term_day=="10" || $term_day=="30" || $term_day=="90") {
				if ($msg[$term_day]['high_price']=="") {
					$msg[$term_day]['high_price']=$price;
				} elseif ($msg[$term_day]['high_price'] < $price) {
					$msg[$term_day]['high_price']=$price;
				} 

				if ($msg[$term_day]['low_price']=="") {
					$msg[$term_day]['low_price']=$price;
				} elseif ($msg[$term_day]['low_price'] > $price) {
					$msg[$term_day]['low_price']=$price;
				} 
			}
		}
	}

	
}

$json_code = array('result'=>'true','msg'=>$msg);
echo json_encode($json_code);
exit;

?>
