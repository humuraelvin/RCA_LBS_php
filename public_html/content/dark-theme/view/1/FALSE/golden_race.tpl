{php} include "content/dark-theme/view/dark_header.php";{/php}


{literal}

    <script type="text/javascript">
        function openVirtualGame(id) {
            window.open("/GoldenRace/Game/"+id,"Casino","width=1100,height=836");
        }
    </script>



    <style>

        @media (min-width: 992px) .casino-page-wrapper .casino-menu {
            min-height: 50px;
        }

            .casino-page-wrapper .casino-menu .submenu {
                display: block;
                height: 60px;
                width: 595px;
            }

            .casino-page-wrapper .casino-menu {
                background-color: #283347;
                position: relative;
                display: block;
            }

            .casino-page-wrapper .casino-menu .submenu li {
                display: block;
                height: 60px;
            }

            @media (min-width: 992px) .submenu>li {
                float: left;
                display: inline-block;
            }

                @media (min-width: 992px) .navbar-nav>li {
                    float: left;
                }

                    .casino-page-wrapper .casino-menu .submenu li a {
                        position: relative;
                        display: block;
                        height: 60px;
                        font-size: 14px;
                        color: #fff;
                        padding: 10px 10px;
                        text-transform: uppercase;
                    }

                    .casino-page-wrapper .casino-menu .submenu .active a {
                        background: #0f853d;
                        color:#fff !important;
                    }

                    .casino-page-wrapper .casino-menu .submenu li:hover a{
                        background: #0f853d;
                        color:#fff;
                    }

                    @media (min-width: 992px) .submenu>li>a {
                        width: auto !important;
                        background: transparent;
                        line-height: 30px;
                        height: 26px;
                        padding-top: 0;
                        padding-bottom: 0;
                        margin: 0;
                        padding: 0 0px;
                        color: #fff;
                        display: inline-block;
                    }

                        @media (min-width: 992px) .navbar-nav>li>a {
                            padding-top: 16px;
                            padding-bottom: 16px;
                        }

                            @media (max-width: 992px)
                                .casino-menu-mobile {
                                    font-size: 17px;
                                    color: #fff;
                                    height: 50px;
                                    top: 96px;
                                    left: 0;
                                    right: 0;
                                    position: fixed;
                                    z-index: 1005;
                                    min-width: 320px;
                                    background-color: #0f853d;
                                }

                                #main-panel {
                                    background: none  !important;
                                }

                                #main-panel #main-center {
                                    background: none  !important;
                                }

                                #main-panel h2 {
                                    padding-top: 30px;
                                    color: #1a6364;
                                    font-weight: 700;
                                }

                                #main-panel h2 a {
                                    color: #1a6364 !important;
                                    font-size: 20px;
                                    font-weight: 500;
                                    text-transform: uppercase;
                                }

                                .fullgamename {
                                    position: relative;
                                    width: 100%;
                                    text-align: center;
                                    color:#fff;
                                    line-height: 30px;
                                    bottom: 0;
                                    background-color: #0f853d;

                                }

                                .casino-image img {
                                    width: 100%;
                                }

                                .virtualFrame {
                                    width: 100%;
                                    height: 100vh;
                                    border: none;
                                }





    </style>

{/literal}





<section id="main" class="virtualgames sportsbook_padding newCasino">

    <div class="remodal-overlay" style="display: none;"></div>



    <div id="large-slider" class="carousel slide mobile-casino" data-ride="carousel">
        <ol class="carousel-indicators">
            {php}$i = 0; {/php}
            {foreach from="$gr_banners" item="banner" key="key"}
                <li data-target="#large-slider" data-slide-to="{php}echo $i;{/php}" class="{php} if ($i == 0) { echo "active";} {/php}"></li>
                {php}$i++;{/php}
            {/foreach}
        </ol>
        <div class="carousel-inner" role="listbox">
            {php}$i = 0;{/php}
            {foreach from="$gr_banners" item="banner" key="key"}
            <div class="item {php} if ($i == 0) { echo "active";} {/php}" data-bgcolor="">
            <a href="" target="">
                <img alt="" src="{php}echo $banner->image;{/php}">
            </a>
            <div class="carousel-caption container banner-caption">
                <div class="col-xs-offset-1 col-sm-offset-0 col-xs-6 col-ms-offset-2">
                    <div class="bordered-text" style="display: none">
                        <h2><span></span></h2>
                    </div>
                    <div class="caption-slide-message" >
                        <div class="caption-slide-message-wrp">
                            <span class="message-span" style="display: none"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {php}$i++;{/php}
        {/foreach}
    </div>
    <a class="left carousel-control hidden-xs" href="#large-slider" role="button" data-slide="prev">
        <span class="glyphicon-chevron-left icon-arrow-left" aria-hidden="true"></span> <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control hidden-xs" href="#large-slider" role="button" data-slide="next">
        <span class="glyphicon-chevron-right icon-arrow-right" aria-hidden="true"></span> <span class="sr-only">Next</span>
    </a>
    </div>



        <div class="container">
            <h2 id="Golden Race" class="version-Goldenrace"> GoldenRace <a href=""> </a> </h2>
            <div class="casino-page">
                <div id="main-panel" class="row">
                    <div class="container">
                        <div id="main-center">
                            <div class="center-container ">

                                <div class="row version-{php}echo permalink($key);{/php}">
                                    {php}foreach ($gr_games as $gamekey => $game) { {/php}
                                    <div class="col-md-3 casino-image nw-action" onclick="openVirtualGame({$game->code})" >
                                        <img src="{php}echo $game->image;{/php}">
                                        <div class="fullgamename">{php}echo $game->name;{/php}</div>
                                        <div class="inner"> <span> <i class="icon-play2"></i> </span> </div>
                                    </div>
                                    {php} } {/php}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="/assets/js/app.js?v={php} echo time(); {/php}"></script>