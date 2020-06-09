<? include ("../include/top.php"); ?>
<?
		if(!isset($_SESSION['s_mem_id'])){
?>
		<script>
			alert('로그인을 하셔야 합니다. ');
			location.href="../member/login.php";
		</script>
<?
		} else {
			$member_que = " SELECT * FROM toursafe_members WHERE uid = '{$_SESSION['s_mem_id']}' ";
			$member_result = mysql_query($member_que);
			if(!$member_result){
			
			} else {
				while($row=mysql_fetch_array($member_result)){
					$com_m_id = $row['uid'];
					$business_name = $row['com_name'];
					$business_op_date = $row['com_open_date'];
					$businessNo = $row['com_no'];
					$phoneContact = decode_pass($row['hphone'],$pass_key);
					$faxContact = decode_pass($row['fax_contact'],$pass_key);
					$emailContact = decode_pass($row['email'],$pass_key);
					$postNo = $row['post_no'];
					$postAddr = $row['post_addr'];
					$postDetail = $row['post_addr_detail'];
					$fileRname = $row['file_real_name'];
					$fileName = $row['file_name'];
					
				}
				$mailCont = explode("@",trim($emailContact));
				
				$faxContact = trim($faxContact);
				$tel = trim($phoneContact);
				
			}
		}	
?>
<script>
	var oneDepth = 0; //1차 카테고리

	var id_check="N";

	function chk_same(){

		frm=document.joinb2b;

		if(!frm.b2bid.value) {
			alert('아이디를 입력하여 주십시오.');		
			frm.b2bid.focus();
			return false;
		}

		if(!idCheck(frm.b2bid.value)){
			alert('아이디는 5~12자 내의 영문, 숫자 조합으로 등록해 주세요.');
			$('input[name=b2bid]').focus();
			return false; 
		}
	
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/chk_id_same.php",
			data : { 'uid' : frm.b2bid.value , 'auth_token' : auth_token},
			success : function(data, status)
			{		
				
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					alert(json.msg);
					id_check="Y"
					$("#check_uid").val(frm.b2bid.value);
					$("#loading_area").css({"display":"none"});
					return false;
				} else {
					alert(json.msg);
					$("#loading_area").css({"display":"none"});
					return false;
				}
			},
			error : function(err)
			{
				alert(err.responseText);
				$("#loading_area").css({"display":"none"});
				return false;
			}
		});
	}

	function check_form() {
		var frm = document.joinb2b;	
		/*		
		if(frm.b2bid.value==frm.b2bpw.value) {
			alert("비밀번호는 띄어쓰기 없는 영문, 숫자, 특수문자 (!,@,#,$,%,^,*,+,=,-) 조합 9~20자리 이내만 사용하실 수 있으며 아이디와 동일하게 사용할 수 없습니다.");
			$('input[name=b2bpw]').focus();
			return false; 
		}
*/
		if(!chkPwd(frm.b2bpw.value) && frm.b2bpw.value != ''){
			alert("비밀번호는 띄어쓰기 없는 영문, 숫자, 특수문자 (!,@,#,$,%,^,*,+,=,-) 조합 9~20자리 이내만 사용하실 수 있으며 아이디와 동일하게 사용할 수 없습니다.");
			$('input[name=b2bpw]').focus();
			return false; 
		}

		if(frm.b2bpw.value!=frm.b2bpws.value && (frm.b2bpw.value != '' && frm.b2bpws.value != '') )
		{
			alert('비밀번호와 확인번호를 동일하게 입력하여 주십시오.');
			frm.b2bpw.value='';
			frm.b2bpws.value='';
			frm.b2bpw.focus();
			return false;
		}
		
		if(frm.com_name.value=='') {
			alert('기업/단체 이름을 입력하여 주십시오.');
			frm.com_name.focus();
			return false;
		}

		if(frm.open_com_d.value=='') {	
			alert('개업연월일을 입력하여 주십시오.');
			frm.open_com_d.focus();
			return false;
		}

		if(frm.com_no.value == ''){
			alert('사업자 등록번호를 입력하여 주십시오.');
			frm.com_no.focus();
			return false;
		}
		/*
		if(frm.mail_front.value=='' ||  frm.mail_back.value=='') {
			alert('기업/단체 이메일을 입력하여 주십시오.');
			frm.mail_front.focus();
			return false;
		}
	
		var eamil_address = frm.mail_front.value+'@'+frm.mail_back.value;

		if(!emailCheck(eamil_address)){
			alert("이메일을 정확히 입력해 주세요.");
			$('input[name=email_front]').focus();
			return false; 
		}

		
		if(frm.hphone.value=='') {
			alert('전화번호를 입력하여 주십시오.');
			frm.hphone.focus();
			return false;
		}
	*/
		var property = $("input[name=com_file_img]")[0].files[0];	
		
		$("#loading_area").css({"display":"block"});
		$("#auth_token").val("<?=$site_check_key?>");	
		
		var form_data = new FormData($('form[name=joinb2b]')[0]);
		form_data.append('fileObj',property);
			


		$.ajax({
			type : "POST",
			dataType:'text',
			url : "../src/member_process_edi.php",			
			contentType:false,
          cache:false,
          processData:false,
			data : form_data,
			success : function(data, status)
			{
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="complete.php?uid="+json.msg;
					$("#loading_area").delay(100).fadeOut();
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
		$(".join_step > ol > li:nth-child(2)").addClass("on");
		var today = new Date();
		var min_date = new Date('1990-01-01 00:00:00').valueOf();
		
		
		$(" #open_com_d").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date",			
            changeYear: true,
			yearSuffix: "년", //연도 뒤에 나오는 텍스트 지정
			startdate:min_date ,
			maxDate:today
		});

	});

