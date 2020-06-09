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
			$add_query .=" and c.name like '%$search%'";
		} elseif ($make=="join_name") {
			$add_query .=" and b.join_name like '%$search%'";
		}
	}

 $sql="select 
		*, a.no as num, a.regdate as regdate, b.no as plan_hana_no, c.no as mem_no, c.hphone, c.email
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
        <form action="" method="" id="formBox">
        <fieldset>
            <section id="searchBox">
                <ul>
                    <li>
                        <select name="" id="">
                            <option value="" selected>선택</option>
                            <option value="">요청일자</option>
                            <option value="">처리일자</option>
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
                                    <option value="">진행여부</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <select name="" id="">
                                    <option value="">청약번호</option>
                                    <option value="">주민번호</option>
                                    <option value="">계약자명</option>
                                </select>
                            </li>
                        </ul>
                    </div>
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
                            <li><input type="text" id="" name=""></li>
                        </ul>
                    </div>
                    <div><button type="button" name="button" class="btn_s1 search">검색</button></div>
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
                    <col width="120px">
                    <col width="80px">
                    <col width="180px">
                    <col width="80px">
                    <col width="310px">
                    <col width="100px">
                    <col width="130px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">요청일자</th>
                        <th scope="col">보험사</th>
                        <th scope="col">진행여부</th>
                        <th scope="col">청약번호</th>
                        <th scope="col">배서처리</th>
                        <th scope="col">메모</th>
                        <th scope="col">계약자명</th>
                        <th scope="col">주민등록번호</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황
                            사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
					<?/*
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황
                            사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황
                            사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">각자의 별에서 어떤 빛은 야망 어떤 빛은 방황
                            사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황
                            사람들의 불빛들 모두 소중한 하나 어두운 밤</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td class="nb">2020-01-31</td>
                        <td>DB손해보험</td>
                        <td class="complete">배서완료</td>
                        <td class="nb t_left"><a href="#">P19O00081200009</a></td>
                        <td>완료</td>
                        <td class="t_left">반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방</td>
                        <td>홍길동</td>
                        <td class="nb">123456-654654</td>
                    </tr>
					*/
					?>
                </tbody>
            </table>
        </section> 
        <section id="btn_area_list">
            <div><button type="button" name="button" class="btn_download">엑셀 다운로드</button></div>
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
</body>
</html>
