$(document).ready(function(){
    $('#plusbt').on('click',function(){
                var last_for_prt = $('#t_list').find('tbody tr td input[name="nob[]"]').length;
                console.log(last_for_prt);
           
               for(i=0; i < 20; i++){
            var copy_tr = $('#b2b_clone').find('tbody tr:eq(0)').clone();
            copy_tr.find('input[type="checkbox"]').attr('id', 'n'+(i+(last_for_prt+1))).prop('checked',false);
           
            copy_tr.find('label').attr('for','n'+(i+(last_for_prt+1)));
          
        $('#t_list').append(copy_tr);
    }
        prt_no();
    });

    $('#allbt').on('click',function(){
        $('#formBox input[name="nob[]"]').prop('checked', true);		
    });

	$('#allcbt').on('click',function(){
		
		 $('#formBox input[name="nob[]"]').each(function(ind,val){           
            if(ind >0 ){
				$('#formBox input[name="nob[]"]').eq(ind).prop('checked',true);               
            }        
        });
	});

    $('#allnbt').on('click',function(){
        $('#formBox input[name="nob[]"]').prop('checked', false);
    });

    $('#seldbt').on('click',function(){
        var t_cnt = $('input[name="nob[]"]').length;
        var ch_t_cnt = 0;
        var ch_re_cnt = 0;
        $('#formBox input[name="nob[]"]').each(function(ind,val){           
            if($('#formBox input[name="nob[]"]').eq(ind).is(':checked')){                
                ch_t_cnt++;                    
            }        
        });

        if(ch_t_cnt < 1){
            alert('선택된 데이터가 없습니다.');
            return false;
        }

        if(ch_t_cnt === t_cnt){
            alert('전체삭제');
            $('#formBox input[name="nob[]"]').each(function(ind,val){           
                if($('input[name="nob[]"]').eq(ind).is(':checked')){           
                    $('input[name="nob[]"]').closest('tr').eq(ind).find('input').val('');
					 $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(6) ').contents().filter(function(){return this.nodeType == 3}).remove();
                    $('input[name="nob[]"]').eq(ind).prop('checked',false);
                }        
            });
        } else {
            var remove_no = new Array();
            
            $('#formBox input[name="nob[]"]').each(function(ind,val){  
                
               // if($('input[name="nob[]"]').eq(ind).is(':checked')){        
				   if($(this).is(':checked')){
                    ch_re_cnt++; 
                    remove_no.push(ind); 
                }        
            });

			console.log(ch_re_cnt);

            $('#formBox input[name="nob[]"]').each(function(ind,val){      
				  if($(this).is(':checked')){
              //  if($('input[name="nob[]"]:checked').eq(ind).is(':checked')){                
                    $('input[name="nob[]"]:checked').closest('tr').remove();         
                }   
            });    
            
            var repair_tr = ch_re_cnt;
           console.log(repair_tr);
            for(i=0; i < repair_tr; i++){

                var copy_cre_tr = $('#b2b_clone').find('tbody tr:eq(0)').clone();
               
                copy_cre_tr.find('input[type="checkbox"]').prop('checked',false);
                $('#t_list').append(copy_cre_tr);    
            }

        }
        prt_no();
    });


//선택 취소 시작
//plan code와 금액 0으로 바꾸어야 함. (member_history 만)
	$('#selcbt').on('click',function(){
		
        var t_cnt = $('input[name="nob[]"]').length;
        var ch_t_cnt = 0;
        var ch_re_cnt = 0;
		var plan_code_no = $('input[name=plan_Code]').val();
		var plan_mem_no = new Array();
        $('#formBox input[name="nob[]"]').each(function(ind,val){           
            if($('#formBox input[name="nob[]"]').eq(ind).is(':checked')){                
                ch_t_cnt++;                    
            }        
        });

        if(ch_t_cnt < 1){
            alert('선택된 데이터가 없습니다.');
            return false;
        }

        if(ch_t_cnt === t_cnt){
           // alert('전체삭제');
            $('#formBox input[name="nob[]"]').each(function(ind,val){           
                if($('input[name="nob[]"]').eq(ind).is(':checked')){           
                    //$('input[name="nob[]"]').closest('tr').eq(ind).find('input').val('');
					//$('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(6) ').contents().filter(function(){return this.nodeType == 3}).remove();
					//$('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').contents().filter(function(){return this.nodeType == 3}).remove();
					// $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').text(0);
					// $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').find('input').val(0);
                    //$('input[name="nob[]"]').eq(ind).prop('checked',false);
					// console.log($('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(1)').find('input[name="memnov[]"]').val());
					 plan_mem_no[''+ind] = $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(1)').find('input[name="memnov[]"]').val();
                }        
            });
        } else {
            var remove_no = new Array();
            
            $('#formBox input[name="nob[]"]').each(function(ind,val){  
                
               // if($('input[name="nob[]"]').eq(ind).is(':checked')){        
				   if($(this).is(':checked')){
                    ch_re_cnt++; 
                    remove_no.push(ind); 
                }        
            });

			//console.log(ch_re_cnt);

            $('#formBox input[name="nob[]"]').each(function(ind,val){      
				  if($(this).is(':checked')){
              //  if($('input[name="nob[]"]:checked').eq(ind).is(':checked')){                
                   // $('input[name="nob[]"]:checked').closest('tr').remove();     
				
					 //$('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').contents().filter(function(){return this.nodeType == 3}).remove();
					// $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').text(0);
					 //$('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(8) ').find('input').val(0);
					// console.log($('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(1) ').find('input[name="memnov[]"]').val());
					 plan_mem_no[''+ind] = $('input[name="nob[]"]').closest('tr').eq(ind).find('td:nth-child(1) ').find('input[name="memnov[]"]').val();
                }   
            });    
            /*
            var repair_tr = ch_re_cnt;
           console.log(repair_tr);
            for(i=0; i < repair_tr; i++){
			
                var copy_cre_tr = $('#b2b_clone').find('tbody tr:eq(0)').clone();
               
                copy_cre_tr.find('input[type="checkbox"]').prop('checked',false);
                $('#t_list').append(copy_cre_tr);    
            }
				*/
        }	
		selCancelput(plan_code_no, plan_mem_no)
       
    });
//선택 취소 끝
   
    $(document).on('paste', 'input', function(e){
            var $this= $(this);
            var pasted;
            var cccc;
            var bbbb;
            if (window.clipboardData && window.clipboardData.getData) { 
        /** ie 용 **/
        pasted = window.clipboardData.getData('Text');
        pasted = pasted.trim('\r\n');
        bbbb = pasted.split('\r\n');
        cccc = bbbb[0].split('\t');
        e.stopPropagation();
        e.preventDefault();   
    } else if (e.originalEvent.clipboardData.getData) {
        /** 그이외 **/
        
        pasted = e.originalEvent.clipboardData.getData('text/plain');
        pasted = pasted.trim('\r\n');
        bbbb = pasted.split('\r\n');
        cccc = bbbb[0].split('\t');
        
        e.stopPropagation();
        e.preventDefault();    
        
    }
    var kk = $this.closest('td').index();
    var mm = $this.closest('td').length;
    var verrown = $this.closest('tr').index();
    var obj = {};
    console.log("선택된 td주소 - input:"+kk+"클립보드 col수"+cccc.length);
    var limit_td = 4;
    if((kk+(cccc.length - 1)) > limit_td){
        alert('복사할 데이터가 셀보다 큽니다.');
        return false;
    } else {        
        var rejectno = 0;
        $.each(pasted.split('\r\n'), function(indy, valuy){
                $.each(valuy.split('\t'),function(indx, valux){
                    var row = verrown+indy, col = kk+indx;
                            obj['cell-'+row+'-'+col] = valux;
                            valux = valux.trim();
                            $this.closest('table').find('tr:eq('+(row+1)+') td:eq('+col+') input').val(valux);     
							//var prt_val = rep_juno(valux);					
							
                            if(col == 4){
								prt_val = rep_juno(valux);
								 $this.closest('table').find('tr:eq('+(row+1)+') td:eq('+col+') input').val(prt_val);     
                                console.log('지정된 col : '+ju_chk(valux));

                                if( ju_chk(prt_val) < 1){
                                    age_calcultor(prt_val, row, col);  
                                    $this.closest('table').find('tr:eq('+(row+1)+') td:eq('+col+') input').css('color', '#777');
                                } else {
                                    $this.closest('table').find('tr:eq('+(row+1)+') td:eq('+col+') input').css('color', 'red');
                                    $this.closest('table').find('tr:eq('+(row+1)+') td:eq('+(col+1)+') input').val('');
									$this.closest('table').find('tr:eq('+(row+1)+') td:eq('+(col+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
                                    rejectno = rejectno + 1;
                                }
                            }
                             
                });
        });
        if(rejectno > 0){
            alert('적합하지않는 주민번호가 있습니다.');
            return false;
        }    
        $('#viewprt').text(JSON.stringify(obj));
      
    }

        });


	
	$('#cal_insuran_tot').on('click',function(){
		//총 납입 보험료 계산하기
		var chkPlan, chkAmount = 0;
		var totcnt = 0, totAmount=0;
		var wrMode = $('input[name="write_pattern"]').val();


		$('#t_list').find('input[name="hage[]"]').each(function(){
			if($(this).val() != ''){
				 chkPlan = $(this).closest('tr').find('td:eq(6) input').val();
				 chkAmount = $(this).closest('tr').find('td:eq(7) input').val();
				 if( (chkPlan != '') && (chkAmount > 0) ){					 
					totAmount = Number(chkAmount)+Number(totAmount);
					console.log(totAmount);
				 }
				 if(chkAmount > 0){
					totcnt++;
				 }

			}
		});

		// canallam='' id='tcala'
		$('#talp').empty();
		$('#talp').append(totcnt);
		$('#talp').attr('chkallp' , '');
		$('#talp').attr('chkallp' , totcnt);
		
		//if(wrMode !=='edimode'){
			$('#tala').empty();
			$('#tala').append(Number(totAmount).toLocaleString('en'));		
			$('#tala').attr('chkallam','');
			$('#tala').attr('chkallam',totAmount);
		/*} else {
		
			$('#tcala').empty();
			$('#tcala').append(Number(totAmount).toLocaleString('en'));		
			$('#tcala').attr('chkEdiallam','');
			$('#tcala').attr('chkEdiallam',totAmount);
		}
		*/
		console.log(totcnt+" 금액 : "+totAmount);
	});

});

function prt_no(){
    //table tr이 증가하면 숫자를 다시 지정한다.
    var cnt= 1;
    $('#t_list tr').each(function(ind){
       
        $('#t_list tbody tr:eq('+ind+') td:eq(1)').text(cnt);
        $('#t_list tbody tr:eq('+ind+') td:eq(0) input[name="nob[]"]').attr("id","n"+cnt);
        $('#t_list tbody tr:eq('+ind+') td:eq(0) label').attr("for","n"+cnt);
        cnt++;
    });

}

function age_calcultor(kind,rown, coln){
        
        var cage;
       
            cage = kind;           

            $.post('../src/age_cal.php', {tyear:cage}, function (data){			
            if(data.msg){			
                
                console.log(data.msg['1']+' : '+data.msg['0']);
                
                
                $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+(coln+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
                $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+(coln+1)+') input[name="hage[]"]').val(data.msg['1']); 
                $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+(coln+1)+')').append(data.msg['1']);				
				 $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+coln+') input').css('color', '#777');
				 $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+(coln+2)+') input:eq(0)').val(''); 
				 $('#t_list').find('tr:eq('+(rown+1)+') td:eq('+(coln+2)+') input:eq(1)').val(''); 
            } else {
                alert('안됐다');
				return false;
            }			

            },"json").done(function(){
            
            
            }).fail(function(){
            
            });
      
    }

    function ju_chk(kind){
        var junum = kind.split("-");
        var jumins3 = junum[0]+junum[1];
         //주민등록번호 생년월일 전달
          var fmt = RegExp(/^\d{6}[1234]\d{6}$/);//포멧 설정
          var buf = new Array(13); 
          var errorcnt = 0;
          //주민번호 유효성 검사 
          if (!fmt.test(jumins3)) { 
              //alert("주민등록번호 형식에 맞게 입력해주세요");
              //$("#id_num").focus(); 
             // return false; 
               errorcnt  = errorcnt + 1;
              
            } 
            
            //주민번호 존재 검사 
        for (var i = 0; i < buf.length; i++){
             buf[i] = parseInt(jumins3.charAt(i)); 
        } 
        
        var multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];// 밑에 더해주는 12자리 숫자들
         var sum = 0; 
         for (var i = 0; i < 12; i++){
              sum += (buf[i] *= multipliers[i]);// 배열끼리12번 돌면서 
        }

        if ((11 - (sum % 11)) % 10 != buf[12]) { 
			//alert("잘못된 주민등록번호 입니다.");
            //$("#id_num").focus();
             //return false; 
             errorcnt  = errorcnt + 1;
            
        }
        return errorcnt;
    }

    $(document).on('keyup, change, keydown, input','input[name="juminno[]"]',function(){
      if($(this).val().length == 13){
			var val_this = rep_juno($(this).val());
			
        if(ju_chk(val_this) < 1){
		 
            var put_td_po = $(this).closest('td').index();
            var put_tr_po = $(this).closest('tr').index();
            age_calcultor(val_this, put_tr_po, put_td_po);
			$(this).val(val_this);	
        } else {
            console.log('에러카운트'+$(this).val());
			$(this).css('color', 'red');
			var put_td_po1 = $(this).closest('td').index();    
            var put_tr_po1 = $(this).closest('tr').index();
			$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+') input[name="hage[]"]').val('');
			$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
			/*
            if($(this).val() == ''){
                  console.log('나온거냐');
                var put_td_po1 = $(this).closest('td').index();    
                var put_tr_po1 = $(this).closest('tr').index();        
                //console.log("row:"+put_tr_po1+" col:"+(put_td_po1+1));                    
                //$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+') input[name="hage[]"]').val('');
                //$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
            } else {
				
				var put_td_po1 = $(this).closest('td').index();    
                var put_tr_po1 = $(this).closest('tr').index();        
                //console.log("row:"+put_tr_po1+" col:"+(put_td_po1+1));    
				//$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1)+') input').val('');
                //$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+') input[name="hage[]"]').val('');
               // $('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
			}  
			*/
        }
		} else {
			$(this).css('color', 'red');
			var put_td_po1 = $(this).closest('td').index();    
            var put_tr_po1 = $(this).closest('tr').index();
			$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+') input[name="hage[]"]').val('');
			$('#t_list').find('tr:eq('+(put_tr_po1+1)+') td:eq('+(put_td_po1+1)+')').contents().filter(function(){return this.nodeType == 3}).remove();
		}
    });


