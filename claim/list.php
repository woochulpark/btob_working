<? 
	include ("../include/top.php"); 
?>
<script>
	var oneDepth = 4; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- s : container -->
    <section id="container">
        <section class="none">
            <h1>청구안내</h1>
        </section>
        <div id="claimWrap">
            <div class="tab_list tab_style">
                <ul>
                    <li class="active">
                        <a>ACE 손해보험</a>
                    </li>
                    <li>
                        <a>DB 손해보험</a>
                    </li>
                </ul>
            </div>
            <div class="claim_contents">
                
            </div>
        </div> 
        
    </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<script>
        $('.tab_list ul li').click(function(){
            var idx = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
           // $('.claim_contents .content').eq(idx).show().siblings().hide();

			$('.claim_contents').load('./claim_list.php?ind='+idx);
        });
		$(document).ready(function(){
			$('.claim_contents').load('./claim_list.php?ind=0');
		});
        </script>
</body>

</html>
