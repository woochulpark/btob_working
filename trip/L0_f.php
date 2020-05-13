<? 
	include ("../include/top.php"); 

	session_start("s_session_key");

	$session_val=time()."_".$tripType."_".$row_mem_info['no'];
	$session_key =encode_pass($session_val,$pass_key);
	$_SESSION['s_session_key']=$session_key;

	$check_key=time()."_".rand(10000,99999).$row_mem_info['no'];
	
	$longt_insuran_com = '';
	$longt_birth_data = '';
	$longt_sex_data = '';

	$currDate = date("Y-m-d");
	$arr_longt_data = explode("//-//",base64_decode($_GET['join_data']));
	

	switch($arr_longt_data[0]){
		case 'ME':
			$longt_insuran_com = '1';
		break;
		case 'HH':
			$longt_insuran_com = '2';
		break;
	}	

	$longt_birth_data = $arr_longt_data[1];

	$longt_sex_data=($arr_longt_data[2] == 'male')?1:2;
	

	if ($tripType!='1' && $tripType!='2') {
?>
<script>
//	alert('잘못됩 접속 입니다..');
//	location.href="../src/logout.php";
</script>
<?
	//exit;
	}

	$sql_check="select * from hana_plan_tmp where member_no='".$row_mem_info['no']."'";
	$result_check=mysql_query($sql_check);
	$row_check=mysql_fetch_array($result_check);

	if ($row_check['no']!='') {
		$sql_delete="delete from hana_plan_tmp where member_no='".$row_mem_info['no']."'";
		mysql_query($sql_delete);

		$sql_delete="delete from hana_plan_member_tmp where tmp_no='".$row_check['no']."'";
		mysql_query($sql_delete);
	}
?>
<script type="text/javascript" src="../js/trip.js"></script>

