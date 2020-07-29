<div id="footer_wrap">
	<div class="footer">
		<p class="go_home"><a href="https://www.toursafe.co.kr/" target="_blank">투어세이프 홈페이지 바로가기</a></p>
		<ul class="f_navi">
			<li><a href="javascript:void(0)" onclick="f_pop2('../include/clause1.php', '이용약관');">이용약관</a></li>
			<li><a href="javascript:void(0)" onclick="f_pop2('../include/clause5.php', '개인정보 수집 및 이용');">개인정보취급방침</a></li>		
			<li><a>해외여행보험약관 (</a><a href="../doc/overseas(DB).pdf" target="_blank">DB</a><a> / </a><a href="../doc/overseas(CHUBB).pdf" target="_blank">CHUBB</a><a>)</a></li>			
			<li><a>국내여행보험약관(</a><a href="../doc/domestic(DB).pdf" target="_blank">DB</a><a> / </a><a href="../doc/domestic(CHUBB).hwp" target="_blank">CHUBB</a><a>)</a></li>			
		</ul>
		<address>
			<span>주소 서울특별시 종로구 경희궁1길 18,2층(신문로2가)</span><span class="footer-line"></span><span>대표 김정훈</span><span class="footer-line"></span><span>사업자등록번호 118-88-00158  </span><br><span>이메일 <a href="mailto:toursafe@bis.co.kr">toursafe@bis.co.kr</a> </span><span class="footer-line"></span><span>전화 <a href="tel:1800-9010">1800-9010</a> </span><span class="footer-line"></span><span>팩스 02-2088-1673 </span>
			</address>
			<p class="copy">COPYRIGHT ⓒ TOURSAFE Co., Ltd. ALL RIGHTS RESERVED </p>

	</div>
</div>

<script>
	$("#endorsereq").on("click",function(){
		 endorse_pop();
	});

	$(document).on("click","#close_endores",function(){
		close_pop("pop_wrap");
	});
	
	function endorse_pop(){
		var pop_width = ($(window).width() / 2) - 350;
		var pop_height = ($(window).height() / 2) - 235;
		$('#pop_wrap').css('display','block');
		
		$('.pop_con').css('left',pop_width+"px");
		$('.pop_con').css('top',pop_height+"px");
	}

	function terms_pop(xwidth, yheight){
		var pop_width = ($(window).width() / 2) - xwidth;
		var pop_height = ($(window).height() / 2) - yheight;
		$('#pop_wrap').css('display','block');
		
		$('.pop_con').css('left',pop_width+"px");
		$('.pop_con').css('top',pop_height+"px");
	}


	function close_pop(cl_name){
		$("#"+cl_name).css('display', 'none');
	}

</script>
<div id="layerPop20" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:700px;">
				<div class="pop_head">
					<p class="title" id="yak_tit2"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="yak_area2" class="pop_body ">
					
				</div>

			</div>
		</div>
	</div>
</div>
 <!-- 배서요청 팝업 -->
<div id="pop_wrap" style="display: none;">
    <div class="bg"></div>
	<div id="layer_body">


	</div>
</div>
<script type="text/javascript">
		function f_pop_layer(page, body,xwidth,yheight){		
		
			$('#'+body).load(page, function(){		
					terms_pop(xwidth,yheight);
			});				
		}

		$('#bulk_confirm').on('click',function(){
				f_pop_layer('../../src/term_condition.php?tripType=<?=($tripType != '')?$tripType:$_GET["tripType"];?>', 'layer_body',350,385);
		});

		$('#common_plan_pop').on('click',function(){
				var insu_sel_no = $('#selinsuran :selected').val();
				var tripBoth = $('input[name=trip_Type]').val();
				//var ju_chk_cnt = $('input[name="juminno[]"]').length();
				var stdate, endate , sthour, enhour;

				stdate = $('#start_date').val();
				endate = $('#start_hour').val();			

				if( (stdate == '' ) || (endate == '') ){
					alert('여행기간이 정해지지 않았습니다.');
					$('#start_date').focus();
					return false;
				}
					
				if(insu_sel_no == ''){
					alert('보험사를 선택해주세요.');
					$('#selinsuran').focus();
					return false;
				}
				var nVal = 0;	
				var totVal = 0;
				$('#formBox input[name="juminno[]"]').each(function(){
					if($(this).val() == ''){
						nVal++;
						console.log('결과값'+$(this).val());
					} else {
						nVal = 0;
					}					
				});

				totVal = $('#formBox input[name="juminno[]"]').length;

				console.log(totVal+" : "+ nVal);
				
				if(nVal > 0 && (totVal == nVal)){
					alert('입력된 주민등록 번호가 없습니다.');
					$('input[name="juminno[0]"]').focus();
					return false;
				}

				f_pop_layer('../../src/plan_s_pop.php?both=common&select_insu='+insu_sel_no+'&tripType='+tripBoth, 'layer_body',570,421);
		});

		$(document).on('click','button[name=ch_particul_plan]', function(){
				var insu_sel_no = $('#selinsuran :selected').val();
				var tripBoth = $('input[name=trip_Type]').val();
				var put_rows = $(this).closest('tr').index();
				var val_ju = $(this).closest('tr').find("td:nth-child(5) input").val();
				var val_age= $(this).closest('tr').find("td:nth-child(6) input").val();
				var stdate, endate , sthour, enhour;

				stdate = $('#start_date').val();
				endate = $('#start_hour').val();			

				if( (stdate == '' ) || (endate == '') ){
					alert('여행기간이 정해지지 않았습니다.');
					$('#start_date').focus();
					return false;
				}


				if( (val_ju == '') || (val_age == '') ){
					alert('정확한 주민등록 번호가 입력되지 않았습니다.');
					$(this).closest('tr').find("td:nth-child(5) input").focus();
					return false;
				} else {
					f_pop_layer('../../src/plan_s_pop.php?both=particul&rowind='+put_rows+'&select_insu='+insu_sel_no+'&tripType='+tripBoth, 'layer_body',570,421);
				}
				
		});

		$('#endorsedet').on('click',function(){
				f_pop_layer('../../src/endorse_det.php?num=<?=$num?>','layer_body',350 ,300 );
		});

		$('#endorsereq').on('click',function(){
				f_pop_layer('../../src/endorse_req.php?num=<?=$num?>','layer_body',350 ,300 );
		});

		$('#selinsuran').on('change', function(){
			resetPlPr('');
		});

		$('input[name="rr"]').on('change',function(){
			resetPlPr('plan');
		});

		$('#trip_purpose').on('change',function(){
			resetPlPr('plan');
		});

		function f_pop2(page,name){
		
		$("#yak_tit2").html(name);
		$('#yak_area2').load(page, function(){
			ViewlayerPop(20);
		});
		}
	</script>