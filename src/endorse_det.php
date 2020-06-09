<?
	include ("../include/common.php"); 
	$vi_q="select * from hana_plan_request where plan_no='{$num}' and member_no='{$_SESSION['s_mem_no']}'  ";
	$vi_e=mysql_query($vi_q);
	//$row=mysql_fetch_array($vi_e);
	$total = mysql_num_rows($vi_e);

?>
<div class="pop_con w700">
        <div class="pop_con_inner">
            <div class="pop_head">
                <p class="tit" id="pop_title">배서 상세목록</p>
                <p class="btn_close" onclick="close_pop('pop_wrap');"><img src="../img/common/btn_close.png" alt="닫기"></p>
            </div>
            <form action="" method="" id="formBox">
                <fieldset>
                <!-- s : 수정 200302 -->
                <div class="pop_body endor_req">
				<?
				$w= 1;
					while($row=mysql_fetch_array($vi_e)){
						//$editor_row=sql_one_one("nation","nation_name"," and no='{$row['plan_no']}'");
						$content=nl2br(stripslashes($row['content']));
				?>
                    <div id="result_area1">
                        <ul>
                            <li>
                                <label>청약번호</label>
                                <div><?=$row['plan_no']?></div>
                            </li>
                            <li>
                                <label>접수일자</label>
                                <div><?=date("Y-m-d",$row['regdate'])?></div>
                            </li>
						</ul>		
						<ul>
                            <li>
                                <label>접수내용</label>
                                <div class="selectbox">
                                    <select name="" id="receptionCont" >
										<option value="" <?=($row['chnage_state'] == '1')? "selected":""?>>처리중</option>
                                        <option value="" <?=($row['chnage_state'] == '2')? "selected":""?>>수정완료</option>
                                        <option value="" <?=($row['chnage_state'] == '3')? "selected":""?>>취소완료</option>
                                    </select>
                                </div>
                            </li>
							 <li>
                                <label>계약자 주민번호</label>
                                <div class=""><input type="text" name="jumin_1" value=""> - <input type="password" name="jumin_2" value=""></div>
                            </li>
                        </ul>						
                        <ul>
                            <li>
                                <textarea name="" id=""><?=$content?></textarea>
                            </li>
                        </ul>
                    </div>
					<?
						if($total == $w && $w > 1){
					?>
                    <div class="modify_line"></div>
					<?
						}
					$w++;
				} //end while
					
				?>
				</div> 
				<div class="pop_body endor_det">
				 <div id="result_area2">
				 		<ul>
							<li >
							 <p>어드민 로그</p>
							 </li>
						</ul>
                        <ul>
                            <li>
                                <label>청약번호</label>
                                <div><?=$num?></div>
                            </li>
						</ul>
						<?/*
                            <li>
                                <label>접수일자</label>
                                <div><?=date("Y-m-d",$row['regdate'])?></div>
                            </li>
						</ul>
						
						<ul>
                            <li>
                                <label>접수내용</label>
                                <div class="selectbox">
                                    <select name="" id="receptionCont" >
										<option value="" <?=($row['chnage_state'] == '1')? "selected":""?>>처리중</option>
                                        <option value="" <?=($row['chnage_state'] == '2')? "selected":""?>>수정완료</option>
                                        <option value="" <?=($row['chnage_state'] == '3')? "selected":""?>>취소완료</option>
                                    </select>
                                </div>
                            </li>
							 <li>
                                <label>계약자 주민번호</label>
                                <div class=""><input type="text" name="jumin_1" value=""> - <input type="password" name="jumin_2" value=""></div>
                            </li>
                        </ul>		
						*/
							$endor_log_que = " SELECT * FROM admin_log WHERE modify_no = '{$num}' ";
							$endor_log_result = mysql_query($endor_log_que);
						?>
                        <ul>
                            <li>
                                <?
									if($endor_log_result){
										$area_val =  "<textarea name='' id=''>";
										while($endor_log_rows = mysql_fetch_array($endor_log_result)){
										$area_val .=  $endor_log_rows['log_content'].'					['.date("Y-m-d",$endor_log_rows['regdate']).']
';
										
										}
										$area_val .= "</textarea>";
										
									} else {
										$area_val = "<textarea name='' id=''></textarea>";
									}
									echo$area_val;
								?>
								
                            </li>
                        </ul>
                    </div>
				 <div class="pop_foot">
				 </div>
				
				

				<?
				/*
                <div class="pop_foot">
                    <div class="foot_line"></div>
                    <div class="p_btn_area">
                        <button type="button" name="submit" class="btn_popup_apply">등록</button>
                        <button type="button" name="button" class="btn_popup_cancel">취소</button>
                    </div>
                </div>
				*/
				?>
                </fieldset>
            </form>
        </div>

    </div>