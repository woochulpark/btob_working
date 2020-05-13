// + 개발자 : 김현진
// + 버그수정자 : 김종관
// + E-mail : tokssonda@nate.com
// + 달력 편하게 써보자 편 - * 

function getLastDay(year, month) {
	var d = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	month = (month*1)-1;
	if (((0 == (year%4)) && ( (0 != (year%100)) || (0 == (year%400)))) && month == 1) {
		return 29;
	} else {
		return d[month];
	}
}

jQuery(function($) 
{
	// + 달력
	// + ex) 1. 기본형 Code : $('#sDate1').helloCalendar();
	// + ex) 2. 년도와 월을 선택할수 있음 Code : $('#sDate2').helloCalendar({'selectBox':true}); 
	// + ex) 3. 년월일 중간에 들어가는 문자열을 정의 할수 있습니다. ( 기본은 "-" 입니다 ) Code : $('#sDate3').helloCalendar({'sign':'.'});
	// + ex) 4. 선택할수 있는 구간을 임의로 정할수 있습니다. Code : $('#sDate4').helloCalendar({'startLinkDate':'2011-05-09','endLinkDate':'2011-05-13'}); 
	// + ex) 5. 시작일과 종료일을 연결하여 종료일보다 큰 날짜를 시작일쪽에서 선택이 되지 않도록 합니다. Code : $('#sDate5').helloCalendar({'endLink':'eDate5'}); $('#eDate5').helloCalendar({'startLink':'sDate5'}); 
	// + ex) 6. 이미지를 클릭했을때 달력이 나오도록 설정 Code : $('#sDate6').helloCalendar({'clickID':'sDate6Img'}); 
	// + ex) 7. 달력이 나오면 달력에 이전달과 다음달 사이에 타이틀을 누르시면 각월에 1일과 각월에 마지막일이 선택되어 집니다. Code : $('#sDate7').helloCalendar({'sTitle':true}); $('#eDate7').helloCalendar({'eTitle':true}); 
	// + ex) 8. 달력이 펼쳐져 있는 형태 $('#calrendarDiv').helloCalendar({'inputID':'sDate8'}); 
	$.fn.helloCalendar = function(params) {

		// + 초기값 셋팅
		var now=new Date();
		var year = now.getFullYear();
		var month = now.getMonth()+1;
		var day = now.getDate();
		var obj = $(this);

		var param = $.extend({
			y : year
			, m : month
			, d : day
			, selectBox : false
			, sign : '-'
			, clickID : $(this).attr('id')
			, startLink : null
			, endLink : null
			, startLinkDate : null
			, endLinkDate : null
			, inputID : null
			, sTitle : false
			, eTitle : false
			, titleNum : null
		},params||{});

		var targetID = $(this).attr('id');
		var selectDate = year+param.sign+month+param.sign+day;
		
		// + 달력 이외에 것을 클릭하면 달력을 삭제함
		$(document).mousedown(function(event){
			var target = $(event.target);
			if(($(target).parent().parent().parent().parent().attr('class') != 'helloCalenderDiv') && ($(target).parent().parent().parent().parent().parent().attr('class') != 'helloCalenderDiv')) {
				$('.helloCalenderDiv').remove();
			}
			event.stopImmediatePropagation();
		});

		$(obj).change(function(){
			$('.helloCalenderDiv').remove();
		});

		// + 클릭달력이 아닌 박혀 있는 달력
		if(param.inputID != null) {

			// + 박혀있는 달력일때 셀렉트 박스 선택이 안되는 버그가 있어 셀렉트 박스를 우선 패스 - * 
			param.selectBox = false;

			if(param.endLink != null) { param.eDate = $('#'+param.endLink).val(); }
			if(param.startLink != null) { param.sDate = $('#'+param.startLink).val(); }
			if(param.endLinkDate != null) { param.eDate = param.endLinkDate }
			if(param.startLinkDate != null) { param.sDate = param.startLinkDate }

			if($('#'+targetID+'_helloCalenderDiv').attr('id') == undefined) {
				if($('#'+param.inputID).val() != ''){
					var thisDate = $('#'+param.inputID).val();
					thisDate = thisDate.replace(/\D/gi,'');
					param.y = thisDate.substring(0,4);
					param.m = thisDate.substring(4,6);
					param.m = param.m.replace(/^0/,'');
					param.d = thisDate.substring(6,8);
					param.d = param.d.replace(/^0/,'');
				}
				var display = '';
				display += '<div style="position:absolute;" id="'+targetID+'_helloCalenderDiv" class="helloCalenderDivView">';
				display += displayMake(param.y,param.m);
				display += '</div>';
				$(obj).append(display);
			} else {
				var prevDisplay = displayMake(param.y,param.m,param.d);
				$('#'+targetID+'_helloCalenderDiv').empty().append(prevDisplay);
			}
		}

		// + 달력 그려내기
		function displayMake(selectYear,selectMonth,selectDay){
			
			switch(selectMonth){
				case 0:
					selectYear--;
					selectMonth = 12;
					break;
				case 13:
					selectYear++;
					selectMonth = 1;
					break;
			}

			param.y = (selectYear*1);
			param.m = (selectMonth*1);

			hell = now.getSeconds();

			var display = '';
			display += '<table class="'+targetID+'_hcTable hcTable"><tr><td colspan="7" class="hcControlBar">';
			display += '<input type="button" class="'+targetID+'_hcPrev hcPrev" value="이전달">';
			display += '<span class="'+targetID+'_hcTitle hcTitle">'+param.y + '.' + ((param.m < 10) ? ('0' + param.m) : param.m)+'</span>';
			display += '<input type="button" class="'+targetID+'_hcNext hcNext" value="다음달">';
			display += '</td>';
			
			if(param.selectBox === true) {
				display += '<tr><td colspan="7">';
				display += '<input type="button" class="'+targetID+'_hcToday hcToday" value="오늘">';
				display += '<select class="'+targetID+'_sboxYear">';
				
				var beforeYear = param.y - 60;
				var afterYear = param.y + 5;
				for(i = beforeYear; i <= afterYear; i++) {
					if(i == param.y) {
						selectOption = 'selected';
					} else {
						selectOption = '';
					}
					display += '<option value="'+i+'" '+selectOption+'>'+i+'년</option>';
				}
				display += '</select><select class="'+targetID+'_sboxMonth">';
				
				for(i = 1; i <= 12; i++) {
					if(i == param.m) {
						selectOption = 'selected';
					} else {
						selectOption = '';
					}
					display += '<option value="'+i+'" '+selectOption+'>'+i+'월</option>';
				}
				display += '</select></td></tr>';
			}

			display += '<tr><th class="hcSun">일</th><th>월</th><th>화</th><th>수</th><th>목</th><th>금</th><th class="hcSat">토</th></tr>';

			var d1 = (param.y+(param.y-param.y%4)/4-(param.y-param.y%100)/100+(param.y-param.y%400)/400
				  +param.m*2+(param.m*5-param.m*5%9)/9-(param.m<3?param.y%4||param.y%100==0&&param.y%400?2:3:4))%7;

			var forNum = 0;
			var lastDay = getLastDay(param.y,param.m);

			if(lastDay == 28 && d1 == 0) {
				forNum = 28;
			} else if(lastDay > 28 && lastDay < 31 && d1 <= 5) {
				forNum = 35;
			} else if(d1 <= 5) {
				forNum = 35;
			} else {
				forNum = 42;
			}

			var startFlag = false;
			var endFlag = false;

			// + start link
			if(param.sDate != '' && (param.startLinkDate != null || param.startLink != null)) {
				thisDate = param.sDate.replace(/\D/gi,'');
				var sDate = new Array();
				sDate.Y = thisDate.substring(0,4);
				sDate.M = thisDate.substring(4,6);
				sDate.M = sDate.M.replace(/^0/,'');
				sDate.D = thisDate.substring(6,8);
				sDate.D = sDate.D.replace(/^0/,'');
				startFlag = true;
			}

			// + end link
			if(param.eDate != '' && (param.endLinkDate != null || param.endLink != null)) {
				thisDate = param.eDate.replace(/\D/gi,'');
				var eDate = new Array();
				eDate.Y = thisDate.substring(0,4);
				eDate.M = thisDate.substring(4,6);
				eDate.M = eDate.M.replace(/^0/,'');
				eDate.D = thisDate.substring(6,8);
				eDate.D = eDate.D.replace(/^0/,'');
				endFlag = true;
			}

			for (i = 0; i < forNum; i++)  {
				if(i%7==0) { display += '</tr><tr>'; }
				if(i < d1 || i >= d1+(param.m*9-param.m*9%8)/8%2+(param.m==2?param.y%4||param.y%100==0&&param.y%400?28:29:30)) {
					display += '<td></td>';
				} else {
					var dayClassName = '';
					if(i%7 == 0) {
						dayClassName = 'hcSun';
					} else if(i%7 == 6) {
						dayClassName = 'hcSat';
					} else {
						dayClassName = '';
					}

					var selectDayClassName = ''; 
					if((i+1-d1) == param.d) {
						selectDayClassName = 'selectDay';
					} else {
						selectDayClassName = '';
					}
					
					// + 기간 링크 설정
					if(startFlag == true && endFlag == true) {
						if(param.y < sDate.Y || param.y > eDate.Y) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == sDate.Y && param.m < sDate.M || param.y == eDate.Y && param.m > eDate.M) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == sDate.Y && param.m == sDate.M && (i+1-d1) < sDate.D || param.y == eDate.Y && param.m == eDate.M && (i+1-d1) > eDate.D) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' '+targetID+'_hcTd hcTd">'+(i+1-d1)+'</td>';
						}
					} else if(startFlag == true && endFlag == false) {
						if(param.y < sDate.Y) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == sDate.Y && param.m < sDate.M) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == sDate.Y && param.m == sDate.M && (i+1-d1) < sDate.D) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' '+targetID+'_hcTd hcTd">'+(i+1-d1)+'</td>';
						}
					} else if(startFlag == false && endFlag == true) {
						if(param.y > eDate.Y) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == eDate.Y && param.m > eDate.M) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else if(param.y == eDate.Y && param.m == eDate.M && (i+1-d1) > eDate.D) {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' hcTd noSelect">'+(i+1-d1)+'</td>';
						} else {
							display += '<td class="'+selectDayClassName+' '+dayClassName+' '+targetID+'_hcTd hcTd">'+(i+1-d1)+'</td>';
						}
					} else {
						display += '<td class="'+selectDayClassName+' '+dayClassName+' '+targetID+'_hcTd hcTd">'+(i+1-d1)+'</td>';
					}
				}
			}
			display += '</tr></table>';
			return display;
		}

		// + 달력 클릭시
		$('#'+param.clickID).click(function(){

			var top = $(obj).offset().top + $(obj).height() + 7;
			var left = $(obj).offset().left;

			if(param.endLink != null) { param.eDate = $('#'+param.endLink).val(); }
			if(param.startLink != null) { param.sDate = $('#'+param.startLink).val(); }
			if(param.endLinkDate != null) { param.eDate = param.endLinkDate }
			if(param.startLinkDate != null) { param.sDate = param.startLinkDate }

			if($('#'+targetID+'_helloCalenderDiv').attr('id') == undefined) {
				if($(obj).val() != ''){
					var thisDate = $(obj).val();
					thisDate = thisDate.replace(/\D/gi,'');
					param.y = thisDate.substring(0,4);
					param.m = thisDate.substring(4,6);
					param.m = param.m.replace(/^0/,'');
					param.d = thisDate.substring(6,8);
					param.d = param.d.replace(/^0/,'');
				}
				var display = '';
				display += '<div style="position:absolute;z-index:10000;top:'+top+'px;left:'+left+'px;" id="'+targetID+'_helloCalenderDiv" class="helloCalenderDiv">';
				display += displayMake(param.y,param.m);
				display += '</div>';
				$('body').append(display);
			} else {
				var prevDisplay = displayMake(param.y,param.m,param.d);
				$('#'+targetID+'_helloCalenderDiv').empty().append(prevDisplay);
			}
		});

		// + 다음달 , 이전달
		$('body').delegate('.'+targetID+'_hcPrev,.'+targetID+'_hcNext','click',function(){
			switch($(this).attr('class')){
				case targetID+'_hcPrev hcPrev':
					param.m--;
					break;
				case targetID+'_hcNext hcNext':
					param.m++;
					break;
			}
			var prevDisplay = displayMake(param.y,param.m,param.d);
			$('#'+targetID+'_helloCalenderDiv').empty().append(prevDisplay);
		});

		// + 오늘 
		$('body').delegate('.'+targetID+'_hcToday','click',function(){
			param.d = day;
			var todayDisplay = displayMake(year,month,param.d);
			$('#'+targetID+'_helloCalenderDiv').empty().append(todayDisplay);
		});

		// + 년 셀렉트 박스
		$('body').delegate('.'+targetID+'_sboxYear','change',function(){
			param.y = $(this).val();
			var selectYearDisplay = displayMake(param.y,param.m,param.d);
			$('#'+targetID+'_helloCalenderDiv').empty().append(selectYearDisplay);
		});
		
		// + 월 셀렉트 박스
		$('body').delegate('.'+targetID+'_sboxMonth','change',function(){
			param.m = $(this).val();
			var selectMonthDisplay = displayMake(param.y,param.m,param.d);
			$('#'+targetID+'_helloCalenderDiv').empty().append(selectMonthDisplay);
		});

		// + 날짜를 선택
		$('body').delegate('.'+targetID+'_hcTd','click',function(){
			var y = param.y
			var m = param.m
			m=((m<10) ? "0" : "")+m;
			var d = $(this).text();
			d=((d<10) ? "0" : "")+d;
			if(param.inputID === null) {
				$(obj).val(y+param.sign+m+param.sign+d);
				$('#'+targetID+'_helloCalenderDiv').remove();
			} else {
				$('#'+param.inputID).val(y+param.sign+m+param.sign+d);
				param.d = d;
				var viewDisplay = displayMake(param.y,param.m,param.d);
				$('#'+targetID+'_helloCalenderDiv').empty().append(viewDisplay);
			}
		});

		// + 날짜에 마우스 오버
		$('body').delegate('.'+targetID+'_hcTd','mouseover',function(){
			$(this).addClass('mouseOver');
		});

		// +  날짜에 마우스 아웃
		$('body').delegate('.'+targetID+'_hcTd','mouseout',function(){
			$(this).removeClass('mouseOver');
		});
		
		// +  타이틀 선택시 
		if(param.sTitle != false || param.eTitle != false) {
			$('body').delegate('.'+targetID+'_hcTitle','click',function(){
				if(param.sTitle == true) {
					var d = 1;
				} else if(param.eTitle == true) {
					var d = getLastDay(param.y,param.m);
				}

				if(param.titleNum != null) {
					d = param.titleNum;
				}

				var y = param.y
				var m = param.m
				m=((m<10) ? "0" : "")+m;
				d=((d<10) ? "0" : "")+d;

				$(obj).val(y+param.sign+m+param.sign+d);
				$('#'+targetID+'_helloCalenderDiv').remove();
			});
		}
	}

});