/* 입력란  */

$(document).ready(function(){
	$('#mail_b_sel').on('change',function(){
		var mail_addr = $('#mail_b_sel :selected').val();
		if(mail_addr != 'etc'){
			$('#mail_b').prop('readonly', true);
			$('#mail_b').val(mail_addr);
		} else {
			$('#mail_b').prop('readonly', false);
			$('#mail_b').val('');
		}
	});

	$(document).on('click', '#plan_save', function(){
			var nChkno = 0;
			var mChk = '';
			var chkCodeno = '';			
			var chkType= '';
			
			
				if(!$('input[name=sel_plancode]:checked').val()){
					nChkno++;
				}
			
				if(nChkno > 0){
					alert('플랜을 선택해주세요.');
					return false;
				} else {
					mChk = $('#t_plan').attr('mulchk');
					console.log("개별or전체 : "+mChk);
					chkCodeno = $('input[name=sel_plancode]:checked').val();
					if(mChk != ''){
						joinPlan('none', mChk,chkCodeno);

					} else {						
						joinPlan('all','',chkCodeno);
						chkType = $('input[name=sel_plantype]').val();
						$('input[name=plan_type]').val(chkType);						
					}
					resetPlPr('plan');
				}
	});

	$('button[name="subscript"]').on('click',function(){
		var chinsuran = $('#selinsuran :selected');
		var stdate = $('#start_date');
		var eddate = $('#end_date');
		var sel_nation  = $('#select_nation');
		var sel_purpose = $('#trip_purpose');
		var visit_both = $('input:radio[name=rr]');
		var nt_conf = $('#notice_confirm');
		var cont_conf = $('#contract_confirm');
		var comm_plan = $('#common_plan');

		var name_vals = 0;

		$('input[name="input_name[]"]').each(function(){
			if($(this).val() != ''){
				name_vals++;
			}
		});

		var tot_people = $('#talp').attr('chkallp');
		var tot_price = $('#tala').attr('chkallam');
		console.log(chk_tot_people(tot_people));
		
		if(chinsuran.val() == ''){
			alert('보험사를 선택해주세요.');
			chinsuran.focus();
			return false;
		}

		if(stdate.val() == "" || eddate.val() == ""){
			alert('여행기간을 입력해주세요.');
			stdate.focus();
			return false;
		}

		if(sel_nation.val() == "N"){
			alert('여행지를 선택해주세요.');
			$('select[name=nation]').focus();
			return false;
		}

		if(sel_purpose.val() == ""){
			alert('여행 목적을 선택해주세요.');
			sel_purpose.focus();
			return false;
		}

		if(!visit_both.is(':checked')){
			alert('현재 체류지를 선택해주세요.');
			visit_both[0].focus()
			return false;
		}

		if(nt_conf.val() != 'Y'){
			alert('여행 출발 전 고지사항을 선택해 주세요.');
			return false;
		}

		if(cont_conf.val() != 'Y'){
			alert('가입/이용동의를 선택해주세요.');
			return false;
		}	

		if(name_vals < 1){
			alert('피보험자 정보중 이름을 입력해주세요.');
			$('input[name="input_name[]"]')[0].focus();
			return false;
		}

		if(comm_plan.val() == ''){
			alert('공통 플랜을 선택해주세요.');
			comm_plan.focus();
			return false;
		}
		var cnt_name_null = 0;
		$('input[name="input_name[]"]').each(function(){
			
			if($(this).val() != ''){
				cnt_name_null++;
			}
		});
		if(cnt_name_null < 1){
			alert('피보험자 이름을 작성해주세요.');
			$('input[name="input_name[]"]').eq(0).focus();
			return false;
		}
		var cnt_ssnum_null  = 0;	
		$('input[name="juminno[]"]').each(function(){
			
			if($(this).val() != ''){
				cnt_ssnum_null++;
			}
		});

		if(cnt_ssnum_null < 1){
			alert('주민등록번호를 작성해주세요.');
			$('input[name="juminno[]"]').eq(0).focus();
			return false;
		}
		var cnt_plan_null = 0;
		$('input[name="plan_code[]"]').each(function(){
			
			if($(this).val() != ''){
				cnt_plan_null++;
			}
		});

		if(cnt_plan_null < 1){
			alert('적용된 플랜이 없습니다. 플랜을 적용 시켜 주세요.');
			return false;
		}


		if(tot_people == '' || tot_people < 1){
			tot_people = 0;
		}
				
		if(!chk_tot_people(tot_people)){
			alert('인원 수 와 계산이 다릅니다.');
			return false;
		}
		//$('#formBox').attr('action','/src/aaa.php');
		//$('#formBox').submit();	

		var form_data = $('#formBox').serialize();
		console.log(form_data);
		
		$.post('/src/bill_process.php', form_data,"json").done(function(data){
			var jobj = JSON.parse(data);
			var pcode;
			var ptype;
			var ptitle;
			if(jobj.result == 'true'){			
					alert(jobj.msg);
					//$('#formBox').trigger("reset");				
					setTimeout(function(){
						location.reload();
					},1000);				
			} else {
				alert(jobj.msg);
			}				
	}).fail(function(){
	
	});

	});	

});

