var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

function win_pop(url, width, height) {
    var newwin = window.open(url, '', 'width=' + width + ',height=' + height + ',left=100,top=0, scrollbars=yes, resizable=yes');
    newwin.focus();
}

function fnc_payment() {
    var newwin = window.open('../popup/payment.php', 'payment', 'width=600,height=650,left=100,top=0,scrollbars=yes');
    newwin.focus();
}

function fnc_payment2() {
    var newwin = window.open('../popup/payment2.php', 'payment', 'width=600,height=650,left=100,top=0,scrollbars=yes');
    newwin.focus();
}

function fnc_terms() {
    var newwin = window.open('../popup/terms.php', 'terms', 'width=600,height=650,left=100,top=0,scrollbars=yes');
    newwin.focus();
}

function fnc_policy() {
    var newwin = window.open('../popup/policy.php', 'policy', 'width=600,height=650,left=100,top=0,scrollbars=yes');
    newwin.focus();
}

function fnc_email() {
    var newwin = window.open('../popup/email.php', 'email', 'width=600,height=650,left=100,top=0,scrollbars=yes');
    newwin.focus();
}

function Comment(num) {
    $(".xans-board-commentform").hide();
    $("#commentform_" + num).show();
}

function Comment_del(num) {
    $(".xans-board-commentform").hide();
    $("#commentform_del" + num).show();
}

function CloseComment() {
    $(".xans-board-commentform").hide();
}


function topM(num){
	$("#top_m"+num).slideToggle(300);
}



var lastScrollPos = 0;
preventScoll = function () {
    lastScrollPos = $(window).scrollTop();

}
enableScroll = function () {

    window.scrollTo(0, lastScrollPos);
}



function topM(num) {
    $("#top_m" + num).slideToggle(300);
}

function goTop() {
    $('html, body').stop().animate({
        scrollTop: 0
    }, {
        duration: 500,
        easing: "easeInOutExpo"
    });
}

/* 프린트 */
function printArea() {
    $("#wrap").addClass("print_wrap");
    window.print();
    setTimeout(function () {
        $("#wrap").removeClass("print_wrap");
    }, 100);

}



/* gnb 스크롤 처리 */
function WinR() {
    $(".m_gnb_on").click(function () {
        var GnbHeight = $(window).height() - 100;
        $(".m_gnb .gnb > ul").css({
            maxHeight: GnbHeight
        });
    });
}

/* 클래스조작 */
function List_ch1() {
    $('#array1').addClass('on');
    $('#array2').removeClass('on');
    $('.list_wrap').removeClass('blog_list');
}

function List_ch2() {
    $('#array1').removeClass('on');
    $('#array2').addClass('on');
    $('.list_wrap').addClass('blog_list');
}



/* 검색박스 */
function ViewSearch() {
    $(".search_box").slideDown(300);
}

function CloseSearch() {
    $(".search_box").slideUp(300);
}


function RightFix(){
	 var rt = $("#right_wrap").offset().top + 56;
            
            $(window).scroll(function () {
                var th = $("#header").outerHeight() + $(".join_step").outerHeight();
                var wt = $(window).scrollTop();

                if(wt >= rt){
                    $("#right_wrap").addClass("pa_aa");
                }else if(wt < rt) {
                    $("#right_wrap").removeClass("pa_aa");
                }
                
                $('.pa_aa').css('top', wt - th);
                
          
  
            });

}



/* 로그인 팝 */
function loginPop(pop_no) {

    var WinHeight = $(window).height() - 50;
    var PopHeight = $("#loginPop" + pop_no).height();
    var pop_ = eval("document.getElementById('loginPop" + pop_no + "')");
    $(".layerPop").hide();
    $("#black").fadeIn(200);
    $(pop_).children(".layerPop_in").css({
        maxHeight: WinHeight - 50
    });
    if (WinHeight >= PopHeight) {
        $(pop_).css({
            marginTop: -PopHeight / 2
        });
    } else {
        $(pop_).css({
            marginTop: -WinHeight / 2
        });
    }
    $(pop_).fadeIn(200);

    $("body").addClass("fixe");
}

