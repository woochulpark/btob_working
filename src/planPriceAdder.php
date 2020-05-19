<?
		include ("../include/common.php"); 
//		print_r(json_decode($_POST['chCode']));
		if(!isset($_POST['chCode'])){
			
			exit;
		} else {
			$schCode = json_decode($_POST['chCode']);

			foreach($schCode as $k=>$v){
				$sliceData = explode(",",$v);
					$ch_plan_code	= $sliceData[0];
					$ch_trip_type		= $sliceData[1];
					$ch_insuran		= $sliceData[2];
					$chStartdate		= $sliceData[3];
					$chStarthour		= $sliceData[4];
					$chEnddate		= $sliceData[5];
					$chEndhour		= $sliceData[6];
					$ch_sex				= $sliceData[7];
					$ch_age				= $sliceData[8];
					$secre_no			= $sliceData[9];

					switch($ch_insuran){
						case 'S_1':
							$plan_table = ' plan_code_btob_db ';
							$price_table = ' plan_code_price_btob_db ';
						break;
						case 'S_2':
							$plan_table = ' plan_code_btob_ace ';
							$price_table = ' plan_code_price_btob_ace ';
						break;
					}

					$term_day = travel_period($chStartdate." ".$chStarthour.":00:00", $chEnddate." ".$chEndhour.":00:00");


				$que = " SELECT * FROM {$price_table} where trip_type = {$ch_trip_type} and plan_code = '{$ch_plan_code}' and term_day = {$term_day} and sex={$ch_sex} and age = {$ch_age}";
				$result = mysql_query($que);
				if($result){
					while($row = mysql_fetch_array($result)){
						$where_plan = $row['plan_code'];
						$title_que = " SELECT plan_title FROM {$plan_table} where trip_type = {$ch_trip_type} and plan_code = '{$where_plan}' ";
						$title_result = mysql_query($title_que);
						$title_row = mysql_fetch_array($title_result);

						$json_put_price[$k] = ['price'=>$row['price'] , 'planCode'=>$row['plan_code'],'planType'=>$row['plan_type'],'planTitle'=>$title_row['plan_title']];
					}
				}
			}
			
			if(count($json_put_price) > 0){
				$result_js = ['result'=>'true', 'msg'=>$json_put_price];
			} else {
				$result_js = ['result'=>'false','msg'=>'적용된 plan이 없습니다.'];
			}

			echo json_encode($result_js);
		}


		//chCode => plan_code, trip_type(해외, 국내), selInsuran, start_date, start_hour, end_data, end_hour, sex, age, ju_no


?>