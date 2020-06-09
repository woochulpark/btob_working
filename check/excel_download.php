<?
	include "../include/common.php";
	//include ("../include/login_check.php");
	include_once "../../PHPExcel.php";
	$objPHPExcel = new PHPExcel();

	if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

		$prt_subject = '혜초 여행사 신청내역';

} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
		$prt_subject = 'followme 신청내역';
} else {
		$prt_subject = '신청내역';
}

 // Set document properties
$objPHPExcel->getProperties()->setCreator('https://b2b.toursafe.co.kr/')
                             ->setLastModifiedBy('https://b2b.toursafe.co.kr')
                             ->setTitle($prt_subject)
                             ->setSubject($prt_subject)
                             ->setDescription($prt_subject);


// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', '신청내역 리스트');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20)->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO')
							  ->setCellValue('B2', '신청일')
							  ->setCellValue('C2', '진행상태')
                              ->setCellValue('D2', '수정처리일')
							  ->setCellValue('E2', '청약완료일')
							  ->setCellValue('F2', '대표피보험자(신청자)')
							  ->setCellValue('G2', '피보험자 주민등록번호')
							  ->setCellValue('H2', '여행지')
							  ->setCellValue('I2', '보험시작일')
							  ->setCellValue('J2', '보험종료일')
							  ->setCellValue('K2', '플랜명')
							  ->setCellValue('L2', '플랜코드')
							  ->setCellValue('M2', '보험료')
							  ->setCellValue('N2', '증권번호')
							  ->setCellValue('O2', '핸드폰')
							  ->setCellValue('P2', '추가정보');

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
		
		if ($searchDate == 'endorse') {
			if ($s_start_date != '') {
				$s_date_r=strtotime($s_start_date." 000000");
				$add_query = $add_query." and d.change_date >='".$s_date_r."'";
			}

			if ($s_end_date!='') {
				$e_date_r=strtotime($s_end_date." 235959");
				$add_query = $add_query." and a.change_date <='".$e_date_r."'";
			}
		} else if($searchDate == 'traStart') {
		
			if ($s_start_date != '') {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);
				$prt_s_date = $s_start_date.' '.$start_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.start_date,' ', a.start_hour) >='{$prt_s_date}'";
			}

			if ($s_end_date!='') {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);
				$prt_e_date = $s_end_date.' '.$end_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.start_date,' ', a.start_hour) <='{$prt_e_date}'";
			}
		} else if($searchDate == 'traEnd'){
			if ($s_start_date!='') {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);

				$prt_s_date = $s_start_date.' '.$start_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.end_date,' ', a.end_hour) >='{$prt_s_date}'";
			}

			if ($s_end_date!='') {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);

				$prt_e_date = $s_end_date.' '.$end_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.end_date,' ', a.end_hour) <='{$prt_e_date}'";
			}
		} else if($searchDate == 'regDate'){
			if ($s_start_date!='') {
				$s_date_r=strtotime($s_start_date." 000000");

				$add_query = $add_query." and a.regdate >='".$s_date_r."'";
			}

			if ($s_end_date!='') {
				$e_date_r=strtotime($s_end_date." 235959");

				$add_query = $add_query." and a.regdate <='".$e_date_r."'";
			}
		}
	}

	if($search) {
		if($search_info == 'name') {
			$add_query .=" and c.name like '%$search%'";
		} elseif ($search_info=="join_name") {
			$add_query .=" and a.join_name like '%$search%'";
		} elseif($search_info == 'pjcode'){
			$add_query .=" and a.plan_join_code like '%$search%'";
		} elseif($search_info == 'citizenno'){
			$sJumin1 = encode_pass($search,$pass_key);
			$add_query .=" and c.jumin_1 =  '{$sJumin1}'";
		} elseif($search_info == 'subScription'){
			$add_query .=" and a.no like '%$search%'";
		}
	}

if($insu_ch_b){
	if($insu_ch == 'chInsurance'){
		$add_query .=" and a.insurance_comp = '{$insu_ch_b}' ";
	} else if($insu_ch == 'chTriptype'){
		$add_query .=" and a.trip_type = '{$insu_ch_b}' ";
	}
}		

 $sql="select a.no as plan_hana_no, a.plan_list_state, a.trip_type, a.plan_join_code, a.start_date, a.start_hour, a.end_date, a.end_hour, a.join_cnt, a.join_name,  c.*, c.no as mem_no, c.hphone, c.email,  d.change_date
from 
(select no from hana_plan) b join 
hana_plan a on b.no=a.no 
left join hana_plan_member c on a.no=c.hana_plan_no
left join hana_plan_change d on a.no=d.hana_plan_no
where 1=1
{$add_query}
group by a.no
order by a.no desc
	 ";
$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
//$sql=$sql." limit $num_per_page_start, $num_per_page";
$row_count = $total_record;
$result=mysql_query($sql) or die(mysql_error());

	$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";


		$d_name=stripslashes($row['name']);
		

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


		if ($row['join_cnt']=="1") {
			$join_text=$d_name;
		} else {
			$join_text=$d_name." 외 ".($row['join_cnt']-1)."명";
		} 

		
	if($_SESSION['s_mem_id'] == 'hyecho_b2b' || $_SESSION['s_mem_id'] == 'followme_b2b'){
		    $plan_code_row=sql_one_one('plan_code_mg',"plan_title"," and plan_code='".$plan_code."'");
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

		if($row['regdate'] != ''){
			$reg_date  = date("Y-m-d",$row['regdate']);
		} else {
			$reg_date = '';
		}

		 // Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit("A$cellCount", $total_record, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("B$cellCount", $reg_date, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("C$cellCount", $plan_state_text_array[$row['plan_list_state']], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit("D$cellCount", $change_date , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("E$cellCount", $row['plan_join_code_date'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("F$cellCount", $join_text, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("G$cellCount", $jumin_no, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("H$cellCount", $nation_text, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("I$cellCount", $row['start_date']." ".$row['start_hour']."시", PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("J$cellCount", $row['end_date']." ".$row['end_hour']."시", PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit("K$cellCount", stripslashes($plan_code_row['plan_title']), PHPExcel_Cell_DataType::TYPE_STRING)			
					->setCellValueExplicit("L$cellCount", stripslashes($row['plan_code']), PHPExcel_Cell_DataType::TYPE_STRING) 
					->setCellValueExplicit("M$cellCount", $total_price, PHPExcel_Cell_DataType::TYPE_NUMERIC) 
					->setCellValueExplicit("N$cellCount", stripslashes($row['plan_join_code']), PHPExcel_Cell_DataType::TYPE_STRING) 
					->setCellValueExplicit("O$cellCount", stripslashes($hphone), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit("P$cellCount", stripslashes($email), PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("H$cellCount")->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle("P$cellCount")->getAlignment()->setWrapText(true);
		$cellCount++;

		$total_record--;
	}
	
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray(
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
	

	 
	/** 영영을 지정하여 가로 세로의 정렬을 정의함 **/
	$objPHPExcel->getActiveSheet()->getStyle('A1:P' . ($row_count + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:P' . ($row_count + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('M3:M' . ($row_count + 2))->getNumberFormat()->setFormatCode("#,##0");
		if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

		$prt_fname = '혜초신청내역목록';

} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
		$prt_fname = 'followme 신청내역목록';
} else {
		$prt_fname = '신청내역목록';
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