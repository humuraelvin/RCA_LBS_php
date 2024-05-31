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
                            <h2><i class="icon-money-bag"></i> Para Çekme</h2> </div>
                        <div class="panel-group panel-collapse" id="acc-accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse1" aria-expanded="false"> <img src="/images/footer_partners/payment/1.png" class="withdrawico" >
                                    <h4>BANKA HAVALESİ İLE PARA ÇEKME</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse1" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-footer for-validation">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" data-validation="acg" type="text" id="money" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label"> Şube Kodu <small></small> </label>
                                                    <input class="form-control" type="text"  id="sube"> </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label"> Hesap Numarası <small></small> </label>
                                                    <input class="form-control" type="text" id="hesap"> </div>
                                            </div>
                                        </div>
                                        <div class="row bwt-details">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label"> IBAN <small></small> </label>
                                                    <input class="form-control" type="text" maxlength="26" id="iban" placeholder=""> </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label"> Banka Adı <small></small> </label>
                                                    <select id="bank" class="form-control">
                                                        {foreach from="$bankalar" item="det" key="a"}
                                                            <option value="{$det["id"]}">{$det["banka"]}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label"> Alıcı İsmi <small></small> </label>
                                                    <input class="form-control" type="text" placeholder="{$bilgi["name"]}" disabled=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnWithDrawOk();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse2" aria-expanded="false"> <img src="/images/footer_partners/payment/paparalogo.jpg" class="withdrawico" >
                                    <h4>PAPARA İLE PARA ÇEKME</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse2" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Papara No <small></small> </label>
                                                    <input class="form-control" type="text"  name="cardno" id="cardno"> </div>
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
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnPaparaWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                    
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse3" aria-expanded="false"> <img src="/images/footer_partners/payment/payfix.png" class="withdrawico" >
                                    <h4>PAYFİX İLE PARA ÇEKME</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse3" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Payfix ID <small></small> </label>
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
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnpayfixWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse4" aria-expanded="false"> <img src="/images/footer_partners/payment/cmtc.png" class="withdrawico" >
                                    <h4>CMT İLE PARA ÇEKME</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse4" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> CMT No <small></small> </label>
                                                    <input class="form-control" type="text"  name="cardnopeple" id="cardnocmt"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitycmt" id="quantitycmt" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fncmtWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="panel-heading show collapsed" style="text-align: left;" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse5" aria-expanded="false"> <img src="/images/footer_partners/payment/peple.jpg" class="withdrawico" >
                                    <h4>PEPLE İLE PARA ÇEKME</h4> <i class="pull-right icon-arrow-down"></i> </div>
                                <div class="panel-collapse collapse" id="collapse5" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Peple No <small></small> </label>
                                                    <input class="form-control" type="text"  name="cardnopeple" id="cardnopeple"> </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="amount">Tutar</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="quantitypeple" id="quantitypeple" onkeypress="noControl(event)"> <span class="input-group-addon">TL</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary btn-lg btn-sm-wide pull-right btn-icon submit-btn" onclick="fnPepleWithdraw();"> PARA ÇEK <i class="icon-arrow-right"></i> </button>
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