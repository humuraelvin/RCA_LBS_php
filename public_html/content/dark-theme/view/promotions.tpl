{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs"><a class="page-title"><i class="icon-bonus"></i>Promosyonlar</a></div>
<section id="main" class="" style="margin-top: 20px; background: none !important;">
    <div class="container">
        <div id="main-panel" class="row" style="background: none !important;">
            <div id="main-center" style="background: none !important;">
                <div class="center-container">

                    <div class="row proms">
                        {foreach from="$promosyonlar" item="promos" key="a"}
                            <div class="col-sm-4 promotions-banner">
                                <a href="#{php}echo $promos->seourl;{/php}" class="promo ">
                                    <img alt="" class="img-responsive casino-animation"
                                         src="{php}echo $promos->resim;{/php}">
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="main-overlay"></div>
        </div>
    </div>

    {foreach from="$promosyonlar" item="promos" key="a"}
        <div class="remodal" data-remodal-id="{php}echo $promos->seourl;{/php}" role="dialog"
             aria-labelledby="modal1Title" aria-describedby="modal1Desc">
            <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
            <div>
                <img alt="" class="img-responsive casino-animation modal-image" src="{php}echo $promos->resim;{/php}">
                <h2 id="modal1Title">{php}echo $promos->baslik;{/php}</h2>
                <p id="modal1Desc" style="text-align:left;">

                    {php}echo nl2br($promos->icerik);{/php}
                </p>
            </div>
            <br>
            <button data-remodal-action="confirm" class="btn-menu">OK</button>
        </div>
    {/foreach}

    {literal}
        <link rel="stylesheet" href="/assets/css/remodal/remodal.css">
        <script src="/assets/css/remodal/remodal.js"></script>
    {/literal}
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}