</script>
<div class="loading_area" id="loading_area" style="display:none">
	<p class="loading_img"><img src="../img/common/bx_loader.gif"></p>
	<div id="bg"></div>
</div>
<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php");?>
			<!-- //header -->
			 <!-- s : container -->
    <section id="container">
        <section id="h1">
            <div><h1>거래처 회원정보 수정</h1></div>
            <div><span class="dot">*</span><span class="c_red f400">표시는 필수로입력하시기 바랍니다.</span></span></div>
        </section>
        <form name="joinb2b" action="" method="" id="formBox" enctype="multipart/form-data" >
		<input type="hidden" id="auth_token" name="auth_token" readonly="">
		<input type="hidden" name="mem_edit" id="mem_edit" value="Y" readonly>
		<!--
					$com_m_id = $row['uid'];
					$business_name = $row['com_name'];
					$business_op_date = $row['com_open_date'];
					$businessNo = $row['com_no'];
					$phoneContact = $row['hphone'];
					$faxContact = $row['fax_contact'];
					$emailContact = $row['email'];
					$postNo = $row['post_no'];
					$postAddr = $row['post_addr'];
					$postDetail = $row['post_addr_detail'];
					$fileRname = $row['file_real_name'];
					$fileName = $row['file_name'];
				-->
        <fieldset>
            <section id="join_info">
                <div>
                    <ul>
                        <li>
                            <label for=""><span class="dot">*</span><span class="c_red">거래처 ID</span></label>
                            <div class="id_wBox"><?=$com_m_id?></div>
                            <div class="id_btn"></div>
                        </li>
                        <li>
                            <label for=""><span class="dot">*</span><span class="c_red">상호명</span></label>
                            <input type="text" name="com_name" id="com_name" value="<?=$business_name?>">
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label for=""><span class="dot">*</span><span class="c_red">비밀번호</span></label>
                            <input type="password" name="b2bpw" id="b2bpw">
                        </li>
                        <li>
                            <label for=""><span class="dot">*</span><span class="c_red">비밀번호 확인</span></label>
                            <input type="password" name="b2bpws" id="b2bpws">
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label for=""><span class="dot">*</span><span class="c_red">개업연월일</span></label>
							<span class="date_picker3">
                            <input type="text" name="open_com_d" id="open_com_d" value="<?=$business_op_date?>" style="border:0px;" readonly placeholder="사업자 등록증 기준">
							</span>
                        </li>
