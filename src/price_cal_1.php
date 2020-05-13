<?
include "../include/common.php";
include "../include/hana_check_ajax.php";

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

$start_date_arr=explode("-",$start_date);
$start_time=mktime($start_hour,"00","00",$start_date_arr[1],$start_date_arr[2],$start_date_arr[0]);

$end_date_arr=explode("-",$end_date);
$end_time=mktime($end_hour,"00","00",$end_date_arr[1],$end_date_arr[2],$end_date_arr[0]);

//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철
//$term_day=ceil(($end_time-$start_time)/86400);
$term_day = travel_period($start_date." ".$start_hour.":00:00", $end_date." ".$end_hour.":00:00"); 
//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철

if ($tripType=="1") {
	if ($term_day > 30) {
		$term_day=30;
	}
} elseif ($tripType=="2") {
	if ($term_day > 90) {
		$term_day = 90;
	}
}

$plan_type = addslashes(fnFilterString($_POST['plan_type']));
$cur_date=date("Y-m-d");
$total_price="0";
$select_cnt=0;

for ($i=0;$i<count($_POST['jumin_1']);$i++) {
	
	if ($_POST['jumin_1'][$i]!='') {
		

	    if (substr($_POST['jumin_2'][$i],0,1) == "1" ||
	        substr($_POST['jumin_2'][$i],0,1) == "2" ||
	        substr($_POST['jumin_2'][$i],0,1) == "3" ||
	        substr($_POST['jumin_2'][$i],0,1) == "4"){
	            $jumin_check=resnoCheck($_POST['jumin_1'][$i],$_POST['jumin_2'][$i]);
	    } else {
	        $jumin_check=foreignerCheck($_POST['jumin_1'][$i],$_POST['jumin_2'][$i]);
	    }

		if ($jumin_check==false) {
			$json_code = array('result'=>'false','msg'=>'앞자리 : '.$_POST['jumin_1'][$i].' 주민등록번호를 확인해 주세요.');
			echo json_encode($json_code);
			exit;
		}

		for ($j=0;$j<count($_POST['jumin_1']);$j++) { 
			if ($i!=$j) {
				if ($_POST['jumin_1'][$i]==$_POST['jumin_1'][$j]) {
					$json_code = array('result'=>'false','msg'=>'동일한 주민등록 번호가 등록되어 있습니다.');
					echo json_encode($json_code);
					exit;
				}
			}
		}

		$sex_type=substr($_POST['jumin_2'][$i],0,1);

		if ($sex_type=="1" || $sex_type=="2" || $sex_type=="5" || $sex_type=="6") {
		    $birth_year="19".substr($_POST['jumin_1'][$i],0,2);
		    $birth_month=substr($_POST['jumin_1'][$i],2,2);
		    $birth_day=substr($_POST['jumin_1'][$i],4,2);
		} elseif ($sex_type=="3" || $sex_type=="4" || $sex_type=="7" || $sex_type=="8") {
		    $birth_year="20".substr($_POST['jumin_1'][$i],0,2);
		    $birth_month=substr($_POST['jumin_1'][$i],2,2);
		    $birth_day=substr($_POST['jumin_1'][$i],4,2);
		}
		
		
		if ($sex_type=="1" || $sex_type=="3" || $sex_type=="5" || $sex_type=="7") {
		    $sex='1';
		} elseif ($sex_type=="2" || $sex_type=="4" || $sex_type=="6" || $sex_type=="8") {
		    $sex='2';
		}

		$birth_date=$birth_year."-".$birth_month."-".$birth_day;
		
		list($cal_age,$term_year) = age_cal($cur_date,$birth_date);
		
		if ($cal_age > 100) {
		    $cal_age=100;
		}

		if ($tripType=="2") {
			if ($cal_age >= 0 && $cal_age <= 14) {
				$cal_type="1";
			} elseif ($cal_age >= 15 && $cal_age <= 70) {
				$cal_type="2";

				if ($cal_age=="15") {
					if ($term_year=="14") {
						$cal_type="1";
					}
				}
			} elseif ($cal_age >= 71 && $cal_age <= 90) {
				$cal_type="3";
			} elseif ($cal_age >= 91) {
				$cal_type="4";
			}
		} elseif ($tripType=="1") {
			if ($cal_age >= 0 && $cal_age <= 14) {
				$cal_type="1";
			} elseif ($cal_age >= 15 && $cal_age <= 79) {
				$cal_type="2";

				if ($cal_age=="15") {
					if ($term_year=="14") {
						$cal_type="1";
					}
				}
			} elseif ($cal_age >= 80 && $cal_age <= 100) {
				$cal_type="3";
			}
		}

		$cal_type_code=${"cal_type_".$cal_type."_code"};


		if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
			$b2b_price_table = 'plan_code_price_btob';
		} else {
			$b2b_price_table = 'plan_code_price_mg';
		}

		if ($cal_type_code!='') {
			
			$select_term="select plan_code, price from ".$b2b_price_table." where trip_type='".$tripType."' and plan_code='".$cal_type_code."' and term_day >= '".$term_day."' and sex='".$sex."' and age='".$cal_age."' order by term_day asc limit 1";
			$result_term=mysql_query($select_term);
			$row_term=mysql_fetch_array($result_term);

				$total_price=$total_price+$row_term['price'];

			$select_cnt++;
		}
	}
}


$json_code = array('result'=>'true','total_price'=>number_format($total_price),'total_price_val'=>$total_price,'select_cnt'=>$select_cnt);
echo json_encode($select_term);
exit;

?>