function joinPlan(kind, kind1, kind2){ //kind -> 분기점, kind1 -> 클릭 버튼 tr , 선택한 plan_code 

	var sPlan_code = {};
	var tripType,selInsuran,termDay,sex,age,stdate,endate,sthour, enhour,noExt,sexno,secNo;
	
	tripType = $('input[name=trip_Type]').val();
	selInsuran = $('#selinsuran :selected').val();
	stdate = $('#start_date').val();
	endate = $('#end_date').val();
	sthour =  $('#start_hour :selected').val();
	enhour = $('#end_hour :selected').val();
	

	if(kind == 'all'){
		console.log('함수 실행');
			$('#t_list').find('input[name="juminno[]"]').each(function(k){
				console.log($(this).closest('tr').index());
				if($(this).val() != ''){
					var reTurnind = $(this).closest('tr').index();
					age = $(this).closest('tr').find('td:eq(5) input').val();
					noExt = $(this).closest('tr').find('td:eq(4) input').val();
					arrExt = noExt.split("-");
					sexno = arrExt[1]. substr(0,1);
					secNo = btoa(noExt);
					
					switch(sexno){
						case '1':
						case '3':
							sex = 1;
						break;
						case '2':
						case '4':
							sex = 2;
						break;
					}
					console.log(get_cancelp('all',reTurnind));
					if(get_cancelp('all',reTurnind) == 'NO'){
						sPlan_code[''+reTurnind] = kind2+','+tripType+','+selInsuran+','+stdate+','+sthour+','+endate+','+enhour+','+sex+','+age+','+secNo;
					}
				}
			});
	} else {
		noExt = $('#t_list').find('tr:eq('+(Number(kind1)+1)+') td:eq(4) input').val();
		arrExt = noExt.split("-");
		sexno = arrExt[1]. substr(0,1);
		secNo = btoa(noExt);
		switch(sexno){
			case '1':
			case '3':
				sex = 1;
			break;
			case '2':
			case '4':
				sex = 2;
			break;
		}

		age = $('#t_list').find('tr:eq('+(Number(kind1)+1)+') td:eq(5) input').val();
		
		if(get_cancelp('',kind1) == 'NO'){
			sPlan_code[''+kind1] = kind2+','+tripType+','+selInsuran+','+stdate+','+sthour+','+endate+','+enhour+','+sex+','+age+','+secNo;
		} else {
			alert('취소된 Plan은 수정 할 수 없습니다.');	
			return false;
		}
	}
	let objJsonStr = JSON.stringify(sPlan_code);		


	$.post('/src/planPriceAdder.php', {chCode:objJsonStr },"json").done(function(data){
			var jobj = JSON.parse(data);
			var pcode;
			var ptype;
			var ptitle;
			if(jobj.result == 'true'){			
				$.each(jobj.msg, function(key, state){
					var gab = state.price;
					pcode = state.planCode;
					//ptype = state.planType;				
					ptitle = state.planTitle;
					$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(7) input').val(gab);
					$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(7)').contents().filter(function(){return this.nodeType == 3}).remove();
					$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(7)').append(Number(gab).toLocaleString('en'));
					$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(6) input').eq(0).val(pcode);
					//$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(6) input').eq(1).val(ptype);
					$('#t_list').find('tr:eq('+(Number(key)+1)+') td:eq(6) input').eq(1).val(ptitle);
					
					close_pop('pop_wrap');
				});				
				
				var putComplanv = putComplan(pcode);
					$('#common_plan').val(putComplanv);
			} else {
				alert(jobj.msg);
			}				
	}).fail(function(){
	
	});	
}