<style>
.file_input_textbox{ float: left;}
.file_input_div{ position: relative; height: 22px; overflow: hidden; border:1px solid black; text-align: center; vertical-align: bottom; border-radius: 4px; padding-top: 3px; font-size: 12px; color:black; background-color:#e7e7e7; font-weight: 420; cursor:pointer;}
.file_input_button{ width: 100px; position: absolute; top: 0px; background-color: #33BB00; color: #FFFFFF; border-style: solid;}
.file_input_hidden{ font-size: 45px; position: absolute; right: 0px; top: 0px; width: 75px; height: 26px; opacity: 0;  filter: alpha(opacity=0);  -ms-filter: "alpha(opacity=0)";  -khtml-opacity: 0;  -moz-opacity: 0;}
</style>
                        <li>
                            <div>
                                <label for=""><span class="dot">*</span><span class="c_red">사업자 등록 번호</span></label>
                                <div class="id_wBox"><input type="text" id="com_no" class="onlyNumber" name="com_no" value="<?=$businessNo?>"></div>
                                <div class="id_btn"><div class="file_input_div">파일업로드<input type="file" class="file_input_hidden" name="com_file_img" /></div><!--<button type="button" name="button" id="com_no_pop" class="btn_s4">파일첨부</button>--></div>
                            </div>
                            <div class="stxt">(사업자 등록증 업로드 필수 아님)<input type="checkbox" name="delfile" value="fdel"  />파일 삭제</div></div>
                        </li>
                    </ul>
                    <ul>
                        <li class="tel">
                            <div class="phone">
                                <label for="">전화번호</label>
                                <ul>
                                    <li>
									<?/*
                                        <select name="sel_phone" id="sel_phone" title="" class="nb">
                                            <option value="02" selected="selected">02</option>
                                            <option value="031">031</option>
                                            <option value="032">032</option>
                                            <option value="033">033</option>
                                            <option value="041">041</option>
                                            <option value="042">042</option> 
                                            <option value="043">043</option> 
                                            <option value="044">044</option> 
                                            <option value="051">051</option> 
                                            <option value="052(2)">052(2)</option> 
                                            <option value="053">053</option> 
                                            <option value="054">054</option> 
                                            <option value="055">055</option>
                                            <option value="061">061</option>
                                            <option value="062">062</option>
                                            <option value="063">063</option>
                                            <option value="064(7)">064(7)</option>
                                        </select>
                                    </li>
                                    <li><input type="text" id="phone_front" name="phone_front" class="onlyNumber" maxlength="4" title="연락처 앞자리를 넣어주세요"  class="nb"></li>
                                    <li><input type="text" id="phone_back" name="phone_back" class="onlyNumber" maxlength="4" title="연락처 뒷자리를 넣어주세요" class="nb">
									*/?>
									<input type="text" id="phonenum" name="phonenum"  style="width:100%;"  title="연락처"  class="onlyNumber" value="<?=$tel?>"  placeholder="숫자만">
									</li>
                                </ul>
                            </div>
                            <div class="fax">
                                <label for="">팩스</label>
                                <input type="text" name="faxnum" id="faxnum" value="<?=$faxContact?>" class="onlyNumber" placeholder="숫자만">
                            </div>
                            <div class="email">
                                <label for="">이메일</label>
                                <ul>
                                    <li><input type="text" id="mail_front" name="mail_front" value="<?=$mailCont[0]?>"></li>
                                    <li>@</li>
									 <li><input type="text" id="mail_back" name="mail_back" value="<?=$mailCont[1]?>" readonly></li>
                                    <li>
                                        <select name="chmail" id="chmail">
                                            <option value="" selected>선택하세요</option>
                                            <option value="hanmail.net" <?=($mailCont[1] == 'hanmail.net')?'selected':'';?> >hanmail.net</option>
                                            <option value="daum.net" <?=($mailCont[1] == 'daum.net')?'selected':'';?> >daum.net</option>
                                            <option value="naver.com" <?=($mailCont[1] == 'naver.com')?'selected':'';?> >naver.com</option>
                                            <option value="gmail.com" <?=($mailCont[1] == 'gmail.com')?'selected':'';?>  >gmail.com</option>
                                            <option value="nate.com" <?=($mailCont[1] == 'nate.com')?'selected':'';?> >nate.com</option>
                                            <option value="lycos.co.kr" <?=($mailCont[1] == 'lycos.co.kr')?'selected':'';?> >lycos.co.kr</option>
                                            <option value="paran.com" <?=($mailCont[1] == 'paran.com')?'selected':'';?> >paran.com</option>
                                            <option value="hanmir.com" <?=($mailCont[1] == 'hanmir.com')?'selected':'';?> >hanmir.com</option>
                                            <option value="empal.com" <?=($mailCont[1] == 'empal.com')?'selected':'';?> >empal.com</option>
                                            <option value="netian.com" <?=($mailCont[1] == 'netian.com')?'selected':'';?> >netian.com</option>
                                            <option value="dreamwiz.com" <?=($mailCont[1] == 'dreamwiz.com')?'selected':'';?> >dreamwiz.com</option>
                                            <option value="hanafos.com" <?=($mailCont[1] == 'hanafos.com')?'selected':'';?> >hanafos.com</option>
                                            <option value="hananet.net" <?=($mailCont[1] == 'hananet.net')?'selected':'';?> >hananet.net</option>
                                            <option value="korea.com" <?=($mailCont[1] == 'korea.com')?'selected':'';?> >korea.com</option>
                                            <option value="hotmail.com" <?=($mailCont[1] == 'hotmail.com')?'selected':'';?> >hotmail.com</option>
                                            <option value="hanwha.com" <?=($mailCont[1] == 'hanwha.com')?'selected':'';?>  >hanwha.com</option>
                                            <option value="etc">기타[직접입력]</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="address">
                            <label for="">주소</label>
                            <div class="zip">
                                <div class="wBox"><input type="text" id="contPost" name="contPost" value="<?=$postNo?>" readonly></div>
                                <div class="btn"><button type="button" name="button" id="searchaddr" class="btn_s4">주소검색</button></div>
                            </div>
                            <div><input type="text" name="joinAddr" value="<?=$postAddr?>" readonly></div>
                            <div><input type="text" name="joinAddrDetail" value="<?=$postDetail?>" readonly></div>
                        </li>
                    </ul>
                </div>
            </section>
            <div class="line_red"></div>
            <section id="btn_area">
                <div class="btn_list">
                    <button type="button" id="form_reset" class="btn_s2">수정취소</button>
                    <button type="button" id="form_submit" class="btn_s1">수정완료</button>
                </div>
            </section>  
        </fieldset>
        </form>
    </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->

</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('#searchaddr').on('click',function(){
			goPopup();
		});

		$('#chk_id').on('click',function(){
			chk_same();
		});

		$('#chmail').on('change',function(){
			if($(this).val() != 'etc'){
				$('#mail_back').attr('readonly', true);
				$('#mail_back').val('');
				$('#mail_back').val($(this).val());
			} else {
				$('#mail_back').val('');
				$('#mail_back').attr('readonly', false);
			}
		});

		$('#form_reset').on('click',function(){
			$('form[name=joinb2b]').each(function(){
				this.reset();
			});
		});
		
		$('#form_submit').on('click',function(){
			check_form();
		});
	});

	function goPopup(){
		
			var pop = window.open("./jusopopup.php?isMobile=N","pop","width=570,height=420, scrollbars=yes, resizable=yes");	
		/*
		if ($(".ver_p").is(":visible")){
			var pop = window.open("./jusopopup.php?isMobile=N","pop","width=570,height=420, scrollbars=yes, resizable=yes");	
		} else {
			var pop = window.open("./jusopopup.php?isMobile=Y","pop","scrollbars=yes, resizable=yes");	
		}	
		*/
	}

	function jusoCallBack(roadFullAddr,roadAddrPart1,addrDetail,roadAddrPart2,engAddr, jibunAddr, zipNo, admCd, rnMgtSn, bdMgtSn,detBdNmList,bdNm,bdKdcd,siNm,sggNm,emdNm,liNm,rn,udrtYn,buldMnnm,buldSlno,mtYn,lnbrMnnm,lnbrSlno,emdNo){
		
	var frm = document.joinb2b;
	
	// 팝업페이지에서 주소입력한 정보를 받아서, 현 페이지에 정보를 등록합니다.
		frm.joinAddr.value = roadAddrPart1 + " " + roadAddrPart2;
		frm.joinAddrDetail.value = addrDetail;
		frm.contPost.value = zipNo;
		/*
		if (    
				$("#contNm").val() != '' && 
				$("#contSsn1").val().length  == 6 && $("#contSsn1").val()  != '' &&
				$("#contSsn2").val().length  == 7 && $("#contSsn2").val()  != '' &&
				$("#contPhone").val()  != '' && ($("#contPhone").val().length  == 10 || $("#contPhone").val().length  == 11) &&
				$("#contEmail").val()  != '' && reg_email.test($("#contEmail").val()) == true &&
				$("#contPost").val()  != '' && $("#contAddr").val()  != '' && $("#contAddrDetail").val()  != ''
	    	)
	    	{
				$('.btn_next').addClass('on');
			} else {
				$('.btn_next').removeClass('on');
			}
		*/
}


</script>
</html>
