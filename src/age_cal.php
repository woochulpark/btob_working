<?php

function age_cal($targetDate, $inputDate) {
    
    $targetDate = str_replace('-','',$targetDate);
    $inputDate = str_replace('-','',$inputDate);
    
	// 현재년도
    $to_year = (int)substr($targetDate,0,4);
    // 현재월
    $to_month = (int)substr($targetDate,4,2);
    // 현재일자
    $to_day = (int)substr($targetDate,6,2);
        
    // 주민번호 연도
    $input_year = (int)substr($inputDate,0,4);
    // 주민번호 월
    $input_month = (int)substr($inputDate,4,2);
    // 주민번호 일자
    $input_day = (int)substr($inputDate,6,2);

	$term_year=$to_year-$input_year; // 계산한년도
	$term_month=$to_month-$input_month; // 계산한달
	$term_day=$to_day-$input_day; // 계산한달

	if ($term_month < 0) { // 현재월이 생일월을 지나기 전

		if ($term_month == -6) {
			if ($term_day < 0) {
				$cal_age=$term_year-1;
			} else {
				$cal_age=$term_year;
			}
		} elseif ($term_month > -6) {
			$cal_age=$term_year;
		} elseif ($term_month < -6) {
			$cal_age=$term_year-1;
		}

	} elseif ($term_month > 0) { // 현재월이 생일월을 지난 후
		
		if ($term_month == 6) {
			if ($term_day >= 0) {
				$cal_age=$term_year+1;
			} else {
				$cal_age=$term_year;
			}
		} elseif ($term_month > 6) {
			$cal_age=$term_year+1;
		} elseif ($term_month < 6) {
			$cal_age=$term_year;
		}

	} elseif ($term_month == 0) { // 현재월이 생일월이 같은경우
		$cal_age=$term_year;
	}

	$manAge = $term_year;

	if ((int)substr($targetDate,4,4) < (int)substr($inputDate,4,4)) {
		$manAge = $manAge -1;
	}

	return array($cal_age,$manAge);
}

if(!isset($_POST['tyear'])){


}
$target_old = $_POST['tyear'];

$old_arr = explode("-",$target_old);

$front_old = $old_arr[0];
$back_old  = substr($old_arr[1], 0, 1);

switch($back_old){
	case 1:
	case 2:
		$cal_year = "19".substr($front_old, 0, 2);
	break;
	case 3:
	case 4:
		$cal_year = "20".substr($front_old, 0, 2); 
	break;
}

$cal_month  = substr($front_old, 2,2);
$cal_day = substr($front_old, 4,2);

$today = date("Y-m-d",time());
$cal_done = age_cal($today,$cal_year."-".$cal_month."-".$cal_day);

$json_code = array('result'=>'true','msg'=>$cal_done);
echo json_encode($json_code);
exit;

?>