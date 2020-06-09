<?
	include ("../include/common.php"); 
	//$vi_q="select * from hana_plan_request where plan_no='{$num}' and member_no='{$_SESSION['s_mem_no']}'  ";
	//$vi_e=mysql_query($vi_q);
	//$row=mysql_fetch_array($vi_e);
?>
<div class="pop_con w700">
        <div class="pop_con_inner">
            <div class="pop_head">
                <p class="tit" id="pop_title">배서 요청</p>
                <p class="btn_close" onclick="close_pop('pop_wrap');"><img src="../img/common/btn_close.png" alt="닫기"></p>
            </div>
            <form action="" method="send_form_pop" id="send_form_pop">
				<input type="hidden" name="plan_no" value="<?=$num?>" />
                <fieldset>
                <div class="pop_body">
                    <div id="modify">
                        <ul>
                            <li>
                                <label>청약번호</label>
                                <div><?=$num?></div>
                            </li>
                            <li>
                                <label>접수일자</label>
                                <div><?=date("Y-m-d",time())?></div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label>접수내용</label>
                                <div>
                                    <select name="change_type" id="change_type">
                                        <option value="4" >수정 접수</option>
                                        <option value="2" >취소 접수</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label>계약자 주민번호</label>
                                <div><input type="text" name="jumin_1"> - <input type="password" name="jumin_2"></div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <textarea name="content" id="content"></textarea>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pop_foot">
                    <div class="foot_line"></div>
                    <div class="p_btn_area">
                        <button type="button" name="endor_sub" class="btn_popup_apply">등록</button>
                        <button type="button" name="button" onclick="close_pop('pop_wrap');" class="btn_popup_cancel">취소</button>
                    </div>
                </div>
                </fieldset>
            </form>
        </div>
    </div>
	<script src="/js/trip.js"></script>
	<script type="text/javascript">
		
		$('button[name=endor_sub]').on('click',function(){
			var j_no1,j_no2,receipt_both, content_text,planNo;
			j_no1 = $('input[name=jumin_1]');
			j_no2 = $('input[name=jumin_2]');
			receipt_both = $('select[name=change_type]');
			content_text = $('textarea[name=content]');
			planNo = $('input[name=plan_no]');
			 if(jumin_chk(j_no1.val(), j_no2.val()) > 1){
				alert('정확한 주민번호를 입력해주세요.');
				return false;
			 }  

			$.post('../src/plan_change_process.php', {jumin_1:j_no1.val(), jumin_2:j_no2.val(), change_type:receipt_both.val(),content:content_text.val(), select_num:planNo.val() }, function (data){			
            if(data.result){			
                
                alert(data.msg);
                close_pop('pop_wrap');                
               
            } else {
                alert('요청이 등록되지 않았습니다. 다시 한번 시도 해주시기 바랍니다. ');
				return false;
            }			

            },"json");
		});
	</script>