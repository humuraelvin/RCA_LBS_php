<div id="betslip-wrap" class="panel panel-betslip" style="margin-top: 0px !important;">

<?php if(count($okupon) == 0){ ?>
  <div class="panel-body betslip">
    <ul class="bets list-unstyled">
        <li class="empty">Bahis kuponunuz boştur, bahis yapmak için herhangi bir orana tıklayın</li>
    </ul>
  </div>
<?php }else{?>



<input id="kcanli" value="0" style="display:none;">

<div class="panel-body betslip">
<ul class="bets list-unstyled" style="padding: 5px 0px 10px 0px;">
<?php foreach($okupon as $k => $z){ ?>
<li >
  <a class="remove close remove-match" onClick="removematch('<?php if(isset($z["id"])) { echo $z["id"];}?>', '<?php if(isset($z["id"])) { echo $z["id"];}?>');"><i class="fa fa-times" style="color: #233240 !important;"></i></a>
  <p title="" class="result"><?php  echo substr($z["evsahibi"],0,14);  ?> - <?php  echo substr($z["deplasman"],0,14);  ?> </p>
  <p class="result"><?php if(isset($z["grup"])) { echo $z["grup"];}?></p>
  <div class="odds-select-name">
  <b style="color:#fff;"> <?php  echo substr($z["tur"],0,21);  ?> </b>
  <div style="float: right;"><div class="odd-coupon"><?php echo nf($z["oran"]) ; ?></div></div>
  </div>
</li>
<?php } ?>
</ul>
</div>


<div class="panel-footer betslip">

<div class="footer-block stake">
    <div class="input-group-sm">
        <span class="input-group-btn" style="width: 30%;float: left;"><button class="btn btn-coupon"  style="height: 40px;font-size: 14px;" type="button" onclick="$('#coupon_amount').val(parseInt($('#coupon_amount').val()) - 2);kazanchesapla();"> - </button></span>
        <input class="multibet_stake form-control kmiktar" onkeyup="kazanchesapla();"  type="text" value="2" id="coupon_amount" style="width: 40%;float: left;height: 40px;text-align: center;font-weight: bold;">
        <span class="input-group-btn" style="width: 30%;float: left;"><button class="btn btn-coupon" style="height: 40px;font-size: 14px;" type="button" onclick="$('#coupon_amount').val(parseInt($('#coupon_amount').val()) * 2);kazanchesapla();"> + </button></span>

        
            <script type="text/javascript">
                $( document ).ready(function() {
                    kazanchesapla();
                });
            </script>
        

    </div>
</div>

<div class="footer-block">
    <ul class="list-unstyled">
        <li>
            Toplam Oran : 
            <span class="pull-right  oran-rakam"><?php echo nf(round($toporan,2)) ; ?></span>
        </li>

        <li>
            Toplam Kazanç : 
            <span class="pull-right makskazanc-rakam" id="coupon_payout">0.00 TL</span>
        </li>
        <li>
            <input type="checkbox" id="retain_selection"  checked="">  
            <label for="retain_selection" style="font-weight: normal;">Oran Değişikliğini kabul ediyorum</label>            
        </li>
    </ul>
</div>

<div class="footer-block2"  style="padding: 10px 6px  0px  6px;">
  <form action="">
      <div id="couponx" class=" form-group ">
          <a class="btn btn-primary btn-lg btn-icon confirm_button btn_accept_coupon">KUPONU YATIR <i class="icon-arrow-right"></i></a>
      </div>
      <div id="xcoupon" class="hidden form-group" style="background-color:rgba(0, 0, 0, 0.3);padding: 14px 0px 14px 0px;">
        <li class="text-center bet-spinner" style="list-style-type:none;">
        <img alt="Loading..." src="/assets/theme15/images/betslip_spinner-2834210147edecfd3ca5cc74d2876e5b.gif">
        </li>
      </div>

  </form>
</div>

</div>






<?php } ?>
</div>


