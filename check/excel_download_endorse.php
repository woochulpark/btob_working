<?
	include "../include/common.php";
	//include ("../include/login_check.php");
	include_once "../../PHPExcel.php";

	$objPHPExcel = new PHPExcel();

	if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

		$prt_subject = '혜초 여행사 배서내역';

} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
		$prt_subject = 'followme 배서내역';
} else {
		$prt_subject = '배서내역';
}

 // Set document properties
$objPHPExcel->getProperties()->setCreator('https://b2b.toursafe.co.kr/')
                             ->setLastModifiedBy('https://b2b.toursafe.co.kr')
                             ->setTitle($prt_subject)
                             ->setSubject($prt_subject)
                             ->setDescription($prt_subject);


// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', '배서내역 리스트');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20)->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO')
							  ->setCellValue('B2', '요청일자')
							  ->setCellValue('C2', '보험사')
							  ->setCellValue('D2', '진행여부')
                              ->setCellValue('E2', '청약번호')
							  ->setCellValue('F2', '메모')
							  ->setCellValue('G2', '대표계약자명')
							  ->setCellValue('H2', '대표피보험자 주민등록번호');

	$cellCount = 3;	




	// 혜초 b2b 전용 (mg 상품)
	//$add_query .=" and a.member_no ='".$row_mem_info['no']."'";	
/*
if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

$add_query =" and a.member_no ='28' ";	
} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
	$add_query =" and a.member_no ='54' ";	
}
*/
	$add_query =" and a.member_no ='{$_SESSION['s_mem_no']}'";	
	
	if($s_start_date != '' && $s_end_date != ''){
		
		 if($searchDate == 'reqDate') {
		
			if ($s_start_date != '') {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);
				$prt_s_date = strtotime($s_start_date.' '.$start_hour.':00:00');
				$add_query = $add_query." and a.regdate >='{$prt_s_date}'";
			}

			if ($s_end_date!='') {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);
				$prt_e_date = strtotime($s_end_date.' '.$end_hour.':00:00');
				$add_query = $add_query." and a.regdate <='{$prt_e_date}'";
			}
		} else if($searchDate == 'confDate'){
			if ($s_start_date!='') {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);

				$prt_s_date = strtotime($s_start_date.' '.$start_hour.':00:00');
				$add_query = $add_query." and a.confirm_regdate >='{$prt_s_date}'";
			}

			if ($s_end_date!='') {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);

				$prt_e_date = strtotime($s_end_date.' '.$end_hour.':00:00');
				$add_query = $add_query." and a.confirm_regdate <='{$prt_e_date}'";
			}
		} 
	}

	if($search) {
		if($search_info == 'subscNo') {
			$add_query .=" and b.no like '%$search%'";
		} elseif ($search_info=="stockNo") {
			$add_query .=" and a.plan_join_code like '%$search%'";
		} elseif($search_info == 'citizenno'){
			$sJumin1 = encode_pass($search,$pass_key);
			$add_query .=" and a.jumin_1 =  '{$sJumin1}'";
		} elseif($search_info == 'contractName'){
			$add_query .=" and b.join_name like '%$search%'";
		} 
	}

if($insu_ch_b){
	if($insu_ch == 'chState'){
		$add_query .=" and a.change_state = '{$insu_ch_b}' ";
	} else if($insu_ch == 'chInsurance'){
		$add_query .=" and b.insurance_comp = '{$insu_ch_b}' ";		
	}
}		


$sql  = "select 
		a.no as num, a.regdate as req_regdate, a.content, a.jumin_1 as jumin_front, a.jumin_2 as jumin_back, a.change_state, b.no as plan_hana_no, b.insurance_comp, b.plan_join_code, b.join_name, b.join_cnt, c.jumin_1, c.jumin_2, c.no as mem_no, c.hphone, c.email
	  from
		hana_plan_request a
		left join hana_plan b on a.plan_no=b.no
		left join hana_plan_member c on b.no=c.hana_plan_no
	  where
		1=1  
		{$add_query}
	  group by b.no
	  order by a.no desc
";


