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

        <div id="main-panel" class="row have-sidebar-left">

            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">



                {php} include "content/dark-theme/view/sidebar.php";{/php}



                <div class="nano-pane" style="display: none;">

                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>

                </div>

            </div>





            <div id="main-center" style="min-height: 500px">

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

                                    <h4>BANKA HAVALESİ İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapse3" style="height: 0px;">



                                    <div class="panel-footer for-validation">

                                        <div class="row">

                                          <!--  <div class="col-sm-6">

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

                                            </div> -->

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

                                    <h4>PAPARA İLE PARA YATIRMA (OTO)</h4>

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


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="paparaDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>

                                

                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsePAPARAIBAN" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/papara-iban.png" class="withdrawico" width="42px">

                                    <h4>PAPARA IBAN İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapsePAPARAIBAN" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="paparaibannamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="paparaibanmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="paparaIBANDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>

                                



                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseKART" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/creditcard.png" class="withdrawico" width="42px">

                                    <h4>KREDİ KARTI İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseKART" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="kartnamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="kartmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlikartDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>






                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseFAST" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/fast.png" class="withdrawico" width="42px">

                                    <h4>FAST İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseFAST" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="fastnamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="fastmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlifastDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>





                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseTOSLA" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/tosla.png" class="withdrawico" width="42px">

                                    <h4>TOSLA İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseTOSLA" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="toslanamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="toslamoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlitoslaDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>



                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseKRIPTO" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/hizlica-kripto.png" class="withdrawico" width="42px">

                                    <h4>KRİPTO İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseKRIPTO" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="kriptonamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="kriptomoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlikriptoDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>




                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseMEFETE" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/mefete.jpg" class="withdrawico" width="42px">

                                    <h4>MEFETE İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseMEFETE" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="mefetenamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="mefetemoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlimefeteDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>





                                <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsePAYCELL" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/paycell.png" class="withdrawico" width="42px">

                                    <h4>PAYCELL İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapsePAYCELL" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="paycellnamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="paycellmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlipaycellDeposit();" >											

                                            PARA YATIR										

                                            <i class="icon-arrow-right"></i>

											

                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div>


                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsepayfix" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/payfix.png" class="withdrawico">

                                    <h4>PAYFİX İLE PARA YATIRMA (OTO)</h4>

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

                                        <a a style="color:#1a2732;" href="#" target="_blank">PAYFİX İLE NASIL YATIRIM YAPARIM ?</a>


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlipayfixDeposit();">

                                            PARA YATIR

                                            <i class="icon-arrow-right"></i>


                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div> 

                                



                                
                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsecepbank" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/cb.png" class="withdrawico" width="42px">

                                    <h4>CEPBANK İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapsecepbank" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="cepbanknamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="cepbankmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">

                                        <a a style="color:#1a2732;" href="#" target="_blank">CEPBANK İLE NASIL YATIRIM YAPARIM ?</a>


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlicepbankDeposit();">

                                            PARA YATIR

                                            <i class="icon-arrow-right"></i>


                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div> 


                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseKASSA" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/kassa.png" class="withdrawico" width="42px">

                                    <h4>KASSA İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseKASSA" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="kassanamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="kassamoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">

                                        <a a style="color:#1a2732;" href="#" target="_blank">KASSA İLE NASIL YATIRIM YAPARIM ?</a>


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlikassaDeposit();">

                                            PARA YATIR

                                            <i class="icon-arrow-right"></i>


                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div> 




                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsecmt" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/cmtc.png" class="withdrawico">

                                    <h4>CMT CÜZDAN İLE PARA YATIRMA (OTO)</h4>

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


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlicmtDeposit();">

                                            PARA YATIR

                                            <i class="icon-arrow-right"></i>

										
                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div> 



                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapsepeple" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/peple.jpg" class="withdrawico">

                                    <h4>PEPLE İLE PARA YATIRMA (OTO)</h4>

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


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlipepleDeposit();">

                                            PARA YATIR

                                            <i class="icon-arrow-right"></i>

										
                                        </button>

                                        <div class="clearfix"></div>

                                    </div>

                                </div> 





						
                                 <div class="panel-heading show collapsed" data-toggle="collapse" data-parent="#acc-accordion" href="#collapseNAYS" aria-expanded="false" style="text-align: left;">

                                    <img src="/images/footer_partners/payment/nays.svg" class="withdrawico" width="42px">

                                    <h4>NAYS İLE PARA YATIRMA (OTO)</h4>

                                    <i class="pull-right icon-arrow-down"></i>

                                </div>

                                <div class="panel-collapse collapse" id="collapseNAYS" style="height: 0px;">

                                    <div class="panel-footer for-validation">

                                        <div class="row">



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label">

                                                        İsim Soyisim

                                                        <small></small>

                                                    </label>

                                                    <input class="form-control" id="naysnamesurname" value="{$bilgi["name"]}" type="text" readonly="">

                                                </div>

                                            </div>



                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="control-label" for="amount">Tutar</label>

                                                    <div class="input-group">

                                                        <input class="form-control" id="naysmoney" data-validation="acg" type="text" onkeypress="numberControl(event)">

                                                        <span class="input-group-addon">TL</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="panel-footer">


                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="hizlinaysDeposit();">

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



            <div class="main-overlay"></div>

        </div>

    </div>



</section>

{php} include "content/dark-theme/view/dark_footer.php";{/php}