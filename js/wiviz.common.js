$(document).ready(function(){
	// $('#imModalCommon').modal();
});

$(".step3").css({"display":"none"});

Number.prototype.format = function(){
    if(this==0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
    };


function ajax_part_view(e,c){
   $('#imModalCommon').modal();
   $.ajax({
   url:'./ajax_user.php',
   type:'get',
   data : {'data' : e},
   success:function(data){
      $( '#imModalCommonBOx' ).html(data);
	   partfind(c);
    }
   });
}
function ajax_id_state(value,mb_id){
	$.ajax({
      url:'./ajax_id_state.php',
      type:'get',
      data : {'mb_id' : value,'value':value},
      success:function(data){
         alert('수정되었습니다.');
      }
     });
}
function return_hidden(e){
	$('.spantxt').css('display','none');
    $('.'+e).attr('type','text');
}
function ajax_part_modify(part_id){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_part_modify.php',
      type:'get',
      data : {'part_id' : part_id},
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });
}


function partfind(value){

	$.ajax({
   url:'./ajax_part_find.php',
   type:'get',
   data : {'data' : value},
   success:function(data){
      $( '#partid' ).html(data);
    }
   });
}

function partfind_sosok(value){
		$.ajax({
   url:'./ajax_part_find_sosok.php',
   type:'get',
   data : {'data' : value},
   success:function(data){
      $( '#partidsosk' ).html(data);
    }
   });
}
function ajax_user_modify(e){

	$.ajax({
            url:'./ajax_user_modify.php',
            type:'post',
            data:$('#userSubmit').serialize(),
            success:function(data){
                $('#ss').append(data);





            }
    })

}



function ajax_part_insert(e,group_code,part_id){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_part_modify.php',
      type:'get',
      data : {'part_id' : part_id,'modify' : e, 'group_code':group_code},
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });
}
function ajax_man(e){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_man.php',
      type:'post',
      data : {'data' : e},
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });
}
function ajax_user_state(wid){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_user_state.php',
      type:'post',
      data : {'data' : wid},
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });


}
function ajax_book(e){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_air_book.php',
      type:'post',
      data : {'data' : e},
      success:function(data){
		  $('#loadimg').css('display','none');
         $( '#imModalCommonBOx' ).html(data);
      },
	  beforeSend : function(date){
	     $('#loadimg').css('display','block');
	 }
     });
}



function countchange_adult(e,id){

	var max = $('input[name=seat]').val();



	var child = $('select[name=child]').val();
	var sum = parseInt(child) + parseInt(e);

	if(sum > max){
		//alert('잔여좌석 이상 예약이 불가합니다. 인원을 재조정해주세요.');
		//$('#inputMan').css('visibility','hidden');
		//return false;
	}
	$('#inputMan').css('visibility','visible');

	$('#' + id).text(sum);
	$('#' + id).attr('data-val',sum);



}
function countchange_child(e,id){
    var max = $('input[name=seat]').val();

	var child = $('select[name=adult]').val();
	var sum = parseInt(child) + parseInt(e);
	if(sum > max){
		//alert('잔여좌석 이상 예약이 불가합니다. 인원을 재조정해주세요.');
		//$('#inputMan').css('visibility','hidden');
		//return false;
	}
	$('#inputMan').css('visibility','visible');
	$('#' + id).text(sum);
	$('#' + id).attr('data-val',sum);
}
function maninfocheck(){
	var data_cnt = $('#total_book').attr('data-val');
	if(data_cnt  ==  0){
		alert('예약인원을 먼저 선택해주세요.');
		return false;
	}
	var frm = document.frm;

	if(!frm.name_ko.value){
		alert('한글성명을 입력해주세요.');
		frm.name_ko.focus();
		return false;
	}
	if(!frm.name_en.value){
		alert('영문성명을 입력해주세요.');
		frm.name_en.focus();
		return false;
	}
	if(!frm.birth.value){
		alert('생년월일을 입력해주세요.');
		frm.birth.focus();
		return false;
	}
	if(frm.birth.value.length < 8){
		alert('생년월일은 숫자 8자리(ex:19991213)입니다.');
		frm.birth.focus();
		return false;
	}
	if(!frm.passNum.value){
		alert('생년월일을 입력하세요.');
		frm.birth.focus();
		return false;
	}
	if(frm.passNum.value.length < 7){
		alert('여권번호를 확인해주세요.');
		frm.passNum.focus();
		return false;
	}
	if(!frm.PassLimit.value){
		alert('여권만료기간을 입력해주세요.');
		frm.PassLimit.focus();
		return false;
	}
	if(frm.PassLimit.value.length < 8){
		alert('여권만료 기간이 부정확합니다.(ex:19991213)');
		frm.PassLimit.focus();
		return false;
	}

	$.ajax({
            url:'./ajax_booking.php',
            type:'post',
            data:$('#frm').serialize(),
            success:function(data){
                $('#time').append(data);
				frm.reset();// 전송완료 후 리셋
				// 추가 인원 확인

				var add = $('#time tr').length;
				if(data_cnt==add){
                  $('#inputMan').css('visibility','hidden');
				  $('#smtBook').css('visibility','visible');
				}

            }
    })




}

