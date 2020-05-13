	var lastScrollPos = 0;
preventScoll = function () {
    lastScrollPos = $(window).scrollTop();

}
enableScroll = function () {

    window.scrollTo(0, lastScrollPos);
}
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