$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
//$sql=$sql." limit $num_per_page_start, $num_per_page";
$row_count = $total_record;
//echo $sql;
$result=mysql_query($sql) or die(mysql_error());

	$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";


		$d_name=stripslashes($row['join_name']);
		if($row['jumin_front'] != '' || $row['jumin_back'] != ''){
			$jumin1 = decode_pass($row['jumin_front'],$pass_key);
			$jumin2 = decode_pass($row['jumin_back'],$pass_key);
		} else {
			$jumin1 = decode_pass($row['jumin_1'],$pass_key);
			$jumin2 = decode_pass($row['jumin_2'],$pass_key);
		}
		$jumin_prt = $jumin1."-".$jumin2;
		/*
		$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['plan_hana_no']."'";
		$result_mem=mysql_query($sql_mem);
		while($row_mem=mysql_fetch_array($result_mem)) {

			if ($row_mem['plan_state']!='3') {
				$total_price=$total_price+$row_mem['plan_price'];
			}

			if ($row_mem['main_check']=='Y') {
				
					$d_name=$row_mem['name'];
				

				$jumin_1=decode_pass($row_mem['jumin_1'],$pass_key);

				if ($row_mem['jumin_2']!='') {
					$jumin_2=decode_pass($row_mem['jumin_2'],$pass_key);

					$jumin_no=$jumin_1."-".$jumin_2;
				} else {
					$jumin_no=$jumin_1;
				}

				$plan_code=$row_mem['plan_code'];
				
				if ($row_mem['hphone']!='') {
					$hphone=decode_pass($row_mem['hphone'],$pass_key);
				} else {
					$hphone="";
				}

				if ($row_mem['email']!='') {
					$email=decode_pass($row_mem['email'],$pass_key);
				} else {
					$email="";
				}
			}

			$total_cnt++;
		}
		*/	

		if ($row['join_cnt']=="1") {
			$join_text=$d_name;
		} else {
			$join_text=$d_name." 외 ".($row['join_cnt']-1)."명";
		} 

		
	if($_SESSION['s_mem_id'] == 'hyecho_b2b' || $_SESSION['s_mem_id'] == 'followme_b2b'){
		if(time() > mktime(0,0,0,6,10,2020)){
						if($row['insurance_comp'] == 'S_1'){
							//DB손해보험
							$plan_code_row=sql_one_one('plan_code_btob_db',"plan_title"," and plan_code='".$plan_code."'");
						}

						if($row['insurance_comp'] == 'S_2'){
							//
							$plan_code_row=sql_one_one('plan_code_btob_ace',"plan_title"," and plan_code='".$plan_code."'");
						}
				} else { 
		    $plan_code_row=sql_one_one('plan_code_mg',"plan_title"," and plan_code='".$plan_code."'");
				}
	
	} else {
			if($_SESSION['s_mem_type'] == 'B2B'){
				if(time() > mktime(0,0,0,6,10,2020)){
						if($row['insurance_comp'] == 'S_1'){
							//DB손해보험
							$plan_code_row=sql_one_one('plan_code_btob_db',"plan_title"," and plan_code='".$plan_code."'");
						}

						if($row['insurance_comp'] == 'S_2'){
							//
							$plan_code_row=sql_one_one('plan_code_btob_ace',"plan_title"," and plan_code='".$plan_code."'");
						}
				} else {
						 $plan_code_row=sql_one_one('plan_code_btob',"plan_title"," and plan_code='".$plan_code."'");
				}
			} else {
				$plan_code_row=sql_one_one('plan_code_hana',"plan_title"," and plan_code='".$plan_code."'");
			}
	}	
		
		

		if ($row['nation_no']=="0") {
			$nation_text="국내";
		} else {
			$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
			$nation_text=stripslashes($nation_row['nation_name']);
		}
	
		if($row['change_date'] != ''){
			$change_date = date("Y-m-d",$row['change_date']);
		} else {
			$change_date = '';
		}

		if($row['req_regdate'] != ''){
			$reg_date  = date("Y-m-d",$row['req_regdate']);
		} else {
			$reg_date = '';
		}

		
		if($row['insurance_comp'] != ''){
				switch($row['insurance_comp']){
					case 'S_1':
						$prt_insuran = 'DB손해보험';
					break;
					case 'S_2':
						$prt_insuran = 'CHUBB';
					break;
				}
		}  else {
			$prt_insuran = '';
		}							

		 // Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit("A$cellCount", $total_record, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("B$cellCount", $reg_date, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("C$cellCount", $prt_insuran, PHPExcel_Cell_DataType::TYPE_STRING)			
					->setCellValueExplicit("D$cellCount", $change_state_array[$row['change_state']], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit("E$cellCount", $row['plan_join_code'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("F$cellCount", html_entity_decode($row['content']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("G$cellCount", html_entity_decode($join_text), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("H$cellCount", $jumin_prt, PHPExcel_Cell_DataType::TYPE_STRING);

		$objPHPExcel->getActiveSheet()->getStyle("F$cellCount")->getAlignment()->setWrapText(true);
		//$objPHPExcel->getActiveSheet()->getStyle("Q$cellCount")->getAlignment()->setWrapText(true);
		$cellCount++;

		$total_record--;
	}
	
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray(
		array('fill'    => array(
									'type'      => PHPExcel_Style_Fill::FILL_SOLID,
									'color'     => array('rgb' => 'F28A8C')
								),
			  'borders' => array(
									'allborders'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
	 
	/** 각각의 셀 크기를 지정함 **/
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	

	 
	/** 영영을 지정하여 가로 세로의 정렬을 정의함 **/
	$objPHPExcel->getActiveSheet()->getStyle('A1:H' . ($row_count + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:H' . ($row_count + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
		if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

		$prt_fname = '혜초배서내역목록';

} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
		$prt_fname = 'followme 배서내역목록';
} else {
		$prt_fname = '배서내역목록';
}
	  
	/** 위에서 쓴 엑셀을 저장하고 다운로드 합니다. **/
	$output_file_name = $date=$prt_fname.date("Ymd"). ".xls";
	header('Content-Type: application/vnd.ms-excel;charset=utf-8');
	header('Content-type: application/x-msexcel;charset=utf-8');
	header('Content-Disposition: attachment;filename="'.$output_file_name.'"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
?>