function ajax_modify_form(e){
	$('#imModalCommon').modal();

	var e_id = e;

	$.ajax({
            url:'./ajax_' + e_id + '.php',
            type:'post',
            data:$('#' + e_id ).serialize(),
           success:function(data){
             $('#loadimg').css('display','none');
		     $( '#imModalCommonBOx' ).html(data);
           },
	       beforeSend : function(date){
		     $('#loadimg').css('display','block');
	      }
    })

}
function mandelete(e){

	$.ajax({
      url:'./ajax_man_delete.php',
      type:'post',
      data : {'data' : e},
      success:function(data){
         $('.ai_' + e).remove();
		 $('#smtBook').css('visibility','hidden');
      }
     });

}


function ajax_book_final(e){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_air_book_final.php',
      type:'post',
      data : {'data' : e},
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#imModalCommonBOx' ).html(data);
      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });
}

function ajax_book_final_on(e){


	$.ajax({
      url:'./ajax_air_book_final_on.php',
      type:'post',
      data : {'data' : e},
      success:function(data){
		 $('#loadimg').css('display','none');
         $( '#msg_return' ).html(data);
      },
	  beforeSend : function(date){
		  $('#loadimg').css('display','block');
		}
     });

}

function ajax_book_mypage(e,c){
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_air_book_mypage.php',
      type:'post',
      data : {'data' : e,'sort':'mypage','mb_id':c},
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#imModalCommonBOx' ).html(data);
      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });
}

function ajax_air_sales(value,id){
	                $.ajax({
                      url:'./ajax_air_sales.php',
                      type:'get',
                      data : {'value' : value,'id':id},
                      success:function(data){
						  $('#loadimg').css('display','none');
                      },
					   beforeSend : function(date){
		                $('#loadimg').css('display','block');
		               }
                      });

}


function ajax_book_cancel(value,id,ids){
	                $.ajax({
                      url:'./ajax_air_cancel.php',
                      type:'get',
                      data : {'value' : value,'id':id,'order':ids},
                      success:function(data){
						  $('#loadimg').css('display','none');
                      },
					   beforeSend : function(date){
		                $('#loadimg').css('display','block');
		               }
                      });
}

function ajax_air_off(value,id){
	                $.ajax({
                      url:'./ajax_air_off.php',
                      type:'get',
                      data : {'value' :value,'id':id},
                      success:function(data){
						  $('#loadimg').css('display','none');
						  $('#ai_off').text(data);
                      },
					   beforeSend : function(date){
		                $('#loadimg').css('display','block');
		               }
                      });

}

function airPrdListSearch(){

	$.ajax({
            url:'./ajax_prdSearch.php',
            type:'post',
            data:$('#prdfind').serialize(),
            success:function(data){
				$('#loadimg').css('display','none');
				$('.pagination').css('display','none');
                $('#airPrdList').html(data);
            },
			 beforeSend : function(date){
		        $('#loadimg').css('display','block');
		    }
        })

}

function linkreplace(url){
	location.replace(url);
}



function wivizboundcheck(value){
	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('#prdlist > div').remove();
	$('.showplan_table').css('display','none');
	$("#process button").css({"background":"#115ad4"});
	$('#sdate').val('');

	$.ajax({
      url:'./ajax_region.php',
      type:'post',
      data : {'data' : value},
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#t_region' ).html(data);
      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });

}



