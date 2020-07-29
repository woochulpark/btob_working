<? 
	include ("../include/top.php"); 

if (!$page) $page = 1;
$num_per_page = 10;
$num_per_page_start = $num_per_page*($page-1);
$page_per_block = 5;

	$add_query .=" and a.member_no ='{$_SESSION['s_mem_no']}'";	

	if($s_start_date != "" && $s_end_date != ""){

		if ($searchDate == 'reqDate') {
			
			if ($s_start_date != '') {
				
				$prt_s_date = strtotime($s_start_date.' '.$start_hour.':00:00');
				$add_query = $add_query." and a.regdate >='{$prt_s_date}'";

			}

			if ($s_end_date != '') {
				
				$prt_e_date = strtotime($s_end_date.' '.$end_hour.':00:00');
				$add_query = $add_query." and a.regdate <='{$prt_e_date}'";
			}

		} else if($searchDate == 'confDate') {

			if ($s_start_date != '') {
				
				$prt_s_date = strtotime($s_start_date.' '.$start_hour.':00:00');
				$add_query = $add_query." and a.confirm_regdate >='{$prt_s_date}'";

			}

			if ($s_end_date != '') {
				
				$prt_e_date = strtotime($s_end_date.' '.$end_hour.':00:00');
				$add_query = $add_query." and a.confirm_regdate <='{$prt_e_date}'";
			}

		}
	}


	if($search) {
		if($search_info == 'subscNo') {
			$add_query .=" and b.no like '%$search%'";
		} elseif ($search_info=="stockNo") {
			$add_query .=" and a.plan_join_code like '%$search%'";
		} elseif($search_info == 'citizenno'){
			$sJumin1 = encode_pass($search,$pass_key);
			$add_query .=" and a.jumin_1 =  '{$sJumin1}'";
		} elseif($search_info == 'contractName'){
			$add_query .=" and b.join_name like '%$search%'";
		} 
	}

if($insu_ch_b){
	if($insu_ch == 'chState'){
		$add_query .=" and a.change_state = '{$insu_ch_b}' ";
	} else if($insu_ch == 'chInsurance'){
		$add_query .=" and b.insurance_comp = '{$insu_ch_b}' ";		
	}
}		

 $sql="select 
		a.no as num, a.regdate as req_regdate, a.content, a.jumin_1 as jumin_front, a.jumin_2 as jumin_back, a.change_state, b.no as plan_hana_no, b.insurance_comp, b.plan_join_code, b.join_name, b.join_cnt, c.jumin_1, c.jumin_2, c.no as mem_no, c.hphone, c.email
	  from
		hana_plan_request a
		left join hana_plan b on a.plan_no=b.no
		left join hana_plan_member c on b.no=c.hana_plan_no
	  where
		1 ".$add_query."
	  group by b.no
	  order by a.no desc
	 ";
	
$result=mysql_query($sql);

