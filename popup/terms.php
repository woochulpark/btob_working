<? include "../include/top.php"; ?>

<script>

$(document).ready(function() {
	win_resize();
});
</script>
</head>
<body>
<div id="Ne_Popw" style="max-width:700px;">
  <div class="layers_wrap">
    <h1 class="layers_tit">이용약관</h1>
    <!--<p class="close_pop"><a href="#" onClick="javascript:window.close();"><img alt="닫기" src="../img/common/close_bt2.gif" /></a></p>-->
    <div class="layers"> 
      
      <!-- 내용 -->
      
      <div class="popup_scroll ">
      <div class="pol_sc">
        <div class="pol_sc_in">
			<? include "../include/terms.php"; ?>
        </div>
        </div>
      </div>
    
      <!-- //내용 --> 
      
    </div>
    
  </div>
</div>


</body></html>