<script>
	var oneDepth = 1; //1차 카테고리
	
	var tripType="<?=$tripType?>";
	var total_won = 0;
	set_limit(<?=$_GET['tripType']?>);

	

	var cal_type_id = new Array();
	cal_type_id[1]=0;
	cal_type_id[2]=0;
	cal_type_id[3]=0;
	cal_type_id[4]=0;

	var cal_type_code = new Array();
	cal_type_code[1]="";
	cal_type_code[2]="";
	cal_type_code[3]="";
	cal_type_code[4]="";



		//var rt = $("#right_wrap").offset().top + 56;
        var rt = $("#h1").offset().top + 56;   
			

		$(window).scroll(function () {
			var th = $("#header").outerHeight() + $(".join_step").outerHeight();
			var wt = $(window).scrollTop();

			if(wt >= rt){
				$("#h1").addClass("pa_aa");
			}else if(wt < rt) {
				$("#h1").removeClass("pa_aa");
			}
			
			$('.pa_aa').css('top', wt - th);  

		});

		$("#nation_search").focusin(function(){
			nation_search_fun();
		});
		
		$("#nation_search").on("paste keyup ",function(){
			nation_search_fun();
		});
		
		$('#swin_close').on("click",function(){
			$("#search_window").hide();	
			$("#com_search_val").empty();
		});

		$(document).on("click",'.ttt',function(){
				var ncode;				
				var nname;
				ncode = $(this).attr('nation_no');
				nname = $(this).text();
				$('input[name=nation]').val(ncode);
				$('input[name=nation_search]').val(nname);
				$("#search_window").hide();	
				$("#com_search_val").empty();
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
            <div><h1>장기 체류(유학생) 보험 가입</h1></div>
            <div></div>
        </section>
        <section id="ac_info">
            <table id="t_info">
                <tbody>
                    <tr>
                        <th>거래처 ID</th>
                        <td class="nb">1234564</td>
                        <th>거래처명</th>
                        <td>00000여행사</td>
                        <th>청약번호</th>
                        <td class="nb">12346979</td>
                        <th>청약일</th>
                        <td class="nb">2019-12-26</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        <section id="Lstay_reference">
            <div class="tit">
                <ul>
                    <li><h2>보험료 간편 조회</h2></li>
                    <li>간편하게 여행자보험을 계산하실 수 있습니다.</li>
                </ul>
            </div>
            <form action="" method="" id="formBox">
            <fieldset>
            <div class="easy_form">
                <ul>
                    <li>
                        <select name="" id="">
								<option value="">선택</option>
                            <?
										foreach($insuran_option as $k=>$v){ 
											if($v != 'S_1' && $v != 'S_2'){
												$chk_sel = explode('_',$v);												
									?>
	                                    <option value="<?=$v?>" <?=($chk_sel[1] == $longt_insuran_com)?'selected':'';?> ><?=$k?></option>
									<?
											}
										}
									?>                                                    
                        </select>
                    </li>
                    <li>
                        <label for="">생년월일</label>
                        <input type="text" id="" name="" value="<?=($longt_birth_data != '')?$longt_birth_data:'';?>" placeholder="예시)19720522">
                    </li>
                    <li>
                        <label for="">성별</label>
                        <ul class="gender">
                            <li>
                                <input type="radio" id="male" name="gender" value="male" <?=($longt_sex_data == 1)?"checked":'';?> />
                                <label for="male" class="radio_bx"><span></span>남</label>
                            </li>
                            <li>
                                <input type="radio" id="female" name="gender" value="female" <?=($longt_sex_data == 2)?"checked":'';?> />
                                <label for="female" class="radio_bx"><span></span>여</label>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" name="submit" class="btn_s1 search">검색</button>
                    </li>
                </ul>
            </div>
            </fieldset>
            </form>
            <ul class="underline">
                <li>- 보험료는 피보험자의 성별, 연령별로 상이하며, 보험료의 차이가 발생될 수 있습니다.</li>
                <li>- 15세 미만자에게는 법적으로 상해/질병, 사망을 담보할 수 없도록 되어 있습니다.</li>
                <li>- 적용 환율은 실시간 환율이 아닌 참고용 환율이며 참고 신청/상담 시의 실시간 최종 환율을 확인해 드립니다. 참고용 환율과 실시간 환율에 따라 보험료의 차이가 발생 될 수 있습니다.</li>
            </ul>
        </section>
        <section id="companyLogo">
            <img src="../img/common/companyLogo_hanhwa.jpg" alt="한화손해보험">
        </section>
        <section>
            <div id="easyresult_wrap">
                <div class="easyresult_tab tab_style">
                    <ul>
                        <li class="active">
                            <a>간편조회 결과</a>
                        </li>
                        <li>
                            <a>보장내용</a>
                        </li>
                        <li>
                            <a>꼭 알아두세요</a>
                        </li>
                        <li>
                            <a>인수 제한</a>
                        </li>
                        <li>
                            <a>각 나라별 정보</a>
                        </li>
                    </ul>
                </div>
            
                <div class="easyresult_contents">
                    <div class="easyresult content">
                        <div class="easyresult_ptable" id="xy">
                            <table class="easyresult_plan">
                                <caption>간편조회 결과</caption>
                                <colgroup>
                                    <col width="70px">
                                    <col width="390px">
                                    <col width="170px">
                                    <col width="170px">
                                    <col width="170px">
                                    <col width="170px">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th colspan="2" scope="col">담보내용 / 플랜명</th>
                                        <th scope="col">DB-R10</th>
                                        <th scope="col">DB-R11</th>
                                        <th scope="col">DB-R12</th>
                                        <th scope="col">DB-R13</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" scope="col">연령</th>
                                        <th colspan="5" scope="col">만 15세 ~ 64세</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" scope="col">선택</th>
                                        <th scope="col">
                                            <input type="radio" id="p1" name=" " value="" />
                                            <label for="p1" class="radio_bx"><span></span></label>
                                        </th>
                                        <th scope="col">
                                            <input type="radio" id="p2" name=" " value="" />
                                            <label for="p2" class="radio_bx"><span></span></label>
                                        </th>
                                        <th scope="col">
                                            <input type="radio" id="p3" name=" " value="" />
                                            <label for="p3" class="radio_bx"><span></span></label>
                                        </th>
                                        <th scope="col">
                                            <input type="radio" id="p4" name=" " value="" />
                                            <label for="p4" class="radio_bx"><span></span></label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background-color: #f6f6f6;">
                                        <th rowspan="2" class="tit">보통<br>약관</th>
                                        <td class="planname">해외상해 사망</td>
                                        <td>1억원</td>
                                        <td>1억원</td>
                                        <td>5,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #5c5c5c;">
                                        <td class="planname">상해후유장해</td>
                                        <td>1억원</td>
                                        <td>1억원</td>
                                        <td>5,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <th rowspan="7" class="tit">특별<br>약관</th>
                                        <td class="planname">해외상해 실손의료비</td>
                                        <td>1억원</td>
                                        <td>5,000만원</td>
                                        <td>4,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">해외질병 실손의료비</td>
                                        <td>1억원</td>
                                        <td>5,000만원</td>
                                        <td>4,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">해외장기체류중 질병 사망 및 질병 80% 이상 고도후유장해</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">해외장기체류 중 중대사고 구조소환비용 [Medical Evacuation & Repatriation]</td>
                                        <td>2,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">해외장기제류중 배상책임 (면책금 : 1만원)</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                        <td>1,000만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">해외체류 중 여권분실 후 재발급비용</td>
                                        <td>가입</td>
                                        <td>가입</td>
                                        <td>가입</td>
                                        <td>가입</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6; border-bottom: 1px solid #5c5c5c;">
                                        <td class="planname">항공기 납치 (일당)</td>
                                        <td>7만원</td>
                                        <td>7만원</td>
                                        <td>7만원</td>
                                        <td>7만원</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="5" class="tit">국내<br>상해<br>질병</th>
                                        <td class="planname">입원의료비</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">통원_외래비</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">처방조제의료비</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">비급여의료비 (도수, 체외충격파, 증식치료)</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                    </tr>
                                    <tr style=" border-bottom: 1px solid #5c5c5c;">
                                        <td class="planname">비급여의료비 (비급여주사료)</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="5" class="tit last">국내<br>상해<br>질병</th>
                                        <td class="planname">입원의료비</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                        <td>3,000만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">통원_외래비</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                        <td>15만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">처방조제의료비</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                        <td>5만원</td>
                                    </tr>
                                    <tr style="background-color: #f6f6f6;">
                                        <td class="planname">비급여의료비 (도수, 체외충격파, 증식치료)</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                        <td>350만원</td>
                                    </tr>
                                    <tr>
                                        <td class="planname">비급여의료비 (비급여주사료)</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                        <td>250만원</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <ul>
                            <li>
                                <button type="button" class="btn_s1">보험 신청하기</button>
                            </li>
                        </ul>
                    </div>
            
                    <div class="warranty content">
                        <table>
                            <thead>
                                <tr>
                                    <th>담보명</th>
                                    <th>지급 사유</th>
                                    <th>지급 금액</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>상해사망</td>
                                    <td>해외 유학 중 급격하고도 우연한 외래의 사고로 상해를 입고 그 결과로써 사망하였을 때</td>
                                    <td>보험가입금액</td>
                                </tr>
                                <tr>
                                    <td>상해후유 장해</td>
                                    <td>해외 유학 중 급격하고도 우연한 외래의 사고로 상해를 입고 그 결과로써 신체의 일부 또는 전부의 기능이 상실되었을 때</td>
                                    <td>후유 장해 시 장해 급수별 가입 금액의 3% - 100%</td>
                                </tr>
                                <tr>
                                    <td>실손 의료비(상해)</td>
                                    <td>
                                        <dl>
                                            <dt>해외</dt>
                                            <dd>해외 유학 중에 입은 상해로 인하여 해외 의료기관에서 의료비 발생 시 보상</dd>
                                        </dl>
                                        <dl>
                                            <dt>국내 상해 입원</dt>
                                            <dd>해외 유학 중에 입은 상해로 인하여 국내 의료기관에서 입원의료비 발생 시 보상</dd>
                                        </dl>
                                        <dl>
                                            <dt>국내 상해 통원</dt>
                                            <dd>해외 유학 중에 입은 상해로 인하여 국내 의료기관에서 통원하여 치료를 받거나 약국에서 처방조제를 받은 경우에 보상</dd>
                                        </dl>
                                    </td>
                                    <td rowspan="2">실손의료비 담보 세부내용 참고</td>
                                </tr>
                                <tr>
                                    <td>실손 의료비(질병)</td>
                                    <td style="border-right: 1px solid #d1d1d1;">
                                        <dl>
                                            <dt>해외</dt>
                                            <dd>해외 유학 중에 질병으로 인하여 해외 의료기관에서 의료비 발생 시 보상</dd>
                                        </dl>
                                        <dl>
                                            <dt>국내 질병입원</dt>
                                            <dd>해외 유학 중에 질병으로 인하여 국내 의료기관에서 입원의료비 발생 시 보상</dd>
                                        </dl>
                                        <dl>
                                            <dt>국내 질병통원</dt>
                                            <dd>해외 유학 중에 질병으로 인하여 국내 의료기관에서 통원하여 치료를 받거나 약국에서 처방조제를 받은 경우에 보상</dd>
                                        </dl>
                                    </td>
                                </tr>
                                <tr>
                                    <td>질병사망 및 질병 80% 이상 고도 후유 장해</td>
                                    <td>해외 유학 중에 발생한 질병을 직접원인으로 하여 사망하거나 장해분류표의 입각 호에 정한 지급률 80% 이상의 후유 장해가 남았을 경우</td>
                                    <td>보험가입금액</td>
                                </tr>
                                <tr>
                                    <td>배상 책임손해</td>
                                    <td>해외 유학 중에 생긴 우연한 사고로 인하여 제3자(타인)에게 배상 책임을 부담함으로써 입은 손해를 보상(공제금액 : 1사고당 1만 원) 보험사가 요청한 서류 첨부 시 검토 가능</td>
                                    <td>법률상의 손해배상책임 금액 및 소송비용 등 지급</td>
                                </tr>
                                <tr>
                                    <td>특별비용 손해</td>
                                    <td>해외 유학 중에 탑승한 항공기나 선박의 행방불명, 사망 또는 14일 이상 입원할 경우 수색 구조비용, 구원자의 교통비, 숙박비, 유체 이송비 및 기타 제잡비</td>
                                    <td>수색 구조비용, 구원자의 교통비, 숙박비, 이송비, 제잡비 등을 보상</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            
                    <div class="notice content">
                        <h3>1. 가입대상</h3>
                        <ul>
                            <li>해외 대학교 및 연구소 등에 유학, 연수 및 이와 유사한 연구를 목적으로 하는 자를 말하며, 이외에 피보험자의 배우자 부모 및 직계 자녀로서 만 19세까지의 자녀 포함. <br>단, 여행지에 따라 일부 제한될 수 있습니다. (ex : 전쟁, 내란 지역, 극동지역 등)</li>
                        </ul>
            
                        <h3>2. 상품의 특이사항</h3>
                        <ul>
                            <li>- 이 상품은 소멸성 순수 보장성보험으로 만기 시 환급금이 없습니다.</li>
                            <li>- 이 상품의 보험료 납입주기는 일시납을 원칙으로 합니다.</li>
                        </ul>

                        <h3>3. 청약 시 주의사항</h3>
                        <ul>
                            <li>- 보험계약 청약서에 인쇄된 내용을 보험계약자 본인이 직접 확인하신 후 자필로 서명하셔야 합니다.</li>
                            <li>- 회사는 계약을 체결할 때 계약자에게 보험약관을 드리고 그 약관의 중요한 내용을 설명하여 드립니다.</li>
                            <li>- 회사가 제공될 약관 및 계약자 보관용 청약서를 청약 시 계약자에게 전달하지 아니하거나 약관의 중요한 내용을 설명하지 아니한 때 또는 계약 체결 시 계약자 가 청약서에 자필서명을 하지 아니한 때에는 계약자는 계약 체결일로부터 3개월 이내에 계약을 취소할 수 있습니다. 다만, 단체계약의 경우에는 계약 체결일로부터 1개월 이내에 계약을 취소할 수 있습니다.<br>(계약 체결 경우 약관과 청약서를 꼭 보관하십시오)</li>
                        </ul>

                        <h3>4. 계약 전 알릴 의무</h3>
                        <ul>
                            <li>계약자 또는 피보험자는 청약 시 청약서에 질문한 사항에 대하여 알고 있는 사실을 반드시 사실대로 알려야 합니다.</li>
                            <li>위반 시 보험계약의 해지 또는 환급금 부지급 등 불이익을 당할 수 있습니다.</li>
                        </ul>

                        <h3>5. 계약 후 알릴 의무</h3>
                        <ul>
                            <li>계약자 또는 피보험자는 보험계약을 맺은 후 보험기간 중에 피보험자의 직업 또는 직무를 변경하거나 보험약관에 정한 계약 후 알릴 의무사항이 발생하였을 경우 지체 없이 회사에 알려야 합니다.</li>
                            <li>그렇지 않을 경우 보험계약의 해지, 환급금 부지급 또는 보험금 지급 등이 거절될 수 있습니다.</li>
                        </ul>

                        <h3>6. 보험금 청구 및 절차</h3>
                        <ul>
                            <li>보험사고 발생 시는 그 사실을 즉시 저희 회사에 알려주시고, 사고 증명서, 진단서 등의 보험금 청구 서류를 제출해 주시면 신속하게 처리 보상 드리겠습니다.</li>
                        </ul>

                        <h3>7. 보험 혜택을 못 받는 경우</h3>
                        <ul>
                            <li>계약자나 보험수익자 또는 피보험자의 고의, 자해, 범죄 또는 폭력행위, 형의 집행, 전쟁, 혁명, 내란, 폭동, 핵연료 물질, 방사선 등 면책사항은 보험약관에 자세히 명시되어 있습니다.</li>
                        </ul>
                    </div>

                    <div class="limit content">
                        <h3>보험 가입제한 안내</h3>
                        <ul>
                            <li class="c_red">ㆍ 금감원 지시사항으로 해외 영주권, 시민권자, 이중국적자는 어떤 이유든 가입 불가입니다.</li>
                            <li>ㆍ 해외 체류 중 가입 및 베트남, 중국 지역은 가입, 보상이 되지 않습니다. 꼭 참고하시기 바랍니다.</li>
                            <li>ㆍ 인수 심의 대상 및 지역에 대하여 더 궁금하시면 전화(02-3291-2570)로 문의하시면 자세하게 안내해드립니다.</li>
                        </ul>

                        <table>
                            <thead>
                                <tr>
                                    <th>위험요소</th>
                                    <th>인수 심의 대상</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>외국인 및 외국 시민권 취득자</td>
                                    <td>
                                        ㆍ 인수 불가 (주민번호 5,6,7,8 - 인수 불가)<br>ㆍ 외국 영주권 및 시민권 취득자는 취득 국가로의 장기 체류 시 보험 가입 불가
                                    </td>
                                </tr>
                                <tr>
                                    <td>전쟁 위험 / 인수 제한지역</td>
                                    <td>
                                        <ul>
                                            <li>ㆍ 외국 영주권 및 시민권 취득자는 취득 국가로의 장기 체류 시 보험 가입 불가</li>
                                            <li><button type="button" class="btn_out">외교부 여행제한/금지 지역 확인</button></li>
                                            <li class="c_red">ㆍ 해당 국가에서 발생하는 사고에 대해서는 보상하지 않으므로 그러한 국가를 여행하는 경우에는 인수 불가</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>위험한 운동 및 레저</td>
                                    <td>
                                        ㆍ 약관에서 보장하지 않는 위험 취미활동을 목적으로 일정에 포함된 경우 가입 불가<br>
                                        ㆍ 전문등반 (전문적인 등산용구를 사용하여 암벽 또는 빙벽을 오르내리거나 특수한 기술, 경험, 사전훈련을 필요로 하는 등반) 가입 불가<br>
                                        ㆍ 행글라이딩, 글라이더 조정, 스카이다이빙, 스쿠버다이빙, 모터보트, 자동차 또는 오토바이에 의한 경기, 시범, 흥행 또는 시운전 가입 불가<br>
                                        ㆍ 위험 활동을 주목적 (물놀이, 해수욕, 피서 포함), 스키여행, 보드 동호회, 바다낚시 동호회의 정기 여행, 산악자전거, 래프팅, 요트, 스포츠 활동 목적
                                            (마라톤, 축구 등), 이와 유사한 정도의 위험이 있는 기타 활동으로 한 여행 - 가입 불가<br>
                                            (워크숍, 세미나, 안전한 활동을 목적으로 한 여행에서 일정 중에 이와 같은 활동이 일부 포함된 경우 가입 가능)
                                    </td>
                                </tr>
                                <tr>
                                    <td>위험한 직업</td>
                                    <td>
                                        ㆍ 상해등급 표상 3급 직업 해당자 - 인수 제한<br>
                                        ㆍ 건설/생산업종 인부, 운동선수 (직업과 관련된 경기 참여나 연수, 연습 포함된 해외여행)<br>
                                        ㆍ 선박/승무원/어부/사공/양식업자 등 선박에 탑승하는 것을 직무로 하는 자.<br>
                                        ㆍ 해외 파견 군인. 이 외 위험성을 동반하는 직무영위자 - 가입 불가
                                    </td>
                                </tr>
                                <tr>
                                    <td>건강상태</td>
                                    <td>
                                       <h3>ㆍ 가입 불가 질환</h3>
                                       <ul>
                                           <li>현증 및 기왕증 모두 거절, 가입 및 갱신 불가 : 암, 백혈병, 고혈압, 협심증, 심근경색, 심장판막증, 간경화증, 뇌졸중증(뇌출혈, 뇌경색), 당뇨병, 에이즈
                                            (AIDS) 및 HIV 보균인, 알코올 및 약물중독, 중증 만성 정신질환, 크론병 등 만성 괴사성 대장염, 전신성 홍반성낭창(루푸스), 만성 신장질환 (이 외 
                                            치명적 질병력, 중대한 질병력 가입 불가)</li>
                                       </ul>

                                       <h3>ㆍ 지속적으로 보험금 지급이 예상되는 건강 상태 </h3>
                                       <ul>
                                           <li>동일 질병 개발력, 재발 예상되는 병명, 완치 여부 확인 불가 건, 꾸준한 병원 치료역 등</li>
                                       </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>사망보험수익자</td>
                                    <td>법정상속인이 아닌 경우 - 인수 제한</td>
                                </tr>
                                <tr>
                                    <td>다수 보험 가입자</td>
                                    <td>ㆍ 2개 이상의 여행보험 가입자<br>
                                        ㆍ 당사 보상 이력 및 대외비(ICPS) 상 타사 보험금 수령 이력 다수, 고액보험금 지급, 장기입원력, 사고 다발 이력 존재할 경우, 타 사계 약 가입 다수</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="country content">
                        <div class="country_list">
                            <ul>
                                <li class="active">
                                    <a>미국</a>
                                </li>
                                <li>
                                    <a>캐나다</a>
                                </li>
                                <li>
                                    <a>호주</a>
                                </li>
                                <li>
                                    <a>일본</a>
                                </li>
                                <li>
                                    <a>프랑스</a>
                                </li>
                                <li>
                                    <a>뉴질랜드</a>
                                </li>
                                <li>
                                    <a>영국</a>
                                </li>
                                <li>
                                    <a>스페인</a>
                                </li>
                                <li>
                                    <a>필리핀</a>
                                </li>
                            </ul>
                        </div>

                        <div class="country_content">
                            <div class="en content">
                                <p>
                                        미국에는 전 국민을 대상으로 하는 국가적인 의료보험이나 건강 관리 체제는 없습니다. 대신 대부분의 사람들은 사설 건강보험을 구입하고 있습니다, 
                                        미 국무부는 J-1 교환 방문 비자를 가진 학생은 건강과 사고, 의료 대비, 유해 환송 등을 커버할 수 있는 보험에 가입할 것을 요구합니다.
                                </p>
                                <p>
                                    미 정부는 F-1이나 M-1 비 이민 비자를 가진 학생에게는 특정한 건강 보험 요구 조건을 제시하지 않으나 대부분의 교육 기관들은 자체적인 건강 보험 요구 사항을 
                                    세워놓고 있어 외국 학생들은 일반적으로 학교 입학을 하기 전에 일정액(대학에 의해 결정됨)의 의료보험 가입을 규정하고 등록 시 의료보험 증서를 요구하고 
                                    있습니다. 교화 교수 및 출장자도 해당 학교 및 회사, 기관에서 요구하는 보장을 검토하고 가입하셔야 합니다. 
                                </p>
                                <p>
                                    또한 학교 보험은 치료비에 대한 일정 금액만을 보상하여 주지만 본인 부담금 20% ~ 40%까지 지불해야 하는 단점이 있으며 특별비용, 휴대품 보상, 배상 책임 등 학생에게 꼭 필요한 보상이 없습니다. 따라서, 국내의 유학생 보험 가입을 권장합니다.
                                </p>
                                <div class="visa">
                                    <div>F-VISA 규정</div>
                                    <ul>
                                        <li>ㆍ상해 및 질병치료비 $50,000이상</li>
                                        <li>ㆍ긴급의료후송비 $10,000이상</li>
                                        <li>ㆍ유해본국송환비 $7,500 이상</li>
                                        <li>ㆍ본인부담금 $500이하</li>
                                        <li>ㆍ국제 신용평가기관에서 평가한 신용등급이 A-이상인 보험회사</li>
                                    </ul>
                                    <ul>
                                        <li>
                                            <span>F-1</span>
                                            풀타임 미국 유학생에게 발급
                                        </li>
                                        <li>
                                            <span>F-2</span>
                                            F-1 비자의 배우자, 자녀에게 발급
                                        </li>
                                        <li>
                                            <span>F-3</span>
                                            미국의 접견국인 캐나다, 멕시코 국민이 미국 학교에 다니는 경우에 발급
                                        </li>
                                    </ul>
                                </div>
                                <div class="visa">
                                    <div>J-VISA 규정</div>
                                    <ul>
                                        <li>ㆍ상해 및 질병치료비 $50,000이상</li>
                                        <li>ㆍ긴급의료후송비 $10,000이상</li>
                                        <li>ㆍ유해본국송환비 $7,500 이상</li>
                                        <li>ㆍ본인부담금 $500이하</li>
                                        <li>ㆍ국제 신용평가기관에서 평가한 신용등급이 A-이상인 보험회사</li>
                                    </ul>
                                    <ul>
                                        <li>
                                            <span>J</span>
                                            문화교류 비자(인턴십, 장/단기 연구원, 교수, 교환학생 등)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="ca content">
                                <p>
                                    캐나다는 현지인들이 의료보험 제도로 대부분의 치료를 무료로 이용하는 것과는 달리 학생비자, 관광비자, 워킹홀리데이비자 등으로 현지에 체류하는 외국인들에게는 그 의료비가 상당히 비싸므로 출국 전 국내 보험 가입을 통한 준비가 반드시 필요합니다.
                                </p>
                                <p>
                                    최근에는 유학생들의 잦은 사고로 인하여 대부분의 학교에서 보험 규정을 강화하고 있으며, 규정에 맞는 보험에 가입한 후 보험 가입 증빙서류를 제출해야 입학을 허가해 주거나 미국과 같이 고액의 보험 가입을 의무화하는 학교가 늘어나고 있습니다. 따라서 학교 입학 조건에 맞는 보상을 확인하시어 꼭 국내에서 보험 가입을 권장하여 드립니다.
                                </p>
                                <table class="table_ca">
                                    <thead>
                                        <tr>
                                            <th>도시</th>
                                            <th>내용</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>브리티시 컬럼비아 주</td>
                                            <td>유효한 학생비자를 소지하고 3개월의 대기 기간이  필요하므로, 미리 3개월간의 보험을 준비해야 합니다.</td>
                                        </tr>
                                        <tr>
                                            <td>알버타 주, 온타리오 주</td>
                                            <td>도착 시 3개월 이내에 등록해야 하고 학생비자의 기재 내용에 따라 수혜 기간이 정해지면 반드시 수혜 기간이 3개월 이상이어야 합니다.</td>
                                        </tr>
                                        <tr>
                                            <td>사스케츠완 주</td>
                                            <td>유학생은 도착한 직후 등록해야 하며, 유학생에 대한 의료혜택은 무상으로 제공됩니다. 기간은 유학 허가서에 명기된 기간과 일치하며, 유학생 및 부양가족도 같은 혜택을 받을 수 있습니다.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>
                                    - 주별 의료혜택에서 유학생이 제외되는 주 마니 토비, 뉴 브런즈윅, 뉴펀들랜드, 노바스코샤, 온타리오, 프린스에드워드아일랜드, 퀘백 주로의 유학생은 개별적으로 보험사를 통해 유학생 보험에 가입해야 합니다.
                                </p>
                            </div>
    
                            <div class="au content">
                                <p>
                                    학생비자로 출국 시 호주 정부가 인정하는 OSHC(Overseas Student Health Cover)라는 일종의 유학생 의료보험을 의무적으로 가입해야 합니다. 따라서 학교에서 학비 Invoice를 발행할 때 의료보험료가 포함되어 있으며 이를 학비와 같이 송금해야 합니다. 이는 비자 서류 중의 하나이며 의료보험 납입영수증은 별도로 없으나 입학허가서상에 OSHC의 금액이 적혀있으므로 이것을 Copy 하여 영수증 대용으로 사용이 가능합니다.
                                </p>
                                <p>
                                    의료보험카드로 모든 사항이 다 혜택을 받는 것은 아니며, 사립병원에서 진료를 받았을 때의 진료비는 평균 85% 정도 지원을 받고 나머지는 본인이 부담하게 되지만 공립병원에서는 치료비의 전액을, 입원비 전액을 최대 35일까지 지원을 받습니다.
                                </p>
                                <p>
                                    치과, 안과, 약국에서 사용한 비용, 물리치료 등 보험 적용이 안되는 부분이 많습니다. 그러므로 호주에서 의무적으로 가입하는 보험은 꼭 보상 내용을 확인하시어 보상이 안되는 부분을 국내 유학생 보험 가입으로 준비해 가시기를 권장합니다.
                                </p>
                                <p>
                                    관광비자 or 워킹홀리데이비자(Working Holiday Visa)로 출국하는 경우 의료보험 적용이 되지 않기 때문에 출국 전 국내에서 유학생 보험을 반드시 가입해 가는 것이 좋습니다.
                                </p>
                                <h3>
                                    학생비자로 가는 경우- 유학생 의료보험 
                                </h3>
                                <p>
                                    호주에 오는 유학생이나 그 가족들은 체류 기간만큼의 OSHC라는 일종의 유학생 의료보험을 가입해야 합니다. 학생비자를 받기 전에 학교에 내는 등록금과 같이 지불하도록 되어있습니다. 한 과정을 마치고 계속 공부를 한다면 비자를 연장하기 이전에 의료보험을 갱신해야 합니다.
                                </p>
                            </div>
                            
                            <div class="ja content">
                                <p>
                                    일본은 다른 선진국에 비해 유학생에게 대한 의료보험 제도가 잘되어 있어서 6개월 이상 장기 체류를 할 경우 외국인 유학생 의료비 보조제도를 이용할 수 있습니다.
                                <br>
                                    단기간의 연수나 or 여행 or 워킹홀리데이비자 등을 가진 외국인에게는 다른 나라와 마찬가지로 의료비 혜택이 없으므로 국내에서 본인에게 맞는 보험을 가입하시기를 권장합니다.
                                </p>
                            </div>
    
                            <div class="fr content">
                                <p>
                                    지방에 체류할 경우에는 학교나 지역 은행 (대부분 은행이 보험 업무를 취급함)에서 안내하는 최상의 보험금액과 비교한 후 보상과 혜택 범위를 고려한 다음 선택하면 된다. 건강한 사람은 가장 저렴한 것으로 (특히 1년 어학연수생), 몸이 자주 아픈 경우는 보험료가 다소 비싸더라도 100% 보상 혜택이 주어지는 보험에 가입하는 것이 유리하다. 대학 등록 시, 학생 상호 보험회사인 MNEF 나 SMEREP에서 여러 가지 보험 상품을 제시하는 경우도 있다.
                                </p>
                                <h3>비자 신청을 위해 제출해야 할 서류</h3>
                                <ul>
                                    <li>
                                        최소 1년 동안 유효한 의료보험증명 : 질병, 임신, 출산, 부상 및 입원(질병 치료실비, 상해치료실비) 그리고 본국 송환 비용(특별비용)을 보장하여야 합니다. <br>(각각 최소 30,000유로 이상 보장되어야 함)<br>단, 비자의 시작일은 보험 적용 기간의 첫째 날부터입니다.
                                    </li>
                                    <li>
                                        한국인들은 프랑스나 "쉥겐지역" 국가들로의 3개월간의 단기간의 업무, 관광 여행을 하는데 있어서 비자가 면제됩니다.
                                    </li>
                                </ul>
                            </div>
    
                            <div class="nz content">
                                <p>
                                    뉴질랜드는 의료제도가 잘 발달되어 있으나 뉴질랜드 국민이나 영주권자는 의료비의 혜택을 받지만 그 밖의 외국인은 전액 본인 부담을 하셔야 하므로 뉴질랜드를 방문하거나 유학을 떠나는 사람은 유학생 보험에 가입하는 것이 좋습니다. 
                                </p>
                                <p>
                                    학교에서 의무적으로 보험 가입을 권유하는 경우도 있으나 학교에서 권유하는 보험은 비싸기 때문에 국내에서 보험 가입을 미리 하시고 출국하는 것이 유리합니다.
                                </p>
                                <h3>Accident Compensation Corporation (ACC)</h3>
                                <ul>
                                    <li>
                                        뉴질랜드 방문객들은 사고를 제외한 의료비와 치료에 수반하는 모든 경비를 본인이 부담함<br>하지만, 사고가 났을 경우 뉴질랜드 시민, 영주권자와 방문객 모두 (ACC)가 제공하는 보상을 받을 수 있습니다. 이 제도는 사고나, 의료사고, 특수한 경우 범죄사고를 당한 사람들을 재정적으로 보호해 주기 위한 목적으로 뉴 빌 랜드의 세금으로 운영되고 있습니다. ACC는 질병 치료의 보상이나 지원은 제공하지 않으며, 상해 치료의 비용도 항상 전액을 보상해 주지 않습니다, 또한 ACC는 사고 후 결과적으로 초래하게 되는 비용(예:소득 감소) 등의 보상을 제공하지 않습니다.
                                    </li>
                                </ul>
                            </div>
    
                            <div class="ig content">
                                <p>
                                    영국은 전 국민의 의료보험인 NHS(National Health Service) 서비스를 외국인 학생들과 동반 배우자 및 자녀들 모두에게 무료 의료 혜택을 제공합니다. 단 학생비자를 받고 6개월 이상 체류하는 학생에 한하며 6개월 미만 체류하는 학생의 경우 응급상황에만 무료 의료혜택을 받을 수 있습니다. 그러나 유럽연합의 국적을 가졌거나 스코틀랜드에서 정규 과정을 이수하는 학생이라면 체류 기간에 상관없이 무료로 의료혜택을 받을 수 있습니다. 만약 영국에 입국해도 의료 혜택을 못 받는 상황이라면 미리 국내에서 개인적으로 보험을 따로 가입해 두는 것이 좋습니다.
                                </p>
                                <p>
                                    등록할 때에는 보통 입학 허가서나 학생임을 증명하는 서류를 지참을 하셔야 합니다. 영국은 국가 의료제도 NHS(National Health Service)를 실시하여 영국에 거주하는 사람을 대상으로 의료 서비스를 제공하고 있습니다.
                                </p>
                                <p>
                                    약국에서 약을 살 경우에는 의사의 처방을 받아야 하며, 이때 비용은 3~4 파운드를 지불하게 되는데 NHS 카드가 없는 경우는 일반 의사의 처방을 받아 비싼 비용을 지불해야 합니다. 그러나 이 서비스는 기초적인 의료 상담에 관한 서비스이며, 질병이나 사고로 인한 의료비는 전혀 보상을 받을 수 없으므로 국내에서 보험 가입을 권장합니다.
                                </p>
                            </div>
    
                            <div class="sp content">
                                <p>
                                   - 6개월 이상 스페인에 거주하려면 여행자 보험 가입증서를 반드시 발급받아야 합니다. <br>- 기존에 국내 보험상품에 가입하셨더라도 여행용 보험이기 때문에 유학 가시는 기간만큼 유효한 여행자 보험 가입증서가 필요합니다. <br>- 보상 총 금액은 최소한 30,000유로 이상이어야 하며, 송환 보장이 반드시 있어야 합니다. <br>- 1년 이상 거주할 시 스페인 현지에서 연장해야 합니다.
                                </p>
                            </div>
    
                            <div class="pi content">
                                <p>
                                    필리핀은 21일 동안 무 비자로 입국이 가능한 나라입니다. 그러나 21일을 초과하여 체류하실 경우 59일 비자를 받으셔야 합니다. 그리고 필리핀에서 어학연수를 하기 위해서는 적법한 비자를 소지하거나(장기 비자 소유자), 관광비자 소지자의 경우에는 필리핀 이민 청으로부터 SSP(Special Study Permit)를 발급받아야 합니다. SSP 없이 필리핀에서 어학연수나 공부를 하는 것은 불법이며, 이민법 위반으로 단속 대상이 됩니다.
                                </p>
                                <ul>
                                    <li>- 만 18세 이하의 미성년자로 학교를 다니는 경우에는 SSP를 발급받아야 합니다.</li>
                                    <li>- 원칙적으로는 관광비자 소지자는 영어연수뿐만 아니라 모든 교습 (개인교습 포함)을 할 때 SSP를 발급받아야 합니다.</li>
                                </ul>
                                <p>
                                    필리핀에서 공부를 할 수 있는 허가증인 SSP는 필리핀 이민청 본청에 정식 등록된 어학원(또는 정식 학교)에서 구비서류를 첨부하여 이민청에 요청서를 발송하면, 개인이 수수료를 지급하고 발급을 받는 것입니다. 따라서, 어학원을 선택하실 때는 이민청에 정식 등록된 어학원인지 확인하실 필요가 있습니다.
                                </p>
                                <h3>학생이 만 15세 미만인 경우</h3>
                                <ul>
                                    <li>
                                        필리핀 이민 법령에 따르면 만 15세 미만의 미성년자는 아버지 혹은 어머니를 동반하지 않는 경우에는 필리핀에 입국할 수 없습니다. 부모님이 동반할 수 없는 경우 만 20세의 성인 인솔자가 아이와 함께 동반 입국할 수 있으나 "소아 동반 위임장"이 필요합니다. 인솔자가 구비하여 할 서류들은 다음과 같습니다.
                                    </li>
                                </ul>
                                <h3>1. 소아 동반 위임장(위탁서)</h3>
                                <ul class="mgB">
                                    <li>영문으로 작성하여 공증을 받거나, 한글로 작성하는 경우에는 번역 공증을 받으시기 바랍니다.</li>
                                    <li>정해진 형식은 없으나, 내용은 부, 모가 소아를 필리핀 출입국 시 지정된 인솔자(성명 및 생년월일 기재)에게 위탁한다는 내용입니다.</li>
                                </ul>
                                <h3>2. 인솔자의 여권사본 및 소아의 여권사본</h3>
                                <h3>3. 신청비：약3500페소, 미화 70불 상당</h3>
                                <h3>4. SSP 발급신청 구비서류</h3>
                                <ul>
                                    <li>- 신청서</li>
                                    <li>- 학원 능력 진술서 : 공증(번역/은행 잔고 최소 800달러 이상)</li>
                                    <li>- 호적등본</li>
                                    <li>- 입학허가 : 이민국으로부터 인가를 받은 학교 혹은 학원</li>
                                    <li>- 재정보증 서류 : 은행 잔액증명원</li>
                                </ul>
                            </div>
                        </div><!-- e : country_content -->
                    </div><!-- e : country -->
                </div>
            </div>
            <script>
                $('.tab_style ul li').click(function(){
                    var idx = $(this).index();
                    $(this).addClass('active').siblings().removeClass('active');
                    $('.easyresult_contents .content').eq(idx).show().siblings().hide();
                })
            </script> 
            <script>
                $('.country_list ul li').click(function(){
                    var idx = $(this).index();
                    $(this).addClass('active').siblings().removeClass('active');
                    $('.country_content .content').eq(idx).show().siblings().hide();
                })
            </script> 
        </section>








    </section><!-- e : container -->

	<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<div id="layerPop0" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in mini" style="max-width:500px;">
				<div class="pop_head">
					<p class="title " id="pop_title"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/btn_close2.png" alt="닫기"></p>
				</div>
				<div class="pop_body pt0" id="pop_content"></div>

			</div>
		</div>
	</div>
</div>

<div id="layerPop1" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title1"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
    					<strong>아시아</strong><p>아프가니스탄, 이스라엘, 이라크, 이란, 북한, 레바논, 파키스탄, 팔레스타인 자치구, 시리아, 타지키스탄, 예멘<br/><br/>
    					<strong>아프리카</strong><p>부르키나파소, 부룬디, 콩고(자이레), 중앙아프리카, 콩고, 코트디브와르, 알제리, 이집트, 기니, 리비아, 말리, 나이지리아, 수단, 시에라리온, 소말리아, 챠드, 자이레, 이디오피아, 케냐, 니제르<br/><br/>
    					<strong>유럽</strong><p>우크라이나, 크림반도<br/><br/>
    					<strong>북아메리카</strong><p>쿠바, 니카라과<br/><br/>
    					<strong>남아메리카</strong><p>아이티, 베네수엘라<br/><br/>
    					<strong>기타</strong><p>남극<br/><br/>
    					* 외교부의 여행금지대상 국가정보는 수시로 변경됩니다. 여행금지대상국가의 경우 가입이 불가하거나 또는 보상 대상에서 제외될 수 있습니다.<br/><br/>
						<a href="http://www.0404.go.kr/dev/main.mofa" style="text-decoration: underline;" target="_blank" title="외교부 홈페이지 새창열림">외교부 해외안전여행 여행제한 및 금지구역 확인</a>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- 여행국가 초성 검색 View -->
<div class="search_win_css" id="search_window"  style="display:none;">
	<div class="br_color">
	<div class="dis_win_css">
		<ul class="slist" id="com_search_val"></ul>	
	</div>
		<div class="swin_close" id="swin_close"><button class="winclose" type="button"><span>닫기</span></button></div>
		</div>
</div>

<!-- 여행국가 초성 검색 View -->
</body>
<script type="text/javascript" src="/js/long_term.js"></script>
</html>
