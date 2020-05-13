<?

include "../include/common.php";

include_once($root_dir."/class/xlsxwriter.class.php");

$writer = new XLSXWriter();
$header_new = array("NO."=>"string", "신청일"=>"string","처리일"=>"string", "대표피보험자(신청자)"=>"string","피보험자 주민등록번호"=>"string","여행지"=>"string", "보험시작일"=>"string", "보험종료일"=>"string","플랜명"=>"string","보험료"=>"non_price","협정요율(수수료율)"=>"string","입금금액"=>"non_price", "선결제"=>"non_price", "납입방법 및 입금일자"=>"string","증권번호"=>"string","가입번호"=>"string","핸드폰"=>"string");

$writer->writeSheetHeader('Sheet1', $header_new, $col_options = array('widths'=>[15,15,15,25,25,35,15,30,30, 25, 20,15, 15, 30, 20, 15, 30],['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center',  'fill'=>'#F28A8C', 'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center',  'fill'=>'#F28A8C', 'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center',  'fill'=>'#F28A8C', 'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11, 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'fill'=>'#F28A8C',  'border'=>'left,right,top,bottom', 'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center']));

if(isset($_POST['start_year']) && isset($_POST['start_month']) && isset($_POST['start_day'])){
	//$check_start  = strtotime($_POST['start_year'].$_POST['start_month'].$_POST['start_day']." 00:00:00");
	$check_start  = $_POST['start_year']."-".$_POST['start_month']."-".$_POST['start_day'];
} else {
	$check_start ='';
}

if(isset($_POST['start_year']) && isset($_POST['start_month']) && isset($_POST['end_day'])){
	//$check_end = strtotime($_POST['start_year'].$_POST['start_month'].$_POST['end_day']." 23:59:59");
	$check_end = $_POST['start_year']."-".$_POST['start_month']."-".$_POST['end_day'];
} else {
	$check_end = '';
}

if($_SESSION['s_mem_id'] == 'hyecho_b2b'){

$add_query .=" and b.member_no='28'";
} else if($_SESSION['s_mem_id'] == 'followme_b2b'){
	$add_query .=" and b.member_no='54'";
}



if($check_start != ''){
	//$add_query = $add_query." and a.change_date >='".$check_start."'";
	$add_query = $add_query." and b.start_date >='".$check_start."'";
}

if($check_end != ''){
	//$add_query = $add_query." and a.change_date <='".$check_end."'";
	$add_query = $add_query." and b.start_date <='".$check_end."'";
}

	$add_query .= " and a.change_date <> '' ";

	$sql="select 
		count(a.no) as t_cnt, sum(change_price) as t_won
	  from
		hana_plan_change a
		left join hana_plan b on b.no=a.hana_plan_no
		left join hana_plan_member d on d.hana_plan_no=b.no
	  where
		1 ".$add_query."
	";
	$result=mysql_query($sql);
	$t_row=mysql_fetch_array($result);

 $sql="select 
		*, b.regdate as regdate, b.no as plan_hana_no, a.change_date as confirm_date, a.no as hana_plan_change_no, d.hphone as hphone, a.com_percent
	  from
		hana_plan_change a
		left join hana_plan b on a.hana_plan_no=b.no
		left join hana_plan_member d on d.hana_plan_no=b.no
	  where
		1 ".$add_query."
	  group by a.no
	  order by concat(b.start_date,' ',b.start_hour) asc
	 ";
	//order by a.no desc
	 //order by concat(b.start_date,' ',b.start_hour) asc
$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
//$sql=$sql." limit $num_per_page_start, $num_per_page";
$result=mysql_query($sql) or die(mysql_error());
$article_num = $total_record;

	$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";

		$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['plan_hana_no']."' and main_check='Y'";
		$result_mem=mysql_query($sql_mem);
		$row_mem=mysql_fetch_array($result_mem);


			if ($row_mem['plan_state']=='3') {
				$d_name="<span style=\"text-decoration: line-through;\">".$row_mem['name']."</span>";
			} else {
				$d_name=$row_mem['name'];
			}

			$jumin_1=decode_pass($row_mem['jumin_1'],$pass_key);

			if ($row_mem['jumin_2']!='') {
				$jumin_2=decode_pass($row_mem['jumin_2'],$pass_key);

				$jumin_no=$jumin_1."- *******";//.$jumin_2;
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


		if ($row_mem_info['mem_type']=="1") {
		    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$plan_code."'");
		} else {

			if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
				$b2b_code_table = 'plan_code_btob';
			} else {
				$b2b_code_table = 'plan_code_mg';
			}

		    $plan_code_row=sql_one_one($b2b_code_table,"plan_title"," and plan_code='".$plan_code."'");
		}
		
		if ($row['join_cnt']=="1") {
			$join_text=$row['join_name'];
		} else {
			$join_text=$row['join_name']." 외 ".($row['join_cnt']-1)."명";
		} 

		
		
		if ($row['nation_no']=="0") {
			$nation_text="국내";
		} else {
			$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
			$nation_text=stripslashes($nation_row['nation_name']);
		}

    
	//$writer->writeSheetRow('Sheet1', $rowdata = array( $article_num,date("Y-m-d",$row['regdate']), date("Y-m-d",$row['confirm_date']), $join_text,  $jumin_no,  $nation_text, $row['start_date']." ".$row['start_hour']."시", $row['end_date']." ".$row['end_hour']."시", stripslashes($plan_code_row['plan_title']),  number_format($row['change_price']), stripslashes($row['com_percent'])." %",number_format($row['change_price']-(($row['change_price']*$row['com_percent'])/100)),number_format($row['in_price']),  $row['add_input_1'],stripslashes($row['plan_join_code']), "A".date("Ymd",$row['regdate']).sprintf("%06d", $row['plan_hana_no']),stripslashes($hphone), $row_options=array('height'=>20, 'wrap_text'=>true, ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11,  'halign'=>'center',    'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11,  'halign'=>'center',    'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] ,['font'=>'Calibri','font-size'=>11,  'halign'=>'center',    'border-style'=>'thin', 'border-color'=>'black', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center','wrap_text'=>true] , ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center']));		
	
	
	$writer->writeSheetRow('Sheet1', $rowdata = array($article_num,date("Y-m-d",$row['regdate']),date("Y-m-d",$row['confirm_date']),$join_text, $jumin_no,  $nation_text, $row['start_date']." ".$row['start_hour']."시", $row['end_date']." ".$row['end_hour']."시", stripslashes($plan_code_row['plan_title']), $row['change_price'],  stripslashes($row['com_percent'])." %",$row['change_price']-(($row['change_price']*$row['com_percent'])/100),$row['in_price'],  $row['add_input_1'],stripslashes($row['plan_join_code']), "A".date("Ymd",$row['regdate']).sprintf("%06d", $row['plan_hana_no']),stripslashes($hphone)), $row_options=array('height'=>20, 'wrap_text'=>true, ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center'], ['font'=>'Calibri','font-size'=>11,  'halign'=>'center', 'valign'=>'center']));		
    
    $article_num--;
}

/** 위에서 쓴 엑셀을 저장하고 다운로드 합니다. **/
/*
$date="보험가입관리_보고용_".date("Ymd"). ".xls";
$output_file_name = iconv('UTF-8','EUC-KR', $date);
header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-type: application/x-msexcel;charset=utf-8');
header('Content-Disposition: attachment;filename="'.$output_file_name.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
*/
//$writer->markMergedCell('Sheet1', $start_row=0, $start_col=0, $end_row=0, $end_col=14);
	$file = "정산_관리_".date("Ymd"). ".xlsx";
	$file = iconv('UTF-8','EUC-KR', $file);
	$writer->writeToFile($file);

	if (file_exists($file)) {
		//ie 한글 파일명 깨짐 방지 iconv 
		//파일을 다운 받고 unlink로 삭제 
		header('Content-Description: File Transfer');
		//header('Content-Type: application/octet-stream');
		header('Content-Type: application/vnd.ms-excel;charset=utf-8');
		header('Content-type: application/x-msexcel;charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		unlink($file);
		exit;
	}
?>