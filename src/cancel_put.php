<?
	include "../include/common.php";	

	foreach($_POST['memNO'] as $k=>$v){
		if($v != ''){
			$cancel_info['trDepth_'.$k] = $v;
		}
	}
	

	if(isset($_POST['planNO'])){
		$num = $_POST['planNO'];
	} else {
		$json_code = array('result'=>'false','msg'=>'잘못된 접속 입니다.');
		echo json_encode($json_code);
		exit;
	}

$keysetv = implode(",",$cancel_info);


	$pre_price=0;
	$after_price=0;

	$sql="select 
		a.*, b.mem_type, b.com_percent
	  from
		hana_plan a, toursafe_members b
	  where
		a.member_no=b.no and a.no='".$num."'
	 ";
	
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	$mem_type=$row['mem_type'];
	if($row['insurance_comp'] == 'S_2'){
		$com_percent=$row['com_percent'];
	} 
	$plan_join_code_date=$row['plan_join_code_date'];

	$sql_tmp="insert into hana_plan_history set
				hana_plan_no='".$row['no']."',
				session_key='".$row['session_key']."',
				order_type='".$row['order_type']."',
				bill_state='".$row['bill_state']."',
				plan_join_code='".$row['plan_join_code']."',
				plan_join_code_date='".$row['plan_join_code_date']."',
				trip_type='".$row['trip_type']."',
				nation_no='".$row['nation_no']."',
				trip_purpose='".$row['trip_purpose']."',
				start_date='".$row['start_date']."',
				start_hour='".$row['start_hour']."',
				end_date='".$row['end_date']."',
				end_hour='".$row['end_hour']."',
				term_day='".$row['term_day']."',
				join_cnt='".$row['join_cnt']."',
				plan_type='".$row['plan_type']."',
				check_type_1='".$row['check_type_1']."',
				check_type_2='".$row['check_type_2']."',
				check_type_3='".$row['check_type_3']."',
				check_type_4='".$row['check_type_4']."',
				check_type_5='".$row['check_type_5']."',
				select_agree='".$row['select_agree']."',
				order_no='".$row['order_no']."',
				card_cd='".$row['card_cd']."',
				card_name='".$row['card_name']."',
				tno='".$row['tno']."',
				app_no='".$row['app_no']."',
				regdate='".time()."'
			";	
			
		mysql_query($sql_tmp);
		$hana_plan_history_no = mysql_insert_id();

	$sql_mem="select 
		*
	  from
		hana_plan_member
	  where
		hana_plan_no='".$num."'
		and no in ({$keysetv})
	 ";
	 $cancel_people = array();
	$result_mem=mysql_query($sql_mem);
	while($row_mem=mysql_fetch_array($result_mem)) {
		if ($row_mem['plan_state']!='3') {
			$pre_price=$pre_price+$row_mem['plan_price'];

			$sql_mem="insert into hana_plan_member_history set
				hana_plan_history_no='".$hana_plan_history_no."',
				plan_state='".$row_mem['plan_state']."',
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
				gift_state='".$row_mem['gift_state']."',
				gift_key='".$row_mem['gift_key']."',
				sms_send='".$row_mem['sms_send']."'
			";	

			 $cancel_people[] = $row_mem['name'];
			mysql_query($sql_mem);
			//echo "<br>";
			//echo $sql_mem;
		}
	}
	
	if ($pre_price!='0') {

		if ($plan_join_code_date=="") {
			$change_date="";
		} else {
			$change_date=time();
		}

		$sql_insert_change="insert into hana_plan_change set
								hana_plan_no='".$num."',
								change_type='3',
								change_price='-".$pre_price."',
								change_date='".$change_date."',";
	if($row['insurance_comp'] == 'S_2'){
		$sql_insert_change.=" com_percent='".$com_percent."',";
	} else if($row['insurance_comp'] == 'S_1'){
		$put_point = ($pre_price * 3) / 100;
		$sql_insert_change.=" com_point ='".$put_point."', "; 
	}
$sql_insert_change.="regdate='".time()."' ";
		mysql_query($sql_insert_change);
	}


	$dbup = "update hana_plan_member set
				plan_state='3',
				plan_price='0'
			where hana_plan_no='".$num."' and no in ({$keysetv})
	";	
	$result=mysql_query($dbup) or die(mysql_error());
	//$msg="수정되었습니다.";


	$dbup = "update hana_plan set
				change_date='".time()."'
			where no='".$num."'
	";	
	$result=mysql_query($dbup) or die(mysql_error());


	$admin_log="insert into admin_log set
				admin_id='".$_SESSION['s_admin_id']."',
				modify_no='".$num."',
				log_content='DB NO : ".$num." - 보험가입 선택 취소(".implode(",",$cancel_people).")',
				login_ip='".$_SERVER[REMOTE_ADDR]."',
				regdate='".time()."'
			";
	$admin_log_result = mysql_query($admin_log);

	
		$msg = array('planNo' => $num, 'planMemno'=>$cancel_info);
	
		
	if($admin_log_result){	
		$json_code = array('result'=>'true','msg'=>$msg);
	} else{
		$json_code = array('result'=>'false','msg'=>$msg);
	}
	echo json_encode($json_code);
	exit;
?>