$total_record=mysql_num_rows($result);
$sql=$sql." limit $num_per_page_start, $num_per_page";
$result=mysql_query($sql) or die(mysql_error());
//echo "<!--".$sql."-->";
$list_page=list_page($num_per_page,$page,$total_record);//function_query
$total_page	= $list_page['0'];
$first		= $list_page['1'];
$last		= $list_page['2'];
$article_num = $total_record - $num_per_page*($page-1);
?>
<script>
	var oneDepth = 3; //1차 카테고리
	var select_num = "";

	function request_view(num) {

		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/plan_request_view.php",
			data :  { "num" : num , "auth_token" : auth_token},
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					ViewlayerPop(0);
					$("#content_pop").html(json.msg);
					$("#loading_area").delay(300).fadeOut();
					return false;
				} else {
					alert(json.msg);
					$("#loading_area").delay(100).fadeOut();
					return false;
				}
				
			},
			error : function(err)
			{
				alert(err.responseText);
				$("#loading_area").delay(100).fadeOut();
				return false;
			}
		});
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
			buttonText: "Select date"        
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

	});
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- s : container -->
    <section id="container">
        <section id="h1">
            <h1>배서목록</h1>
        </section>
        <form action="" method="" id="applyform">
        <fieldset>
            <section id="searchBox">
                <ul>
                    <li>
                         <select name="searchDate" id="searchDate">
                            <option value="">일자 선택</option>
                            <option value="reqDate">요청일자</option>
                            <option value="confDate">처리일자</option>
                        </select>
                    </li>
                    <li>
                        <div class="cld_wrap">
                            <span class="date_picker1">
                                <input type="text" id="start_date" name="s_start_date" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;"><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                            </span>
                            <span>
                                <select name="start_hour" id="start_hour" class="nb">
                                     <? for ($i=0;$i<24;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                               </select>
                            </span>
                        </div>
                        <div>~</div>
                        <div class="cld_wrap">
                            <span class="date_picker1">
                                <input type="text" id="end_date" name="s_end_date" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;"><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                            </span>
                            <span>
                                <select name="end_hour" id="end_hour" class="nb">
                                     <? for ($i=1;$i<25;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
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
                                    <option value="">기타선택</option>									
                                    <option value="chState">진행여부</option>
									 <option value="chInsurance">보험사 선택</option>                                    
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <select name="search_info" id="search_info">
									<option value="">보험정보선택</option>
                                    <option value="subscNo">청약번호</option>
	                                <option value="stockNo">증권번호</option>
                                    <option value="citizenno">대표주민번호앞자리</option>
                                    <option value="contractName">계약자명</option>
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
        <section id="of-x">
            <table id="t_re_list">
                <caption>검색 결과</caption>
                <colgroup>
                    <col width="40px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="150px">
                    <col width="90px">
                    <col width="310px">
                    <col width="90px">
                    <col width="130px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">요청일자</th>
                        <th scope="col">보험사</th>
                        <th scope="col">진행여부</th>
                        <th scope="col">증권번호</th>
                        <th scope="col">청약번호</th>
                        <th scope="col">메모</th>
                        <th scope="col">계약자명</th>
                        <th scope="col">주민등록번호</th>
                    </tr>
                </thead>
                <tbody>
				<?
					while($rows= mysql_fetch_array($result)){
						if($rows['jumin_1'] != '' && $rows['jumin_2'] != ''){
							$juminNo = decode_pass($rows['jumin_1'],$pass_key)."-*******";//.decode_pass($rows['jumin_2'],$pass_key);
						} else {
							$juminNo = '없음';
						}
						
				?>
                    <tr>
                        <td class="nb"><?=$article_num?></td>
                        <td class="nb"><?=date("Y-m-d",$rows['req_regdate'])?></td>
                        <td><?
									
									foreach($insuran_option as $k=>$v){
										if($v == $rows['insurance_comp']){
											echo $k;
										} else {
											$m = "&nbsp;";
										}
									}
									?>
						</td>
                        <td class="complete"><?=$change_state_array[$rows['change_state']]?></td>
                        <td class="nb"><?=$rows['plan_join_code']?></td>
                        <td><a href="/check/view.php?num=<?=$rows['plan_hana_no']?>" ><?=$rows['plan_hana_no']?></a></td>
                        <td class="t_left"><?=stripslashes($rows['content'])?></td>
                        <td><?=$rows['join_name']?></td>
                        <td class="nb"><?=$juminNo?></td>
                    </tr>
					<?
								$article_num--;
							}
				
					?>
                </tbody>
            </table>
        </section> 
        <section id="btn_area_list">
            <div><button type="button" name="excel_down" class="btn_download">엑셀 다운로드</button></div>
        </section>
      <? 
		$where = "&search_info=$search_info";
			$where .= "&search=$search";
			$where .= "&insu_ch=$insu_ch";
			$where .= "&insu_ch_b=$insu_ch_b";
			$where .= "&searchDate=$searchDate";
			$where .= "&s_start_date=$s_start_date";
			$where .= "&s_end_date=$s_end_date";
	  
	  b2b_list_page_numbering_div($page_per_block,$page,$total_page,$where); ?>
    </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<div id="layerPop0" class="layerPop" style="display:none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title">수정</p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
					<div id="content_pop" style="width:100%;"></div>

					<div class="btn-tc">
						<a href="javascript:void(0);" onclick="CloselayerPop();" class="btnNormal m_block"><span>닫기</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>	
	$(document).ready(function(){
		$('button[name=excel_down]').on('click',function(){
			var cnt_get = <?=count($_GET)?>;
			if(Number(cnt_get) > 0){			
				var opt_loca = '<?=$_SERVER["QUERY_STRING"]?>';
			location.href='./excel_download_endorse.php?'+opt_loca;
			} else {
				alert('내역을 조회 후 다운로드가 가능합니다.');
				return false;
			}
		});


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
				$('#insu_ch_b option:eq(0)').attr('value','').text('선택');
			} else if(ch_val == 'chState') {//진행여부
				var bb = new Object();
				bb = {'0':'선택',<?
							$prt_obj = "";
							$arrcnt = count($change_state_array);
							
						foreach($change_state_array as $k=>$v){
							
							if($k < 3 ){
								$prt_obj .=  "'".$k."':'".$v."',";
							} else {
								$prt_obj .=  "'".$k."':'".$v."'";
							}

						}
						echo $prt_obj; 
				?>};
				$('#insu_ch_b').empty();
				for(var prop in bb){		
					console.log(prop);
					if(prop == 0){
						propv = '';
					} else {
						propv = prop;
					}
						$('#insu_ch_b').append($("<option></option>").attr("value",propv).text(bb[prop]));
					
				} 
					//$('#insu_ch_b option:eq(0)').attr('value','').text('선택');
					
			} else {
				$('#insu_ch_b').empty();		
				$('#insu_ch_b').append($("<option></option>").attr("value","").text('선택'));
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
					if(aa == 'reqDate'){
						alert('요청일자를 선택해주세요.');					
						return false;
					} else if(aa == 'confDate'){
						alert('처리일자를 선택해주세요.');					
						return false;
					}
				}
			} else {
				if(st_date == '' || ed_date == ''){
					alert('일자를 선택해주세요.');					
					return false;
				}
			}

			if(bb != ''){
				var insuran_ch = $('#insu_ch_b option:selected').val();
				if(insuran_ch == ''){
					if(bb == 'chState'){
						alert('진행 여부를 선택하세요.');
						return false;
					} else if(bb == 'chInsurance'){
						alert('보험사를 선택하세요.');
						return false;
					}
				}
			} else {
				if(insuran_ch == ''){
					 alert('기타정보를 선택해주세요.');					
					 return false;
				}
			}

			if(cc != ''){
				var search_val = $('#search').val();
				if(search_val == ''){
					if(cc =='subscNo'){
						alert('청약번호를 입력하세요.');
						return false;
					} else if(cc == 'stockNo'){
						alert('증권번호를 입력하세요.');
						return false;
					} else if(cc == 'citizenno'){
						alert('대표주민번호앞자리를 입력하세요.');
						return false;
					} else if(cc == 'contractName'){
						alert('계약자명을 입력하세요.');
						return false;
					}
				}
			} else {
				if(search_val == ''){
					alert('보험정보를 선택해주세요.');					
					return false;
				}
			}

			$('#applyform').submit();
		});	

	}); //end ready
</script>
</body>
</html>
