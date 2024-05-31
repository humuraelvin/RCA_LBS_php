<div class="container">
  <div class="row">
    <?php include "includes/sidebar-account.php"; ?>
    <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
      <div class="panel panel-default border-radius">
        <div class="panel-heading border-bottom"> PARA ÇEK </div>
        <div class="panel-body panel-bg clear-padding">
          <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified nav-deposit-withdraw" role="tablist">
              <li role="presentation" class="active">
                <a href="#bank" aria-controls="bank" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/bank.png" alt="BANKA HAVALESİ" /> </div> HAVALE</a>
              </li>
              <li role="presentation">
                <a href="#tlnakit" aria-controls="tlnakit" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/tlnakit.png" alt="TLNAKİT" /> </div> TLNAKİT</a>
              </li>
              <li role="presentation">
                <a href="#ecopayz" aria-controls="ecopayz" role="tab" data-toggle="tab">
                  <div class="img"><img src="/img/payment/ecopayz.png" alt="ECOPAYZ" /> </div> ECOPAYZ</a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="bank">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" data-validation="acg" type="text" id="money" onkeypress="noControl(event)"> <span class="input-group-addon"><i class="fa fa-try" aria-hidden="true"></i></span> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">ŞUBE KODU</label>
                    <input class="form-control" type="text" id="sube"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">HESAP NUMARASI</label>
                    <input class="form-control" type="text" id="hesap"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">IBAN</label>
                    <input class="form-control" type="text" value="TR" maxlength="32" id="iban" autocomplete="off"> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">BANKA ADI</label>
                    <select id="bank" class="form-control">
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">ALICI İSMİ</label>
                    <input class="form-control" type="text" placeholder="Albert Einstein" disabled>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnWithDrawOk();"> PARA ÇEK <i class="fa fa-arrow-right" aria-hidden="true"></i> </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="tlnakit">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Müşteri No</label>
                    <input class="form-control" type="text"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" type="text"> <span class="input-group-addon">TL</span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnNetellerOk();"><i class="fa fa-check" aria-hidden="true"></i> PARA ÇEK </button>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="ecopayz">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Hesap No</label>
                    <input class="form-control" type="text"> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="amount">TUTAR</label>
                    <div class="input-group">
                      <input class="form-control" type="text"> <span class="input-group-addon">TL</span> </div>
                  </div>
                </div>
                <div class="clearfix padding-20 text-center">
                  <button class="btn btn-success btn-bg submit-btn" onclick="fnNetellerOk();"><i class="fa fa-check" aria-hidden="true"></i> PARA ÇEK </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body panel-alert pt-20 text-center">
          <span class="alert-icon"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
          <p>PARA ÇEKME TALEBİNİZ İŞLEME ALINMIŞTIR.</p>
          <p>MÜŞTERİ TEMSİLCİNİZ EN KISA ZAMANDA SİZİNLE İLETİŞİME GEÇECEK.</p>
        </div>
      </div>
    </div>
  </div>
</div>