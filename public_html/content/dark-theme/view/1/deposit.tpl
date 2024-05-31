{php} include "content/dark-theme/view/dark_header.php";{/php}
{literal}
    <script>
        function numberControl(e) {
            olay = document.all ? window.event : e;
            tus = document.all ? olay.keyCode : olay.which;
            if(tus<48||tus>57) {
                if(document.all) { olay.returnValue = false; } else { olay.preventDefault(); }
            }
        }

        $(document).ready(function() {
            $('#time').mask('00:00', {
                placeholder: '__:__'
            });

        });
    </script>
{/literal}

<div class="remodal" data-remodal-id="bitcoin" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
    <div>
        <p id="modal1Desc">
            <span id="btciframe"></span>
        </p>
    </div><br>
    <button data-remodal-action="confirm" class="remodal-confirm">KAPAT</button>
</div>

<div class="remodal" data-remodal-id="qrcode" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
    <h2 id="modal1Title" style="font-size: 20px;">PARA YATIRMA TALEBİNİZ, İNCELENMEK ÜZERE KAYIT EDİLMİŞTİR.</h2>
    <div><span id="qrframe"></span></div>
</div>

<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
    <a class="page-title"><i class="icon-wallet"></i>PARA YATIR</a>
</div>


<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left" style="background: #dfebf9;">
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">

                {php} include "content/dark-theme/view/sidebar.php";{/php}

                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                </div>
            </div>


            <div id="main-center" style="min-height: 500px;background: #dfebf9;">
                <div class="center-container">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h2>
                                <i class="icon-wallet"></i> Para Yatır
                            </h2>
                        </div>

                        <div class="panel-group panel-collapse" id="acc-accordion">
                            <div class="panel panel-default">

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse3" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/1.png" class="withdrawico">
                                    <h4>BANKA HAVALESİ İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapse3" style="height: 0px;">

                                    <div class="panel-footer for-validation">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Banka Adı
                                                        <small></small>
                                                    </label>
                                                    <select class="form-control" id="bank" >
                                                        <option value="0">Banka Seçiniz</option>
                                                        {foreach from="$bankalar" item="det" key="a"}
                                                            <option value="{$det["id"]}">{$det["banka"]}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="money" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row bwt-details">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="namesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İşlem Saati
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="time" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="bankDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsePAPARA" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/paparalogo.jpg" class="withdrawico">
                                    <h4>PAPARA İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsePAPARA" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="paparanamesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="paparamoney" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="paparaDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsepayfix" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/payfix.png" class="withdrawico">
                                    <h4>PAYFİX İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsepayfix" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="payfixnamesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="payfixmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a <a style="color:#1a2732;" href="http://www.fixturka.com/?hash=4bcc07bed479ed21539f53e4d523d479" target="_blank">PAYFİX YATIRIM İÇİN LİNKE TIKLAYINIZ.</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="payfixDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsecmt" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/cmtc.png" class="withdrawico">
                                    <h4>CMT CÜZDAN İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsecmt" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="cmtnamesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="cmtmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="cmtDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsepeple" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/peple.jpg" class="withdrawico">
                                    <h4>PEPLE İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsepeple" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="peplenamesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="peplemoney" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="pepleDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                
                              <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseparaode" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/paraodelogo.png" class="withdrawico">
                                    <h4>PARAÖDE İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapseparaode" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        İsim Soyisim
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" id="paraodenamesurname" value="{$bilgi["name"]}" type="text" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="paraodemoney" data-validation="acg" type="text" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a href="http://www.payturka.co/?hash=545974db945fea2b187d36dfc34bc0ef">PARAÖDE YATIRIM İÇİN LİNKE TIKLAYINIZ</a>
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="paraodeDeposit();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsecepbank" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/4.png" class="withdrawico">
                                    <h4>CEPBANK İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsecepbank" method="post" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Banka Adı
                                                        <small></small>
                                                    </label>
                                                    <select class="form-control" id="bank2">
                                                        {foreach from="$cepbankalar" item="det" key="a"}
                                                            <option value="{$det["id"]}">{$det["banka"]}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" data-validation="acg" type="text" id="money2" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Gönderen Telefon
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="gtel">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Alıcı Telefon
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="atel">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Alıcı Kimlik Numarası
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="atc">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Şifre veya Referans Kodu
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="referans">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Müşteri Notu
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="note">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnMobileBankOk();">
                                            PARA YATIR
                                            <i class="icon-arrow-right"></i>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsebkm" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/7.jpg" class="withdrawico">
                                    <h4>BKM EXPRESS İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsebkm" method="post" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Banka Adı
                                                        <small></small>
                                                    </label>
                                                    <select class="form-control" id="bkmBank">
                                                        {foreach from="$bkmbankalar" item="det" key="a"}
                                                            <option value="{$det["id"]}">{$det["banka"]}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" data-validation="acg" type="text" id="bkmMoney" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Gönderen Telefon
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="bkmGtel">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Alıcı Telefon
                                                            <small></small>
                                                        </label>
                                                        <input class="form-control" type="text" id="bkmAtel">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Alıcı Kimlik Numarası
                                                            <small></small>
                                                        </label>
                                                        <input class="form-control" type="text" id="bkmAtc">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Şifre veya Referans Kodu
                                                            <small></small>
                                                        </label>
                                                        <input class="form-control" type="text" id="bkmRef">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Müşteri Notu
                                                            <small></small>
                                                        </label>
                                                        <input class="form-control" type="text" id="bkmNote">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-footer">
                                            <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnBkmExpress();">
                                                PARA YATIR
                                                <i class="icon-arrow-right"></i>
                                            </button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>



                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsecredit" aria-expanded="false" style="text-align: left;">
                                    <img src="/images/footer_partners/payment/crypto.jpg" class="withdrawico">
                                    <h4>KREDİ KARTI İLE PARA YATIRMA</h4>
                                    <i class="pull-right icon-arrow-down"></i>
                                </div>
                                <div class="panel-collapse collapse" id="collapsecredit" method="post" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Telefon Numarasi
                                                        <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" id="creditTel">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" data-validation="acg" type="text" id="creditMoney" onkeypress="numberControl(event)">
                                                        <span class="input-group-addon">TL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-footer">
                                            <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnCreditCard();">
                                                PARA YATIR
                                                <i class="icon-arrow-right"></i>
                                            </button>
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