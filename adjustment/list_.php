<? 
	include ("../include/top.php"); 

	if ($start_year=="") {
		$start_year=date("Y");
	}

	if ($end_year=="") {
		$end_year=date("Y");
	}

	if ($start_month=="") {
		$start_month="01";
	}

	if ($end_month=="") {
		$end_month="12";
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
							<div class="bbs_search_in" style="padding:0px; margin-bottom:5px; max-width:800px;">
								

								<div class="col-sm-2" style="max-width:570px; margin:0 auto;">
									<div class="select_ds pr20">
										<div class="col-sm-2">
											<div class="select_ds pr20" style="width:40%;">
												<select class="txtb" class="select" name="start_year">
												  <? for ($i=2019;$i<date("Y")+2;$i++) { ?>
												  <option value="<?=$i?>" <? if ($start_year==$i) { ?>selected<? } ?>><?=$i?></option>
												  <? } ?>
												</select>
												<span class="pa_minus">년</span>
											</div>
											<div class="select_ds pl10 pr20" style="width:30%;">
												<select class="txtb" class="select" id="start_month" name="start_month">
												  <? for ($i=1;$i<13;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($start_month==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">월</span>
											</div>

											<div class="select_ds pl10 pr20" style="width:30%;">
												<select class="txtb" class="select" id="start_day" name="start_day">
												  <? for ($i=1;$i<32;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($start_day==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">일</span>
											</div>
										</div>
										<span class="pa_minus">~</span>
									</div>
									<div class="select_ds pl10">
										<div class="col-sm-2">
											<div class="select_ds pr20" style="width:40%;">
												<select class="txtb" class="select" name="end_year">
												 <? for ($i=2019;$i<date("Y")+2;$i++) { ?>
												  <option value="<?=$i?>" <? if ($end_year==$i) { ?>selected<? } ?>><?=$i?></option>
												  <? } ?>
												</select>
												<span class="pa_minus">년</span>
											</div>
											<div class="select_ds pl10 pr20" style="width:30%;">
												<select class="txtb" class="select" id="end_month" name="end_month">
												  <? for ($i=1;$i<13;$i++) { ?>
												  <option value="<?=sprintf("%02d", $i)?>" <? if ($end_month==sprintf("%02d", $i)) { ?>selected<? } ?>><?=sprintf("%02d", $i)?></option>
												  <? } ?>
												</select>
											<span class="pa_minus">월</span>
											</div>

											<div class="select_ds pl10 pr20" style="width:30%;">
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
</form>

				</div>

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
$check_date_start=strtotime($start_year.$start_month.$start_day." 00:00:00");
$check_date_end=strtotime($end_year.$end_month.$end_day." 23:59:59");

/*
$check_date_end=strtotime($end_year.$end_month.date('t', strtotime($end_year.$end_month."01"))." 23:59:59");
$sql_sum="select 
		 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
	  from
		hana_plan a
		left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='".$check_date_start."' and b.change_date <='".$check_date_end."'
	  where
		a.member_no='".$row_mem_info['no']."'
	  group by c_date
	 ";
*/

$sql_sum="select 
		 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
	  from
		hana_plan a
		left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='".$check_date_start."' and b.change_date <='".$check_date_end."'
	  where
		a.member_no='".$row_mem_info['no']."'
	 ";
$result_sum=mysql_query($sql_sum);
while($row=mysql_fetch_array($result_sum)) {

?>
								<tr>
									<th><?=$row['c_date']?></th>
									<td><a href="view.php?check_date=<?=$row['check_date']?>"><?=number_format($row['all_change_price'])?> 원</a></td>
									<td><a href="view.php?check_date=<?=$row['check_date']?>"><?=number_format($row['all_real_change_price'])?></a></td>
									<td><a href="view.php?check_date=<?=$row['check_date']?>"><?=number_format($row['all_in_price'])?> 원</a></td>
									<td><a href="view.php?check_date=<?=$row['check_date']?>"><?=number_format($row['all_real_change_price']-$row['all_in_price'])?> 원</a></td>
									<td><a href="javascript:void();" onclick="window.open('invoice.php', 'invoice', 'width=900,height=650,left=100,top=0,scrollbars=yes')" class="btnTiny"><span><img src="../img/common/ico_fax.png" alt=""></span></a></td>
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


</body>

</html>
