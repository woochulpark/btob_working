<? 
	include ("../include/top.php"); 

if (!$page) $page = 1;
$num_per_page = 10;
$num_per_page_start = $num_per_page*($page-1);
$page_per_block = 10;

	$add_query =" and a.member_no ='{$_SESSION['s_mem_no']}'";	

	if($s_start_date != "" && $s_end_date != ""){

		if ($searchDate == 'endorse') {
			if ($s_start_date) {
				$s_date_r=strtotime($s_start_date." 000000");
				$add_query = $add_query." and d.change_date >='".$s_date_r."'";				
			}

			if ($s_end_date != '') {
				$e_date_r=strtotime($s_end_date." 235959");
				$add_query = $add_query." and a.change_date <='".$e_date_r."'";
			}
		} else if($searchDate == 'traStart') {
		
			if ($s_start_date != '') {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);
				$prt_s_date = $s_start_date.' '.$start_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.start_date,' ', a.start_hour) >='{$prt_s_date}'";

			}

			if ($s_end_date) {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);
				$prt_e_date = $s_end_date.' '.$end_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.start_date,' ', a.start_hour) <='{$prt_e_date}'";
			}
		} else if($searchDate == 'traEnd'){
			if ($s_start_date) {
				//$s_date_r=strtotime($s_start_date." ".$start_hour);

				$prt_s_date = $s_start_date.' '.$start_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.end_date,' ', a.end_hour) >='{$prt_s_date}'";
			}

			if ($s_end_date) {
				//$e_date_r=strtotime($s_end_date." ".$end_hour);

				$prt_e_date = $s_end_date.' '.$end_hour.':00:00';
				$add_query = $add_query." and CONCAT(a.end_date,' ', a.end_hour) <='{$prt_e_date}'";
			}
		} else if($searchDate == 'regDate'){
			if ($s_start_date) {
				$s_date_r=strtotime($s_start_date." 000000");

				$add_query = $add_query." and a.regdate >='".$s_date_r."'";
			}

			if ($s_end_date) {
				$e_date_r=strtotime($s_end_date." 235959");

				$add_query = $add_query." and a.regdate <='".$e_date_r."'";
			}
		}
	}

	if($search) {
		if($search_info == 'name') {
			$add_query .=" and c.name like '%$search%'";
		} elseif ($search_info=="join_name") {
			$add_query .=" and a.join_name like '%$search%'";
		} elseif($search_info == 'pjcode'){
			$add_query .=" and a.plan_join_code like '%$search%'";
		} elseif($search_info == 'citizenno'){
			$sJumin1 = encode_pass($search,$pass_key);
			$add_query .=" and c.jumin_1 =  '{$sJumin1}'";
		} elseif($search_info == 'subScription'){
			$add_query .=" and a.no like '%$search%'";
		}
	}

if($insu_ch_b){
	if($insu_ch == 'chInsurance'){
		$add_query .=" and a.insurance_comp = '{$insu_ch_b}' ";
	} else if($insu_ch == 'chTriptype'){
		$add_query .=" and a.trip_type = '{$insu_ch_b}' ";
	}
}		

 $sql="select a.no as plan_hana_no, a.plan_list_state, a.trip_type, a.plan_join_code, a.start_date, a.start_hour, a.end_date, a.end_hour, a.join_cnt, a.join_name,  c.*, c.no as mem_no, c.hphone, c.email,  d.change_date
from 
(select no from hana_plan_test) b join 
hana_plan_test a on b.no=a.no 
left join hana_plan_member_test c on a.no=c.hana_plan_no
left join hana_plan_change_test d on a.no=d.hana_plan_no
where 1=1
{$add_query}
group by a.no
order by a.no desc
	 ";
