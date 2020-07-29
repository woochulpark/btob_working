<?
	include "../include/common.php";	

	$sess_code = $_SESSION['s_session_key'];
	$mem_no = $_SESSION['s_mem_no'];

	if(!isset($_SESSION['s_session_key']) && $sess_code == ''){
		$json_code = array('result'=>'false','msg'=>'세션정보가 삭제 되었습니다. 다시 시도해 주세요');
		echo json_encode($json_code);
		exit;
	}  else {

		if($_POST['write_pattern'] != 'edimode'){

			$session_chk_que = " SELECT no FROM hana_plan WHERE session_key = '{$_SESSION['s_session_key']}' ";

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
		} else {
			//수정페이지
		
			//var_dump($_POST);			
			$s_plan_code = '';

			if($_POST['plan_Code'] == "") {
				$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
				echo json_encode($json_code);
				exit;
			} else {
				$s_plan_code = $_POST['plan_Code'];
			}	

			$start_date = addslashes(fnFilterString($_POST['start_date']));
			$start_hour = addslashes(fnFilterString($_POST['start_hour']));

			$end_date = addslashes(fnFilterString($_POST['end_date']));
			$end_hour = addslashes(fnFilterString($_POST['end_hour']));
			$nation = addslashes(fnFilterString($_POST['nation']));


			$start_date_arr=explode("-",$start_date);
			$start_time=mktime($start_hour,"00","00",$start_date_arr[1],$start_date_arr[2],$start_date_arr[0]);

			$end_date_arr=explode("-",$end_date);
			$end_time=mktime($end_hour,"00","00",$end_date_arr[1],$end_date_arr[2],$end_date_arr[0]);

			$term_day=ceil(($end_time-$start_time)/86400);

			if ($_POST['trip_Type']=="1") {
				if ($term_day > 30) {
					$term_day=30;
				}
			} elseif ($_POST['trip_Type']=="2") {
				if ($term_day > 90) {
					$term_day = 90;
				}
			}

			$pre_price=0;
	
			$search_plan_que = " select a.*, b.mem_type, b.com_percent from hana_plan a join toursafe_members b on a.member_no=b.no where a.member_no = {$mem_no} and a.no = {$s_plan_code} ";
			//echo $search_plan_que;
			$result_plan = mysql_query($search_plan_que);			
			
			$search_plan_mem_que = " select * from hana_plan_member where member_no = {$mem_no} and hana_plan_no = {$s_plan_code} ";
			
			$result_mem = mysql_query($search_plan_mem_que);
			
			if(!isset($result_plan)){
				//plan과 회원사 정보 검사해서 없으면 튕겨짐.				
				exit;
			}
			$plan_list_state = '';
						//$aap= 0;
			while($row_plan = mysql_fetch_array($result_plan)){
					/*
					if($_POST['trip_Type'] != $row_plan['trip_type']){
						if($_POST['trip_Type'] == 1){
							$prt_trip = '국내';
						} else {
							$prt_trip = '해외';						
						}
						$wri_admin_log = "[여행타입 수정] - {$prt_trip}, ";
					}
					*/
					// 플랜 no 와 보험사 정보는 일단 수정 상황 아님. 차후 개발

					if($_POST['rr'] != $row_plan['current_resi']){
						if($_POST['rr'] == 2){
							$prt_rr = '해외';
						} else {
							$prt_rr = '국내';
						}
						$wri_admin_log .= "[현재체류지 수정] - {$prt_rr},";
						$insu_w_prt = '청약 정보 수정';
					}

					if($_POST['etc_memo1'] != $row_plan['etc_memo1']){
						$wri_admin_log .= "[추가정보1 수정] , ";
						$insu_w_prt = '청약 정보 수정';
					} 

					if($_POST['etc_memo2'] != $row_plan['etc_memo2']){
						$wri_admin_log .= "[추가정보2 수정] , ";
						$insu_w_prt = '청약 정보 수정';
					} 

					if($_POST['common_plan'] != $row_plan['common_plan']){
						$wri_admin_log .= "[공통Plan 수정] , ";
						$insu_w_prt = '청약 정보 수정';
					}

					if($_POST['trip_purpose'] != $row_plan['trip_purpose']){
						$tripPurpose = $_POST['trip_purpose'];
						$wri_admin_log .= "[여행목적 수정] - {$trip_purpose_array[$tripPurpose]} ,";
						$insu_w_prt = '청약 정보 수정';						
					}

					if($_POST['nation'] != $row_plan['nation_no']){
						$nation_ser_que = "SELECT nation_name FROM nation WHERE no = {$_POST['nation']} and use_type='Y'";
						$nation_ser_res = mysql_query($nation_ser_que);
						$nation_ser_row = mysql_fetch_array($nation_ser_res);
						$wri_admin_log .= "[여행지 수정] - {$nation_ser_row['nation_name']}, ";
						$insu_w_prt = '청약 정보 수정';
					}

					if($_POST['start_date'] != $row_plan['start_date'] || $_POST['start_hour'] != $row_plan['start_hour'] || $_POST['end_date'] != $row_plan['end_date'] || $_POST['end_hour'] != $row_plan['end_hour']){
						$wri_admin_log .= "[여행기간 수정]";
						$insu_w_prt = '청약 정보 수정';
					}

					$plan_list_state = $row_plan['plan_list_state'];
					$plan_join_code_date = $row_plan['plan_join_code_date'];
					$com_percent=$row['com_percent'];

					$sql_tmp="insert into hana_plan_history set
							hana_plan_no='".$row_plan['no']."',
							session_key='".$row_plan['session_key']."',
							order_type='".$row_plan['order_type']."',
							bill_state='".$row_plan['bill_state']."',
							plan_join_code='".$row_plan['plan_join_code']."',
							plan_join_code_date='".$row_plan['plan_join_code_date']."',
							trip_type='".$row_plan['trip_type']."',
							nation_no='".$row_plan['nation_no']."',
							trip_purpose='".$row_plan['trip_purpose']."',
							start_date='".$row_plan['start_date']."',
							start_hour='".$row_plan['start_hour']."',
							end_date='".$row_plan['end_date']."',
							end_hour='".$row_plan['end_hour']."',
							term_day='".$row_plan['term_day']."',
							join_cnt='".$row_plan['join_cnt']."',
							plan_type='".$row_plan['plan_type']."',
							check_type_1='".$row_plan['check_type_1']."',
							check_type_2='".$row_plan['check_type_2']."',
							check_type_3='".$row_plan['check_type_3']."',
							check_type_4='".$row_plan['check_type_4']."',
							check_type_5='".$row_plan['check_type_5']."',
							select_agree='".$row_plan['select_agree']."',
							order_no='".$row_plan['order_no']."',
							card_cd='".$row_plan['card_cd']."',
							card_name='".$row_plan['card_name']."',
							tno='".$row_plan['tno']."',
							app_no='".$row_plan['app_no']."',
							regdate='".time()."'
						";	
					
				mysql_query($sql_tmp);
				$hana_plan_history_no = mysql_insert_id();

				$sql_mem="select 
					*
				  from
					hana_plan_member
				  where
					hana_plan_no='{$s_plan_code}'
				 ";

				 $result_mem=mysql_query($sql_mem);

				 	while($row_mem=mysql_fetch_array($result_mem)) {

					if ($row_mem['plan_state']!='3') {
						$pre_price=$pre_price+$row_mem['plan_price'];

						$sql_mem="insert into hana_plan_member_history set
							hana_plan_history_no='".$hana_plan_history_no."',
							plan_state='".$row_mem['plan_state']."',
							main_check='".$row_mem['main_check']."',
							name='".$row_mem['name']."',
							name_eng = '{$row_mem['name_eng']}',
							jumin_1='".$row_mem['jumin_1']."',
							jumin_2='".$row_mem['jumin_2']."',
							hphone='".$row_mem['hphone']."',
							email='".$row_mem['email']."',
							plan_code='".$row_mem['plan_code']."',
							plan_price='".$row_mem['plan_price']."',
							sex='".$row_mem['sex']."',
							age='".$row_mem['age']."',
							gift_state='".$row_mem['gift_state']."',
							gift_key='".$row_mem['gift_key']."',
							sms_send='".$row_mem['sms_send']."'
						";	
						mysql_query($sql_mem);
					}
				}

				$cur_date=date("Y-m-d");
				$total_price="0";

				$sql_tmp="update hana_plan set
					common_plan = '".$_POST['common_plan']."',
					nation_no='".$_POST['nation']."',
					trip_purpose='".$_POST["trip_purpose"]."',
					start_date='".$_POST["start_date"]."',
					start_hour='".$_POST["start_hour"]."',
					end_date='".$_POST["end_date"]."',
					end_hour='".$_POST["end_hour"]."',
					term_day='".$term_day."',
					current_resi = '".$_POST['rr']."'
				where no='{$s_plan_code}'
				";	
				
				mysql_query($sql_tmp);

					
					
			} // while end
$join_cnt_r=0;		
			//echo "플랜 : ".$aap;
			$aa = 0;
			$sql_mem1="select 
					*
				  from
					hana_plan_member
				  where
					hana_plan_no='{$s_plan_code}'
				 ";
			
			$result_mem1=mysql_query($sql_mem1);
			while($row_plan_mem = mysql_fetch_array($result_mem1)){
					$f_jumin = decode_pass($row_plan_mem['jumin_1'],$pass_key);
					$b_jumin = decode_pass($row_plan_mem['jumin_2'],$pass_key);
					//echo trim($f_jumin)."-".trim($b_jumin);
					$jumin_arr[] = trim($f_jumin)."-".trim($b_jumin);
					$memk_arr[] = trim($row_plan_mem['name']);
					$meme_arr[] = trim($row_plan_mem['name_eng']);
					$mem_code_arr[] = trim($row_plan_mem['plan_code']);					
					$aa++;
			}
			//echo $aa;
		
			$p_juminno = $_POST['juminno'];
			$p_plancode = $_POST["plan_code"];
			$p_namek = $_POST["input_name"];
			$p_namee = $_POST["input_eng_name"];

			//echo "타입 : ".gettype($_POST['juminno'])."<br>";
			//echo "타입 : ".gettype($jumin_arr)."<br>";			
			
			$search_jumin = array_intersect_assoc($jumin_arr,$p_juminno);
			$search_code = array_intersect_assoc($mem_code_arr,$p_plancode);
			$search_namek = array_intersect_assoc($memk_arr,$p_namek);
			$search_namee = array_intersect_assoc($meme_arr,$p_namee);
		
			$wri_admin_log1 = '';
			if(count($_POST['juminno']) === count($search_jumin)){
				//echo " 수정된 것이 없음";
			} else {
				$wri_admin_log1 .= ' [주민번호 수정]';
				$wrk_prt = '피보험자 명세 수정';
			}		

			if(count($_POST['plan_code']) === count($search_code)){
				//echo " 수정된 것이 없음";
			} else {
				$wri_admin_log1 .= ' [플랜CODE 수정]';
				$wrk_prt = '피보험자 명세 수정';
			}		

			if(count($_POST["input_name"]) === count($search_namek)){
				//echo " 수정된 것이 없음";
			} else {
				$wri_admin_log1 .= ' [피보험자 이름 수정]';
				$wrk_prt = '피보험자 명세 수정';
			}		

			if(count($_POST["input_eng_name"]) === count($search_namee)){
				//echo " 수정된 것이 없음";
			} else {
				$wri_admin_log1 .= ' [피보험자 영문 이름 수정]';
				$wrk_prt = '피보험자 명세 수정';
			}		

			foreach($_POST['juminno'] as $k => $v){
				$prtJumin = explode("-",$_POST['juminno'][$k]); 	
				$jumin_1 =encode_pass(addslashes(fnFilterString($prtJumin[0])),$pass_key);
				$jumin_2 =encode_pass(addslashes(fnFilterString($prtJumin[1])),$pass_key);

				$sex_type=substr($prtJumin[1],0,1);
				
				if ($sex_type=="1" || $sex_type=="3" || $sex_type=="5" || $sex_type=="7") {
					$sex='1';
				} elseif ($sex_type=="2" || $sex_type=="4" || $sex_type=="6" || $sex_type=="8") {
					$sex='2';
				}

				if ($_POST['phonef']!='' && $_POST['phonem']!='' && $_POST['phonel']!='') {
					$hphone=encode_pass(addslashes(fnFilterString($_POST['phonef'])).addslashes(fnFilterString($_POST['phonem'])).addslashes(fnFilterString($_POST['phonel'])),$pass_key);
				} else {
					$hphone="";
				}

				if ($_POST['mail_f']!='' && $_POST['mail_b']!='') {
					$email=encode_pass(addslashes(fnFilterString($_POST['mail_f']))."@".addslashes(fnFilterString($_POST['mail_b'])),$pass_key);
				} else {
					$email="";
				}

				if($_POST['plan_state'][$k] != '3'){
					$total_price=$total_price+$_POST['particul_price'][$k];

					$sql_tmp="update hana_plan_member set
							name='".addslashes(fnFilterString($_POST['input_name'][$k]))."',
							name_eng = '".addslashes(fnFilterString($_POST['input_eng_name'][$k]))."',
							plan_state='".$_POST['plan_state'][$k]."',
							jumin_1='".$jumin_1."',
							jumin_2='".$jumin_2."', ";
					if($_POST['mainv'][$k] == "Y"){
					$sql_tmp .= "	hphone='".$hphone."',
							email='".$email."', ";
					}
					$sql_tmp .= "	plan_code='".$_POST['plan_code'][$k]."',
							plan_title='".$_POST['plan_title'][$k]."',
							plan_price='".$_POST['particul_price'][$k]."',
							sex='".$sex."',
							age='".$_POST['hage'][$k]."'
						where no='".$_POST['memnov'][$k]."'
					";	
					
				} else {
					$sql_tmp="update hana_plan_member set
						name='".addslashes(fnFilterString($_POST['input_name'][$k]))."',
						name_eng = '".addslashes(fnFilterString($_POST['input_eng_name'][$k]))."',
						plan_state='".$_POST['plan_state'][$k]."',
						jumin_1='".$jumin_1."',
						jumin_2='".$jumin_2."', ";
					if($_POST['mainv'][$k] == "Y"){
					$sql_tmp .= "	hphone='".$hphone."',
						email='".$email."', ";
					}
					$sql_tmp .= "	plan_code='".$_POST['plan_code'][$k]."',
						plan_title='".$_POST['plan_title'][$k]."',
						plan_price='0',
						sex='".$sex."',
						age='".$_POST['hage'][$k]."'
					where no='".$_POST['memnov'][$k]."'
				";	
				}
				
				mysql_query($sql_tmp);

				$join_cnt_r++;
			}

			if ($pre_price!=$total_price) {
			$after_price=$total_price-$pre_price;

			if ($plan_join_code_date=="") {
				$change_date="";
			} else {
				$change_date=time();
			}

			if ($plan_list_state=='4') {
				$plan_list_state = '5';
			}
			
			$sql_insert_change="insert into hana_plan_change set
									hana_plan_no='{$s_plan_code}',
									change_type='{$plan_list_state}',
									change_price='{$after_price}',
									change_date='{$change_date}', ";
			if($_POST["selinsuran"] == 'S_2'){
				$sql_insert_change .= " com_percent='{$com_percent}', ";
			} else {
				$put_point = ($after_price * 3) / 100;
				$sql_insert_change .= " com_point= '{$put_point}', ";
			}
				$sql_insert_change .= "	regdate='".time()."'
									";
			mysql_query($sql_insert_change);
		}

			$dbup = "update hana_plan set
						change_date='".time()."',
						join_cnt='{$join_cnt_r}'
					where no='{$s_plan_code}'
			";	
			$result=mysql_query($dbup) or die(mysql_error());
			
			$admin_log="insert into admin_log set
			admin_id='".$_SESSION['s_mem_id']."',
			modify_no='{$s_plan_code}',
			log_content='DB NO : {$s_plan_code} - {$insu_w_prt}\n{$wri_admin_log} \n\r {$wrk_prt}\n{$wri_admin_log1}',
			login_ip='{$_SERVER['REMOTE_ADDR']}',
			regdate='".time()."'
		";
		//echo $admin_log;
		mysql_query($admin_log);
		$json_code = array('result'=>'true','msg'=>'수정되었습니다.');
		echo json_encode($json_code);
		exit;
		} //수정 종료
	}
?>

 