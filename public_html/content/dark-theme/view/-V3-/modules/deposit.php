<div class="container">
  <div class="row">
    <?php include "includes/sidebar-account.php"; ?>
    <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
      <div class="panel panel-default border-radius">
        <div class="panel-heading border-bottom"> PARA YATIR </div>
        <div class="panel-body panel-bg clear-padding">
          <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified nav-deposit-withdraw" role="tablist">
              <li role="presentation" class="active">
                <a href="#bank" aria-controls="bank" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/bank.png" alt="BANKA HAVALESİ" /> </div> HAVALE</a>
              </li>
              <li role="presentation">
                <a href="#cepbank" aria-controls="cepbank" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/cepbank.png" alt="CEPBANK" /> </div> CEPBANK</a>
              </li>
              <li role="presentation">
                <a href="#tlnakit" aria-controls="tlnakit" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/tlnakit.png" alt="TLNAKİT" /> </div> TLNAKİT</a>
              </li>
              <li role="presentation">
                <a href="#payzwin" aria-controls="payzwin" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/payzwin.jpg" alt="PAYZWIN" /> </div> PAYZWIN</a>
              </li>
              <li role="presentation">
                <a href="#ecopayz" aria-controls="ecopayz" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/ecopayz.png" alt="ECOPAYZ" /> </div> ECOPAYZ</a>
              </li>
              <li role="presentation">
                <a href="#neteller" aria-controls="neteller" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/neteller.png" alt="NETELLER" /> </div> NETELLER</a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="bank">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" id="money" data-validation="acg" type="text" onkeypress="numberControl(event)"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> AD SOYAD </label>
                    <input class="form-control" id="namesurname" value="Albert Einstein" type="text" disabled> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> BANKA ADI </label>
                    <select class="form-control" id="bank">
                      <option value="5">AKBANK</option>
                      <option value="6">DENIZBANK</option>
                      <option value="19">FİNANSBANK</option>
                      <option value="8">GARANTI BANKASI</option>
                      <option value="230">HALKBANK</option>
                      <option value="10">ING BANK</option>
                      <option value="231">KUVEYT TÜRK</option>
                      <option value="17">PTT</option>
                      <option value="232">TEB</option>
                      <option value="12">TURKIYE IS BANKASI</option>
                      <option value="13">VAKIFLAR BANKASI</option>
                      <option value="14">YAPI KREDİ</option>
                      <option value="20">ZİRAAT BANKASI</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> İŞLEM SAATİ </label>
                    <div class='input-group date' id='dtp_time'>
                      <input type='text' class="form-control" id="time" placeholder="12:30" /> <span class="input-group-addon">
                                  <i class="fa fa-clock-o" aria-hidden="true"></i>
                              </span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="bankDeposit();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="cepbank">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> BANKA ADI </label>
                    <select class="form-control" id="bank2">
                      <option value="5">AKBANK</option>
                      <option value="6">DENIZBANK</option>
                      <option value="8">GARANTI BANKASI</option>
                      <option value="17">PTT</option>
                      <option value="232">TEB</option>
                      <option value="12">TURKIYE IS BANKASI</option>
                      <option value="14">YAPI KREDİ</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" type="text" id="money2" onkeypress="numberControl(event)"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> GÖNDEREN TELEFON </label>
                    <input class="form-control" type="text" id="gtel"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> ALICI TELEFON </label>
                    <input class="form-control" type="text" id="atel"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> ALICI KİMLİK NUMARASI </label>
                    <input class="form-control" type="text" id="atc"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> ŞİFRE VEYA REFERANS NOTU </label>
                    <input class="form-control" type="text" id="referans"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> MÜŞTERİ NOTU </label>
                    <input class="form-control" type="text" id="note"> </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnMobileBankOk();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="tlnakit">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> KART NO </label>
                    <input class="form-control" type="text" name="cardno" id="cardno"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" name="quantity" id="quantity" type="text" onkeypress="numberControl(event)"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnTlNakitOk();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="payzwin">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> KART NO </label>
                    <input class="form-control" type="text" name="payzno" id="payzno"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" name="payzmik" id="payzmik" type="text" onkeypress="numberControl(event)"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnPayzwinOk();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="ecopayz">
                <div style="margin:0;padding:0;display:inline">
                  <input name="utf8" type="hidden" value="✓">
                  <input name="authenticity_token" type="hidden" value="UNp9hWgM2RCDgWAbIHa/CAaU7f1dyXrCHjKryzZl95w="> </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> ECOPAYZ HESAP NO </label>
                    <input class="form-control" type="text"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" type="text"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnecoPayzOk();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="neteller">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> HESAP ID </label>
                    <input class="form-control" type="text"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> GİZLİ İD </label>
                    <input class="form-control" type="text"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> PARA BİRİMİ </label>
                    <select class="form-control">
                      <option value="1">USD</option>
                      <option value="2">EUR</option>
                      <option value="3">GBP</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" type="text"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnPayzwinOk();"> <i class="fa fa-check" aria-hidden="true"></i> PARA YATIR </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body panel-alert pt-20 text-center">
          <span class="alert-icon"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
          <p>PARA YATIRMA TALEBİNİZ İŞLEME ALINMIŞTIR.</p>
          <p>MÜŞTERİ TEMSİLCİNİZ EN KISA ZAMANDA SİZİNLE İLETİŞİME GEÇECEK.</p>
        </div>
      </div>
    </div>
  </div>
</div>