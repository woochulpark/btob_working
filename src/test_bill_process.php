<?
	include "../include/common.php";	

	$full_info = Array ('trip_Type' => '2', 'selinsuran' => 'S_1', 'start_date' => '2020-05-18',	'start_hour' => '00', 'end_date' => '2020-05-31', 'end_hour' => '01', 'nation' => '593' ,'select_nation' => 'Y', 'trip_purpose' => '1', 'rr' => '해외','phonef'=>'010', 'phonem'=>'2222', 'phonel'=>'3333', 'mail_f' => 'test', 'mail_b' => 'test.com', 'mail_b_sel' => 'etc', 'notice_confirm' => 'Y', 'contract_confirm' => 'Y', 'common_plan' => 'TSB01', 'plan_chk' => 'TSB01//-//TSB07', 'input_name' => Array ( 0 => '진동완', 1 => '임현숙', 2 => '윤설희', 3 => '진수아', 4 => '진수현', 5 => '진선미', 6 => '장윤애', 7 => '김현정', 8 => '김혜정', 9 => '최선정'), 'input_eng_name' => Array ( 0 => '',1 => '',2 => '',3 => '',4 => '',5 => '',6 => '',7 => '',8 => '',9 => ''), 'juminno' => Array ( 0 => '720528-1119828', 1 => '511101-2119811', 2 => '740215-2029911', 3 => '050803-4171217', 4 => '080331-4250627', 5 => '740621-2119810', 6 => '850718-2067218', 7 => '850720-2052817', 8 => '640904-2063612', 9 => '900420-2908512' ), 'hage' => Array ( 0 => '47', 1 => '68', 2 => '46', 3 => '14', 4 => '12', 5 => '45', 6 => '34', 7 => '34', 8 => '55', 9 => '30' ), 'plan_code' => Array ( 0 => 'TSB01', 1 => 'TSB01', 2 => 'TSB01', 3 => 'TSB07', 4 => 'TSB07', 5 => 'TSB01', 6 => 'TSB01', 7 => 'TSB01', 8 => 'TSB01', 9 => 'TSB01', ),'plan_type'=> Array('1','1','1','1','1','1','1','1','1','1'),'plan_title'=> Array('B02','B02','B02','B07','B08','B02','B02','B02','B02','B02'), 'particul_price' => Array ( 0 => '20730', 1 => '55520', 2 => '21130', 3 => '1710', 4 => '1660', 5 => '20420', 6 => '13840', 7 => '13840', 8 => '29290', 9 => '13360' ) );
	$sess_code = $_SESSION['s_session_key'];
	$mem_no = $_SESSION['s_mem_no'];

	if(!isset($_SESSION['s_session_key']) && $sess_code == ''){
		$json_code = array('result'=>'false','msg'=>'세션정보가 삭제 되었습니다. 다시 시도해 주세요');
		echo json_encode($json_code);
		exit;
	}  else {
		$selInsurance = $full_info['selinsuran'];
		$tripType = $full_info['trip_Type'];
		$nationVal = $full_info['nation'];
		$tripPurpose = $full_info['trip_purpose'];
		$startDate = $full_info['start_date'];
		$startHour = $full_info['start_hour'];
		$endDate = $full_info['end_date'];
		$endHour = $full_info['end_hour'];			
		$planType = $full_info['plan_type'];
		$join_cnt = count($full_info['juminno']);
		$notiConfirm = $full_info['notice_confirm'];
		$contConfirm = $full_info['contract_confirm'];
		$commonPlan = $full_info['common_plan'];
		$join_name = $full_info['input_name'][0];
		$today_t = time();
		if ($full_info['phonef'] !='' && $full_info['phonem'] !='' && $full_info['phonel'] !='') {
			$hphone=encode_pass(addslashes(fnFilterString($full_info['phonef'])).addslashes(fnFilterString($full_info['phonem'])).addslashes(fnFilterString($full_info['phonel'])),$pass_key);
		} else {
			$hphone="";
		}

		if ( $full_info['mail_f'] !='' && $full_info['mail_b'] !='') {
			$email=encode_pass(addslashes(fnFilterString($full_info['mail_f']))."@".addslashes(fnFilterString($full_info['mail_b'] )),$pass_key);
		} else {
			$email='';
		}

		foreach($full_info['juminno'] as $k=>$v){
			foreach($full_info['juminno'] as $m=>$n){
				if($full_info['juminno'][$k] === $n && $v != $n){
						$json_code = array('result'=>'false','msg'=>'동일한 주민등록 번호가 있습니다.');
					echo json_encode($json_code);					
					exit;
				} 
			}
		}
		
		foreach($full_info['juminno'] as $k=>$v){

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
				$json_code = array('result'=>'false','msg'=>'주민번호를 다시 확인해 주세요.');
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
			foreach($full_info['hage'] as $k=>$v){
				if( $v >= 80 && $rl_term_day > 30){
					$json_code = array('result'=>'false','msg'=>'여행자보험 가입시 80세이상 고객님은  최대 30일까지만 가입이 가능합니다. 31일 이상 가입은 고객센터로 연락주세요. (1800-9010)');
					echo json_encode($json_code);
					exit;
				}
			}
		}

		$sql_tmp="insert into hana_plan set
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
					join_name = '{$join_name}',
					plan_type='{$planType}',
					check_type_1='{$notiConfirm}',
					check_type_2='{$notiConfirm}',
					check_type_3='{$notiConfirm}',
					check_type_4='{$notiConfirm}',
					check_type_5='{$notiConfirm}',
					select_agree='{$contConfirm}',
					regdate='{$today_t}'
				";	
		echo $sql_tmp;
		echo "<br />";
				// mysql_insert_id() php구문
				// mysql_query('last_insert_id()') mysql구문
		$mainCheck = 'N';
		$all_price = 0;
		foreach($full_info['juminno'] as $k=>$v){
				
				if($k < 1){
					$mainCheck = 'Y';
					$hphone_put = $hphone;
					$email_put = $email;
				} else {
					$mainCheck = 'N';
					$hphone_put = '';
					$email_put = '';
				}

				$kor_name= $full_info['input_name'][$k];
				$eng_name = $full_info['input_eng_name'][$k];
				$ju_num = explode("-",$full_info['juminno'][$k]);
				$jumin_1 =encode_pass(addslashes(fnFilterString($ju_num[0])),$pass_key);
				$jumin_2 =encode_pass(addslashes(fnFilterString($ju_num[1])),$pass_key);

				$planCode = $full_info['plan_code'][$k];
				$planPrice = $full_info['particul_price'][$k];
				$agePut = $full_info['hage'][$k];
				$planTitle = $full_info['plan_title'][$k];

				$sex_type = substr($ju_num[1], 0, 1);
				
				if ($sex_type=="1" || $sex_type=="3" || $sex_type=="5" || $sex_type=="7") {
					$sex='1';
				} elseif ($sex_type=="2" || $sex_type=="4" || $sex_type=="6" || $sex_type=="8") {
					$sex='2';
				}	
				
				$hana_plan_no = 'test';
				$sql_mem="insert into hana_plan_member set
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
				echo "<br/>";
				echo $sql_mem;
		}
		echo "<br />";


		if($selInsurance == 'S_1'){			
			$put_point = ($all_price * 3) / 100;
		}

		if($selInsurance == 'S_2'){			
			$sql_mem=" select com_percent from toursafe_members where no='{$mem_no}' ";
			$result_mem=mysql_query($sql_mem);
			$row_mem=mysql_fetch_array($result_mem);
		}	
			$com_percent=$row_mem['com_percent'];

		$sql_insert_change="insert into hana_plan_change set
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
		echo $sql_insert_change;
		echo "<br />";
		if($selInsurance == 'S_1'){			
			$sql_insert_point = " insert into hana_plan_point set 
								member_no = '{$mem_no}', 		
								hana_plan_no = '{$hana_plan_no}',
								point = '{$put_point}',
								reg_date = now()		
			";

		echo $sql_insert_point;
		}
	}
?>