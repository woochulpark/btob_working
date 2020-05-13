function insuterminator() {
	var frm=document.send_form;

	if (tripType=="2") {
		/*
		if (frm.nation.value=="") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}
		*/
		if(frm.nation.value=="" && frm.nation_search.value != ""){
				alert('입력하신 여행국가는 인수제한 국가이거나, 국가명 오류 입력으로 확인됩니다.\n인수제한 국가 확인 및 정확한 국가명 입력을 부탁드립니다.');
			return false;
		} else if (frm.nation.value=="" && frm.nation_search.value == "") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}
	}


	if (frm.trip_purpose.value=="") {
		alert('여행목적을 선택해 주세요.');
		return false;
	}

	if (frm.trip_purpose.value=="3") {
		alert('운동경기/위험활동/기타의 경우는 보험인수가 거절됩니다.\n\n다음 단계로 진행이 불가합니다.');
		return false;
	}

	if (frm.start_date.value=="") {
		alert('출발일을 선택해 주세요.');
		return false;
	}

	if (frm.end_date.value=="") {
		alert('도착일을 선택해 주세요.');
		return false;
	}

	var input_length=$("input[name='input_name[]']").length;
	
	for (var i=0;i<input_length;i++) {
		if ($("input[name='input_name[]']").eq(i).val()=="") {
			alert('이름을 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val()=="") {
			alert('주민번호 앞자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val().length!="6") {
			alert('주민번호 앞자리를 정확히 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val()=="") {
			alert('주민번호 뒷자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val().length!="7") {
			alert('주민번호 뒷자리를 정확히 입력하세요.');
			return false;
		}
	}

	if ($("input[name='hphone1[]']").eq(0).val()=="" || $("input[name='hphone2[]']").eq(0).val()=="" || $("input[name='hphone3[]']").eq(0).val()=="") {
		alert('대표가입자 연락처를 입력하세요.');
		return false;
	}

	if ($("input[name='hphone1[]']").eq(0).val().length < 3) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone2[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone3[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}
	
	$("#auth_token").val(auth_token);
	$("#loading_area").css({"display":"block"});

	view_reset();

	$.ajax({
		type : "POST",
		url : "../src/insurance_cal.php",
		data :  $("#send_form").serialize(),
		success : function(data, status) {
			var json = eval("(" + data + ")");

			if (json.result=="true") {
				$(".last_selec,#showplan").show();

				$("#cal_type_id_1").html(json.cal_type_id_1);
				$("#cal_type_id_2").html(json.cal_type_id_2);
				$("#cal_type_id_3").html(json.cal_type_id_3);
				$("#cal_type_id_4").html(json.cal_type_id_4);

				cal_type_id[1]=json.cal_type_id_1;
				cal_type_id[2]=json.cal_type_id_2;
				cal_type_id[3]=json.cal_type_id_3;
				cal_type_id[4]=json.cal_type_id_4;

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

function plan_code_select(plan_code,cal_type,select_num) {
	if (cal_type_id[cal_type]==0) {
		alert('해당 연령의 가입자가 없습니다.');
		return false;
	}
	cal_type_code[cal_type]=plan_code;

	$(".plan_col_sel_"+cal_type).removeClass("on");
	$("#btob_"+select_num).addClass("on");

	$("#cal_type_"+cal_type+"_code").val(plan_code);

	price_cal();
}

function price_cal() {

	var frm=document.send_form;

	if (tripType=="2") {
/*
		if (frm.nation.value=="") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}
*/
		 if(frm.nation.value=="" && frm.nation_search.value != ""){
				alert('입력하신 여행국가는 인수제한 국가이거나, 국가명 오류 입력으로 확인됩니다.\n인수제한 국가 확인 및 정확한 국가명 입력을 부탁드립니다.');
			return false;
		} else if (frm.nation.value=="" && frm.nation_search.value == "") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}

	}

	if (frm.trip_purpose.value=="") {
		alert('여행목적을 선택해 주세요.');
		return false;
	}

	if (frm.trip_purpose.value=="3") {
		alert('운동경기/위험활동/기타의 경우는 보험인수가 거절됩니다.\n\n다음 단계로 진행이 불가합니다.');
		return false;
	}

	if (frm.start_date.value=="") {
		alert('출발일을 선택해 주세요.');
		return false;
	}

	if (frm.end_date.value=="") {
		alert('도착일을 선택해 주세요.');
		return false;
	}

	var input_length=$("input[name='input_name[]']").length;
	
	for (var i=0;i<input_length;i++) {
		if ($("input[name='input_name[]']").eq(i).val()=="") {
			alert('이름을 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val()=="") {
			alert('주민번호 앞자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val().length!="6") {
			alert('주민번호 앞자리를 정확히 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val()=="") {
			alert('주민번호 뒷자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val().length!="7") {
			alert('주민번호 뒷자리를 정확히 입력하세요.');
			return false;
		}
	}

	if ($("input[name='hphone1[]']").eq(0).val()=="" || $("input[name='hphone2[]']").eq(0).val()=="" || $("input[name='hphone3[]']").eq(0).val()=="") {
		alert('대표가입자 연락처를 입력하세요.');
		return false;
	}

	if ($("input[name='hphone1[]']").eq(0).val().length < 3) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone2[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone3[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	$("#auth_token").val(auth_token);
	$("#loading_area").css({"display":"block"});

	$.ajax({
		type : "POST",
		url : "../src/price_cal.php",
		data :  $("#send_form").serialize(),
		success : function(data, status) {
			var json = eval("(" + data + ")");
			
			if (json.result=="true") {

				total_won=json.total_price_val;

				$(".total_won_1").html(json.total_price);
				$(".total_won_2").html(json.total_price+"원");
				$("#select_cnt").html(json.select_cnt+"명");

				$(".last_selec, #showplan").show();
				$(".hiddenplan").hide();
				var aa = $(".last_selec").offset().top;

				$("#loading_area").delay(300).fadeOut();
				return false;
			} else {
				alert(json.msg);
				view_reset();
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


function submitInsu(){
	var frm=document.send_form;

	if (tripType=="2") {
		/*
		if (frm.nation.value=="") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}
		*/
		 if(frm.nation.value=="" && frm.nation_search.value != ""){
				alert('입력하신 여행국가는 인수제한 국가이거나, 국가명 오류 입력으로 확인됩니다.\n인수제한 국가 확인 및 정확한 국가명 입력을 부탁드립니다.');
			return false;
		} else if (frm.nation.value=="" && frm.nation_search.value == "") {
			alert('여행국가를 선택해 주세요.');
			return false;
		}
	}

	if (frm.trip_purpose.value=="") {
		alert('여행목적을 선택해 주세요.');
		return false;
	}

	if (frm.trip_purpose.value=="3") {
		alert('운동경기/위험활동/기타의 경우는 보험인수가 거절됩니다.\n\n다음 단계로 진행이 불가합니다.');
		return false;
	}

	if (frm.start_date.value=="") {
		alert('출발일을 선택해 주세요.');
		return false;
	}

	if (frm.end_date.value=="") {
		alert('도착일을 선택해 주세요.');
		return false;
	}

	var input_length=$("input[name='input_name[]']").length;
	
	for (var i=0;i<input_length;i++) {
		if ($("input[name='input_name[]']").eq(i).val()=="") {
			alert('이름을 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val()=="") {
			alert('주민번호 앞자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_1[]']").eq(i).val().length!="6") {
			alert('주민번호 앞자리를 정확히 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val()=="") {
			alert('주민번호 뒷자리를 입력하세요.');
			return false;
		}

		if ($("input[name='jumin_2[]']").eq(i).val().length!="7") {
			alert('주민번호 뒷자리를 정확히 입력하세요.');
			return false;
		}
	}

	if ($("input[name='hphone1[]']").eq(0).val()=="" || $("input[name='hphone2[]']").eq(0).val()=="" || $("input[name='hphone3[]']").eq(0).val()=="") {
		alert('대표가입자 연락처를 입력하세요.');
		return false;
	}

	if ($("input[name='hphone1[]']").eq(0).val().length < 3) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone2[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	if ($("input[name='hphone3[]']").eq(0).val().length < 4) {
		alert('대표가입자 연락처를 정확히 입력하세요.');
		return false;
	}

	for (var i=1;i<5;i++ ) {
		if (cal_type_id[i]!=0) {
			if (cal_type_code[i]=="") {
				alert('보험상품을 선택해 주세요.');
				return false;
			}
		}
	}

	$("#auth_token").val(auth_token);
	$("#loading_area").css({"display":"block"});

	$.ajax({
		type : "POST",
		url : "../src/tmp_process.php",
		data :  $("#send_form").serialize(),
		success : function(data, status) {
			var json = eval("(" + data + ")");

			if (json.result=="true") {
				location.href="step04.php";

				$("#loading_area").delay(300).fadeOut();
				return false;
			} else {
				alert(json.msg);
				view_reset();
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


	function treemonthcal(kind, kind1){
		var start_date = kind;
		var data_arr = start_date.split('-');
		var hap_year;
		var hap_month;
		var gap_month;
		var enddate;
		var gap_day;

		 hap_month = Number(data_arr[1]) + Number(kind1);
		 //console.log(hap_month);
		 if(hap_month > 12){
			//gap_month = hap_month - Number(data_arr[1]);
			gap_month = hap_month - 12;

			//console.log('차이: '+gap_month);
		  hap_year = Number(data_arr[0]) + 1;
		 } else {
			gap_month = hap_month;
		  hap_year = Number(data_arr[0]);
		 }
	// 2019-08-21 추가 분 -  월을 분리해서 사용하는 중에 10보다 작은 월에 0을 붙여야 한다. (안붙이면 오류)
		 if(gap_month < 10){
			gap_month = "0"+gap_month;
		 } 

		 console.log('차이: '+gap_month);
		var lastDay = ( new Date(hap_year, gap_month,'')).getDate().toString();

		if(data_arr[2] > lastDay){
			gap_day = lastDay;
		} else {
			gap_day = data_arr[2];
		}
		//console.log('종료 일자 : '+lastDay);
		
		enddate = hap_year+"-"+gap_month+"-"+gap_day;
		//console.log('종료일 : '+enddate);
		return enddate;
	}	

	function check_hour_max(kind1, kind2, kind3, kind4){
		var stdate = $('#'+kind1).val();
		var enddate = $('#'+kind2).val();

		var sthour = $('#'+kind3).val();
		var edhour = $('#'+kind4).val();
		
		var maxdate;	
		var tripType1 = get_limit();
		
		if(tripType1 == "2"){
			maxdate = treemonthcal(stdate, '3');
		} else {
			maxdate = treemonthcal(stdate, '1');
		}
		console.log(cutMaxTripday(stdate, enddate, maxdate, sthour, edhour, tripType1));
		console.log('여행'+maxdate);
		if(!cutMaxTripday(stdate, enddate, maxdate, sthour, edhour, tripType1)){
				if(tripType1 == "2"){
					alert('단기해외여행자보험은 최대 3개월까지 가입가능합니다. 3개월 이상 가입 신청 시 유학(장기체류)보험으로 신청해주세요.');

				} else {
					alert('단기국내여행자보험은 최대 1개월까지 가입가능합니다.');
				}
				 $('#'+kind2).val('')

			return false;
		} else {
			return true;
		}
	}


			function set_limit(limonth){
			month_limit = limonth;
		}	

		function get_limit(){
			return month_limit;
		}