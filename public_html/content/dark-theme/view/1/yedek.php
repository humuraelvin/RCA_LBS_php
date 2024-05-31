{php} include "content/dark-theme/view/dark_header.php";{/php}

{php} if (isset($duyuru->icerik)) { {/php}

<!-- Duyuru Modal -->
{literal}

<script type="text/javascript">
$(function(){
    var d = "<?php echo date('d'); ?>";
	var duyuru_id = "<?php echo $duyuru->id; ?>";
	if ( localStorage.getItem('duyuru_' + duyuru_id + '_' + d) === null ) {
        $('#remodalx').remodal().open();
        $(".duyuru-kapat").on('click', function() {
			localStorage.setItem('duyuru_' + duyuru_id + '_' + d, 1 );
		});
	}
});
</script>


{/literal} 


<div class="remodal home-remodal" id="remodalx" data-remodal-id="duyuru-<?php echo $duyuru->id; ?>" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" style="background: none;">
    <div class="modal-content" style="-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;">
        <div class="modal-header">
            <button type="button" class="close" data-remodal-action="close" aria-label="Close"><i class="icon-close"></i></button>
            <h4 class="modal-title">DUYURULAR</h4>
        </div>
        <div class="modal-body scrollable" >
            <p style="font-size: 16px;">{php} echo $duyuru->icerik; {/php}</p>
        </div>
        <div class="modal-footer">
            <button data-remodal-action="confirm" class="remodal-confirm duyuru-kapat" data-id="<?php echo $duyuru->id; ?>" style="padding: 10px 20px 10px 20px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;">BİR DAHA GÖSTERME</button>
        </div>
    </div>
</div>

{php} } {/php}

<section id="" class="" >

          <div id="large-slider" class="carousel slide" data-ride="carousel">

  <ol class="carousel-indicators"> 
  {php}$sayi = 0;{/php}
  {foreach from="$bannerlar" item="banner" key="a"}
  {php}
  if ($sayi == 0) {$csxx = "active";}
  else {$csxx = "";}
  {/php}
  <li data-target="#large-slider" data-slide-to='{php}echo $sayi;{/php}' class='{php}echo $csxx;{/php}'></li>
  {php}$sayi++;{/php}
  {/foreach}      
</ol>



<div class="carousel-inner" role="listbox">
  {php}$sayi = 1;{/php}
  {foreach from="$bannerlar" item="banner" key="a"}
  {php}
  if ($sayi == 1) {$csx = "active";}
  else {$csx = "";}
  {/php}
  <div class="item {php}echo $csx;{/php}" data-bgcolor="#000000">
  		<a><img src='{php}echo $banner->url;{/php}'></a>
  </div>
  {php}$sayi++;{/php}
  {/foreach} 