/* 레이어 팝 */
function ViewlayerPop(pop_no) {

    preventScoll();
    var WinHeight = $(window).height();

    var pop_ = $("#layerPop" + pop_no).children(".layerPop_inner");
    $(".layerPop").hide();
    $("#layerPop" + pop_no).fadeIn(100);



    var PopHeight = $("#layerPop" + pop_no).children(".layerPop_inner").height();
    var Padd = WinHeight - PopHeight;


    if (WinHeight >= PopHeight) {
        $(pop_).css({
            paddingTop: Padd / 2
        });
    } else {
        $(pop_).css({
            paddingTop: "40px"
        });
    }

    $("body").addClass("fixe");
}

function CloselayerPop(pop_no) {
    var pop_ = eval("document.getElementById('layerPop" + pop_no + "').style");
    pop_.display = 'none';
    $("body").removeClass("fixe");

    enableScroll();
}


function CloselayerPop() {
    $(".layerPop .file_input > input").val('');
    $(".layerPop").fadeOut(200);
    $("body").removeClass("fixe");

    enableScroll();
}




/* 폰트 사이즈 */
function FontDown() {
    var objFont = (parseInt($(".reding_txt .txt").css("fontSize")) - 1) + "px";
    $(".reding_txt .txt").css("fontSize", objFont);
}

function FontUp() {
    var objFont = (parseInt($(".reding_txt .txt").css("fontSize")) + 1) + "px";
    $(".reding_txt .txt").css("fontSize", objFont);
}

function FontBack() {
    $(".reding_txt .txt").css("fontSize", "16px");
}

function KID_FontBack() {
    $(".reding_txt .txt").css("fontSize", "18px");
}

var is_Resized;
var is_Resized_cnt = 0;

/* 팝업 auto_resiaing */
function win_resize() {
    $(document).attr("overflow-x", "hidden");
    $(document).attr("overflow-y", "auto");

    var wrapWidth = $("#Ne_Popw").outerWidth();
    var wrapHeight = $("#Ne_Popw").outerHeight();

    var w1 = $(window).width();
    var h1 = $(window).height();

    try {
        // 크롬의 문제로 W, H 값을 따로 설정
        // window.resizeBy(wrapWidth - w1, wrapHeight-h1);
        window.resizeBy(wrapWidth - w1, 0);
        window.resizeBy(0, wrapHeight - h1);
        //창 크기 자동 조절 E

        if ($(window).height() != $("#Ne_Popw").outerHeight()) {
            is_Resized = setTimeout(function () {
                win_resize()
            }, 200);
            is_Resized_cnt++;
            if (is_Resized_cnt >= 3) {
                clearTimeout(is_Resized);
            }
        }



    } catch (e) {}
}




/* 이미지 전환 */
function faqlist(q_open) {
    if ($(q_open).css('display') != "none") {
        $(q_open).hide();
    } else {
        $('tbody>tr.bg2').hide();
    }
}


function FixedTab() {
    var headerH = $("#header").height();
    var fixedTab = $("#lnb_wrap").offset();
    $(window).scroll(function () {

        if ($(document).scrollTop() > fixedTab.top - headerH) {
            $('#lnb_wrap').addClass('fix');
        } else {
            $('#lnb_wrap').removeClass('fix');
        }
    });
}





var dt = new Date();
var check_month = dt.getMonth() + 1;
var check_year = dt.getFullYear();

