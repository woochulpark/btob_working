<? include ("../include/top.php"); ?>

<script>
	var oneDepth = 0; //1차 카테고리
	$(document).ready(function() {
		$(".join_step > ol > li:nth-child(1)").addClass("on");
		
		$('#all_no').click(function() {
			if ($(this).is(":checked")) {
				$('.aa_no').prop("checked", true);
				$('.aa_no').parent().parent().addClass("ez-selected");
				$('.aa_ok').parent().parent().removeClass("ez-selected");
				$('.aa_ok').prop("checked", false);
			} else {
				$('.aa_no').prop("checked", false);
				$('.aa_no').parent().parent().removeClass("ez-selected");
			}
		})

		$('.aa_ok').click(function() {
			$('#all_no').prop("checked", false);
			$('#all_no').parent().removeClass("ez-checked");
		})
		
		$('.aa_no').change(function(){
			if ($('.aa_no:checked').length == $('.aa_no').length) {
				$('#all_no').prop("checked", true);
				$('#all_no').parent().addClass("ez-checked");
			}
		});
		

		$('#allagree').click(function() {
			if ($(this).is(":checked")) {
				$('.agree').prop("checked", true);
				$('.agree').parent().addClass("ez-checked");

			} else {
				$('.agree').prop("checked", false);
				$('.agree').parent().removeClass("ez-checked");
			}
		})

		$('.agree').change(function(){
			if ($('.agree:checked').length == $('.agree').length) {
				$('#allagree').prop("checked", true);
				$('#allagree').parent().addClass("ez-checked");
			}else {
				$('#allagree').prop("checked", false);
				$('#allagree').parent().removeClass("ez-checked");
			}
		});
	});


	function check_form() {
		frm = document.send_form
	
		if ($("input:checkbox[name='chk1']").is(":checked") == false) {
			alert('이용약관에 동의해 주세요.');
			return false;
		}

		if ($("input:checkbox[name='select_agree']").is(":checked") == false) {
			alert('개인정보 수집 및 이용목적에  동의해 주세요.');
			return false;
		}

		frm.submit();


		
		
	}

</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			 <!-- s : container -->
    <section id="container">


<form name="send_form" method="post" action="join02.php">
<? /*
                        <div class="join_step">
						<ol class="three">
							<li><span class="ico"><span>1</span></span><span class="txt">약관동의</span></li>
							<li><span class="ico "><span>2</span></span><span class="txt">정보입력</span></li>
							<li><span class="ico "><span>3</span></span><span class="txt">가입완료</span></li>
						</ol>
                           
                        </div>
			*/
			?>
                        <!-- 약관 -->
                        <h3 class="s_tit ">이용약관</h3>
                        <div class="scrollbox">
							<? include ("../include/clause1.php"); ?>
                        </div>
                        <div class="check_boxW tr">
                            <label><input type="checkbox" name="chk1" class="agree">동의합니다.</label>
                        </div>
                        <!-- //약관 -->

                        <!-- 약관 -->
                        <h3 class="s_tit ">개인정보 수집 및 이용목적 </h3>
                        <div class="scrollbox">
                           <? include ("../include/clause4.php"); ?>
                        </div>
                        <div class="check_boxW tr">
                            <label><input type="checkbox" name="select_agree" class="agree" value="Y">동의합니다.</label>
                        </div>
                        <!-- //약관 -->

                       

                        <div class="tc f115 pt10 mt20 all_check" style="border-top:1px dashed #ccc">
                            <label><input type="checkbox" id="allagree" class="" value="" name=""> <strong>전체 약관에 동의합니다.</strong></label>
                        </div>





                        <div class="btn-tc "> <a href="javascript:void(0);" onclick="check_form();" class="btnStrong m_block"><span>가입하기</span></a> <a href="#url" class="btnStrong cancel m_block "><span>취소하기</span></a> </div>
</form>


			
				

		 </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->
<div id="layerPop0" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:700px;">
				<div class="pop_head">
					<p class="title" id="yak_tit"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="yak_area" class="pop_body ">
					
				</div>

			</div>
		</div>
	</div>
</div>
</body>

</html>
