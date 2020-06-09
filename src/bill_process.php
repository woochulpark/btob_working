<?
	include "../include/common.php";	
	
	$sess_code = $_SESSION['s_session_key'];
	$mem_no = $_SESSION['s_mem_no'];

	if(!isset($_SESSION['s_session_key']) && $sess_code == ''){
		$json_code = array('result'=>'false','msg'=>'세션정보가 삭제 되었습니다. 다시 시도해 주세요');
		echo json_encode($json_code);
		exit;
	}  else {

		$session_chk_que = " SELECT no FROM hana_plan_test WHERE session_key = '{$_SESSION['s_session_key']}' ";

		$session_chk_res = mysql_query($session_chk_que);
		$session_chk_row = mysql_fetch_array($session_chk_res);

		if(isset($session_chk_row['no'])){
			$json_code = array('result'=>'false','msg'=>'동일한 세션 정보가 확인되었습니다.');
			echo json_encode($json_code);
			exit;
		}
		

		$selInsurance = $_POST['selinsuran'];
		$tripType = $_POST['trip_Type'];
		$nationVal = $_POST['nation'];
		$tripPurpose = $_POST['trip_purpose'];
		$startDate = $_POST['start_date'];
		$startHour = $_POST['start_hour'];
		$endDate = $_POST['end_date'];
		$endHour = $_POST['end_hour'];			
		$planType = $_POST['plan_type'];
		$join_cnt = count(array_filter($_POST['juminno']));
		$currentResi = $_POST['rr'];
		$notiConfirm = $_POST['notice_confirm'];
		$contConfirm = $_POST['contract_confirm'];
		$commonPlan = $_POST['common_plan'];
		$join_name = $_POST['input_name'][0];
		$memoEtc1 = addslashes(fnFilterString($_POST['etc_memo1']));
		$memoEtc2 = addslashes(fnFilterString($_POST['etc_memo2']));
		$today_t = time();
		if ($_POST['phonef'] !='' && $_POST['phonem'] !='' && $_POST['phonel'] !='') {
			$hphone=encode_pass(addslashes(fnFilterString($_POST['phonef'])).addslashes(fnFilterString($_POST['phonem'])).addslashes(fnFilterString($_POST['phonel'])),$pass_key);
		} else {
			$hphone="";
		}

		if ( $_POST['mail_f'] !='' && $_POST['mail_b'] !='') {
			$email=encode_pass(addslashes(fnFilterString($_POST['mail_f']))."@".addslashes(fnFilterString($_POST['mail_b'] )),$pass_key);
		} else {
			$email='';
		}

		foreach(array_filter($_POST['juminno']) as $k=>$v){
			foreach(array_filter($_POST['juminno']) as $m=>$n){
				if($_POST['juminno'][$k] === $n && $v != $n){
						$json_code = array('result'=>'false','msg'=>'동일한 주민등록 번호가 있습니다.');
					echo json_encode($json_code);					
					exit;
				} 
			}
		}
		
		foreach(array_filter($_POST['juminno']) as $k=>$v){

			$jumin_both = explode("-",$v);

			if (substr($jumin_both[1],0,1) == "1" ||
		        substr($jumin_both[1],0,1) == "2" ||
		        substr($jumin_both[1],0,1) == "3" ||
		        substr($jumin_both[1],0,1) == "4"){
		            $jumin_check=resnoCheck($jumin_both[0],$jumin_both[1]);
		    } else {
		        $jumin_check=foreignerCheck($jumin_both[0],$jumin_both[1]);
		        //$jumin_check=true;
		    }

			if ($jumin_check==false) {
				$json_code = array('result'=>'false','msg'=>'주민번호를 다시 확인해 주세요1.'.$v);
				echo json_encode($json_code);
				exit;
			}
		}

		$start_date_arr=explode("-",$startDate);
		$start_time=mktime($startHour,"00","00",$start_date_arr[1],$start_date_arr[2],$start_date_arr[0]);

		$end_date_arr=explode("-",$endDate);
		$end_time=mktime($endHour,"00","00",$end_date_arr[1],$end_date_arr[2],$end_date_arr[0]);

		// 해외 80세 이상 관광은 보험의 일정 (1개월)이 아닌 순수 30일을 가져와야 함. 2019-08-29
		$rl_term_day = real_period($startDate." ".$startHour.":00:00", $endDate." ".$endHour.":00:00");

		//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철
		//$term_day=ceil(($end_time-$start_time)/86400);
		$term_day = travel_period($startDate." ".$startHour.":00:00", $endDate." ".$endHour.":00:00"); 
		//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철
		//2019-07-03 해외 여행 80대(보험나이) 1개월 이상 보험가입 금지 - 박우철
		
		if($tripType == 2){
			foreach(array_filter($_POST['hage']) as $k=>$v){
				if( $v >= 80 && $rl_term_day > 30){
					$json_code = array('result'=>'false','msg'=>'여행자보험 가입시 80세이상 고객님은  최대 30일까지만 가입이 가능합니다. 31일 이상 가입은 고객센터로 연락주세요. (1800-9010)');
					echo json_encode($json_code);
					exit;
				}
			}
		}

		$sql_tmp="insert into hana_plan_test set
					member_no='{$mem_no}',
					insurance_comp = '{$selInsurance}',
					session_key='{$sess_code}',
					order_type='1',
					trip_type='{$tripType}',
					common_plan = '{$commonPlan}',
					nation_no='{$nationVal}',
					trip_purpose='{$tripPurpose}',
					start_date='{$startDate}',
					start_hour='{$startHour}',
					end_date='{$endDate}',
					end_hour='{$endHour}',
					term_day='{$term_day}',
					join_cnt='{$join_cnt}',
					current_resi = '{$currentResi}',
					join_name = '{$join_name}',
					plan_type='{$planType}',
					check_type_1='{$notiConfirm}',
					check_type_2='{$notiConfirm}',
					check_type_3='{$notiConfirm}',
					check_type_4='{$notiConfirm}',
					check_type_5='{$notiConfirm}',
					select_agree='{$contConfirm}',
					etc_memo1 = '{$memoEtc1}',
					etc_memo2 = '{$memoEtc2}',
					regdate='{$today_t}'
				";	
		//echo $sql_tmp;
		//echo "<br />";
		$result_plan = mysql_query($sql_tmp);
				// mysql_insert_id() php구문
				// mysql_query('last_insert_id()') mysql구문
		$mainCheck = 'N';
		$all_price = 0;
		$hana_plan_no = mysql_insert_id();
		foreach(array_filter($_POST['juminno']) as $k=>$v){
				
				if($k < 1){
					$mainCheck = 'Y';
					$hphone_put = $hphone;
					$email_put = $email;
				} else {
					$mainCheck = 'N';
					$hphone_put = '';
					$email_put = '';
				}

				$kor_name= $_POST['input_name'][$k];
				$eng_name = $_POST['input_eng_name'][$k];
				$ju_num = explode("-",$_POST['juminno'][$k]);
				$jumin_1 =encode_pass(addslashes(fnFilterString($ju_num[0])),$pass_key);
				$jumin_2 =encode_pass(addslashes(fnFilterString($ju_num[1])),$pass_key);

				$planCode = $_POST['plan_code'][$k];
				$planPrice = $_POST['particul_price'][$k];
				$agePut = $_POST['hage'][$k];
				$planTitle = $_POST['plan_title'][$k];

				$sex_type = substr($ju_num[1], 0, 1);
				
				if ($sex_type=="1" || $sex_type=="3" || $sex_type=="5" || $sex_type=="7") {
					$sex='1';
				} elseif ($sex_type=="2" || $sex_type=="4" || $sex_type=="6" || $sex_type=="8") {
					$sex='2';
				}	
				
				
				$sql_mem="insert into hana_plan_member_test set
					hana_plan_no='{$hana_plan_no}',
					member_no='{$mem_no}',
					main_check='{$mainCheck}',
					name='{$kor_name}',
					name_eng = '{$eng_name}',
					jumin_1='{$jumin_1}',
					jumin_2='{$jumin_2}',
					hphone='{$hphone_put}',
					email='{$email_put}',
					plan_code='{$planCode}',
					plan_price='{$planPrice}',
					sex='{$sex}',
					age='{$agePut}',
					plan_title='{$planTitle}'
				";	
					$all_price = $all_price + $planPrice;
				//echo "<br/>";
				//echo $sql_mem;

				$result_member = mysql_query($sql_mem);
		}
		//echo "<br />";


		if($selInsurance == 'S_1'){			
			$put_point = ($all_price * 3) / 100;
		}

		if($selInsurance == 'S_2'){			
			$sql_tour_mem=" select com_percent from toursafe_members where no='{$mem_no}' ";
			$result_mem=mysql_query($sql_tour_mem);
			$row_mem=mysql_fetch_array($result_mem);
		}	
			$com_percent=$row_mem['com_percent'];

		$sql_insert_change="insert into hana_plan_change_test set
								hana_plan_no='".$hana_plan_no."',
								change_type='1',
								change_price='{$all_price}',
								in_price='0',
								change_date='', ";
					if($selInsurance == 'S_1'){					
		$sql_insert_change.="com_point='{$put_point}', ";		
					} else if($selInsurance == 'S_2'){				
		$sql_insert_change.="com_percent='{$com_percent}', ";
					}
		$sql_insert_change.=" regdate='{$today_t}'
								";	
		//echo $sql_insert_change;
		//echo "<br />";
		$result_change =mysql_query($sql_insert_change);
		if($selInsurance == 'S_1'){			
			$sql_insert_point = " insert into hana_plan_point set 
								member_no = '{$mem_no}', 		
								hana_plan_no = '{$hana_plan_no}',
								point = '{$put_point}',
								reg_date = now()		
			";

		//echo $sql_insert_point;
			$result_point = mysql_query($sql_insert_point);
		}
		if(!$result_plan || !$result_member || ($selInsurance == 'S_2' && !$result_change) || ($selInsurance == 'S_1' && !$result_point )){
			$json_code = array('result'=>'false','msg'=>'정보 등록중 오류가 발생하였습니다. 다시 한번 시도 해주시기 바랍니다.');
			echo json_encode($json_code);
			exit;
		} else {
			$msg='등록 성공하였습니다.';
			$json_code = array('result'=>'true','msg'=>$msg);
			echo json_encode($json_code);
			exit;
		}
	}
?>