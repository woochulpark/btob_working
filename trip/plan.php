<script>
	function view_pop(plan_type,tripType) {
		$.ajax({
			type : "POST",
			url : "../src/plan_type_view.php",
			data :  { "plan_type" : plan_type , "tripType" : tripType , "auth_token" : auth_token },
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					$("#pop_title").html(json.msg_title);
					$("#pop_content").html(json.msg);
					ViewlayerPop(0);

					$("#loading_area").delay(100).fadeOut();
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
		if( isMobile.any() ) {
			$(".plan_s_width").css("width","160px");
			$(".m_view_p").css("display","block");

			$(".plan_tr").css("width","20%");
		}
	});

	function f_toggle(){
		if ($(".toggle_layer").css('display') != "none") {
			$(".toggle_bt > button").addClass("on").html("열기");		
			$(".toggle_layer").slideUp(300);	
		} else {
			$(".toggle_bt > button").removeClass("on").html("닫기");
			$(".toggle_layer").slideDown(300);
		}
	}

	function f_tab(name, el){
		$(".plan_tab > li").removeClass("on");
		$(el).parent("li").addClass("on");
		$(".plan_tr").hide();
		$("."+name).show();
	}
</script>


	<div id="showplan" style="display:block;">
	<ul class="atab plan_tab">
<? 
	if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
		$b2b_code_table = 'plan_code_btob';
	} else {		
			$b2b_code_table = 'plan_code_mg';		
	}


	$on_cnt=0;
	$sql_code="select cal_type,plan_start_age,plan_end_age  from ".$b2b_code_table." where trip_type='".$tripType."' group by cal_type";
	$result_code=mysql_query($sql_code);
	while($row_code=mysql_fetch_array($result_code)) {
		
		$cal_type=$row_code['cal_type'];
		$plan_start_age=$row_code['plan_start_age'];
		$plan_end_age=$row_code['plan_end_age'];
?>
		<li <? if ($on_cnt=="0") { ?>class="on"<? } ?>><a href="javascript:void(0);" onclick="f_tab('plan_col<?=$cal_type?>', this);"><?=$plan_start_age?>세~<?=$plan_end_age?>세 <span class="count" id="cal_type_id_<?=$cal_type?>">0</span></a></li>
<?
		$on_cnt++;
	}
?>
	</ul>
	<div class="toggle_layer">
	
		<div class="table_line2" style="min-width:100%;">
			<table class="table_style1 plan_table" style="font-size:0.95em">
				
				<thead>
					<tr>
						<th style="width:%;" class="plan_s_width">
							플랜명 (보험나이)
						</th>
	<? 
		$td_cnt=1;
		$plan_array=array();

		

		$sql_code="select * from ".$b2b_code_table." where trip_type='".$tripType."'";
		$result_code=mysql_query($sql_code);
		while($row_code=mysql_fetch_array($result_code)) {

			$plan_array[$td_cnt]['plan_code']=$row_code['plan_code'];
			$plan_array[$td_cnt]['cal_type']=$row_code['cal_type'];
			for ($i=1;$i<27;$i++) { 
				$plan_array[$td_cnt]['type_'.$i]=$row_code['type_'.$i];
			}
			echo "<!--".$plan_array[$td_cnt]['plan_code']."-->";
	?>
						<th style="text-align:center;width:10%;<? if ($row_code['cal_type']!='1') { ?>display:none;<? } ?>" class="plan_tr <?=$row_code['plan_code']?> plan_col<?=$row_code['cal_type']?>">
							<?=stripslashes($row_code['plan_title'])?><br><a href="javascript:void(0);" onclick="plan_code_select('<?=$row_code[plan_code]?>','<?=$row_code[cal_type]?>','<?=$row_code[no]?>');" class="btnTiny plan_col_sel_<?=$row_code['cal_type']?>" id="btob_<?=$row_code['no']?>"><span>선택</span></a>
						</th>
	<?
			$td_cnt++;
		}
	?>

					</tr>
				</thead>
				<tbody>
	<? 
		$tr_cnt=1;

		if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
			$b2b_type_table = 'plan_code_type_btob';
		} else {
			$b2b_type_table = 'plan_code_type_mg';
		}

		$sql_title="select * from ".$b2b_type_table." where trip_type='".$tripType."'";
		
		$result_title=mysql_query($sql_title);
		while($row_title=mysql_fetch_array($result_title)) {
	?>
					<tr>
						<td class="tl plan_s_width "><button type="button" class="q_bt" onclick="view_pop('<?=$row_title[plan_type]?>','<?=$tripType?>');"><?=stripslashes($row_title['title'])?></button> </td>
	<?
			for ($i=1;$i<$td_cnt;$i++) { 
				if ($plan_array[$i]['type_'.$tr_cnt]=="0" || $plan_array[$i]['type_'.$tr_cnt]=="") {
					$table_price="";
				} else {

					$table_price=kor_won($plan_array[$i]['type_'.$tr_cnt]);
				}
	?>
						<td style="text-align:right;width:10%;<? if ($plan_array[$i]['cal_type']!='1') { ?>display:none;<? } ?>" class="plan_tr <?=$plan_array[$i]['plan_code']?> plan_col<?=$plan_array[$i]['cal_type']?>"><?=$table_price?></td>
	<?
			}
	?>
					</tr>
	<?
			$tr_cnt++;
		}
	?>
				</tbody>
			</table>
		</div>
	</div>
</div>