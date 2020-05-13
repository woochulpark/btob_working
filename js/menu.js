 var Gnb = $(".gnb ul").html();
    var onGnb = $(".gnb ul > li.on > .sub_menu").html();
    var onGnb2 = $(".gnb ul > li.on > .sub_menu > li.on").html();
    $("#lnb_menu, #w_lnb_menu").html(onGnb);
    $("#gnb_menu").html(Gnb);
  
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