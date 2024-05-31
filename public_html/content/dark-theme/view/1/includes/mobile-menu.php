<div id="mobile-wrapper-left" role="tablist" aria-multiselectable="true" class="slideout-menu-left">

	<div class="mobile-button" role="tab">
		<a class="collapsed" role="button" data-toggle="collapse" data-parent="#mobile-wrapper" href="#menu-sports" aria-expanded="false" aria-controls="mobile-sports"><i class="fa fa-futbol-o" aria-hidden="true"></i>SPOR BAHİSLERİ</a>
		<div id="menu-sports" class="collapse<?php if($module=='sports') { ?> in<?php } ?>" role="tabpanel">
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-futbol" aria-hidden="true"></i>FUTBOL</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-basketbol" aria-hidden="true"></i>BASKETBOL</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-tenis" aria-hidden="true"></i>TENİS</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-voleybol" aria-hidden="true"></i>VOLEYBOL</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-hentbol" aria-hidden="true"></i>HENTBOL</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-beyzbol" aria-hidden="true"></i>BEYZBOL</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-ragbi" aria-hidden="true"></i>RAGBİ</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-badminton" aria-hidden="true"></i>BADMİNTON</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-pesapallo" aria-hidden="true"></i>PESAPALLO</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-kriket" aria-hidden="true"></i>KRIKET</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-boks" aria-hidden="true"></i>BOKS</a></div>
			<div class="mobile-button"><a href="/index.php?module=sports"><i class="sicon-dart" aria-hidden="true"></i>DART</a></div>
		</div>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=live"><i class="menu-icon-live animated infinite flash" aria-hidden="true"></i>CANLI</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=virtualGames"><i class="menu-icon-sanal" aria-hidden="true"></i>SANAL</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=poker"><i class="menu-icon-poker" aria-hidden="true"></i>POKER</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=vivoSlots"><i class="menu-icon-casino" aria-hidden="true"></i>CASINO</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=LiveCasinoGames"><i class="menu-icon-canli-casino" aria-hidden="true"></i>CANLI CASINO</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=egamingBetOn"><i class="menu-icon-betongames" aria-hidden="true"></i>BETON GAMES</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=liveTombala"><i class="menu-icon-tombala" aria-hidden="true"></i>CANLI TOMBALA</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=promotions"><i class="menu-icon-promosyon" aria-hidden="true"></i><span class="visible-dropdown">PROMOSYONLAR</span></a>
	</div>
</div>
<div id="mobile-wrapper-right" role="tablist" aria-multiselectable="true" class="slideout-menu-right">
	<?php if($getUser=='logged'): ?>
	<div class="mobile-button">
		<a href="/index.php?module=login"><i class="fa fa-unlock-alt" aria-hidden="true"></i>GİRİŞ YAP</a>
	</div>
	<?php else: ?>
	<div class="mobile-user">
		<img class="img-circle" src="img/albert.jpg"> Albert
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=myaccount"><i class="fa fa-user-o" aria-hidden="true"></i>Hesabım</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=deposit"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Para Yatır</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=mycoupons"><i class="fa fa-history" aria-hidden="true"></i>Bahislerim</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=mytransfer"><i class="fa fa-exchange" aria-hidden="true"></i>Transfer</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=mytransactions"><i class="fa fa-try" aria-hidden="true"></i>Hesap Hareketleri</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=withdraw"><i class="fa fa-money" aria-hidden="true"></i>Para Çek</a>
	</div>
	<div class="mobile-button">
		<a href="/index.php?module=affiliate"><i class="fa fa-handshake-o" aria-hidden="true"></i>Affiliate</a>
	</div>
	<?php endif; ?>

</div>