function resetPlPr(kind){
	if(kind != 'plan'){
		$('input[name="plan_code[]"]').each(function(){
			$(this).val('');
		});
		$('input[name="particul_price[]"]').each(function(){
			$(this).val('');
			$(this).closest('td').contents().filter(function(){return this.nodeType == 3}).remove();
			$(this).closest('td').append(0);
		});
		$('#tala').empty();
		$('#tala').attr('chkallp','');
		$('#tala').append(0);
	} else {
		$('#tala').empty();
		$('#tala').attr('chkallam','');
		$('#tala').append(0);
	}
}

function chk_tot_people(exTot){
	var all_people = 0; 
	var all_sn_num = 0;
	var all_pl_code = 0;
	//console.log(exTot);
	var cancel_num = 0;
	var cancel_txt;

	$('#formBox input[name="input_name[]"]').each(function(e){			
		if($(this).val() !=''){
			all_people++;
		}
		cancel_txt = $(this).closest('tr').find('td:nth-child(2)').attr('cancel_light');		
		if(cancel_txt == 'red'){
			cancel_num++;
		}
	});

	$('#formBox input[name="juminno[]"]').each(function(){
		if($(this).val() != ''){
			all_sn_num++;
		}
	});

	$('#formBox input[name="plan_code[]"]').each(function(){
		if($(this).val() != ''){
			all_pl_code++;
		}
	});

	all_people = all_people - cancel_num;
	all_sn_num = all_sn_num - cancel_num;
	all_pl_code = all_pl_code - cancel_num;
	
	if((all_people == Number(exTot)) && (all_people ==  Number(exTot)) && (all_sn_num == Number(exTot)) && (all_people > 0)) {
		return true;
	} else {
		return false;
	}
}


