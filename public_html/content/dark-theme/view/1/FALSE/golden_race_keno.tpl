{php} include "content/dark-theme/view/dark_header.php";{/php}


{literal}



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
                        background: #ff7c0c;
                        color:#fff !important;
                    }

                    .casino-page-wrapper .casino-menu .submenu li:hover a{
                        background: #ff7c0c;
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
                                    background-color: #ff7c0c;
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
                                    background-color: #ff7c0c;

                                }

                                .casino-image img {
                                    width: 100%;
                                    border: 1px solid #ff7c0c;
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

    <div class="casino-page-wrapper">
        <iframe src="{php} echo json_decode($url)->url {/php}" class="virtualFrame" scrolling="yes" frameborder="0"></iframe>
    </div>

</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="/assets/js/app.js?v={php} echo time(); {/php}"></script>