var i = 0;
var oneDepth = 0;
var twoDepth = 0;
var tabDepth = 0;
/* gnb_sub */
$(document).ready(function () {
    if (isMobile.any()!= null || isMobile.Android()!= null || isMobile.iOS()!= null) {
			$(".m_img img").click(function(){
				var imgSrc = $(this).attr("src");
				
				window.location.href = '../include/img_pop.php?type='+imgSrc+'';
			});
		} 
    
    
    if (oneDepth > 0) {
        $(".gnb0" + oneDepth).addClass("on");

    } else {
        oneDepth = 0;
    }

    if (twoDepth > 0) {
        $(".on .lnb" + twoDepth).addClass("on");
    } else {
        twoDepth = 0;
    }
    if (tabDepth > 0) {
        $(".tab_num" + tabDepth).addClass("on");
    } else {
        tabDepth = 0;
    }


    /* 페이지 체크 */
    var pageName1 = $(".gnb ul > li.on > a").html();
    var pageName2 = $(".sub_menu > li.on > a").html();


    $("#lnb_tit, #location_1").html(pageName1);
    $("#title, #lnb_tit2, #location_2").html(pageName2);
    $("#sub_tit").html(pageName1);
    $("#wrap").addClass("sub_wrap_" + oneDepth);

    var Gnb = $(".gnb ul").html();
    var onGnb = $(".gnb ul > li.on > .sub_menu").html();
    var onGnb2 = $(".gnb ul > li.on > .sub_menu > li.on").html();
    $("#lnb_menu, #w_lnb_menu").html(onGnb);
    $("#gnb_menu").html(Gnb);


    $("#lnb_tit").click(function () {
        $("#lnb_menu").slideUp(200);
        $("#lnb_tit2").removeClass("on");
        if ($("#gnb_menu").css('display') != "none") {
            $(this).removeClass("on");
            $("#gnb_menu").slideUp(200);
        } else {
            $(this).addClass("on");
            $("#gnb_menu").slideDown(200);
        }

    });

    $("#lnb_tit2").click(function () {
        $("#lnb_tit").removeClass("on");
        $("#gnb_menu").slideUp(200);
        if ($("#lnb_menu").css('display') != "none") {
            $(this).removeClass("on");
            $("#lnb_menu").slideUp(200);
        } else {
            $(this).addClass("on");
            $("#lnb_menu").slideDown(200);
        }

    });

    //FixedTab();


    
    $(".main_wrap .in_header").mouseenter(function(){
        $("#header").addClass("over");
    });
    $(".main_wrap .in_header").mouseleave(function(){
        $("#header").removeClass("over");
    });
    
    $(window).scroll(function () {

        if ($(document).scrollTop() > 0) {
            $("#header").addClass("down");
        } else {
            $("#header").removeClass("down");
        }
    });

   



    $(".search_btn").click(function () {
        $(".search_box").slideToggle(200);
    });

    //$("#sub_visual").animate({"opacity":"1"}, {duration:700, easing:"easeInExpo"});



    //선택 add on
    $(".choice_tab > li").click(function () {
        $(".choice_tab > li").removeClass("on");
        $(this).addClass("on");
    });


    //해더 고정
    /*  $( window ).scroll( function() {
          if ( $( document ).scrollTop() > 0 ) {
            $( '#header' ).addClass( 'bg_on' );
			$( '#container' ).addClass( 'scroll_on' );
			
          }
          else {
            $( '#header' ).removeClass( 'bg_on' );
			$( '#container' ).removeClass( 'scroll_on' );
          }
        });
		
		var rmOffset = $(".quick_wrap").offset();
        $( window ).scroll( function() {
          if ( $( document ).scrollTop() > rmOffset.top) {
            $(".quick_wrap").addClass( 'lbfixed' );
          }
          else {
            $(".quick_wrap").removeClass( 'lbfixed' );
          }
        });		
		
		*/



    //ie9이하 placeholder 적용
   // $('input, textarea').placeholder();
    /* 페밀리 사이트 */
    $(".familySite > .on").click(function () {
        $("#footerW").toggleClass("z_over");
        $(".familySite > ul").toggleClass("show");
    });
    $(".familySite").mouseleave(function () {
        $("#footerW").removeClass("z_over");
        $(".familySite > ul").removeClass("show");
    });


    /* 자주 묻는 질문 아코디언 */
    $('tbody>tr.bg').click(function () {
        var item = $(this);
        $('tbody>tr.on').removeClass("on");
        item.addClass("on");
        if (item.next().css('display') != "none") {
            $('tbody>tr.bg2').hide();
            item.removeClass("on");

        } else {
            $('tbody>tr.bg2').hide();
            item.next().show();

        }


    });

    $(".in_header #my_info").click(function () {
        $(".my_info_pop").stop().fadeToggle(0);

    });
    $(".in_header .btn_close").click(function () {
        $(".my_info_pop").stop().hide();

    });





    $('.bt_all').click(function () {
        preventScoll();
        $("body").addClass("fixe");
        $('#slide_menu_wrap').addClass('on');
        $('#black').fadeIn(400);
        $("#slide_menu_wrap").addClass("on");

        $('#slide_menu_wrap').show()
        $('#slide_menu_wrap').stop().animate({
            right: 0
        }, {
            duration: 500,
            easing: "easeInOutExpo"
        });


    });

    $('.all_close, #black').click(function () {

        $("body").removeClass("fixe");
        $("#slide_menu_wrap").removeClass("on");
        $('#black').fadeOut(400);

        //$(".box").hide();
        $(".layerPop").hide();
        $("#slide_menu_wrap .sub_menu").slideUp();
        $("#slide_menu_wrap .sub_menu").slideUp();
        $("#slide_menu_wrap .gnb > ul > li > a").removeClass('on');

        $('#slide_menu_wrap').stop().animate({
            right: -80 + '%'
        }, {
            duration: 500,
            easing: "easeInExpo"
        });
        historylog = "";
        enableScroll();
    });
    $("#slide_menu_wrap .sub_menu").parent("li").children("a").attr("href","#url")

    $("#slide_menu_wrap .gnb > ul > li > a").click(function () {
        var ab = $(this).next(".sub_menu");
        if ($(ab).css('display') !== 'block') {
            $("#slide_menu_wrap .gnb > ul > li > a").removeClass('on');
            $(this).addClass('on');
            $('#slide_menu_wrap .sub_menu').slideUp(200);
            $(ab).slideDown(200);

        } else {
            $("#slide_menu_wrap .gnb > ul > li > a").removeClass('on');
            $('#slide_menu_wrap .sub_menu').slideUp(200);
        }

    });


    /* lnb */
    $(".right_menu > li").click(function () {
        var item = $(this)
        if ($(this).children(".sub_m").css('display') != "none") {
            $(this).children(".sub_m").slideUp(300);
            $(this).removeClass("on");
        } else {
            $(".sub_m").slideUp(300);
            $(".right_menu > li").removeClass("on");
            $(this).children(".sub_m").slideDown(300);
            $(this).addClass("on");
        }

    });


    /* w-gnb */
    $(".w_gnb .gnb > ul > li").mouseenter(function () {
        var item = $(this);
        //$("#gnb_bar").stop().slideDown(200);

        $(this).children(".sub_menu").stop().slideDown(200);
    });
    $(".w_gnb .gnb > ul > li").mouseleave(function () {
        var item = $(this);
        //$("#gnb_bar").stop().slideUp(200);

        $(".sub_menu").stop().slideUp(200);
    });

    /* m-gnb */
    $(".m_gnb_on").click(function () {
        $(".m_gnb").slideToggle(200);

    });

    $(".m_gnb > .gnb > ul > li").hover(function () {
            var item = $(this);
            $(this).children(".sub_menu").show();
        },
        function () {
            $(".sub_menu").stop().hide();
        });

    $(".gnb_close").click(function () {
        $(".gnb_sub").stop().slideUp(200);
    });

   

    /* layer pop */
    $(".close_bt").click(function () {
        $(".layerPop, .sitemap_wrap").fadeOut(200);
        $("body").removeClass("fixe");
        enableScroll();

    });

    var ddd = "Y";

    $(".layerPop").click(function () {
        if (ddd == "Y") {
            $(".layerPop").fadeOut(200);
            $("body").removeClass("fixe");
            enableScroll();
        } else {
            ddd = "Y";
        }
    });
    $(".pop_wrap_in").click(function () {
        ddd = "N";
    });


    $(".onlyNumber").keyup(function (event) {

        if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
            var inputVal = $(this).val();
            $(this).val(inputVal.replace(/[^0-9]/gi, ''));
        }
    });

    $(".onlyAlphabet").keyup(function (event) {
        if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
            var inputVal = $(this).val();
            $(this).val(inputVal.replace(/[^a-z]/gi, ''));
        }
    });

    $(".notHangul").keyup(function (event) {
        if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
            var inputVal = $(this).val();
            $(this).val(inputVal.replace(/[^a-z0-9]/gi, ''));
        }
    });

    $(".onlyHangul").keyup(function (event) {
        if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
            var inputVal = $(this).val();
            $(this).val(inputVal.replace(/[a-z0-9]/gi, ''));
        }
    });

    $("#selec").click(function () {
        $(this).toggleClass("on");
        $("#selec_l").slideToggle(200);
    });
    $("#selec_l > li > a").click(function () {
        var txt = $(this).html();
        var check_id = $(this).attr('data-id');
        $("#selec").html(txt);
        $("#selec_l").slideUp(200);
        $("#selec").removeClass("on");

        if (check_id != '') {
            $("#site_type").val(check_id);
            document.form1.submit();
        }
    });


});