$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
$sql=$sql." limit $num_per_page_start, $num_per_page";
$result=mysql_query($sql) or die(mysql_error());
echo "<!--".$sql."-->";
$list_page=list_page($num_per_page,$page,$total_record);//function_query
$total_page	= $list_page['0'];
$first		= $list_page['1'];
$last		= $list_page['2'];
$article_num = $total_record - $num_per_page*($page-1);
?>
<script>
	var oneDepth = 3; //1차 카테고리
	var select_num = "";
	
	function f_pop(num){
		select_num=num;
		ViewlayerPop(0);
	}

	$(document).ready(function() {

		$("#start_date").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date",
			onClose: function( selectedDate ) {   		
				$("#end_date").val("");
				$("#end_date").datepicker("enable");
				$("#end_date").datepicker( "option", "minDate", new Date(Date.parse(selectedDate)) );
			}
		});

		$(" #end_date").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date"
		});			

		$("#end_date").datepicker("disable");
	});
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
						 <section id="container">
        <section id="h1">
            <h1>신청내역조회/수정</h1>
        </section>
        <form action="" name="applyform" method="" id="applyform">
        <fieldset>
            <section id="searchBox">
                <ul>
                    <li>
                        <select name="searchDate" id="searchDate">
                            <option value="" selected>날짜 검색</option>
                            <option value="endorse">청약일자</option>
                            <option value="traStart">여행 시작일</option>
                            <option value="traEnd">여행 종료일</option>
                        </select>
                    </li>
                    <li>
                        <div class="cld_wrap">
                            <span class="date_picker1">
                                <input type="text" id="start_date" name="s_start_date" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;" readonly><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                            </span>
                            <span>
                                <select name="start_hour" id="start_hour" class="nb">
                                    <? for ($i=0;$i<24;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>" <?=($start_hour == $i)? "selected":"";?>><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                               </select>
                            </span>
                        </div>
                        <div>~</div>
                        <div class="cld_wrap">
                            <span class="date_picker1">
                                <input type="text" id="end_date" name="s_end_date" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;" readonly><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                            </span>
                            <span>
                                <select name="end_hour" id="end_hour" class="nb">
                                     <? for ($i=1;$i<25;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>" <?=($end_hour == $i)? "selected":"";?>><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                               </select>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul>
                    <div>
                        <ul>
                            <li>
                                <select name="insu_ch" id="insu_ch">
                                    <option value="">보험관련 선택</option>
                                    <option value="chInsurance">보험사선택</option>
                                    <option value="chTriptype">여행지역선택</option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <select name="search_info" id="search_info">
									<option value="">보험정보선택</option>
                                    <option value="subScription">청약번호</option>
                                    <option value="join_name">대표피보험자명</option>
                                    <option value="citizenno">주민번호</option>
                                    <option value="pjcode">증권번호</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li>
                                <select name="insu_ch_b" id="insu_ch_b">
                                    <option value="">선택</option>                                  
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li><input type="text" id="search" name="search"></li>
                        </ul>
                    </div>
                    <div><button type="button" name="apply_search" class="btn_s1 search">검색</button></div>
                </ul>
            </section>
        </fieldset>
        </form>
		<?/*
        <div id="check_all">
            <button type="button" id="applicant_allbt" class="btn_s5">전체 선택</button>
            <button type="button" id="applicant_allnbt" class="btn_s5">전체 해제</button>
        </div>
		*/?>
        <section id="list_of-x">
            <table id="t_re_list">
                <caption>검색 결과</caption>
                <colgroup>
					<col width="40px">
                    <col width="140px">
                    <col width="140px">
                    <col width="80px">
                    <col width="100px">
                   <?// <col width="100px">?>
                    <col width="100px">
                    <col width="100px">
                    <col width="70px">
                    <col width="108px">
                    <col width="90px">
                    <col width="70px">
                </colgroup>
                <thead>
                    <tr>
                       <?// <th scope="col">선택</th>?>
					   <th scope="col">번호</th>
                        <th scope="col">청약번호</th>
                        <th scope="col">증권번호</th>
                        <th scope="col">진행상태</th>
                        <th scope="col">보험사</th>
                        <?//<th scope="col">보험상품</th>?>
                        <th scope="col">청약일</th>
                        <th scope="col">피보험자</th>
                        <th scope="col">총인원</th>
                        <th scope="col">시작/종료일</th>
                        <th scope="col">총보험료</th>
                        <th scope="col">결제여부</th>
                    </tr>
                </thead>
                <tbody>
				<?
					$w =1;
					$lcnt = 0;
					$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";


		$d_name=stripslashes($row['name']);
		

		$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['plan_hana_no']."'";
		$result_mem=mysql_query($sql_mem);
		while($row_mem=mysql_fetch_array($result_mem)) {

			if ($row_mem['plan_state']!='3') {
				$total_price=$total_price+$row_mem['plan_price'];
			}

			if ($row_mem['main_check']=='Y') {
				if ($row_mem['plan_state']=='3') {
					$d_name="<span style=\"text-decoration: line-through;\">".$row_mem['name']."</span>";
				} else {
					$d_name=$row_mem['name'];
				}

				$jumin_1=decode_pass($row_mem['jumin_1'],$pass_key);

				if ($row_mem['jumin_2']!='') {
					$jumin_2=decode_pass($row_mem['jumin_2'],$pass_key);

					$jumin_no=$jumin_1."- *******"; //.$jumin_2;
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
			}

			$total_cnt++;
		}


		if ($row['join_cnt']=="1") {
			$join_text=$d_name;
		} else {
			$join_text=$d_name." 외 ".($row['join_cnt']-1)."명";
		} 

		
		if ($row_mem_info['mem_type']=="1") {
		    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$plan_code."'");
		} else {
			if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
				if(time() > mktime(0,0,0,6,10,2020)){
						if($row['insurance_comp'] == 'S_1'){
							//DB손해보험
							$b2b_code_table = 'plan_code_btob_db';
						}

						if($row['insurance_comp'] == 'S_2'){
							//
							$b2b_code_table = 'plan_code_btob_ace';
						}
				} else {
					$b2b_code_table = 'plan_code_btob';
				}
			} else {
				$b2b_code_table = 'plan_code_mg';
			}
		    $plan_code_row=sql_one_one($b2b_code_table,"plan_title"," and plan_code='".$plan_code."'");
		}
		
		

		if ($row['nation_no']=="0") {
			$nation_text="국내";
		} else {
			$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
			$nation_text=stripslashes($nation_row['nation_name']);
		}
				?>
                    <tr>
                      <?/*  <td>
                            <input type="checkbox" id="n<?=$w?>" name="appli_nob[]" value="" />
                            <label for="n<?=$w?>" class="check_bx"><span></span></label>
                        </td>
					*/?>
						<td><?=$article_num?></td>
                        <td class="nb"><a href="/check/view.php?num=<?=$row['plan_hana_no']?><?=($_SERVER["QUERY_STRING"] != '')?"&".$_SERVER["QUERY_STRING"]:'';?>"><?=$row['plan_hana_no']?></a></td>
                        <td class="nb"><?=$row['plan_join_code']?></td>
                        <td class="<?=($row['plan_list_state'] == '6')? 'complete':'cancel';?>">
							<?
									switch($row['plan_list_state']){
										case '1':
											echo "결제완료";
										break;
										case '2':
											echo "취소접수";
										break;
										case '3':
											echo "취소완료";
										break;
										case '4':
											echo "수정접수";
										break;
										case '5':
											echo "수정완료";
										break;
										case '6':
											echo "청약완료";
										break;
										case '7':
											echo "청약대기1";
										break;
										case '8':
											echo "청약대기2";
										break;
										case '9':
											echo "청약대기3";
										break;
									}
							?>						
						</td>
                        <?//<td>DB손해보험</td>?>
                        <td>
								<?
									if($row['insurance_comp'] != ''){
											switch($row['insurance_comp']){
												case 'S_1':
													echo 'DB손해보험';
												break;
												case 'S_2':
													echo 'CHUBB';
												break;
											}
									}  else {
										echo '';
									}
								?>
						</td>
                        <td class="nb"><?=date("Y-m-d",$row['change_date'])?></td>
                        <td><?=$row['join_name']?></td>
                        <td ><span class="nb"><?=number_format($row['join_cnt'])?></span>명</td>
                        <td class="nb"><?=$row['start_date']?><br><?=$row['end_date']?></td>
                        <td class="nb c_black"><?=number_format($total_price)?></td>
                        <td class="c_blue"><?=($row['plan_list_satate'] != '1')? 'NO':'YES';?></td>
                    </tr>
					<?
						$w++;
				$article_num--;
						}
					
					?>
                </tbody>
            </table>
        </section>
        <section id="btn_area_list">
            <div>
                <!--button type="button" name="button" class="btn_s2" id="endorse">배서 목록</button-->
                <button type="button" name="excel_down" class="btn_download">엑셀 다운로드</button>
            </div>
        </section>
		<?

			$where = "&search_info=$search_info";
			$where .= "&search=$search";
			$where .= "&insu_ch=$insu_ch";
			$where .= "&insu_ch_b=$insu_ch_b";
			$where .= "&searchDate=$searchDate";
			$where .= "&s_start_date=$s_start_date";
			$where .= "&s_end_date=$s_end_date";

		b2b_list_page_numbering_div($page_per_block,$page,$total_page,$where);
		/*
        <section id="paging">
            <a href="#" class="arrow first" id=""><span>첫페이지</span></a>
            <a href="#" class="arrow prev" id=""><span>이전페이지</span></a>
            <span class="num">
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#" class="on">8</a>
                <a href="#">9</a>
                <a href="#">10</a>
            </span>
            <a href="#" class="arrow next" id=""><span>다음페이지</span></a>
            <a href="#" class="arrow last" id=""><span>마지막페이지</span></a>
        </section>
		*/?>
    </section><!-- e : container -->

	<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<script>	
	$(document).ready(function(){
		$('button[name=excel_down]').on('click',function(){
			var cnt_get = <?=count($_GET)?>;
			if(Number(cnt_get) > 0){			
				var opt_loca = '<?=$_SERVER["QUERY_STRING"]?>';
			location.href='./excel_download.php?'+opt_loca;
			} else {
				alert('내역을 조회 후 다운로드가 가능합니다.');
				return false;
			}
		});

	/*
		$('button[name=excel_down]').on('click',function(){
			var search_stdate;
			var search_eddate;
			var search_sel;
			var search_text;

			location.href='./excel_download.php?start_date='+search_stdate+'&end_date='+search_eddate+'&make='+search_sel+'&search='+search_text;
		});
*/
		$('#endorse').on('click',function(){
			location.href='/check/endorse_list.php';
		});
		
		$('#insu_ch').on('change',function(){
			var ch_val;
			ch_val = $(this).val();
			console.log(ch_val);
			if(ch_val == 'chInsurance'){//보험사선택
				var aa = new Object();				
				aa = {"":"선택",S_1:"DB손해보험", S_2:"CHUBB"};
				$('#insu_ch_b').empty();
				for(var prop in aa){
					$('#insu_ch_b').append($("<option></option>").attr("value",prop).text(aa[prop]));
				} 
			} else if(ch_val == 'chTriptype') {//해외,국내
				var bb = new Object();
				bb = {'0':"선택",'1':"국내", '2':"해외"};
				$('#insu_ch_b').empty();
				for(var prop in bb){				
					$('#insu_ch_b').append($("<option></option>").attr("value",prop).text(bb[prop]));
				} 
					$('#insu_ch_b option:eq(0)').attr('value','').text('선택');
			} else {
				$('#insu_ch_b').empty();				
				$('#insu_ch_b').append($("<option></option>").attr("value",'').text('선택'));
			}
		});

		$('button[name=apply_search]').on('click',function(){
			
			var aa = $('#searchDate option:selected').val();
			var bb = $('#insu_ch option:selected').val();
			var cc = $('#search_info option:selected').val();

			if(aa != ''){
				var st_date = $('#start_date').val();
				var ed_date = $('#end_date').val();
				if(st_date == '' || ed_date == ''){
					alert('검색 일자를 선택해주세요.');					
					return false;
				}
			}

			if(bb != ''){
				var insuran_ch = $('#insu_ch_b option:selected').val();
				if(insuran_ch == ''){
					alert('보험 관련 검색을 입력하세요.');
					return false;
				}
			}

			if(cc != ''){
				var search_val = $('#search').val();
				if(search_val == ''){
					alert('보험정보를 입력하세요.');
					return false;
				}
			}

			$('#applyform').submit();
		});	

	}); //end ready
</script>

</body>
<script type="text/javascript" src="/js/applicant_list.js"></script>
</html>
