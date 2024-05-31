{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs">
	 <a href="javascript:window.location.href=window.location.href" class="page-title">
          <i class="icon-roulette"></i>
        CANLI CASINO
      </a>
</div>

{literal}
<script type="text/javascript">
    function hogaming(id){
        $.ajax({
            url:"/LiveCasino/Token/"+id,
            success:function(response){
                if (response.code == "1") {
                    console.log(response.token);
                    $("#liveLoaders").hide();
                    $(".center-container").append('<iframe scrolling="no" frameborder="0" border="0" width="100%" height="800px" src="https://livegames.detailgaming.com/login/visitor/checkLoginGI.jsp?ticketId='+ response.token +'&gameType=0000000000000004&lang=en&version=v4"></iframe>')
                }
            }
        });
    }
    hogaming(1);
</script>
{/literal}

<section id="main" class="backgroundsize " >
  <div class="container">
    <div id="main-panel" class="row" style="min-height: 600px;">
      <div id="main-center">
        <div class="center-container">
            <div id="liveLoaders" class="loaderSport" ></div>
        </div>
      </div>
    </div>
  </div>
</section>



{php} include "content/dark-theme/view/dark_footer.php";{/php}