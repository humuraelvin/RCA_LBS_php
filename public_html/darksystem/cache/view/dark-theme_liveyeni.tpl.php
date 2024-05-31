<?php  include "content/dark-theme/view/dark_header.php"; ?>
<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-arrow-left"></i> </button>
    <a class="page-title"><i class="icon-football"></i> CANLI BAHİSLER</a>
    <button type="button" class="navbar-toggle toggle-right" data-toggle="sidebar" data-target=".sidebar-right" style="display: none;"> <i class="icon-betslip"></i>
        <span id="mobile-bet-counter" class="bet-counter displaynone">0</span>
    </button>
</div>



<section id="main" class="sportbook-theme" >
    <div class="container">
        <div id="main-panel" class="row have-sidebar-right have-sidebar-left">
            <div id="main-left" style="background: whitesmoke;" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano">
                <div class="left-container nano-content">
                    <form id="search" class="form-group form-icon">
                        <i class="icon-search"></i>
                        <input type="text" id="search_widget_input" class="form-control" autocomplete="off" placeholder="Maç Ara" />
                    </form>



                    <ul class="list-unstyled sport-menu event-menu no-padding">




                        <div id="live-menu-holder" >
                            <div data-reactroot="">
                                <div class="subCategories live-sports async-menu all-events sub-sport-menu" id="live-menu" >
                                    <div class=" panel-default border-sm">
                                        <!--LeftLiveMenu-->
                                        <div class="live_left_content dark-menu CL-OP RND-OP">
                                            <div class="live_left_content_wait"></div>
                                        </div>
                                        <!--LeftLiveMenu-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        </li>
                    </ul>

                </div>

            </div>

            <div id="main-center" style="min-height: 800px;">
                <div class="center-container">
                    <div id="liveLoaders" class="loaderSport"></div>
                    <div id="live_event_info">
                        <div id="event-filters" class="bets no-padding-sm">
                            <!--CenterLiveMenu-->
                            <div class="live_content_center" style="width: 100% !important;">
                                <!--<div class="lmt-container" ></div>-->
                                <div class="live_content_center_real" id="livematchdetail"></div>
                            </div>
                            <!--CenterLiveMenu-->
                        </div>
                    </div>
                </div>
            </div>

    
            <div id="main-right" class="sidebar sidebar-right sidebar-animate sidebar-md-show nano">

                <div class="right-pontainer nano-contentcanli" >

                    <div id="betslip" data-show-history="">
                        <!--
                                                <div class="betCouponsHeader">
                            <i class="icon-tv"></i> CANLI YAYIN

                        </div>
                    <div class="lmt-container1 mobile-hide" ></div>-->
                        <div class="panel-placer"></div>

                        <div class="betCouponsHeader">
                            <i class="icon-betslip"></i> BAHİS KUPONU

                            <div class="reset-coupon">
                                <a class="icon-trash"></a>
                            </div>

                        </div>

                        <div class="right_coupon CL-OP RND-OP"></div>
                    </div>
                </div>
            </div>

            <div class="main-overlay"></div>
        </div>
    </div>

    <div id="betSlipHeader"  data-toggle="sidebar" data-target=".sidebar-right" style="display: none;">
        <div class="betSlipBlock">
            <div class="BetslipInner isSelectionInBetslip">
                <div class="count-in-betslip" style="display: block; text-align: center; right:15px;">1</div>
                <div class="betslip-sign" style="font-size:1.8em !important;" >Kupon</div>
            </div>
        </div>
    </div>

</section>









<?php  include "content/dark-theme/view/dark_footer.php"; ?>