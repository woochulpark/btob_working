<? 
	include ("../include/top.php"); 

if (!$page) $page = 1;
$num_per_page = 10;
$num_per_page_start = $num_per_page*($page-1);
$page_per_block = 5;

	$add_query .=" and a.member_no ='".$row_mem_info['no']."'";	

	if ($start_date!='') {
		$s_date_r=strtotime($start_date." 000000");

		$add_query = $add_query." and a.regdate >='".$s_date_r."'";
	}

	if ($end_date!='') {
		$e_date_r=strtotime($end_date." 235959");

		$add_query = $add_query." and a.regdate <='".$e_date_r."'";
	}

	if($search) {
		if($make == 'name') {
			$add_query .=" and b.name like '%$search%'";
		} elseif ($make=="join_name") {
			$add_query .=" and a.join_name like '%$search%'";
		}
	}

 $sql="select 
		*, a.no as plan_hana_no, b.no as mem_no, b.hphone, b.email
	  from
		hana_plan a
		left join hana_plan_member b on a.no=b.hana_plan_no
	  where
		1 ".$add_query."
	  group by a.no
	  order by a.no desc
	 ";
$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
$sql=$sql." limit $num_per_page_start, $num_per_page";
$result=mysql_query($sql) or die(mysql_error());

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
        <form action="" method="" id="formBox">
        <fieldset>
            <section id="searchBox">
                <ul>
                    <li>
                        <select name="" id="">
                            <option value="" selected>날짜 검색</option>
                            <option value="">청약일자</option>
                            <option value="">여행 시작일</option>
                            <option value="">여행 종료일</option>
                        </select>
                    </li>
                    <li>
                        <div class="cld_wrap">
                            <span class="date_picker1">
                                <input type="text" id="start_date" name="" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;"><!-- class="ui-datepicker-trigger hasDatepicker" -->
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
                                <input type="text" id="end_date" name="" value="" style="border:0px;height:26px;padding:0px 5px 0px 5px;"><!-- class="ui-datepicker-trigger hasDatepicker" -->
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
                                <select name="" id="">
                                    <option value="">보험사 선택</option>
                                    <option value="">DB손해보험</option>
                                    <option value="">에이스보험</option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <select name="" id="">
                                    <option value="">청약번호</option>
                                    <option value="">피보험자명</option>
                                    <option value="">주민번호</option>
                                    <option value="">증권번호</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li>
                                <select name="" id="">
                                    <option value="">보험 상품 선택</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li><input type="text" id="" name=""></li>
                        </ul>
                    </div>
                    <div><button type="button" name="submit" class="btn_s1 search">검색</button></div>
                </ul>
            </section>
        </fieldset>
        </form>
        <div id="check_all">
            <button type="button" id="applicant_allbt" class="btn_s5">전체 선택</button>
            <button type="button" id="applicant_allnbt" class="btn_s5">전체 해제</button>
        </div>
        <section id="list_of-x">
            <table id="t_re_list">
                <caption>검색 결과</caption>
                <colgroup>
                    <col width="40px">
                    <col width="140px">
                    <col width="140px">
                    <col width="80px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="70px">
                    <col width="108px">
                    <col width="90px">
                    <col width="70px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">선택</th>
                        <th scope="col">청약번호</th>
                        <th scope="col">증권번호</th>
                        <th scope="col">진행상태</th>
                        <th scope="col">보험사</th>
                        <th scope="col">보험상품</th>
                        <th scope="col">청약일</th>
                        <th scope="col">피보험자</th>
                        <th scope="col">총인원</th>
                        <th scope="col">시작/종료일</th>
                        <th scope="col">총보험료</th>
                        <th scope="col">결제여부</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" id="n1" name="appli_nob[]" value="" />
                            <label for="n1" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left"><a href="/check/view.php">120200051377</a></td>
                        <td class="nb t_left">120200051377</td>
                        <td class="cancel">청약취소</td>
                        <td>DB손해보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">1,782</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">1,524,000</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n2" name="appli_nob[]" value="" />
                            <label for="n2" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">13</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">17,400</td>
                        <td class="c_red">NO</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n3" name="appli_nob[]" value="" />
                            <label for="n3" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">120200051377</td>
                        <td class="nb t_left">120200051377</td>
                        <td class="cancel">청약취소</td>
                        <td>DB손해보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">48</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">8,719,000</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n4" name="appli_nob[]" value="" />
                            <label for="n4" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">106</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">61,780</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n5" name="appli_nob[]" value="" />
                            <label for="n5" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">2,745</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">330,990</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n6" name="appli_nob[]" value="" />
                            <label for="n6" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">23</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">1,011,120</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n7" name="appli_nob[]" value="" />
                            <label for="n7" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">77</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">51,880</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n8" name="appli_nob[]" value="" />
                            <label for="n8" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">64</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">19,340</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n9" name="appli_nob[]" value="" />
                            <label for="n9" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">35</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">99,450</td>
                        <td class="c_blue">YES</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="n10" name="appli_nob[]" value="" />
                            <label for="n10" class="check_bx"><span></span></label>
                        </td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="nb t_left">P19O00081200009</td>
                        <td class="cancel">청약취소</td>
                        <td>에이스보험</td>
                        <td>해외여행자</td>
                        <td class="nb">2019-12-05</td>
                        <td>홍길동</td>
                        <td class="t_right"><span class="nb">240</span>명</td>
                        <td class="nb">2019-12-22<br>2019-12-30</td>
                        <td class="nb t_right c_black">741,350</td>
                        <td class="c_blue">YES</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="btn_area_list">
            <div>
                <!--button type="button" name="button" class="btn_s2" id="endorse">배서 목록</button-->
                <button type="button" name="button" class="btn_download">선택 엑셀 다운로드</button>
            </div>
        </section>
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
    </section><!-- e : container -->

	<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<script>
	function plan_change() {
		var frm=document.send_form_pop;

		if (select_num=="") {
			alert('보험을 선택해 주세요.');
			return false;
		}

		if (frm.content.value=="") {
			alert('수정 내용을 입력해 주세요.');
			return false;
		}

		$("#auth_token").val(auth_token);
		$("#select_num").val(select_num);
		
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/plan_change_process.php",
			data :  $("#send_form_pop").serialize(),
			success : function(data, status) {
				console.log(data);
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					alert(json.msg);
					location.reload();
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
	$(document).ready(function(){
		$('#excel_hyecho').on('click',function(){			
			var search_stdate;
			var search_eddate;
			var search_sel;
			var search_text;
						
			search_stdate = $('#start_date').val();
			search_eddate = $('#end_date').val();
			search_sel = $('select[name=make]').val();
			search_text = $('#searchstr').val();

			location.href='./excel_download_hyecho.php?start_date='+search_stdate+'&end_date='+search_eddate+'&make='+search_sel+'&search='+search_text;

		});

		$('#endorse').on('click',function(){
			location.href='/check/endorse_list.php';
		});
	});
</script>

<div id="layerPop0" class="layerPop" style="display:none;">
<form id="send_form_pop" name="send_form_pop">
<input type="hidden" id="auth_token" name="auth_token" readonly>
<input type="hidden" id="select_num" name="select_num" readonly>

	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title">수정</p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
					<select class="txtb" name="change_type" style="width:100%">
						<option value="4">수정접수</option>
						<option value="2">취소접수</option>
					</select>
					<textarea name="content" class="textarea mt10" rows="6" cols="100" style="width:100%; height:150px;"></textarea>

					<div class="btn-tc">
						<a href="javascript:void(0);" onclick="plan_change();" class="btnNormal m_block"><span>신청</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
</body>
<script type="text/javascript" src="/js/applicant_list.js"></script>
</html>
