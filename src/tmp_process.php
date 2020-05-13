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

$sql_check="select * from hana_plan_tmp where member_no='".$row_mem_info['no']."' and session_key='".$_SESSION['s_session_key']."'";
$result_check=mysql_query($sql_check);
$row_check=mysql_fetch_array($result_check);

if ($row_check['no']!='') {
	$sql_delete="delete from hana_plan_tmp where member_no='".$row_mem_info['no']."' and session_key='".$_SESSION['s_session_key']."'";
	mysql_query($sql_delete);

	$sql_delete="delete from hana_plan_member_tmp where tmp_no='".$row_check['no']."'";
	mysql_query($sql_delete);
}

$start_date = addslashes(fnFilterString($_POST['start_date']));
$start_hour = addslashes(fnFilterString($_POST['start_hour']));

$end_date = addslashes(fnFilterString($_POST['end_date']));
$end_hour = addslashes(fnFilterString($_POST['end_hour']));

$start_date_arr=explode("-",$start_date);
$start_time=mktime($start_hour,"00","00",$start_date_arr[1],$start_date_arr[2],$start_date_arr[0]);

$end_date_arr=explode("-",$end_date);
$end_time=mktime($end_hour,"00","00",$end_date_arr[1],$end_date_arr[2],$end_date_arr[0]);

//2019-08-06 $term_day 상품별 여행기간 계산 추가 - 박우철
//$term_day=ceil(($end_time-$start_time)/86400);
$term_day = travel_period($start_date." ".$start_hour.":00:00", $end_date." ".$end_hour.":00:00"); 
//2019-08-06 $term_day 상품별 여행기간 계산 추가 - 박우철

if ($tripType=="1") {
	if ($term_day > 30) {
		$term_day=30;
	}
} elseif ($tripType=="2") {
	if ($term_day > 90) {
		$term_day = 90;
	}
}

$cur_date=date("Y-m-d");
$total_price="0";

$sql_tmp="insert into hana_plan_tmp set
			session_key='".$_SESSION['s_session_key']."',
			member_no='".$row_mem_info['no']."',
			trip_type='".$tripType."',
			order_type='".$send_type."',
			nation_no='".$nation."',
			trip_purpose='".$trip_purpose."',
			start_date='".$start_date."',
			start_hour='".$start_hour."',
			end_date='".$end_date."',
			end_hour='".$end_hour."',
			term_day='".$term_day."',
			join_cnt='".$join_cnt."',
			plan_type='".$plan_type."',
			regdate='".time()."'

		";	
mysql_query($sql_tmp);
$tmp_no = mysql_insert_id();

$main_check="";

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
			$json_code = array('result'=>'false','msg'=>'주민등록번호를 확인해 주세요.');
			echo json_encode($json_code);
			exit;
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
			$cal_age_cal=100;
		} else {
			$cal_age_cal=$cal_age;
		}

		if ($main_check=="") {
			$main_check="Y";
		} else {
			$main_check="N";
		}

		if ($tripType=="2") {
			if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
					if ($cal_age_cal >= 0 && $cal_age_cal <= 14) {
						$cal_type="1";
					} elseif ($cal_age_cal >= 15 && $cal_age_cal <= 70) {
						$cal_type="2";

						if ($cal_age=="15") {
							if ($term_year=="14") {
								$cal_type="1";
							}
						}
					} elseif ($cal_age_cal >= 71 && $cal_age_cal <= 90) {
					
							$cal_type="3";
						
					} elseif ($cal_age_cal >= 91) {
						$cal_type="4";
					}
			} else {
						if($cal_age >= 0 && $cal_age <= 14){
							$cal_type="1";
						} 	
						else if($cal_age >= 15 && $cal_age <= 69)
						{
							$cal_type = "2";

							if($cal_age == 15 && $term_year == 14)
							{
								$cal_type  = "1";
							}
						}
						else if($cal_age >= 70 && $cal_age <= 100)
						{
							$cal_type="4";		
						}
			}

		} elseif ($tripType=="1") {
			if ($cal_age_cal >= 0 && $cal_age_cal <= 14) {
				$cal_type="1";
			} elseif ($cal_age_cal >= 15 && $cal_age_cal <= 79) {
				$cal_type="2";

				if ($cal_age=="15") {
					if ($term_year=="14") {
						$cal_type="1";
					}
				}
			} elseif ($cal_age_cal >= 80 && $cal_age_cal <= 100) {
				$cal_type="3";
			}
		}

		$cal_type_code=${"cal_type_".$cal_type."_code"};

		if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
			$b2b_price_table = 'plan_code_price_btob';
		} else {
			$b2b_price_table = 'plan_code_price_mg';
		}

		if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
			$b2b_code_table = 'plan_code_btob';
		} else {
			$b2b_code_table = 'plan_code_mg';
		}

		$select_term="select plan_code, price from ".$b2b_price_table." where trip_type='".$tripType."' and plan_code='".$cal_type_code."' and term_day >= '".$term_day."' and sex='".$sex."' and age='".$cal_age_cal."' order by term_day asc limit 1";
		$result_term=mysql_query($select_term);
		$row_term=mysql_fetch_array($result_term);

			$total_price=$total_price+$row_term['price'];

		$jumin_1 =encode_pass(addslashes(fnFilterString($_POST['jumin_1'][$i])),$pass_key);
		$jumin_2 =encode_pass(addslashes(fnFilterString($_POST['jumin_2'][$i])),$pass_key);
		
		if ($_POST['hphone1'][$i]!='' && $_POST['hphone2'][$i]!='' && $_POST['hphone3'][$i]!='') {
			$hphone=encode_pass(addslashes(fnFilterString($_POST['hphone1'][$i])).addslashes(fnFilterString($_POST['hphone2'][$i])).addslashes(fnFilterString($_POST['hphone3'][$i])),$pass_key);
		} else {
			$hphone="";
		}

		if ($_POST['email1'][$i]!='' && $_POST['email2'][$i]!='') {
			$email=encode_pass(addslashes(fnFilterString($_POST['email1'][$i]))."@".addslashes(fnFilterString($_POST['email2'][$i])),$pass_key);
		} else {
			if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
				$email="";
			} else {
				$email=encode_pass(addslashes(fnFilterString($_POST['email1'][$i])),$pass_key);
			}
		}

		$sql_tmp="insert into hana_plan_member_tmp set
			tmp_no='".$tmp_no."',
			main_check='".$main_check."',
			name='".addslashes(fnFilterString($_POST['input_name'][$i]))."',
			jumin_1='".$jumin_1."',
			jumin_2='".$jumin_2."',
			hphone='".$hphone."',
			email='".$email."',
			plan_code='".$row_term['plan_code']."',
			plan_price='".$row_term['price']."',
			sex='".$sex."',
			age='".$cal_age."',
            plan_title = (select plan_title from ".$b2b_code_table." where plan_code = '".$row_term['plan_code']."')
		";	
		mysql_query($sql_tmp);
	}
}


$json_code = array('result'=>'true','msg'=>'success');
echo json_encode($json_code);
exit;

?>
