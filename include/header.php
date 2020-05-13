<div id="header">
    <div class="in_header">
        <h1><a href="../main/main.php"><img src="../img/common/logo.png" alt="투어세이프 여행자보험"></a></h1>
		<div class="top_menu_wrap" style="padding-right: 260px;">
			<ul class="top_menu">
				<li class="tel"><strong>1800-9010</strong></li>
				<li class="fax"><span>Fax : 02-2088-1673</span></li>
				<li class="mail"><span>E-mail : toursafe@bis.co.kr</span></li>
			</ul>
			
			<? if($_SESSION['s_mem_id']=="") { ?>
			<p class="bookmark" style="right:110px;"><a href="javascript:void(0);" id="favorite"><span>즐겨찾기</span></a></p>
			<p class="logout"><a href="../member/login.php"><span>로그인</span></a></p>
			<? } else { ?>
			<p class="bookmark" style="right:115px;"><a href="javascript:void(0);" id="favorite"><span>즐겨찾기</span></a></p>
			<p class="logout"><a href="../src/logout.php"><span>로그아웃</span></a></p>
			<? } ?>
		</div>
        <h2 class="skip">주요 서비스 메뉴</h2>
		<?

				if($_SESSION['s_mem_id'] != '' && $_SERVER['PHP_SELF'] != '/member/join.php'){
		?>
        <div id="gnbW" class="w_gnb">
            <? include ("../include/gnb.php"); ?>
        </div>
		<?
				}
			?>
    </div>
    <div class="m_gnbW">
        <div class="m_gnb_on bt_all">
            <div class="menu_btn">
                <div class="line-top"></div>
                <div class="line-middle"></div>
                <div class="line-bottom"></div>
            </div>
        </div>
    </div>
    <div id="gnb_bar">
    </div>
</div>

<!-- m gnb -->

<div id="slide_menu_wrap" class="slide_menu_wrap ">
    <div class="slide_menu_inner">
        <? include ("../include/gnb.php"); ?>
    </div>
    <div class="all_close">
        <div class="menu_btn is-open">
            <div class="line-top"></div>
            <div class="line-middle"></div>
            <div class="line-bottom"></div>
        </div>
    </div>
</div>

<!-- //m gnb -->


<div id="black"></div>

<script>
	$(document).ready(function(){
		$('#favorite').on('click', function(e) { 

		var bookmarkURL = window.location.href; 

		var bookmarkTitle = document.title;

		var triggerDefault = false; 

			

		if (window.sidebar && window.sidebar.addPanel) { 

			// Firefox version < 23 

			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, ''); 

		} else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) { 

			// Firefox version >= 23 and Opera Hotlist 

			var $this = $(this); 

			$this.attr('href', bookmarkURL); 

			$this.attr('title', bookmarkTitle); 

			$this.attr('rel', 'sidebar'); 

			$this.off(e); 

			triggerDefault = true; 

		} else if (window.external && ('AddFavorite' in window.external)) { 

			// IE Favorite 

			window.external.AddFavorite(bookmarkURL, bookmarkTitle); 

		} else { 

			// WebKit - Safari/Chrome 

			alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.'); 

		} 

		

		return triggerDefault; 

	});



	});
</script>