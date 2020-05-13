<?
include "../include/common.php";
include "../include/login_check_ajax.php";


	ini_set('memory_limit','512M');
	ini_set('max_execution_time', 0); // No time limit
	ini_set('post_max_size', '20M');
	ini_set('upload_max_filesize', '20M');

$check_key = $_REQUEST[check_key];
$send_name = $_REQUEST[send_name];
$send_type = $_REQUEST[send_type];

$savedir = "/board/free/tmp/";
$up_file_name =	$send_name;

if($_FILES[$up_file_name]["name"]==""){
	$json_code = array('result'=>'false','msg'=>'등록된 파일이 없습니다.');
	echo json_encode($json_code);
	exit;
}

	$save_name_front = "tmp_".$send_type;
	$sumnail_flag = 1;

	list($img_list1,$real_img_list1) = img_save_ajax_excel_b2b_tmp($up_file_name,$save_name_front,$sumnail_flag,$root_dir);

	include_once $root_dir."/PHPExcel.php";
	$objPHPExcel = new PHPExcel();

	require_once $root_dir."/PHPExcel/IOFactory.php";
	$filename = $root_dir."/board/free/tmp/".$img_list1;

	$objReader = PHPExcel_IOFactory::createReaderForFile($filename);
	// 읽기전용으로 설정

	$objReader->setReadDataOnly(true);

	// 엑셀파일을 읽는다
	$objExcel = $objReader->load($filename);

	// 첫번째 시트를 선택
	$objExcel->setActiveSheetIndex(0);

	$objWorksheet = $objExcel->getActiveSheet();
	$rowIterator = $objWorksheet->getRowIterator();

	foreach ($rowIterator as $row) { // 모든 행에 대해서
	   $cellIterator = $row->getCellIterator();
	   $cellIterator->setIterateOnlyExistingCells(false); 
	}

	$maxRow = $objWorksheet->getHighestRow();

	$msg=array();
	$excel_cnt=0;

	for ($i = 2 ; $i <= $maxRow ; $i++) {

		$no = $objWorksheet->getCell('A' . $i)->getValue(); // A열
		$name = $objWorksheet->getCell('B' . $i)->getValue(); // B열
		$jumin1 = $objWorksheet->getCell('C' . $i)->getValue(); // D열
		$jumin2 = $objWorksheet->getCell('D' . $i)->getValue(); // E열
		$hphone = $objWorksheet->getCell('E' . $i)->getValue(); // E열
		$email = $objWorksheet->getCell('F' . $i)->getValue(); // E열

		$hphone_arr=explode("-",$hphone);
		$email_arr=explode("@",$email);

		if ($name!='' && $jumin1!='' && $jumin2!='') {

			if (strlen($jumin1)!='6' || strlen($jumin2)!='7') {
				$json_code = array('result'=>'false','msg'=>'주민등록번호가 정확하지 않은 정보가 있습니다. 다시 확인해 주세요.');
				echo json_encode($json_code);
				exit;
			}

			$msg[$excel_cnt]['name']=$name;
			$msg[$excel_cnt]['jumin1']=$jumin1;
			$msg[$excel_cnt]['jumin2']=$jumin2;
			$msg[$excel_cnt]['hphone1']=$hphone_arr[0];
			$msg[$excel_cnt]['hphone2']=$hphone_arr[1];
			$msg[$excel_cnt]['hphone3']=$hphone_arr[2];
			$msg[$excel_cnt]['email1']=$email_arr[0];
			$msg[$excel_cnt]['email2']=$email_arr[1];

			$excel_cnt++;
		}
	}
	
	if ($excel_cnt=="0") {
		$json_code = array('result'=>'false','msg'=>'등록될 회원이 없습니다. 다시 확인해 주세요.');
		echo json_encode($json_code);
		exit;
	} else {
		$json_code = array('result'=>'true','msg'=>$msg);
		echo json_encode($json_code);
		exit;
	}
?>