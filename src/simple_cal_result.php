		<?
			include "../include/common.php";
			if(!isset($_GET['tripT']) || !isset($_GET['birthT'])){
				exit;
			} else {
				$referen_data = $_GET['tripT']."//-//".$_GET['birthT']."//-//".$_GET['sexT']."//-//".$_GET['startdT']."//-//".$_GET['starthT']."//-//".$_GET['enddT']."//-//".$_GET['endhT'];
				$referen_data_enc = base64_encode($referen_data);
				echo "<!--";
	print_r($_SESSION);
	echo "<br>";
	print_r($_GET);
	echo "-->";

				if(!isset($chk_config['chk_code'])){
				
				} else {
					$trip_Type   = addslashes(fnFilterString($_GET['tripT']));				
					$birth_Day   = addslashes(fnFilterString($_GET['birthT']));
					$sEx			  = addslashes(fnFilterString($_GET['sexT']));
					$start_Day   = addslashes(fnFilterString($_GET['startdT']));
					$start_Hour = addslashes(fnFilterString($_GET['starthT']));
					$end_Day     = addslashes(fnFilterString($_GET['enddT']));
					$end_Hour   = addslashes(fnFilterString($_GET['endhT']));

					$start_date_arr=explode("-",$start_Day);
					$start_time=mktime($start_Hour,"00","00",$start_date_arr[1],$start_date_arr[2],$start_date_arr[0]);

					$end_date_arr=explode("-",$end_Day);
					$end_time=mktime($end_Hour,"00","00",$end_date_arr[1],$end_date_arr[2],$end_date_arr[0]);

					// 해외 80세 이상 관광은 보험의 일정 (1개월)이 아닌 순수 30일을 가져와야 함. 2019-08-29
					$rl_term_day = real_period($start_Day." ".$start_Hour.":00:00", $end_Day." ".$end_Hour.":00:00");

					//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철
					//$term_day=ceil(($end_time-$start_time)/86400);
					$term_day = travel_period($start_Day." ".$start_Hour.":00:00", $end_Day." ".$end_Hour.":00:00"); 
					//2019-07-24 $term_day 상품별 여행기간 계산 추가 - 박우철
					//2019-07-03 해외 여행 80대(보험나이) 1개월 이상 보험가입 금지 - 박우철		

					$birth_date = substr($birth_Day,0,4)."-".substr($birth_Day,4,2)."-".substr($birth_Day,6,2);
					$cur_date=date("Y-m-d");		

					list($cal_age,$term_year) = age_cal($cur_date,$birth_date);
		
					if ($cal_age > 100) {
						$cal_age=100;
					}
					
					switch($trip_Type){
						case 'oversea':
							$triptype = 2;
						break;
						case 'domestic':
							$triptype = 1;
						break;
					}

					switch($sEx){
						case 'male':
							$sex = 1;
						break;
						case 'female':
							$sex = 2;
						break;
					}
				}	

				/*
					보험선택//-//생년월일//-//성별//-//시작일//-//시작시간//-//종료일//-//종료시간
				*/

				if($triptype != 2){ //국내
					if($_SESSION['s_mem_insu1'] == 'Y'){ //DB(동부)
							if ($cal_age >= 0 && $cal_age <= 14) {
								$cal_type="1";
								$que_plan_type= ' and plan_type < 4';
							} elseif ($cal_age >= 15 && $cal_age <= 69) {
								$cal_type="2";

								if ($cal_age=="15") {
									if ($term_year=="14") {
										$cal_type="1";
									}
								}
								$que_plan_type= ' and plan_type < 4';
							} elseif ($cal_age >= 70 && $cal_age <= 79) {
								$cal_type="3";
								$que_plan_type= '';
							} else if($cal_age >= 80 && $cal_age <= 100){
								$cal_type="4";
								$que_plan_type= '';
							}

							$que_plan_db = "SELECT a.* from (SELECT no from plan_code_btob_db where trip_type={$triptype} and cal_type={$cal_type} {$que_plan_type}) b join plan_code_btob_db a on b.no=a.no ";
							
							$result_plan=mysql_query($que_plan_db);
							$max_cnt = mysql_num_rows($result_plan);							
							$plan_cnt_db = ($max_cnt == '')?0:$max_cnt;
							$plan_in = '';
							$x = 0;
							while($row_plan = mysql_fetch_array($result_plan)){
								if($x < ($max_cnt - 1)){
									$plan_in .=	"'".$row_plan['plan_code']."',";
								}  else {
									$plan_in .= "'".$row_plan['plan_code']."'";
								}
								$plan_db[$row_plan['plan_code']] = array('plan_type'=>$row_plan['plan_type'], 'plan_code'=>$row_plan['plan_code'],'type_1'=>$row_plan['type_1'], 'type_2'=>$row_plan['type_2'],'type_3'=>$row_plan['type_3'],'type_4'=>$row_plan['type_4'],'type_5'=>$row_plan['type_5']);
								$x++;
							}
												
							$que_price_db = "SELECT a.* from (SELECT no from plan_code_price_btob_db where trip_type={$triptype} and age={$cal_age} and sex={$sex} and term_day = {$term_day} and plan_code in ({$plan_in})) b join plan_code_price_btob_db a on b.no=a.no ";
							
						
							$result_price = mysql_query($que_price_db);
							$max_cnt = mysql_num_rows($result_price);
							$plan_price_cnt_db = ($max_cnt == '')?0:$max_cnt;
							while($row_price = mysql_fetch_array($result_price)){
								
									$pcode = $row_price['plan_code'];
									$price = $row_price['price'];									
									$plan_db[$pcode]['price'] = $price;
									 
							}
							
							$que_type_db = "select plan_type,title from plan_code_type_btob_db where trip_type={$triptype} and plan_type in('type_1', 'type_2', 'type_3', 'type_4', 'type_5')";
							$result_type = mysql_query($que_type_db);
							while($row_type = mysql_fetch_array($result_type)){
										$type_plan_db[$row_type['plan_type']] = $row_type['title'];
							}
								
					} 

					if($_SESSION['s_mem_insu2'] == 'Y'){ //CHUBB
								if ($cal_age >= 0 && $cal_age <= 14) {
									$cal_type="1";
								} elseif ($cal_age >= 15 && $cal_age <= 79) {
									$cal_type="2";

									if ($cal_age=="15") {
										if ($term_year=="14") {
											$cal_type="1";
										}
									}
								} elseif ($cal_age >= 80 && $cal_age <= 100) {
									$cal_type="3";
								}	
								
								$que_plan_ace = "SELECT a.* from (SELECT no from plan_code_btob_ace where trip_type={$triptype} and cal_type={$cal_type} and plan_type < 4) b join plan_code_btob_ace a on b.no=a.no ";
							
							$result_plan=mysql_query($que_plan_ace);
							$max_cnt = mysql_num_rows($result_plan);							
							$plan_cnt_ace = ($max_cnt == '')?0:$max_cnt;
							$plan_in = '';
							$x = 0;
							while($row_plan = mysql_fetch_array($result_plan)){
								if($x < ($max_cnt - 1)){
									$plan_in .=	"'".$row_plan['plan_code']."',";
								}  else {
									$plan_in .= "'".$row_plan['plan_code']."'";
								}
								$plan_ace[$row_plan['plan_code']] = array('plan_type'=>$row_plan['plan_type'], 'plan_code'=>$row_plan['plan_code'],'type_1'=>$row_plan['type_1'], 'type_2'=>$row_plan['type_2'],'type_3'=>$row_plan['type_3'],'type_4'=>$row_plan['type_4'],'type_5'=>$row_plan['type_5']);
								$x++;
							}
							

					
							$que_price_ace = "SELECT a.* from (SELECT no from plan_code_price_btob_ace where trip_type={$triptype} and age={$cal_age} and sex={$sex} and term_day = {$term_day} and plan_code in ({$plan_in})) b join plan_code_price_btob_ace a on b.no=a.no";
							
						
							$result_price = mysql_query($que_price_ace);
							$max_cnt = mysql_num_rows($result_price);
							$plan_price_cnt_ace = ($max_cnt == '')?0:$max_cnt;
							while($row_price = mysql_fetch_array($result_price)){
									
									$pcode = $row_price['plan_code'];
									$price = $row_price['price'];									
									$plan_ace[$pcode]['price'] = $price;
									 
							}
							
							$que_type_ace = "select plan_type,title from plan_code_type_btob_ace where trip_type={$triptype} and plan_type in('type_1', 'type_2', 'type_3', 'type_4', 'type_5')";

							$result_type = mysql_query($que_type_ace);
							while($row_type = mysql_fetch_array($result_type)){
										$type_plan_ace[$row_type['plan_type']] = $row_type['title'];
							}
							
					}
				} else { // 해외
					if($_SESSION['s_mem_insu1'] == 'Y'){
							if ($cal_age >= 0 && $cal_age <= 14) {
								$cal_type="1";
								$que_plan_type = ' and plan_type < 4 ';
							} elseif ($cal_age >= 15 && $cal_age <= 69) {
								$cal_type="2";

								if ($cal_age=="15") {
									if ($term_year=="14") {
										$cal_type="1";
									}
								}
								$que_plan_type = ' and plan_type < 4 ';
							} elseif ($cal_age >= 70 && $cal_age <= 79) {
								$cal_type="3";
								$que_plan_type = '';
							}
							
							$que_plan_db = "SELECT a.* from (SELECT no from plan_code_btob_db where trip_type={$triptype} and cal_type={$cal_type} {$que_plan_type}) b join plan_code_btob_db a on b.no=a.no ";
							echo "<!--1".$que_plan_db."-->";
							$result_plan=mysql_query($que_plan_db);
							$max_cnt = mysql_num_rows($result_plan);
							$plan_cnt_db = ($max_cnt == '')?0:$max_cnt;
							$plan_in = '';
							$x = 0;
							while($row_plan = mysql_fetch_array($result_plan)){
								if($x < ($max_cnt - 1)){
									$plan_in .=	"'".$row_plan['plan_code']."',";
								}  else {
									$plan_in .= "'".$row_plan['plan_code']."'";
								}
								$plan_db[$row_plan['plan_code']] = array('plan_type'=>$row_plan['plan_type'], 'plan_code'=>$row_plan['plan_code'],'type_1'=>$row_plan['type_1'], 'type_2'=>$row_plan['type_2'],'type_3'=>$row_plan['type_3'],'type_4'=>$row_plan['type_4'],'type_5'=>$row_plan['type_5']);
								$x++;
							}
							
					
							$que_price_db = "SELECT a.* from (SELECT no from plan_code_price_btob_db where trip_type={$triptype} and age={$cal_age} and sex={$sex} and term_day = {$term_day} and plan_code in ({$plan_in})) b join plan_code_price_btob_db a on b.no=a.no";
							
							echo "<!--".$que_price_db."-->";
						
							$result_price = mysql_query($que_price_db);
							$max_cnt = mysql_num_rows($result_price);
							$plan_price_cnt_db = ($max_cnt == '')?0:$max_cnt;
							while($row_price = mysql_fetch_array($result_price)){
									//echo kor_won($row_price['price']);
									$pcode = $row_price['plan_code'];
									$price = $row_price['price'];									
									$plan_db[$pcode]['price'] = $price;
									 
							}
							
							$que_type_db = "select plan_type,title from plan_code_type_btob_db where trip_type={$triptype} and plan_type in('type_1', 'type_2', 'type_3', 'type_4', 'type_5')";
							echo "<!--".$que_type_db."-->";
							$result_type = mysql_query($que_type_db);
							while($row_type = mysql_fetch_array($result_type)){
										$type_plan_db[$row_type['plan_type']] = $row_type['title'];
							}
								
					} 

					if($_SESSION['s_mem_insu2'] == 'Y'){
							if ($cal_age >= 0 && $cal_age <= 14) {
								$cal_type="1";
								$que_plan_type = ' and plan_type < 4 ';
							} elseif ($cal_age >= 15 && $cal_age <= 70) {
								$cal_type="2";
								
								if ($cal_age=="15") {
									if ($term_year=="14") {
										$cal_type="1";
									}
								}

								$que_plan_type = ' and plan_type < 4 ';
							} elseif ($cal_age >= 71 && $cal_age <= 90) {
								$cal_type="3";
								$que_plan_type = '';
							} elseif ($cal_age >= 80 && $cal_age <= 100) {
								$cal_type="4";
								$que_plan_type = '';
							}
								
							$que_plan_ace = "SELECT a.* from (SELECT no from plan_code_btob_ace where trip_type={$triptype} and cal_type={$cal_type} {$que_plan_type}) b join plan_code_btob_ace a on b.no=a.no ";
							echo "<!--".$que_plan_ace."-->";
							$result_plan=mysql_query($que_plan_ace);
							$max_cnt = mysql_num_rows($result_plan);
							$plan_cnt_ace = ($max_cnt =='')?0:$max_cnt;
							$plan_in = '';
							$x = 0;
							while($row_plan = mysql_fetch_array($result_plan)){
								if($x < ($max_cnt - 1)){
									$plan_in .=	"'".$row_plan['plan_code']."',";
								}  else {
									$plan_in .= "'".$row_plan['plan_code']."'";
								}
								$plan_ace[$row_plan['plan_code']] = array('plan_type'=>$row_plan['plan_type'], 'plan_code'=>$row_plan['plan_code'],'type_1'=>$row_plan['type_1'], 'type_2'=>$row_plan['type_2'],'type_3'=>$row_plan['type_3'],'type_4'=>$row_plan['type_4'],'type_5'=>$row_plan['type_5']);
								$x++;
							}										
					
							$que_price_ace = "SELECT a.* from (SELECT no from plan_code_price_btob_ace where trip_type={$triptype} and age={$cal_age} and sex={$sex} and term_day = {$term_day} and plan_code in ({$plan_in})) b join plan_code_price_btob_ace a on b.no=a.no ";
							echo "<!--".$que_price_ace."-->";
						
							$result_price = mysql_query($que_price_ace);
							$max_cnt = mysql_num_rows($result_price);
							$plan_price_cnt_ace = ($max_cnt =='')?0:$max_cnt;
							while($row_price = mysql_fetch_array($result_price)){
									//echo kor_won($row_price['price']);
									$pcode = $row_price['plan_code'];
									$price = $row_price['price'];									
									$plan_ace[$pcode]['price'] = $price;									 
							}
							
							$que_type_ace = "select plan_type,title from plan_code_type_btob_ace where trip_type={$triptype} and plan_type in('type_1', 'type_2', 'type_3', 'type_4', 'type_5')";
							echo "<!--".$que_type_ace."-->";
							$result_type = mysql_query($que_type_ace);
							while($row_type = mysql_fetch_array($result_type)){
										$type_plan_ace[$row_type['plan_type']] = $row_type['title'];
							}
								
					}
				}


			}
		?>
		<div class="wrap_pd">