function insuterminator(){
	var frm = document.forms[0];
	$(".step3").css({"display":"none"});

	$('#smitInsu').css('display','none');
	$("#process button").css({"background":"#aaa"});

	if(frm.t_bound.value == ""  || frm.t_bound.value==1){
		alert('여행종류를 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.t_bound.focus();
		return false;
	}
	if(frm.t_region.value == "" ){
		alert('여행지역을 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.t_region.focus();
		return false;
	}
	if(frm.sdate.value == "" ){
		alert('출발일을 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.sdate.focus();
		return false;
	}
	if(frm.shour.value == "" ){
		alert('출발시간을 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.shour.focus();
		return false;
	}
	if(frm.rdate.value == "" ){
		alert('도착일을 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.rdate.focus();
		return false;
	}
	if(frm.rhour.value == "" ){
		alert('도착시간을 선택해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm.rhour.focus();
		return false;
	}


	// 주민번호 체크

	var p_name_count = (frm.mancount.value==1)? 1 : frm['p_name[]'].length ;




    var i=0;
	if( p_name_count > 1 ){
	while( i < p_name_count){
		if(frm['p_name[]'][i].value == "" ){
		alert('가입자 성함을 입력해주세요.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_name[]'][i].focus();
		return false;
	    }
		if(frm['p_id1[]'][i].value == "" ){
		alert('주민등록번호는 필수입니다.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_id1[]'][i].focus();
		return false;
	    }
		if(frm['p_id2[]'][i].value == "" ){
		alert('주민등록번호 뒷자리는 필수입니다.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_id2[]'][i].focus();
		return false;
	    }
		i++;
	  }
	}
	else if(p_name_count==1){
		if(frm['p_name[]'].value == "" ){
		alert('가입자성함은 필수입니다.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_name[]'].focus();
		return false;
	    }
		if(frm['p_id1[]'].value == "" ){
		alert('주민등록번호는 필수입니다.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_id1[]'].focus();
		return false;
	    }
		if(frm['p_id2[]'].value == "" ){
		alert('주민등록번호 뒷자리는 필수입니다.');
		$("#process button").css({"background":"#115ad4"});
		frm['p_id2[]'].focus();
		return false;
	    }

	}

	var jd = new Date();

	$.ajax({
      url:'./ajax_insu.php',
      type:'post',
      data:$('#trip').serialize(),
      success:function(data){
        $('#loadimg').css('display','none');
		$( '#prdlist' ).html(data);
		$('#useroutput').addClass('usershowcost');
		if(2 === jd.getDay()) {
	 		$(".card_samsung").css({"display":"none"});
	 	}
		if(4 === jd.getDay()) {
	 		$(".card_samsung").css({"display":"none"});
	 	}
        $(".card_lotte").css({"display":"none"});
		// $(".card_ace").css({"display":"none"});
		// $(".card_mg").css({"display":"none"});

         // console.log("data: " + data);
		 nonFocus();
		 step2Focus();
      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });

}



/*************************************펑션********************************************/
function checknum(value,element){
	if("p_id1[]" === $(element).attr("name")) {
		if(6 == element.value.length) {
			$(element).next().focus();
		}
	}

	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('#prdlist > div').remove();
	$("#process button").css({"background":"#115ad4"});
	var val = value;
	if(isNaN(val)){
		alert('숫자만 입력 가능합니다.');
		$(element).val('');
	}
	var id = $(element).attr('data-id');

	if(id =='id2'){  // 주민번호 뒷자리 규칙
        var id2 = val.substring(0, 1)
		var id1_index = $(element).prevAll('input').val(); // id1 값
        if(id1_index == ""){
			alert('주민등록번호 앞자리를 입력해 주세요.');
			$(element).val('');
		}
		//1)시작숫자 체크 0 에러

		if(id2 == 0){
			//alert('주민등록번호 뒷자리는 0으로 시작할 수 없습니다.');
			$(element).val('');

		}
	}
}

function moveNext(value,element) {
	console.log(value);

}

function manchange(val){
	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('#prdlist > div').remove();
	$("#process button").css({"background":"#115ad4"});
	$('.showplan_table').css('display','none');
	// 현재 선택되어 있는 인원
    var now = $('.infoform').length;
	var diff = parseInt(val) - parseInt(now) ;
	var div = '<tr class="infoform infoform-add">';
		div += '<td><input class="form-control" name="p_name[]" placeholder="홍길동" type="text"></td>';
		div += '<td><span><input class="wiviz-form idform1 jumin1" name="p_id1[]" placeholder="801010" onkeyup="checknum(this.value,this)" data-id="id1" maxlength="6" type="text">';
		div += ' - <input class="wiviz-form" name="p_id2[]" placeholder="*******" type="password"onkeypress="checknum(this.value,this)" data-id="id2" maxlength="7"></span></td>';
		div += '<td><input class="form-control idform2" name="p_tel[]" placeholder="00000000000" type="text" onkeypress="checknum(this.value,this)" data-id="tel" maxlength="11"></td>';
		div += '<td>';
		div += '</td>';
		div += '<td>';
		div += '</td>';
		div += '<td><span class="delspan">제거<i class="xi-minus-circle-o"></i></span></td>';
	    div += '</tr>';
	// 추가
	if(diff > 0){ // 늘어나는 경우
		for(var i=0;i<diff;i++){
		    $(div).appendTo( "#mantable" );
	    }
	}
	else if(diff < 0){ // 줄어드는 경우
		if(confirm('인원축소 및 변경시에는 기존 작성된 데이터가 삭제됩니다.\n기존 데이터 보존 상태로 가입자 수 변경은 \n개별인원 제거(-) 버튼을 사용해주세요.\n개별인원 제거를 사용하시고자 하는 경우, 취소 버튼을 눌러주세요.')== true){
			$('.infoform-add').remove();
		    for(var i=0;i < val-1; i++){
		    $(div).appendTo( "#mantable" );
	        }
		}
		else{
			return;
		}

	}
}
function changeup(e){
	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('#prdlist > div').remove();

	var div = '<tr class="infoform">';
		div += '<td><input class="form-control" name="p_name[]" placeholder="홍길동" type="text"></td>';
		div += '<td><span><input class="wiviz-form idform1 jumin1" name="p_id1[]" placeholder="801010" onkeyup="checknum(this.value,this); " data-id="id1" maxlength="6" type="text">';
		div += ' - <input class="wiviz-form" name="p_id2[]" placeholder="*******" type="password" onkeypress="checknum(this.value,this)" data-id="id2" maxlength="7"></span></td>';
		div += '<td><input class="form-control idform2" name="p_tel[]" placeholder="00000000000" type="text" onkeypress="checknum(this.value,this)" data-id="tel" maxlength="11"></td>';
		div += '<td>';
		div += '</td>';
		div += '<td>';
		div += '</td>';
		div += '<td>대표가입자</td>';
	    div += '</tr>';
	//1)적접 부분 비활성
	if(e == 'direct'){
		    $('#mantablebody > tr').remove();
			 $(div).appendTo( "#mantable" );
			$('.form-excel').css('display','none');
			$('.form-direct').css('display','block');
			$('#excelselect').val('no');

	}
	if(e == 'excelup'){
		$('#excelselect').val('yes');
     	$('.form-direct').css('display','none');
		$('.form-excel').css('display','block');
	}



}




$(document).on('click','.delspan',function(){

	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('#prdlist > div').remove();
	$("#process button").css({"background":"#115ad4"});
	$('.showplan_table').css('display','none');
         // var indextr = $(this).parents('.infoform-add').index();
		$(this).parent().parent().remove();
		// 자신을 제거후, 인원 수를 확인하여, 셀렉트값 변경
		var changeCount = $('#mantablebody tr.infoform').length;
		alert('인원변경이 있습니다. 보험료조회를 다시 진행해 주세요.');
		$('#mancount').val(changeCount);

});


//////////////
				//1) 여행종류 확인
$(document).on('click','#sdate',function(){
	var bound = $('#t_bound').val();
	if(bound=="" || bound==1){
		alert('여행종류를 선택해주세요.');
		return false;
	}
	dateppick(bound);
});
$('#sdate').on('change', function () {
	var bound = $('#t_bound').val();
	var choose = $('#sdate').val();
    var today = new Date();
	var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
	var todaystring = year + '-' + month + '-' + day;
    if(bound=='inbound'){
	    if(todaystring == choose){
		   alert('국내여행은 당일 가입이 불가능합니다.');
           $('#sdate').val('');
		   exit;
     	}
	}



});



function dateppick(bounds){
	    var disabelds = [''];
		var mypick = $('.datepicker').pickadate({
			format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
            container: '#datecontainer',
			min: new Date(),
			monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
		    monthsFull:['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			weekdaysShort: ['일', '월', '화', '수', '목', '금', '토'],
            closeOnSelect: true,
            closeOnClear: true,
			today: '오늘',
            clear: '초기화',
            close: '닫기',

         });
		var picker = mypick.pickadate('picker');
}

function excelselectUp(){
   var frm = document.forms[0];
   $(".step3").css({"display":"none"});
   $('#smitInsu').css('display','none');
   var check = $('#excelselect').val();
   if(frm.mancount_ex.value==""){
	   alert('파일을 선택하세요.');
	   return false;
   }
   if(check != 'yes'){
	   alert('정상접근이 아닙니다.');
	   return false;
   }

   var form = $('form')[0];
   var formData = new FormData(form);
   $.ajax({
      url:'./ajax_insu_excel.php',
      type:'post',
	  processData: false,
      contentType: false,
      data: formData,
      success:function(data){
         $('#loadimg').css('display','none');

		 $( '#mantablebody' ).html(data);
		 var mancount = $('.infoform-add').length;
		 $('#mancount').val(mancount);

      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });

}

function ajax_result(value){


	var company = value.split('-');
	var final_company = company[4].slice(0,-5);   // 뒤에서 여행자보험 글씨 자르기 10-25 수정 구민경
	var s = $('.infoform').length;

	$.ajax({
      url:'./ajax_result.php?gtype='+ value,
      type:'post',
      data:$('#trip').serialize(),
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#mantablebody' ).html(data);
		 $(".step3").css({"display":"block"});
		 $('#smitInsu').css('display','block');
		 $("#showplan").css({"display":"block"});
		nonFocus();
		step3Focus();
		$(".step1 #mantable input").click(function(){
			nonFocus();
			step1Focus();
			$("#process button").css({"background":"#115ad4"});
		});


		 var totalUnitPrice=0;$('.mypriceclass').each(function(index) {
         totalUnitPrice += parseInt($(this).attr('data-price')); // parse the value to an Integer (otherwise it'll be concatenated as string) or use parseFloat for decimals
         });
         if(totalUnitPrice < 1000){
			  totalUnitPrice = 1000;
			  $('#etc_1000').text('총 보험료가 1,000원 미만인 경우, 1,000원으로 결제됨을 알려드립니다.');
		 }
		 $('.numSum').html(totalUnitPrice.format());
		 $('#sumprice').val(totalUnitPrice);


		 $('#selected_company').html(final_company);  // 선택된 회사명 출력 2017-10-25 수정 구민경
		 $('#mancount_tr_length').html(s);  // // 선택된 인원수 출력 2017-10-25 수정 구민경

		 getplan(value);
	     gotobyscroll('gotoscet');

      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });
}



function getplan(value){

	                $.ajax({
                      url:'./ajax_plan.php',
                      type:'get',
                      data : {'value' : value},
                      success:function(data){
						  $('#loadimg').css('display','none');
						  $( '#showplan' ).html(data);
						  var str = $('#planarr').attr('data-val');
						  var arr = str.split("/");
						  for(var i=0;i<arr.length;i++){
							  $('.'+arr[i]).css('background','#bed4fd');
						  }
                      },
					   beforeSend : function(date){
		                   $('#loadimg').css('display','block');
		               }
                      });


}




function submitInsu(){
	var form = $('form')[0];
	var value= $(":input:radio[name=mychoice]:checked").val();

	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_result_submit.php?gtype='+ value,
      type:'post',
      data:$('#trip').serialize(),
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });
}
function myInsu(e){
	val = e;
	$.ajax({
      url:'./ajax_myInsu.php?page='+val,
      type:'post',
      data:$('#insu').serialize(),
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#PrdList' ).html(data);

      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });
}

function gotobyscroll(id){
	$('html,body').animate({scrollTop:$('#'+id).offset().top},'slow');
}


function ajax_cancel(){




	$('#imModalCommon').modal();
	var gid = $('#gid_cancel').attr('data-id');

	$.ajax({
      url:'./ajax_cancel.php',
      type:'post',
      data : {'data' : gid},
      success:function(data){
         $('#loadimg').css('display','none');
		 $( '#imModalCommonBOx' ).html(data);

      },
	   beforeSend : function(date){
		 $('#loadimg').css('display','block');
	   }
     });
}

// 변경시 무조건 보험료 초기화
function changebak(){
	$("#process button").css({"background":"#115ad4"});
	$('#prdlist > div').remove();
	$(".step3").css({"display":"none"});
	$('#smitInsu').css('display','none');
	$('.showplan_table').css('display','none');
	return true;
}



function engname(id){
    $('#imModalCommon').css({"display":"block"});
    $('.modal-backdrop').css({"display":"block"});
	$('#imModalCommon').modal();
	$.ajax({
      url:'./ajax_eng.php?gtype='+ id,
      type:'get',
      success:function(data){
         $( '#imModalCommonBOx' ).html(data);
      }
     });
}
