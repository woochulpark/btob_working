<?
	include "../include/common.php";
	echo "<!--";
	//print_r($_GET);
	echo "-->";

	$plan_table = '';
	$type_table = '';
	if(isset($_GET['select_insu']) && $_GET['select_insu'] != ''){
		$sinsu = $_GET['select_insu'];
		switch($sinsu){
			case 'S_1':
				$plan_table = ' plan_code_btob_db ';
				$type_table = ' plan_code_type_btob_db ';
			break;
			case 'S_2':
				$plan_table = ' plan_code_btob_ace ';
				$type_table = ' plan_code_type_btob_ace ';
			break;
		}
	}
	
	$insu_pot = array();

	$plan_que = "SELECT * FROM {$plan_table} WHERE trip_type = {$_GET['tripType']} ";	
	$type_que = "SELECT * FROM {$type_table} WHERE trip_type={$_GET['tripType']} ";

	//echo $plan_que;
	
	$plan_result = mysql_query($plan_que);
	$type_result = mysql_query($type_que);


	
	while($plan_row = mysql_fetch_array($plan_result)){
		$insu_plan_pot[$sinsu]['plan_code'][]		= $plan_row['plan_code'];
		$insu_plan_pot[$sinsu]['cal_type'][]			= $plan_row['cal_type'];
		$insu_plan_pot[$sinsu]['plan_title'][]			= $plan_row['plan_title'];
		$insu_plan_pot[$sinsu]['plan_start_age'][]			= $plan_row['plan_start_age'];
		$insu_plan_pot[$sinsu]['plan_end_age'][]			= $plan_row['plan_end_age'];
		$insu_plan_pot[$sinsu]['plan_type'][]		= $plan_row['plan_type'];
		$insu_plan_pot[$sinsu]['type_1']	[]		= $plan_row['type_1'];
		$insu_plan_pot[$sinsu]['type_2']	[]		= $plan_row['type_2'];
		$insu_plan_pot[$sinsu]['type_3']	[]		= $plan_row['type_3'];
		$insu_plan_pot[$sinsu]['type_4']	[]		= $plan_row['type_4'];
		$insu_plan_pot[$sinsu]['type_5']	[]		= $plan_row['type_5'];
		$insu_plan_pot[$sinsu]['type_6']	[]		= $plan_row['type_6'];
		$insu_plan_pot[$sinsu]['type_7']	[]		= $plan_row['type_7'];
		$insu_plan_pot[$sinsu]['type_8']	[]		= $plan_row['type_8'];
		$insu_plan_pot[$sinsu]['type_9']	[]		= $plan_row['type_9'];
		$insu_plan_pot[$sinsu]['type_10'][] = $plan_row['type_10'];
		$insu_plan_pot[$sinsu]['type_11'][] = $plan_row['type_11'];
		$insu_plan_pot[$sinsu]['type_12'][] = $plan_row['type_12'];
		$insu_plan_pot[$sinsu]['type_13'][] = $plan_row['type_13'];
		$insu_plan_pot[$sinsu]['type_14'][] = $plan_row['type_14'];
		$insu_plan_pot[$sinsu]['type_15'][] = $plan_row['type_15'];
		$insu_plan_pot[$sinsu]['type_16'][] = $plan_row['type_16'];
		$insu_plan_pot[$sinsu]['type_17'][] = $plan_row['type_17'];
		$insu_plan_pot[$sinsu]['type_18'][] = $plan_row['type_18'];
		$insu_plan_pot[$sinsu]['type_19'][] = $plan_row['type_19'];
		$insu_plan_pot[$sinsu]['type_20'][] = $plan_row['type_20'];
		$insu_plan_pot[$sinsu]['type_21'][] = $plan_row['type_21'];
		$insu_plan_pot[$sinsu]['type_22'][] = $plan_row['type_22'];
		$insu_plan_pot[$sinsu]['type_23'][] = $plan_row['type_23'];
		$insu_plan_pot[$sinsu]['type_24'][] = $plan_row['type_24'];
		$insu_plan_pot[$sinsu]['type_25'][] = $plan_row['type_25'];
		$insu_plan_pot[$sinsu]['type_26'][] = $plan_row['type_26'];	
	}
	
	$tp_n = 0;
	while($type_row = mysql_fetch_array($type_result)){
		
		$insu_type_pot[$sinsu][$tp_n]['plan_type']		= $type_row['plan_type'];
		$insu_type_pot[$sinsu][$tp_n]['title']				= $type_row['title'];
		$insu_type_pot[$sinsu][$tp_n]['content']		= $type_row['content'];
		$tp_n++;
	}


