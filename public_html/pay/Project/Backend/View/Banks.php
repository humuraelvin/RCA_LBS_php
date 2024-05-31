<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\Banks;

  /**
  * METHODS
  */
  $edit   = $app->edit();
  $single = $app->single();

  /**
  * CRUD
  */
  $identity = $single->identity;
  $app->create();
  $app->update($identity);
  $app->delete($identity);
  $app->deleteSelected($identity);

  /**
  * PAGENATION
  */
  $total = $app->total();
  $fetch = $app->fetch();


  /**
  * OTHER
  */
  $DBGetCount = new Helper\Database\DBGetCount;
  $DBGetID    = new Helper\Database\DBGetID;
  $translate  = new Helper\DashboardTranslate;
  $photos     = new Helper\DashboardFile;
  $pageHeader = new Helper\DashboardPageHeader;
  $dropzone   = false;

?>

<section class="page--header">
  <?php echo $pageHeader->get($DBGetID->config("brandName"), $single->slug, $single->name);?>
</section>

<section class="main--content">

  <?php if(PSLUG2=='add') { ?>

    <div class="panel">
      <div class="records--body">
        <!-- Title -->
        <div class="title">
          <h6 class="h6">Yenİ Banka Hesabı Ekle</h6>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Hesap Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Ödeme Yöntemi Seç:</label>
                <div class="col-md-9">
                  <select class="select2" name="bankID" data-placeholder="Seç" style="width:100%;">
                    <option></option>
                    <?php
                      $query = Library\Database::fetch("SELECT * FROM sta_system_payment_methods ORDER BY method_name ASC");
                      foreach ($query as $row) {
                        echo '<option  value="'.$row->id.'">'.__($row->method_name).'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Banka Seç:</label>
                <div class="col-md-9">
                  <select class="select2" name="bank_name" data-placeholder="Seç" style="width:100%;">
                    <option value="" selected="" disabled="">Banka seçiniz</option>
                    <option value="YAPI KREDİ">YAPI KREDİ</option>
                    <option value="ENPARA">ENPARA</option>
                    <option value="İŞ BANK">İŞ BANK</option>
                    <option value="FİBA BANK">FİBA BANK</option>
                    <option value="GARANTİ">GARANTİ</option>
                    <option value="AKBANK">AKBANK</option>
                    <option value="ZİRAAT BANKASI">ZİRAAT BANKASI</option>
                    <option value="TEB">TEB</option>
                    <option value="QNB FİNANS">QNB FİNANS</option>
                    <option value="KUVEYTTÜRK">KUVEYTTÜRK</option>
                    <option value="İNG">İNG</option>
                    <option value="DENİZ BANK">DENİZ BANK</option>
                    <option value="VAKIF BANK">VAKIF BANK</option>
                    <option value="HALKBANK">HALKBANK</option>
                    <option value="DENİZ BANK">DENİZ BANK</option>
                    <option value="TÜRKİYE FİNANS">TÜRKİYE FİNANS</option>
                    <option value="ODEOBANK">ODEOBANK</option>
                    <option value="ALBARAKA">ALBARAKA</option>
                    <option value="ŞEKERBANK">ŞEKERBANK</option>
                    <option value="AKTİF BANK">AKTİF BANK</option>

                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Hesap Sahibi:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="accountName" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">IBAN:</label>
                <div class="col-md-9">
                  <input id="form3" type="text" name="iban" class="form-control" required>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-9 offset-md-3">
                  <input name="add" type="submit" value="Ekle" class="btn btn-rounded btn-success">
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Tab Content -->
      </div>

    </div>

  <?php } else if(PSLUG2=='edit') { ?>

    <div class="panel">
      <div class="records--body">
        <!-- Title -->
        <div class="title">
          <h6 class="h6">Düzenle</h6>
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug;?>" class="btn btn-rounded btn-info"><i class="fas fa-chevron-left"></i> GERİ DÖN</a>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Hesap Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Ödeme Yöntemi Seç:</label>
                <div class="col-md-9">
                  <select class="select2" name="bankID" data-placeholder="Seç" style="width:100%;">
                    <option></option>
                    <?php
                      $query = Library\Database::fetch("SELECT * FROM sta_system_payment_methods ORDER BY method_name ASC");
                      foreach ($query as $row) {
                        echo '<option '.($row->id==$edit->bankID ? "selected" : NULL).'  value="'.$row->id.'">'.__($row->method_name).'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Banka Seç:</label>
                <div class="col-md-9">
                  <select class="select2" name="bank_name" data-placeholder="Seç" style="width:100%;">
                    <option value="" selected="" disabled="">Banka seçiniz</option>
                    <option <?=$edit->bank_name=='YAPI KREDİ' ? 'selected' : null ;?> value="YAPI KREDİ">YAPI KREDİ</option>
                    <option <?=$edit->bank_name=='ENPARA' ? 'selected' : null ;?> value="ENPARA">ENPARA</option>
                    <option <?=$edit->bank_name=='İŞ BANK' ? 'selected' : null ;?> value="İŞ BANK">İŞ BANK</option>
                    <option <?=$edit->bank_name=='FİBA BANK' ? 'selected' : null ;?> value="FİBA BANK">FİBA BANK</option>
                    <option <?=$edit->bank_name=='GARANTİ' ? 'selected' : null ;?> value="GARANTİ">GARANTİ</option>
                    <option <?=$edit->bank_name=='AKBANK' ? 'selected' : null ;?> value="AKBANK">AKBANK</option>
                    <option <?=$edit->bank_name=='ZİRAAT BANKASI' ? 'selected' : null ;?> value="ZİRAAT BANKASI">ZİRAAT BANKASI</option>
                    <option <?=$edit->bank_name=='TEB' ? 'selected' : null ;?> value="TEB">TEB</option>
                    <option <?=$edit->bank_name=='QNB FİNANS' ? 'selected' : null ;?> value="QNB FİNANS">QNB FİNANS</option>
                    <option <?=$edit->bank_name=='KUVEYTTÜRK' ? 'selected' : null ;?> value="KUVEYTTÜRK">KUVEYTTÜRK</option>
                    <option <?=$edit->bank_name=='İNG' ? 'selected' : null ;?> value="İNG">İNG</option>
                    <option <?=$edit->bank_name=='DENİZ BANK' ? 'selected' : null ;?> value="DENİZ BANK">DENİZ BANK</option>
                    <option <?=$edit->bank_name=='VAKIF BANK' ? 'selected' : null ;?> value="VAKIF BANK">VAKIF BANK</option>
                    <option <?=$edit->bank_name=='HALKBANK' ? 'selected' : null ;?> value="HALKBANK">HALKBANK</option>
                    <option <?=$edit->bank_name=='DENİZ BANK' ? 'selected' : null ;?> value="DENİZ BANK">DENİZ BANK</option>
                    <option <?=$edit->bank_name=='TÜRKİYE FİNANS' ? 'selected' : null ;?> value="TÜRKİYE FİNANS">TÜRKİYE FİNANS</option>
                    <option <?=$edit->bank_name=='ODEOBANK' ? 'selected' : null ;?>value="ODEOBANK">ODEOBANK</option>
                    <option <?=$edit->bank_name=='ALBARAKA' ? 'selected' : null ;?> value="ALBARAKA">ALBARAKA</option>
                    <option <?=$edit->bank_name=='ŞEKERBANK' ? 'selected' : null ;?> value="ŞEKERBANK">ŞEKERBANK</option>
                    <option <?=$edit->bank_name=='AKTİF BANK' ? 'selected' : null ;?> value="AKTİF BANK">AKTİF BANK</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Hesap Sahibi:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="accountName" class="form-control" value="<?php echo $edit->accountName;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">IBAN/ HESAP NUMARASI:</label>
                <div class="col-md-9">
                  <input id="form3" type="text" name="iban" class="form-control" value="<?php echo $edit->iban;?>" required>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-9 offset-md-3">
                  <input name="edit" type="submit" value="Düzenle" class="btn btn-rounded btn-success">
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Tab Content -->
      </div>

    </div>

  <?php } else { ?>

    <div class="panel">
      <div class="records--header">
        <div class="title">
          <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
          <p>Toplam <strong><?php echo $total;?></strong> banka hesabı bulundu.</p>
        </div>
        <div class="actions">
          <form action="" class="search flex-wrap flex-md-nowrap">
            <input type="text" name="query" class="form-control" placeholder="Ara..." required>
            <button type="submit" class="btn btn-rounded"><i class="fa fa-search"></i></button>
            <?php if($_GET["query"]) {?>
              <button onclick="location.href='<?php echo PATH_DASHBOARD.'/'.$single->slug;?>';" class="btn btn-rounded btn-danger ml-2" data-toggle="tooltip" data-placement="bottom" title="Aramayı Sıfırla">
                <i class="fa fa-times"></i>
              </button>
            <?php } ?>
          </form>
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/add';?>" class="addProduct btn btn-lg btn-rounded btn-warning">Yeni Hesap Ekle</a>
        </div>
      </div>
    </div>

    <form action="" method="post">
      <!-- Select Area -->
      <div class="selectAllArea">
        <button type="button" class="checkall btn btn-outline-secondary btn-sm"><i class="fa fa-hand-pointer"></i> Hepsini Seç</button>
        <button type="submit" name="deleteAll" onclick="return confirm('Seçilenleri silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="SEÇİLENLERİ SİL"><i class="fa fa-trash"></i> Sil</button>
      </div>
      <!-- End Select Area -->
      <div class="panel">
        <!-- List Start -->
        <div class="records--list" data-title="">
          <table id="recordsListView">
            <thead>
              <tr>
                <th width="20" class="not-sortable" style="padding-right:0;">#</th>
                <th>BANKA ADI</th>
                <th class="not-sortable">HESAP SAHIBI</th>
                <th class="not-sortable">IBAN/HESAP NO</th>

                <th width="100" class="not-sortable">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($fetch as $row) { ?>
                <tr>
                  <td class="form-group" style="padding-right:0;">
                    <label class="form-check" style="top:-5px;">
                      <input type="checkbox" name="item[]" value="<?php echo $row->$identity;?>" class="checkhour form-check-input">
                      <span class="form-check-label" style="padding-left:0"></span>
                    </label>
                  </td>
                  <td><strong><?php echo $DBGetID->peymentMethod($row->bankID, 'method_name');?> <?= $row->bank_name ? '<small>('.$row->bank_name.')</small>' : null;?></strong></td>
                  <td><strong><?php echo $row->accountName;?></strong></td>
                  <td><strong><?php echo $row->iban;?></strong></td>
                  <td>
                    <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/edit?id='.$row->$identity;?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="DÜZENLE"><i class="fa fa-edit"></i></a>
                    <a onclick="return confirm('Silmek istediğinize emin misiniz ?');" href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/delete?id='.$row->$identity;?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="SİL"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- List End -->
      </div>
    </form>

  <?php } ?>

</section>
