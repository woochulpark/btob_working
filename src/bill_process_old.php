<?

include "../include/common.php";
include "../include/login_check_ajax.php";	
	
	$sql_check="select * from hana_plan_tmp where member_no='".$row_mem_info['no']."' and session_key='".$_SESSION['s_session_key']."' and order_type='1'";
	$result_check=mysql_query($sql_check);
	$row_check=mysql_fetch_array($result_check);

	if ($row_check['no']=='') {
		$json_code = array('result'=>'false','msg'=>'세션정보가 삭제 되었습니다. 다시 시도해 주세요');
		echo json_encode($json_code);
		exit;
	} else {
		$sql_tmp="insert into hana_plan set
					member_no='".$row_mem_info['no']."',
					session_key='".$_SESSION['s_session_key']."',
					order_type='1',
					trip_type='".$row_check['trip_type']."',
					nation_no='".$row_check['nation_no']."',
					trip_purpose='".$row_check['trip_purpose']."',
					start_date='".$row_check['start_date']."',
					start_hour='".$row_check['start_hour']."',
					end_date='".$row_check['end_date']."',
					end_hour='".$row_check['end_hour']."',
					term_day='".$row_check['term_day']."',
					join_cnt='".$row_check['join_cnt']."',
					plan_type='".$row_check['plan_type']."',
					check_type_1='".$row_check['check_type_1']."',
					check_type_2='".$row_check['check_type_2']."',
					check_type_3='".$row_check['check_type_3']."',
					check_type_4='".$row_check['check_type_4']."',
					check_type_5='".$row_check['check_type_5']."',
					select_agree='".$row_check['select_agree']."',
					regdate='".time()."'

				";	
		mysql_query($sql_tmp);
		$hana_plan_no = mysql_insert_id();

		$all_price=0;
		
		$sql_mem="select* from hana_plan_member_tmp where tmp_no='".$row_check['no']."' order by no asc";
		$result_mem=mysql_query($sql_mem);
		while($row_mem=mysql_fetch_array($result_mem)) {

			$sql_mem="insert into hana_plan_member set
				hana_plan_no='".$hana_plan_no."',
				member_no='".$row_mem_info['no']."',
				main_check='".$row_mem['main_check']."',
				name='".$row_mem['name']."',
				jumin_1='".$row_mem['jumin_1']."',
				jumin_2='".$row_mem['jumin_2']."',
				hphone='".$row_mem['hphone']."',
				email='".$row_mem['email']."',
				plan_code='".$row_mem['plan_code']."',
				plan_price='".$row_mem['plan_price']."',
				sex='".$row_mem['sex']."',
				age='".$row_mem['age']."',
                plan_title='".$row_mem['plan_title']."'
			";	
			mysql_query($sql_mem);

			$all_price=$all_price+$row_mem['plan_price'];

			if ($row_mem['main_check']=="Y") {
				$mem_update="update hana_plan set 
								join_name='".$row_mem['name']."'
							where no='".$hana_plan_no."'
							";
				mysql_query($mem_update);
/*
				$kakao_phone="82".substr(decode_pass($row_mem['hphone'],$pass_key), 1,10);

				$msg=$row_mem['name']." 고객님! 투어세이프 입니다.
여행자보험 가입 감사합니다.";
				sendTalk_button($kakao_phone, "bis_hana_join", $msg);
*/
			}

		}

		$sql_mem="select com_percent from toursafe_members where no='".$row_mem_info['no']."'";
		$result_mem=mysql_query($sql_mem);
		$row_mem=mysql_fetch_array($result_mem);

			$com_percent=$row_mem['com_percent'];

		$sql_insert_change="insert into hana_plan_change set
								hana_plan_no='".$hana_plan_no."',
								change_type='1',
								change_price='".$all_price."',
								in_price='0',
								change_date='',
								com_percent='".$com_percent."',
								regdate='".time()."'
								";
		mysql_query($sql_insert_change);

		$sql_delete="delete from hana_plan_tmp where session_key='".$_SESSION['s_session_key']."'";
		mysql_query($sql_delete);

		$sql_delete="delete from hana_plan_member_tmp where tmp_no='".$row_check['no']."'";
		mysql_query($sql_delete);

		$session_val=time()."_".$row_check['trip_type']."_".$row_mem_info['no'];
		$session_key =encode_pass($session_val,$pass_key);
		$_SESSION['s_session_key']=$session_key;
		

		$json_code = array('result'=>'true','msg'=>$hana_plan_no);
		echo json_encode($json_code);
		exit;

	}
?>