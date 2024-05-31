<div class="left-container nano-content account-left-bar" tabindex="0" style="right: -17px;background: #dfebf9;">
    <ul class="list-unstyled sport-menu event-menu acc-menu no-padding">
        <li><a style="text-align:center;"><?php echo $bilgi['name'] ?></a></li></ul>
    <ul class="list-unstyled sport-menu event-menu acc-menu no-padding">
        <li class="active"><a href="/myaccount" style="text-align:left;"><i class="icon-policy"></i>Hesabım</a></li>
        <li><a href="/myaccount/coupons" style="text-align:left;"><i class="icon-betslip"></i>Bahis Geçmişi</a></li>
        <li><a href="/myaccount/transactions" style="text-align:left;"><i class="icon-dolar2"></i>Hesap Hareketleri</a></li>
        <li><a href="/myaccount/transfer" style="text-align:left;"><i class="icon-transactions"></i>Transfer</a></li>
        <li><a href="/myaccount/deposit" style="text-align:left;"><i class="icon-wallet"></i>Para Yatır</a></li>
        <li><a href="/myaccount/withdraw" style="text-align:left;"><i class="icon-money-bag"></i>Para Çek</a></li>
        <?php if ( $bilgi['affiliate'] == 1 ) { ?>
        <li><a href="/myaccount/affiliate" style="text-align:left;"><i class="icon-head"></i>Affiliate</a></li>
        <?php } ?>
    </ul>
</div>