</div>



    <a class="left carousel-control hidden-xs" href="#large-slider" role="button" data-slide="prev">
      <span class="glyphicon-chevron-left icon-arrow-left" aria-hidden="true"></span> <span class="sr-only">Geri</span>
    </a>
    <a class="right carousel-control hidden-xs" href="#large-slider" role="button" data-slide="next">
      <span class="glyphicon-chevron-right icon-arrow-right" aria-hidden="true"></span> <span class="sr-only">İleri</span>
    </a>
  </div>

    <div class="container mobilehide">
        <div id="main-panel" class="row ">
            <div id="main-center">
                <div class="center-container">
                    <div class="row products">
                        <div class="col-sm-3 col-xs-6 ">
                            <a href="/sports" class="product " ">
                            <img src="/uploads/homepage/sporbahisleri.png" width="100%">
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <a href="/live" class="product ">
                                <img src="/uploads/homepage/canlibahisler.png" width="100%">
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <a href="/GoldenRace/Game/10111" class="product " >
                                <img src="/uploads/homepage/sanalsporlar.png" width="100%">
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <a href="/LiveCasino/Slot" class="product " >
                                <img src="/uploads/homepage/slotcasino.png" width="100%">
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <a href="/LiveCasino" class="product " >
                                <img src="/uploads/homepage/canlicasino.png" width="100%">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="otk-landing_pbet">
        <div class="otk-pbet_interior_boxes otk-el-row" style="margin-left: -1.5px; margin-right: -1.5px;">
            <div class="otk-int_b_otk-arrow_left" style="background-image: url('/assets/images/arrowleft.png');"></div>
            <div class="otk-int_b_otk-arrow_right" style="background-image: url('/assets/images/arrowright.png');"></div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/sports" class="otk-int_box_item_in " style="background-image: url('/assets/images/1.png');">
                    <img src="/assets/images/ball_icon.svg" class="otk-int_box_ico_slot">
                    <div class="otk-int_box_title"> Spor Bahisleri</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/LiveCasino/Slot" class="otk-int_box_item_in" style="background-image: url('/assets/images/2.png');">
                    <img src="/assets/images/slot_machine.svg" class="otk-int_box_ico_slot">
                    <div class="otk-int_box_title"> Slot Oyunları</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/LiveCasino/Slot" class="otk-int_box_item_in" style="background-image: url('/assets/images/4.png');">
                    <img src="/assets/images/live_casino.svg" class="otk-int_box_ico_slot">
                    <div class="otk-int_box_title"> Canlı Casino</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/LiveCasino/Slot" class="otk-int_box_item_in" style="background-image: url('/assets/images/7.png');">
                    <img src="/assets/images/horse_racing.svg" class="otk-int_box_ico">
                    <div class="otk-int_box_title">Sanal Bahis</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/LiveCasino/Slot" class="otk-int_box_item_in" style="background-image: url('/assets/images/5.png');">
                    <img src="/assets/images/card_icons.svg" class="otk-int_box_ico_pkr">
                    <div class="otk-int_box_title single_liner_tit"> Poker</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
            <div class="otk-int_box_item otk-el-col otk-el-col-4" style="padding-left: 1.5px; padding-right: 1.5px;">
                <a href="/LiveCasino/Slot" class="otk-int_box_item_in" style="background-image: url('/assets/images/6.png');">
                    <img src="/assets/images/bingo_icon.svg" class="otk-int_box_ico_bingo">
                    <div class="otk-int_box_title otk-single_liner_tit"> Tombala</div>
                </a>
                <div class="otk-sbox otk-sboxtop"></div>
                <div class="otk-sbox_glower"></div>
            </div>
        </div>
        <div class="otk-pbet_interior_boxes otk-live_casino otk-el-row">
            <div class="otk-live_box_item otk-first_l_box otk-el-col otk-el-col-6">
                <a href="/LiveCasino" class="otk-int_box_item_in otk-lin_in otk-poker_b" style="background-image: url('/assets/images/l1.png');"></a>
                <div class="otk-sbox otk-sboxlive"></div>
                <a href="/LiveCasino" class="otk-landing_btn otk-live_btn">Blackjack</a>
                <div class="otk-first_l_box otk-live_line otk-line_1 otk-BoxBehind" style="background-image: url('/assets/images/line1.svg');"><span
                            class="otk-arrow otk-arrow1"></span> <span class="otk-arrow otk-arrow2"></span></div>
            </div>
            <div class="otk-live_box_item otk-el-col otk-el-col-6">
                <a href="/LiveCasino" class="otk-int_box_item_in otk-lin_in" style="background-image: url('/assets/images/l2.png');"></a>
                <div class="otk-sbox otk-sboxlive"></div>
                <a href="/LiveCasino" class="otk-landing_btn otk-live_btn">Poker</a>
            </div>
            <div class="otk-live_box_item otk-el-col otk-el-col-6">
                <a href="/LiveCasino" class="otk-int_box_item_in otk-lin_in" style="background-image: url('/assets/images/l3.png');"></a>
                <div class="otk-sbox otk-sboxlive"></div>
                <a href="/LiveCasino" class="otk-landing_btn otk-live_btn">Roulette</a>
            </div>
            <div class="otk-live_box_item otk-last_l_box otk-el-col otk-el-col-6">
                <a href="/LiveCasino" class="otk-int_box_item_in otk-lin_in" style="background-image: url('/assets/images/l4.png');"></a>
                <div class="otk-sbox otk-sboxlive"></div>
                <a href="/LiveCasino" class="otk-landing_btn otk-live_btn">Baccarat</a>
                <div class="otk-live_line otk-line_2 otk-BoxBehind" style="background-image: url('/assets/images/line1.svg');"><span
                            class="otk-arrow otk-arrow1"></span> <span class="otk-arrow otk-arrow2"></span></div>
            </div>
            <div class="otk-live_line otk-line_3 otk-BoxBehind" style="background-image: url('/assets/images/line2.svg');"></div>
            <div class="otk-live_line otk-line_4 otk-BoxBehind" style="background-image: url('/assets/images/line3.svg');"></div>
        </div>
                <div class="otk-new_l_arrow_down"><img src="/assets/images/arrow_down.svg"></div>
        <div class="otk-pbet_popular_games otk-el-row" style="margin-left: -7.5px; margin-right: -7.5px;">
            <div class="otk-m_g_left" style="background-image: url('/assets/images/mgleft.png');">
                <div class="otk-sbox game_ch_lef_shw"></div>
            </div>
            <div class="otk-m_g_right" style="background-image: url('/assets/images/mgright.png');"></div>
            <div class="otk-int_box_item otk-game_of_m_covr otk-game_box_lg otk-el-col otk-el-col-10" style="padding-left: 7.5px; padding-right: 7.5px;">
                <a href="/LiveCasino/Slot" class="otk-g_b_i_cover">
                    <div class="otk-game_box_interior" style="background-image: url('assets/images/6c08f63d4055905768da9b74328b0681.jpeg');"></div>
                    <div class="otk-pn_game_name">Vikings</div>
                </a>
                <div class="otk-ribbon otk-ribbon-top-right"><span>Ayın Oyunu</span></div>
            </div>
            <div class="otk-int_box_item otk-pb_pg_right otk-el-col otk-el-col-14" style="padding-left: 7.5px; padding-right: 7.5px;">
                <div class="otk-game_box otk-animate otk-animate-bg otk-el-col otk-el-col-12" style="padding-left: 7.5px; padding-right: 7.5px;">
                    <a href="/LiveCasino/Slot" class="otk-g_b_i_cover">
                        <div class="otk-game_box_interior" style="background-image: url('assets/images/3edcb4fa961bfa46f905bf29c65041e8.jpeg');"></div>
                        <div class="otk-pn_game_name">Immortal Romance</div>
                    </a>
                </div>
                <div class="otk-game_box otk-animate otk-animate-bg otk-el-col otk-el-col-12" style="padding-left: 7.5px; padding-right: 7.5px;">
                    <a href="/LiveCasino/Slot" class="otk-g_b_i_cover">
                        <div class="otk-game_box_interior" style="background-image: url('assets/images/4cf0f1f6a4b98c7285250004c09cd3a3.jpeg');"></div>
                        <div class="otk-pn_game_name">Starburst</div>
                    </a>
                </div>
                <div class="otk-game_box otk-animate otk-animate-bg otk-el-col otk-el-col-12" style="padding-left: 7.5px; padding-right: 7.5px;">
                    <a href="/LiveCasino/Slot" class="otk-g_b_i_cover">
                        <div class="otk-game_box_interior" style="background-image: url('assets/images/bbd06bfff4648702575d55f20e3624ae.jpeg');"></div>
                        <div class="otk-pn_game_name">Eggomatic</div>
                    </a>
                </div>
                <div class="otk-game_box otk-animate otk-animate-bg otk-el-col otk-el-col-12" style="padding-left: 7.5px; padding-right: 7.5px;">
                    <a href="/LiveCasino/Slot" class="otk-g_b_i_cover">
                        <div class="otk-game_box_interior" style="background-image: url('assets/images/04463fa84816385ad6ea82ea4e3b010e.jpeg');"></div>
                        <div class="otk-pn_game_name">Archangels Salvation</div>
                    </a>
                </div>
            </div>
        </div>
        <a href="/signin" class="otk-landing_btn otk-centered_btn">Hemen Üye Ol</a>
        <!---->
    </div>
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}