// 공통플랜 함수
function putComplan(kind){ // kind = 선택 플랜
	var getComplan;
	var arrComplan = new Array();
	var chkplan;
	var prtComplan;
	var same_num=0;
	getComplan = $('#plan_chk').val();
	if(getComplan != ''){
		arrComplan = getComplan.split("//-//");
		
		$('input[name="plan_code[]"]').each(function(){
			if(arrComplan[0] == $(this).val()){
				same_num++;
			}
			
		});
		
		if(same_num < 1){
			arrComplan[0] = kind;
		} else {
			arrComplan.unshift(kind);			
		}
		
	
	} else {
		arrComplan[0] = kind;
	}

	prtComplan = arrComplan.join('//-//');	
	console.log(prtComplan+"implode");
	$('#plan_chk').val(prtComplan);

	return arrComplan[0];
}

function selCancelput(kind, kind1){ //kind => planNO, kind1=> array(plan_member)
	 $.post('../src/cancel_put.php', {planNO:kind, memNO:kind1},"json").done(function(data){
          //console.log(data);
		var jobj = JSON.parse(data);
			if(jobj.result == 'true'){		
					alert('수정 되었습니다.');
					$.each(jobj.msg['planMemno'],function(key,val){
						var tr_position = key.split("_");
						$('input[name="nob[]"]').closest('tr').eq(tr_position[1]).find('td:nth-child(8) ').contents().filter(function(){return this.nodeType == 3}).remove();
						$('input[name="nob[]"]').closest('tr').eq(tr_position[1]).find('td:nth-child(8) ').prepend(0);
						$('input[name="nob[]"]').closest('tr').eq(tr_position[1]).find('td:nth-child(8) ').find('input').val(0);
					});
					location.reload();

			} else {
				alert('수정이 되지 않았습니다. 다시 시도해주세요.');
			}		
		
		}).fail(function(){
		
		});
}

