<? 
	include ("../include/top.php"); 

	if ($start_year=="") {
		$start_year=date("Y");
	}

	if ($start_month=="") {
		$start_month=date("m");
	}

	if ($start_day=="") {
		$start_day="01";
	}

	if ($end_day=="") {
		$end_day=date("d");
	}
?>
<script>
	var oneDepth = 2; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">

				<div class="bbs_search">
<form method="get" action="<?=$PHP_SELF?>" name="form1">
						<fieldset>
							<legend>게시물 검색</legend>
							<div class="bbs_search_in" style="padding:0px; margin-bottom:5px; max-width:630px;">
								

								<div class="col-sm-2" style="max-width:470px; margin:0 auto;">
									<div class="select_ds pr20" style="width:100%;">
										<div class="col-sm-2">
											<div class="select_ds pr20" style="width:30%;">
												<select class="txtb" class="select" name="start_year">
												  <? for ($i=2019;$i<date("Y")+2;$i++) { ?>
												  <option value="<?=$i?>" <? if ($start_year==$i) { ?>selected<? } ?>><?=$i?></option>
												  <? } ?>
												</select>
												<span class="pa_minus">년</span>
											</div>
											<div class="select_ds pl10 pr20" style="width:20%;">
												<select class="txtb" class="select" id="start_month" name="start_month">
												  <? for ($i=1;$i<13;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($start_month==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">월</span>
											</div>

											<div class="select_ds pl10 pr20" style="width:20%;">
												<select class="txtb" class="select" id="start_day" name="start_day">
												  <? for ($i=1;$i<32;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($start_day==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">일</span>
											</div>
											
											<div class="select_ds pl15 pr15" style="width:5%;margin-top:10px;">~</div>

											<div class="select_ds pl10 pr20" style="width:20%;">
												<select class="txtb" class="select" id="end_day" name="end_day">
												  <? for ($i=1;$i<32;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($end_day==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">일</span>
											</div>

										</div>
										

										
									</div>
	
									<input class="btn_search" type="button" value="검색" onclick="document.form1.submit();">
								</div>
							</div>
					</fieldset>
					<?php
								if($_SESSION['s_mem_id'] == 'hyecho_b2b' ||  $_SESSION['s_mem_id'] == 'followme_b2b'){
									echo "<div style='padding-top:10px;'><button type='button' class='btn_search' id='excel_adjust_hyecho'>엑셀저장</button></div>";	
								}
							?>
</form>

				</div>

	*정산대금 입금방식 : 당월1일 ~ 당월 말일 정산대금 익월 21일 지정된 계좌로 입금 (영업일기준) 

				<div class="table_overflow mt20">
					<div class="table_line2 overlayer">
						<table class="board-list">
							<colgroup>
								<col width="%">
								<col width="16%">
								<col width="16%">
								<col width="16%">
								<col width="16%">
								<col width="10%">
							</colgroup>
							<tbody>
								<tr>
									<th>년월</th>
									<th>보험료</th>
									<th>할인보험료</th>
									<th>선결제</th>
									<th>입금금액</th>
									<th>인쇄</th>
								</tr>
<?
//$check_date_start=strtotime($start_year.$start_month.$start_day." 00:00:00");
//$check_date_end=strtotime($start_year.$start_month.$end_day." 23:59:59");
if($_SESSION['s_mem_id'] == 'hyecho_b2b' ||  $_SESSION['s_mem_id'] == 'followme_b2b'){
$check_date_start= $start_year."-".$start_month."-".$start_day;
$check_date_end= $start_year."-".$start_month."-".$end_day;
} else {
	$check_date_start=strtotime($start_year.$start_month.$start_day." 00:00:00");
$check_date_end=strtotime($start_year.$start_month.$end_day." 23:59:59");
}
if($_SESSION['s_mem_id'] == 'hyecho_b2b' ||  $_SESSION['s_mem_id'] == 'followme_b2b'){
	$sql_sum="select 
		 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
	  from
		hana_plan a
		left join hana_plan_change b on a.no=b.hana_plan_no and a.start_date >='".$check_date_start."' and a.start_date <='".$check_date_end."'
	  where
		a.member_no='".$row_mem_info['no']."' and b.change_date!=''
		";
} else {
$sql_sum="select 
		 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
	  from
		hana_plan a
		left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='".$check_date_start."' and b.change_date <='".$check_date_end."'
	  where
		a.member_no='".$row_mem_info['no']."' and b.change_date!=''
	 ";
}



//echo $sql_sum;
$result_sum=mysql_query($sql_sum);
$row=mysql_fetch_array($result_sum);
	if ($row['c_date']!='') { 
?>
								<tr>
									<th><?=$row['c_date']?></th>
									<td><a href="view.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>"><?=number_format($row['all_change_price'])?> 원</a></td>
									<td><a href="view.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>"><?=number_format($row['all_real_change_price'])?> 원</a></td>
									<td><a href="view.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>"><?=number_format($row['all_in_price'])?> 원</a></td>
									<td><a href="view.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>"><?=number_format($row['all_real_change_price']-$row['all_in_price'])?> 원</a></td>
									<td><a href="javascript:void();" onclick="window.open('invoice.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>', 'invoice', 'width=900,height=650,left=100,top=0,scrollbars=yes')" class="btnTiny"><span><img src="../img/common/ico_fax.png" alt=""></span></a></td>
								</tr>
<?
	}
?>
							</tbody>
						</table>
					</div>
				</div>

			

		</div>

	</div>
	<!-- //container -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#excel_adjust_hyecho').on('click',function(){		
			$('form[name=form1]').attr('method','post');
			$('form[name=form1]').attr('action','./adjuste_excel_report.php');	
			$('form[name=form1]').submit();
			$('form[name=form1]').attr('action','/adjustment/list.php');	
		});	
	});


</script>

</body>

</html>