<?		if($_SESSION['s_mem_insu2'] == 'Y'){ //CHUBB ?>
                    <div class="insur">
                    
						<h2>
						 
						<img src="../img/main/logo_chubb.png" alt="에이스보험 CHUBB">
						
						</h2>
						<?

					  		if($plan_cnt_ace < 1 || $plan_price_cnt_ace < 1){
								$non_result_print = "검색된 결과가 없습니다. ";
								
								if($cal_age > 100){
									$non_result_print = "해당 연령의 상품이 없습니다.";
								}
							?>
									 
									<h3 class="nonprt"> <?=$non_result_print?> </h3>

						<?
							} else {
							foreach($plan_ace as $k=>$v){
								switch($plan_ace[$k]['plan_code']){
									case 'M23426':
									case 'M23425':
									case 'M23238':
									case 'M23237':
									case 'M23239':
									$prt_plan_title = '실속';
									$prt_level = 1;
									break;
									case 'M23431':
									case 'M23433':
									$prt_plan_title = '기본';
									$prt_level = 3;
									break;
									case 'M23427':
									case 'M23424':
									case 'M23236':
									case 'M23235':
									case 'M23241':
									$prt_plan_title = '표준';
									$prt_level = 2;
									break;
									case 'M23428':
									case 'M23422':
									case 'M23229':
									case 'M23226':
									case 'M23234':
									$prt_plan_title = '고급';
									$prt_level = 3;
									break;
								}
								
								if($plan_ace[$k]['price'] > 0){
						?>
                        <div class="case">
                            <ul>
                                <span class="level<?=$prt_level?>"><?=$prt_plan_title?></span>
                                <h3>주요담보</h3>								
                                 <?=($plan_ace[$k]['type_1'] > 0) ? "<li>- ".$type_plan_ace['type_1']." ".num2han($plan_ace[$k]['type_1'])."</li>":"";?>
                                <?=($plan_ace[$k]['type_2'] > 0) ? "<li>- ".$type_plan_ace['type_2']." ".num2han($plan_ace[$k]['type_2'])."</li>":""; ?>
                                <li>- <?=$type_plan_ace['type_3']?> <?=num2han($plan_ace[$k]['type_3'])?></li>
                                <li>- <?=$type_plan_ace['type_4']?> <?=num2han($plan_ace[$k]['type_4'])?></li>
								 <?=($plan_ace[$k]['type_1'] < 1 || $plan_ace[$k]['type_2'] < 1) ? "<li>- ".$type_plan_ace['type_5']." ".num2han($plan_ace[$k]['type_5'])."</li>":"";?>
                            </ul>
                            <ul>
                                <li>총<span><?=number_format($plan_ace[$k]['price'])?></span>원</li>
                            </ul>
                            <ul>
                                <?//<button type="button" >자세히보기</button>?>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="2">가입하기</button>
                            </ul>
                        </div>
						<?
							
								}
						} //end foreach
						} //end if
						/*
                        <div class="case">
                            <ul>
                                <span class="level2">실속</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>12,400</span>원</li>
                            </ul>
                            <ul>
                                <?//<button type="button" >자세히보기</button>?>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="1">가입하기</button>
                            </ul>
                        </div>
                        <div class="case">
                            <ul>
                                <span class="level3">고급</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>32,150</span>원</li>
                            </ul>
                            <ul>
                                <?//<button type="button" >자세히보기</button>?>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="1">가입하기</button>
                            </ul>
                        </div>
						<?
						*/
						/*
						<div style="padding-bottom:20px;"></div>
						<div class="case">
                            <ul>
                                <span class="level1">기본</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>57,900</span>원</li>
                            </ul>
                            <ul>
                                <button type="button" >자세히보기</button>
                                <button type="button" join-data="<?=$referen_data_enc?>">가입하기</button>
                            </ul>
                        </div>
                        <div class="case">
                            <ul>
                                <span class="level2">실속</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>12,400</span>원</li>
                            </ul>
                            <ul>
                                <button type="button" >자세히보기</button>
                                <button type="button" join-data="<?=$referen_data_enc?>">가입하기</button>
                            </ul>
                        </div>
                        <div class="case">
                            <ul>
                                <span class="level3">고급</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>32,150</span>원</li>
                            </ul>
                            <ul>
                                <button type="button" >자세히보기</button>
                                <button type="button" join-data="<?=$referen_data_enc?>">가입하기</button>
                            </ul>
                        </div>
						*/?>
                    </div><!-- e : insur 상품 -->
					<?
						} // if chubb	
					if($_SESSION['s_mem_insu1'] == 'Y'){ //DB ?>
                    <div class="insur">
                        <h2>
						 
						<img src="../img/main/logo_db.png" alt="DB손해보험">	
						
						</h2>
						<?

					  		if($plan_cnt_db < 1 || $plan_price_cnt_db < 1){
								$non_result_print = "검색된 결과가 없습니다. ";
								
								if($cal_age > 80){
									$non_result_print = "해당 연령의 상품이 없습니다.";
								}
							?>
									 
									<h3 class="nonprt"> <?=$non_result_print?> </h3>
									 
								<?
							} else {
							foreach($plan_db as $k=>$v){
								
								switch($plan_db[$k]['plan_code']){
									case 'TSB07':
									case 'TSB01':
									case 'TSA35':
									case 'TSA33':
									case 'TSA38':
									$prt_plan_title = '실속';
									$prt_level = 1;
									break;
									case 'TSB09':
									case 'TSA37':
									$prt_plan_title = '기본';
									$prt_level = 3;
									break;
									case 'TSB08':
									case 'TSB02':
									case 'TSA36':
									case 'TSA34':
									case 'TSA39':
									$prt_plan_title = '표준';
									$prt_level = 2;
									break;
									case 'TSB03':									
									$prt_plan_title = '고급';
									$prt_level = 3;
									break;
								}

								if($plan_db[$k]['price'] > 0){
						?>
                        <div class="case">
                            <ul>
                                <span class="level<?=$prt_level?>"><?=$prt_plan_title?></span>
                                <h3>주요담보</h3>
                                 <?=($plan_db[$k]['type_1'] > 0) ? "<li>- ".$type_plan_db['type_1']." ".num2han($plan_db[$k]['type_1'])."</li>":"";?>
                                <?=($plan_db[$k]['type_2'] > 0) ? "<li>- ".$type_plan_db['type_2']." ".num2han($plan_db[$k]['type_2'])."</li>":""; ?>
                                <li>- <?=$type_plan_db['type_3']?> <?=num2han($plan_db[$k]['type_3'])?></li>
                                <li>- <?=$type_plan_db['type_4']?> <?=num2han($plan_db[$k]['type_4'])?></li>
								 <?=($plan_db[$k]['type_1'] < 1 || $plan_db[$k]['type_2'] < 1) ? "<li>- ".$type_plan_db['type_5']." ".num2han($plan_db[$k]['type_5'])."</li>":"";?>
                            </ul>
                            <ul>
                                <li>총<span><?=number_format($plan_db[$k]['price'])?></span>원</li>
                            </ul>
                            <ul>
                               <?// <button type="button" >자세히보기</button>?>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="1">가입하기</button>
                            </ul>
                        </div>
						<?
								
								}
					} //end foreach
							}//end if
								/*
						?>
                        <div class="case">
                            <ul>
                                <span class="level2">실속</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>60,230</span>원</li>
                            </ul>
                            <ul>
                                <button type="button" >자세히보기</button>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="2">가입하기</button>
                            </ul>
                        </div>
                        <div class="case">
                            <ul>
                                <span class="level3">고급</span>
                                <h3>주요담보</h3>
                                <li>- 상해사망(만15세미만부담보) 1억</li>
                                <li>- 상해사망 70대플랜 3천만</li>
                                <li>- 휴대품손해 50만원<a href="#" target="_blank">[자세히]</a></li>
                                <li>- 항공기 수하물지연보상 無</li>
                            </ul>
                            <ul>
                                <li>총<span>9,800</span>원</li>
                            </ul>
                            <ul>
                                <button type="button" >자세히보기</button>
                                <button type="button" join-data="<?=$referen_data_enc?>" both_insu="2">가입하기</button>
                            </ul>
                        </div>
						<? */ ?>
                    </div><!-- e : insur 상품 -->
					<? } // if DB??>
                </div>
            </div><!-- e : body -->
			<!--<? print_r($_SESSION)?>-->
			<script type="text/javascript">
				$(document).on('click','.insur button',function(){
					var search_data = $(this).attr('join-data');
					var bothinsuran = $(this).attr('both_insu');
					location.href="/trip/01.php?tripType="+<?=($_GET['tripT'] == 'domestic')? 1 : 2 ;?>+"&join_data="+search_data+"&insuboth="+bothinsuran;
				});
			</script>