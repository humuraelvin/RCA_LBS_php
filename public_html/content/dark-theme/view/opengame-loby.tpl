{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs">
    <a href="" class="page-title">
        <i class="icon-casino"></i> Casino
    </a>
</div>

{literal}
<script type="text/javascript">
        function hogaming(id){
            $.ajax({
                url:"/GameLoby/Token/"+id,
                success:function(response){

                    if (response.code == "1") {
                        $(location).attr('href', response.url)
                    }
                }
            });
        }
        hogaming({/literal}{php} echo $id {/php}{literal});
</script>
{/literal}
<section id="main" class="sportsbook_padding " style="padding: 40px 0px 40px 0px;">
<div id="liveLoaders" class="loaderSport" ></div>
    <div style="text-align: center;font-size: 16px;color:#fff;">Lütfen Bekleyiniz...</div>
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}