<? 
	include ("../include/top.php"); 
	
	$val_list = "page=".$page."&make=".$make."&search=".$search."&start_date=".$start_date."&end_date=".$end_date;

	$vi_q="select * from hana_plan where no='".$num."' and member_no='".$row_mem_info['no']."'";
	$vi_e=mysql_query($vi_q);
	$row=mysql_fetch_array($vi_e);

	if ($row['no']=="") {
?>
<script>
	alert('잘못된 접속 입니다.');
	history.go(-1);
</script>
<?
		exit;
	}

	if ($row['nation_no']=="0") {
		$nation_text="국내";
	} else {
		$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
		$nation_text=stripslashes($nation_row['nation_name']);
	}

	$sql_mem="select 
			*
		  from
			hana_plan_member
		  where
			hana_plan_no='".$num."'
			and main_check='Y'
		 ";
	$result_mem=mysql_query($sql_mem);
	$row_mem=mysql_fetch_array($result_mem);

	if ($row_mem_info['mem_type']=="1") {
	    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$row_mem['plan_code']."'");
	} else {
	    $plan_code_row=sql_one_one("plan_code_btob","plan_title"," and plan_code='".$row_mem['plan_code']."'");
	}
	
?>
<script>
	var oneDepth = 3; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? //include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<ul class="step4_step three">
					<li>
						<div class="box">보험기간<span class="ico"><img src="../img/pages/step4_ico07.png" alt=""></span>
							<p class="table"><span class="point_c"><span class="ib"><?=date("Y년 m월 d일",strtotime($row['start_date']))?> <?=$row['start_hour']?>시 ~ </span><span class="ib"><?=date("Y년 m월 d일",strtotime($row['end_date']))?> <?=$row['end_hour']?>시</span></span></p>
						</div>
					</li>
					<li>
						<div class="box">여행지 <span class="ico"><img src="../img/pages/step4_ico03.png" alt=""></span>
							<p class="table"><span class="point_c"><?=$nation_text?> </span></p>
						</div>
					</li>

					<li>
						<div class="box">보험상품<span class="ico"><img src="../img/pages/step4_ico06.png" alt=""></span>
							<p class="table">
							<?
								if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
							?>
							<span class="point_c">CHUBB <?=$type_array[$row['trip_type']]?> <?=stripslashes($plan_code_row['plan_title'])?></span>
							<?
								} else {
							?>
							<span class="point_c">MG손해보험</span>
							<?
								}
							?>
							</p>
						</div>
					</li>
				</ul>

				<h3 class="s_tit">피보험자 정보</h3>
				<div class="table_overflow">

					<div class="table_line2 overlayer">
						<table class="board-list" style="min-width:1000px;">
							<colgroup>
								<!--col class="w_cell" width="3%"-->
								<col width="70px" />
								<col width="110px" />
								<col width="110px" />
								<col width="85px" />
								<col width="85px" />
								<col width="90px" />
								<col width="120px" />
								<col width="90px" />
							</colgroup>
							<thead>
								<tr>
									<th class="w_cell">NO</th>
									<th>진행상태</th>
									<th>대표피보험자(신청자)</th>
									<!--th>피보험자 주민등록번호</th-->
									<th>보험나이</th>
									<!--th>휴대폰번호</th-->
									<th>이메일</th>
									<th>플랜명</th>
									<th>보험금액</th>
									<th>가입확인서</th>
								</tr>
							</thead>
							<tbody>
<?
	$i=1;

	$sql_mem="select 
		*
	  from
		hana_plan_member
	  where
		hana_plan_no='".$num."'
	  order by main_check desc
	 ";
	$result_mem=mysql_query($sql_mem);
	while($row_mem=mysql_fetch_array($result_mem)) {
?>
								<tr>
									<td class="w_cell"><?=$i?></td>
									<td><span class="<?=$plan_state_text_class_array[$row_mem['plan_state']]?>"><?=$plan_state_text_array[$row_mem['plan_state']]?></span></a></td>
									<td><?=stripslashes($row_mem['name'])?> <? if ($row_mem['main_check']=="Y") { ?>(대표)<? } ?></td>
									<!--td><?//=decode_pass($row_mem['jumin_1'],$pass_key)?><? if ($row_mem['jumin_2']!='') { ?> - <?//=decode_pass($row_mem['jumin_2'],$pass_key)?><? } ?></td-->
									<td><?=stripslashes($row_mem['age'])?>세</td>
									<!--td><? if ($row_mem['hphone']!='') { ?><?//=decode_pass($row_mem['hphone'],$pass_key)?><? } ?></td-->
									<td><? if ($row_mem['email']!='') { ?><?=decode_pass($row_mem['email'],$pass_key)?><? } ?></td>
									<td><?=stripslashes($row_mem['plan_code'])?> - <?=stripslashes($row_mem['plan_title'])?></td>
									<td><strong class="point_c"><?=number_format($row_mem['plan_price'])?>원</strong></td>
									<td>
									<? if ($row_mem['plan_state']!="2" && $row_mem['plan_state']!="3") { ?>
										<p class="pt5"><a href="javascript:void(0);" onclick="window.open('../check/confirmation.php?num=<?=$row_mem['no']?>', 'confirmation', 'width=900,height=650,left=100,top=0,scrollbars=yes')" class="btnNormal radius"><span class="f095">확인</span></a></p>
									<? } ?>
									</td>	
								</tr>
<?
		$i++;
	}
?>

								
							</tbody>
						</table>
					</div>
				</div>

				<div class="btn-tc"> <a href="javascript:window.close();" class="btnStrong m_block "><span>닫기</span></a> </div>

			</div>
<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? //include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>

</html>