?>
<div class="pop_con w1140">
        <div class="pop_con_inner">
            <div class="pop_head">
                <p class="tit" id="pop_title">플랜 선택</p>
                <p class="btn_close" onclick="close_pop('pop_wrap');"><img src="../img/common/btn_close.png" alt="닫기"></p>
            </div>
            <div class="pop_body">
                <div class="plan_table" id="of-xy">
                    <table id="t_plan" mulchk="<?=($_GET['rowind'] !="")?$_GET['rowind'] :"";?>">
                        <caption>검색 결과</caption>
                        <colgroup>
                            <col width="270px">
                            <col width="40px">
							<?
								foreach($insu_plan_pot[$sinsu]['plan_code'] as $k=>$v){
								?>
                            <col width="80px">
								<?
								}
							/*
							?>
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
                            <col width="80px">
							<?
							*/
							?>
                        </colgroup>
                        <thead>
                            <tr>
                                <th rowspan="3" scope="col">담보</th>
                                <th scope="col">구분</th>
							<?
								foreach($insu_plan_pot[$sinsu]['plan_title'] as $k=>$v){
								?>
                                <th scope="col"><?=$v?><br>(<?=$insu_plan_pot[$sinsu]['plan_start_age'][$k]?>-<?=$insu_plan_pot[$sinsu]['plan_end_age'][$k]?>)</th>
							<?
							}	
							?>
                            </tr>
                            <tr>
                                <th scope="col">연령</th>
								<?
								foreach($insu_plan_pot[$sinsu]['plan_code'] as $k=>$v){
								?>
                                <th scope="col"><?=$insu_plan_pot[$sinsu]['plan_start_age'][$k]?>~<?=$insu_plan_pot[$sinsu]['plan_end_age'][$k]?></th>
								<?
							}								
								
								?>
                            </tr>
                            <tr>
                                <th scope="col">선택</th>
								<?
								foreach($insu_plan_pot[$sinsu]['plan_code'] as $k=>$v){
								?>
                                <th scope="col">
								<input type="hidden" name="sel_plantype" value="<?=$insu_plan_pot[$sinsu]['plan_type'][$k]?>" />
								<input type="hidden" name="sel_plantitle" value="<?=$insu_plan_pot[$sinsu]['plan_title'][$k]?>" />
                                    <input type="radio" id="p<?=$k?>" name="sel_plancode" value="<?=$v?>">
									
									
                                    <label for="p<?=$k?>" class="radio_bx"><span></span></label>
                                </th>
							<?
								}								
								?>
                            </tr>
                        </thead>
                        <tbody>
						<?
						
							//var_dump($insu_type_pot);
								$span_cnt = count($insu_type_pot[$sinsu]);

								
								foreach($insu_type_pot[$sinsu] as $k=>$v){
									//echo "바보";
								//print_r($insu_plan_pot[$sinsu]['type_1']);
						?>
                            <tr style="background-color: #f6f6f6;">							
                                <td><?=$v['title'];?></td>
								<?
										if($k < 1){
								?>
                                <td rowspan="<?=$span_cnt?>" class="essential">필수</td>
								<?
									}
								?>
									<?
										foreach($insu_plan_pot[$sinsu]['type_'.($k+1)] as $m=>$n){	
								?>
                                 <td><?=number_format($insu_plan_pot[$sinsu]['type_'.($k+1)][$m])?></td>
								<?
									}
								?>                               
                            </tr>
							<?
								}
							?>
                        </tbody>
                    </table>
                </div>
            </div><!-- e : pop_body -->
            <div class="pop_foot f_plan">
                <p>※ 플랜선택을 클릭하시고 저장을 클릭하시면  닫을 수 있습니다.</p>
                <button type="button" id="plan_save" class="btn_popup_apply w20">저장</button>
            </div>
        </div><!-- e : pop_con_inner -->
    </div>