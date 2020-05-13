<? 
	include ("../include/top.php"); 

	
	$sql_sum="select 
			 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
		  from
			hana_plan a
			left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='".$check_start."' and b.change_date <='".$check_end."'
		  where
			a.member_no='".$row_mem_info['no']."'
		 ";
	$result_sum=mysql_query($sql_sum);
	$row=mysql_fetch_array($result_sum);
?>
<script>
function f_print(){
	$(".btn-tc").hide();
	$("#wrap").addClass("print_wrap");
	window.print();
	setTimeout(function () {
		$("#wrap").removeClass("print_wrap");
		$(".btn-tc").show();
	}, 100);
}

</script>
<style>
#wrap.print_wrap {width: 21cm; min-height: 29.7cm; padding:0; margin: 0 auto; zoom:100%}
@page {size: A4; margin: 0;}

@media print {
    html, body {width: 210mm; height: 297mm; background:none;}
    #wrap.print_wrap {margin: 0; border: initial; width: initial; min-height: initial; box-shadow: initial; background: initial; page-break-after: always;}

}
</style>
    <div id="wrap" class="invoice_wrap">
        <div id="inner_wrap">
            <!-- container -->
            <div id="container">
				<ul class="invoice_top">
					<li>주식회사 투어세이프<br>보험대리점<br>03176 서울시 종로구 <br>경희궁1길18  2층</li>
					<li>Toursafe Co., Ltd	<br>Insurance Company<br>2nd  Fl.,18,Gyeonghuigung 1gil,<br> Jongro-gu,  Seoul 03176, Korea</li>
					<li>대표번호: +82 2 2088 1891~6<br>직통번호: 1800 9010    <br> www.toursafe.co.kr</li>
				</ul>

                <h1 class="sub_tit"><img src="../img/common/logo.png" alt="투어세이프 여행자보험"><br>INVOICE</h1>
				<p class="date">Date: <?=date("Y-m-d")?></p>
				<div class="table_two">
					<div class="table_wrap">
						<div class="table_line">
							<table cellspacing="0" cellpadding="0" summary="회원정보입력" class="board-write ">
								<caption>
									기본정보
								</caption>
								<colgroup>
									<col class="m_th" width="120px;">
									<col width="%;">
								</colgroup>
								<tbody>
									<tr>
										<th>수신 </th>
										<td><?=stripslashes($row_mem_info['com_name'])?></td>
									</tr>
									<tr>
										<th> </th>
										<td></td>
									</tr>
									<tr>
										<th> </th>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="table_wrap">
						<div class="table_line">
							<table cellspacing="0" cellpadding="0" summary="회원정보입력" class="board-write ">
								<caption>
									기본정보
								</caption>
								<colgroup>
									<col class="m_th" width="120px;">
									<col width="%;">
								</colgroup>
								<tbody>
									<tr>
										<th>발신  </th>
										<td>㈜투어세이프 </td>
									</tr>
									<tr>
										<th>이메일</th>
										<td>toursafe@bis.co.kr</td>
									</tr>
									<tr>
										<th>연락처  </th>
										<td>02-2088-1672<br>(정산담당: 임우리차장)</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
               
				<p style="line-height:150%; padding:20px 0px;">귀 사의 무궁한 발전을 기원합니다.<br>
당 월 정산 상세내역은 첨부를 참고 해 주시고, 해당 금액을 입금 부탁 드립니다.
</p>

               <div class="table_line">
					<table cellspacing="0" cellpadding="0" summary="회원정보입력" class="table_style1">
						<caption>
							기본정보
						</caption>
						<colgroup>
							<col width="50%;">
							<col width="%;">
						</colgroup>
						<tbody>
							<tr>
								<th>총보험료  </th>
								<td><?=number_format($row['all_change_price'])?> 원</td>
							</tr>
							<tr>
								<th>할인보험료(총보험료-협정요율)  </th>
								<td><?=number_format($row['all_real_change_price'])?> 원</td>
							</tr>
							<tr>
								<th>선결제</th>
								<td><?=number_format($row['all_in_price'])?> 원</td>
							</tr>
							<tr class="total">
								<th>입금하실 금액</th>
								<td><?=number_format($row['all_real_change_price']-$row['all_in_price'])?> 원</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h3 class="s_tit">입금계좌정보</h3>

				<div class="br_box">
					<ul class="bul02">
						<li>은행: <strong>국민은행</strong></li>
						<li>계좌번호: <strong> <strong>023501-04-230715</strong>  (예금주: 주식회사 투어세이프)</strong></li>
					</ul>
					<p class="pt5">※ 입금하신 내역이 있으시면 연락 주시기 바랍니다.</p>
				</div>
 
            </div>
				<div class="btn-tc"> <a href="javascript:void(0);" onclick="f_print();" class="btnStrong m_block "><span>인쇄</span></a> </div>
        </div>
        <!-- //container -->
    </div>
    <!-- //wrap -->



    </body>

    </html>