/* 셀렉 디쟈인 */
function Select(id) {


    if ($(".Select-" + id).css('display') == "none") {
        $(".Select-" + id).show();
    } else {
        $(".Select-" + id).hide();
    }

    $(".Select-" + id).find("li").on("click", function () {
        if ($(this).text() == "직접입력") {
            $("#Select-" + id).prop("readonly", false).focus().val("");
            $(".Select-" + id).hide();
        } else {
            var $val = $(this).text();
            $("#Select-" + id).val($val);
            $(".Select-" + id).hide();
        }
    })

    $(".st_select").mouseleave(function () {
        $(".Select").hide();
    });

}




function seMove(seq) {
    var offset = $("#position" + seq).offset();
    $('html, body').stop().animate({
        scrollTop: offset.top + 1
    }, {
        duration: 500,
        easing: "easeInOutExpo"
    });

}



/* 이미지 전환 */
function MM_swapImgRestore() { //v3.0
    var i, x, a = document.MM_sr;
    for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
}

function MM_preloadImages() { //v3.0
    var d = document;
    if (d.images) {
        if (!d.MM_p) d.MM_p = new Array();
        var i, j = d.MM_p.length,
            a = MM_preloadImages.arguments;
        for (i = 0; i < a.length; i++)
            if (a[i].indexOf("#") != 0) {
                d.MM_p[j] = new Image;
                d.MM_p[j++].src = a[i];
            }
    }
}

function MM_findObj(n, d) { //v4.01
    var p, i, x;
    if (!d) d = document;
    if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
        d = parent.frames[n.substring(p + 1)].document;
        n = n.substring(0, p);
    }
    if (!(x = d[n]) && d.all) x = d.all[n];
    for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
    for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
    if (!x && d.getElementById) x = d.getElementById(n);
    return x;
}

function MM_swapImage() { //v3.0
    var i, j = 0,
        x, a = MM_swapImage.arguments;
    document.MM_sr = new Array;
    for (i = 0; i < (a.length - 2); i += 3)
        if ((x = MM_findObj(a[i])) != null) {
            document.MM_sr[j++] = x;
            if (!x.oSrc) x.oSrc = x.src;
            x.src = a[i + 2];
        }
}



