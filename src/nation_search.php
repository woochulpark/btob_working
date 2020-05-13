<?php
		include "../include/common.php";
		include "../include/hana_check_ajax.php";
	
		if(!isset($_POST['nation_search'])){
			$json_code = array('result'=>'false', 'msg'=>'올바른 접근이 필요합니다.');
			echo json_encode($json_code);
			exit;
		} else {
			if($_POST['nation_search'] != ''){
				$s_nation = $_POST['nation_search'];
			} else {
				exit;
			}
		}
		


		if($s_nation == 'ㄱ'){
			$where = "and (nation_name RLIKE '^(ㄱ|ㄲ)' OR ( nation_name >= '가' AND nation_name < '나' )) ";
		}else if($s_nation == 'ㄴ'){
			$where = "and (nation_name RLIKE '^ㄴ' OR ( nation_name >= '나' AND nation_name < '다' )) ";
		}else if($s_nation == 'ㄷ'){
			$where = "and (nation_name RLIKE '^(ㄷ|ㄸ)' OR ( nation_name >= '다' AND nation_name < '라' )) ";
		}else if($s_nation == 'ㄹ'){
			$where = "and (nation_name RLIKE '^ㄹ' OR ( nation_name >= '라' AND nation_name < '마' )) ";
		}else if($s_nation == 'ㅁ'){
			$where = "and (nation_name RLIKE '^ㅁ' OR ( nation_name >= '마' AND nation_name < '바' )) ";
		}else if($s_nation == 'ㅂ'){
			$where = "and (nation_name RLIKE '^ㅂ' OR ( nation_name >= '바' AND nation_name < '사' )) ";
		}else if($s_nation == 'ㅅ'){
			$where = "and (nation_name RLIKE '^(ㅅ|ㅆ)' OR ( nation_name >= '사' AND nation_name < '아' )) ";
		}else if($s_nation == 'ㅇ'){
			$where = "and (nation_name RLIKE '^ㅇ' OR ( nation_name >= '아' AND nation_name < '자' )) ";
		}else if($s_nation == 'ㅈ'){
			$where = "and (nation_name RLIKE '^(ㅈ|ㅉ)' OR ( nation_name >= '자' AND nation_name < '차' )) ";
		}else if($s_nation == 'ㅊ'){
			$where = "and (nation_name RLIKE '^ㅊ' OR ( nation_name >= '차' AND nation_name < '카' )) ";
		}else if($s_nation == 'ㅋ'){
			$where = "and (nation_name RLIKE '^ㅋ' OR ( nation_name >= '카' AND nation_name < '타' )) ";
		}else if($s_nation == 'ㅌ'){
			$where = "and (nation_name RLIKE '^ㅌ' OR ( nation_name >= '타' AND nation_name < '파' )) ";
		}else if($s_nation == 'ㅍ'){
			$where = "and (nation_name RLIKE '^ㅍ' OR ( nation_name >= '파' AND nation_name < '하' )) ";
		}else if($s_nation == 'ㅎ'){
			$where = "and (nation_name RLIKE '^ㅎ' OR ( nation_name >= '하')) ";
		}	else {
			$where = " and (nation_name LIKE '".$s_nation."%')";
		}

			if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
				
				$f_where = "use_type='Y'";
			} else {
				//$f_where = "(use_type='Y' or no in '509')";
				$f_where = "(use_type = 'Y' or no in ('512', '508', '509', '487') )";
			}

		$sql="select no, nation_name from nation where ".$f_where." ".$where;

		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) {
			$nation_both[] = array('nation_code'=>$row['no'],'nation_name'=>$row['nation_name']);		
		}

		$json_code = array('result'=>'true','msg'=>$nation_both);
		echo json_encode($json_code);
		exit;
?>