function get_cancelp(kind, kind1){ //kind => all or parts , kind1 => tr index
	var chkval;
	var retval;
	if(kind == 'all'){
		chkval = $('input[name="nob[]"]').closest('tr').eq(kind1).find('td:eq(1)').attr('cancel_light');
	} else {
		chkval = $('input[name="nob[]"]').closest('tr').eq(Number(kind1)+1).find('td:eq(1)').attr('cancel_light');		
	}
	console.log(chkval = $('input[name="nob[]"]').closest('tr').eq(kind1).find('td:eq(1)').attr('cancel_light'));
	if(chkval != 'red' && (chkval === '' || typeof chkval === 'undefined' )){
		retval = 'NO';
	} else {
		retval = 'YES';
	}
	console.log(retval);
	return retval;
}

function rep_juno(kind){
	
	var fu_ju = kind.replace(/[^0-9]/g, "");
	console.log(fu_ju);						
   if (fu_ju.length > 5 && fu_ju.length < 14) {

		var cnt_ju = fu_ju.length;
		var cut_b_ju = fu_ju.length - 6;
		
			var fju;
			var bju;
			fju = fu_ju.substr(0,6);
			bju = fu_ju.substr(6, cut_b_ju);	
		
			//kind.val(fju+'-'+bju);				

			 //$('#t_list').find('tr:eq('+(rown+1)+') td:eq('+coln+') input[name="juminno[]"]').val(fju+'-'+bju);
			 var ret_val = fju+'-'+bju;
			 return ret_val;
	}
}