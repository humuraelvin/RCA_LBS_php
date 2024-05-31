{php} include "content/dark-theme/view/dark_header.php";{/php}

{literal}
    <script>
        function noControl(e) {
            olay = document.all ? window.event : e;
            tus = document.all ? olay.keyCode : olay.which;
            if(tus<48||tus>57) {
                if(document.all) { olay.returnValue = false; } else { olay.preventDefault(); }
            }
        }
        $(document).ready(function() {
                $('#iban').mask('SS00 0000 0000 0000 0000 0000 00', {
                    placeholder: '____ ____ ____ ____ ____ __'
                });
        });
    </script>
{/literal}

<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button> <a class="page-title"><i class="icon-money-bag"></i>PARA ÇEK</a> </div>
<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left" >
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">

                {php} include "content/dark-theme/view/sidebar.php";{/php}

                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                </div>
            </div>
			
            <div id="main-center" style="min-height: 500px;">
                <div class="center-container">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h3>Para Çekme</h3>							
						</div>
                        <div class="panel-group panel-collapse" id="acc-accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse2" aria-expanded="false"> <img hegiht="32px" width="32px" src="/images/footer_partners/payment/papara.png" class="withdrawico" >
                                    <h4>PAPARA ile Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse2" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Papara No <small></small> </label>
                                                    <input class="form-control" type="text"  name="paparacardno" id="paparacardno"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantity" id="quantity" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">PAPARA İLE ÇEKİM NASIL YAPILIR?</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnPaparaWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse6" aria-expanded="false"> <img hegiht="32px" width="32px" src="/images/footer_partners/payment/Bitcoin.svg.png" class="withdrawico" >
                                    <h4>BİTCOİN İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse6" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> BTC-BSC Adresiniz <small></small> </label>
                                                    <input class="form-control" type="text"  name="btcno" id="btcno"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitybtc" id="quantitybtc" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">BEP20(BSC) Ağından Cüzdan Adresinizi Giriniz.</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnbtcWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse7" aria-expanded="false"> <img hegiht="32px" width="32px" src="/images/footer_partners/payment/tether-usdt-logo.png" class="withdrawico" >
                                    <h4>TETHER İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse7" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> USDT/TRC20 Adresiniz <small></small> </label>
                                                    <input class="form-control" type="text"  name="tetherno" id="tetherno"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitytether" id="quantitytether" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">TRC20 Ağından USDT Adresinizi Giriniz.</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fntetherWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
								
								<div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse8" aria-expanded="false"> <img hegiht="32px" width="32px" src="/images/footer_partners/payment/havale2.png" class="withdrawico" >
                                    <h4>HAVALE İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse8" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">IBAN Numaranız <small></small> </label>
                                                    <input class="form-control" type="text"  name="havaleno" id="havaleno"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantityhavale" id="quantityhavale" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">BANKA HAVALESİ İLE ÇEKİM NASIL YAPILIR?</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnhavaleWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
								
								<div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse9" aria-expanded="false"> <img hegiht="32px" width="32px" src="https://play-lh.googleusercontent.com/s-ZeUzIkPzQqgb8ylvheWKtRvyOSvFs4DRzS-jTStCgL4l5uQjvmI2vQBXW2MT9RtapT" class="withdrawico" >
                                    <h4>MEFETE İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse9" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> MEFETE Numaranız <small></small> </label>
                                                    <input class="form-control" type="text"  name="mefeteno" id="mefeteno"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitymefete" id="quantitymefete" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnmefeteWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
								
								<div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse10" aria-expanded="false"> <img hegiht="32px" width="32px" src="https://play-lh.googleusercontent.com/TMjps5wMyQcsGhZvqw3dq4yFBQCpwL-EHeRq6BU7NFG2FoF3M7zLK20TOLbj9jn4xzw" class="withdrawico">
                                    <h4>PAYFİX İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse10" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Payfix Numaranız <small></small> </label>
                                                    <input class="form-control" type="text"  name="cardnopayfix" id="cardnopayfix"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitypayfix" id="quantitypayfix" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">PAYFİX İLE ÇEKİM NASIL YAPILIR?</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnpayfixWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
								
								<div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse11" aria-expanded="false"> <img hegiht="32px" width="32px" src="https://www.parazula.com/images/logo.png" class="withdrawico">
                                    <h4>PARAZULA İle Para Çekme</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse11" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Parazula Numaranız <small></small> </label>
                                                    <input class="form-control" type="text"  name="parazulano" id="parazulano"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantityparazula" id="quantityparazula" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#646d75;" href="#" target="_blank">PARAZULA İLE ÇEKİM NASIL YAPILIR?</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnpayfixWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}