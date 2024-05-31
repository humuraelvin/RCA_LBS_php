
       
        <div id="ab-sidebar-coupon" class="col-sm-4 col-md-3 col-lg-3 ab-sidebar-right ab-sidebar-coupon">

          <div id="betslip" class="panel panel-default border-radius">
            <div class="panel-heading border-bottom">
              BAHİS KUPONU
              <a class="pull-right reset-coupon" href="javascript:;" title="TEMİZLE"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </div>
            <div class="panel-body clear-padding coupon-slip">
              <div class="coupon-bets">
                <div id="match_384152" class="coupon-match">
                  <div class="match-info">
                    <div>Syrianska FC</div>
                    <div class="selected">IFK Varnamo</div>
                    <span class="btn btn-danger btn-sm btn-bet btn-remove" onclick="removematch('384152', '384152');"><i class="fa fa-times" aria-hidden="true"></i></span>
                  </div>
                  <div class="match-result">
                    <span class="text">MAÇ SONUCU</span>
                    <div class="pull-right">
                      <span class="result">2</span>
                      <span class="multiplier">3.04</span>
                    </div>
                  </div>
                </div>
                <div id="match_355329" class="coupon-match">
                  <div class="match-info">
                    <div>Chelsea FC</div>
                    <div>FC Bayern Munich</div>
                    <span class="btn btn-danger btn-sm btn-bet btn-remove" onclick="removematch('355329', '355329');"><i class="fa fa-times" aria-hidden="true"></i></span>
                  </div>
                  <div class="match-result">
                    <span class="text">MAÇ SONUCU</span>
                    <div class="pull-right">
                      <span class="result">0</span>
                      <span class="multiplier">4.61</span>
                    </div>
                  </div>
                </div>
                <div id="match_356364" class="coupon-match">
                  <div class="match-info">
                    <div class="selected">Gais Goteborg</div>
                    <div>Östers IF</div>
                    <span class="btn btn-danger btn-sm btn-bet btn-remove" onclick="removematch('356364', '356364');"><i class="fa fa-times" aria-hidden="true"></i></span>
                  </div>
                  <div class="match-result">
                    <span class="text">MAÇ SONUCU</span>
                    <div class="pull-right">
                      <span class="result">1</span>
                      <span class="multiplier">1.52</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-body clear-padding coupon-result">
              <div class="title text-center">KUPON TUTARI</div>
              <div class="input-group">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="quant[1]">
                        <i class="fa fa-minus"></i>
                    </button>
                </span>
                <input type="text" name="quant[1]" class="multibet_stake form-control input-number kmiktar" onchange="kazanchesapla();" onkeyup="kazanchesapla();" value="1" min="1" max="9999999" id="coupon_amount">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                        <i class="fa fa-plus"></i>
                    </button>
                </span>
              </div>

            </div>


            <div class="panel-body padding-10 coupon-post">
              <div class="clearfix">
                Toplam Oran:
                <span class="pull-right oran-rakam">21.30</span>
              </div>
              <div class="clearfix">
                Toplam Kazanç:
                <span class="pull-right makskazanc-rakam" id="coupon_payout">2.130 TL</span>
              </div>

              <div class="checkbox">
                <label>
                <input type="checkbox" id="retain_selection"> Oran Değişikliğini kabul ediyorum
              </label>
              </div>
              <form action="">
                <div id="couponx">
                  <a class="btn btn-primary btn-md btn-block btn-p-lg btn-icon btn-bg confirm_button btn_accept_coupon">KUPONU YATIR <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </div>
                <div id="xcoupon" class="hidden form-group" style="background-color:rgba(0, 0, 0, 0.3);padding: 14px 0px 14px 0px;">
                  <li class="text-center bet-spinner" style="list-style-type:none;">
                    <img alt="Loading..." src="/assets/theme15/images/betslip_spinner-2834210147edecfd3ca5cc74d2876e5b.gif">
                  </li>
                </div>
              </form>
            </div>

          </div>
          <div class="ab-sidebar-close ab-coupon-close visible-xs visible-sm" data-target=".ab-sidebar-coupon">KUPONU GİZLE</div>
        </div>
        <div class="ab-sidebar-toggle ab-coupon-toggle visible-xs visible-sm" data-target=".ab-sidebar-coupon">KUPONU GÖSTER</div>