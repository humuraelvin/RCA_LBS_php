<?php  include "content/dark-theme/view/dark_header.php"; ?>
<div class="navbar-title visible-sm visible-xs">
    <a href="" class="page-title">
        <i class="icon-casino"></i> Casino
    </a>
</div>


<script type="text/javascript">
        function hogaming(id){
            $.ajax({
                url:"/LiveCasino/Token/"+id,
                success:function(response){

                    if (response.code == "1") {
                        $(location).attr('href', response.url)
                    }
                }
            });
        }
        hogaming(<?php  echo $id  ?>);
</script>

<section id="main" class="sportsbook_padding " style="padding: 40px 0px 40px 0px;">
<div id="liveLoaders" class="loaderSport" ></div>
    <div style="text-align: center;font-size: 16px;color:#fff;">Lè´‰tfen Bekleyiniz...</div>
</section>
<?php  include "content/dark-theme/view/dark_footer.php"; ?>