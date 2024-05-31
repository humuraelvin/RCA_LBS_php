<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\Payments;

  /**
  * METHODS
  */
  $edit   = $app->edit();
  $single = $app->single();

  /**
  * CRUD
  */
  $identity = $single->identity;
  $app->changeStatus();
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

<span class="payment-check-response"></span>
<span class="payment-delete-response"></span>

<section class="page--header">
  <?php echo $pageHeader->get($DBGetID->config("brandName"), $single->slug, $single->name);?>
</section>

<section class="main--content">

  <div class="panel mb-3">
    <div class="records--header">
      <div class="title">
        <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
        <p>Toplam <strong><?php echo $total;?></strong> işlem bulundu.</p>
      </div>
    </div>
  </div>

  <div class="btn-group d-block d-sm-flex mb-4">
    <?php foreach($app->fetchPaymentMethods() as $row) { ?>
    <button onclick="location.href='<?php echo PATH_DASHBOARD.'/'.$single->slug.'?payment_method='.$row->id;?>'" class="btn btn-rounded btn-<?=$row->btn;?> w-100 text-capitalize sac-steps buttonxyz"><?php echo $row->method_name;?> <strong>(<?php echo $app->totalPaymentMethod($row->id); ?>)</strong></button>
    <?php } ?>
  </div>

  <form action="" method="post">
    <div class="panel">
      <!-- List Start -->
      <div class="records--listtt" data-title="">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th width="40" class="not-sortable" style="padding-right:0;">#</th>
              <th class="not-sortable">KULLANICI ADI</th>
              <th class="not-sortable">TELEFON NUMARASI</th>
              <th class="not-sortable">ÖDEME YÖNTEMİ</th>
              <th class="not-sortable">TUTAR</th>
              <th class="not-sortable">İŞLEM TARİHİ</th>
              <th width="250" class="not-sortable">İŞLEMLER</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($fetch as $row) { ?>
            <tr style="background:#<?=$row->payment_status ? 'c8f5d2e0' : 'f5c9c9a3';?>">
              <td valign="top" class="form-group" style="padding-right:0;">
                #
              </td>
              <td>
                <h5 class="mb-0 d-inline">
                  <strong><?php echo $DBGetID->userId($row->user_id, 'username');?></strong></strong>
                </h5>
              </td>
              <td><?= $DBGetID->userId($row->user_id, 'phone') ? $DBGetID->userId($row->user_id, 'phone') : '-';?></td>
              <td>
                <?php echo $DBGetID->peymentMethod($row->payment_method, 'method_name');?>
                <?php if($row->payment_method==4):?>
                  <a href="javascript:;" data-toggle="modal" data-target="#exampleModal_<?php echo $row->id;?>">(Detay Gör)</a>
                <?php endif;?>
                <?php if($row->payment_method==5):?>
                  (<?php echo $row->payment_bank;?>)
                <?php endif;?>
              </td>
              <td><?php echo $row->payment_amount;?> TL</td>
              <td><?php echo $row->created_at;?></td>
              <td>
                <a href="javascript:;" id="<?php echo $row->id.'|'.$row->user_id.'|'.$row->payment_amount;?>" class="payment-check btn btn-info btn-sm mb-1"><i class="fa fa-check"></i> ÖDEMEYİ ONAYLA</a>
                <a href="javascript:;" id="<?php echo $row->id;?>" class="payment-delete btn btn-danger btn-sm"><i class="fa fa-trash"></i> SİL</a>
              </td>
            </tr>

            <?php if($row->payment_method==4):?>
              <div class="modal fade" id="exampleModal_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cepbank Ödemesi</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php $smsPay = explode('|', $row->payment_sms); ?>
                      <dl class="row">
                        <dt class="col-sm-5">Banka</dt>
                        <dd class="col-sm-7"><?=$smsPay[0];?></dd>
                        <dt class="col-sm-5">Gönderici Telefon No</dt>
                        <dd class="col-sm-7"><?=$smsPay[1];?></dd>
                        <dt class="col-sm-5">Alıcı Telefon No</dt>
                        <dd class="col-sm-7"><?=$smsPay[2];?></dd>
                        <dt class="col-sm-5">Alıcı TC Kimlik No</dt>
                        <dd class="col-sm-7"><?=$smsPay[3];?></dd>
                        <dt class="col-sm-5">Alıcı Doğum Tarihi</dt>
                        <dd class="col-sm-7"><?=$smsPay[4];?></dd>
                        <dt class="col-sm-5">Alıcı Kimlik V. Tarihi</dt>
                        <dd class="col-sm-7"><?=$smsPay[5];?></dd>
                        <dt class="col-sm-5">Referans Numarası</dt>
                        <dd class="col-sm-7"><?=$smsPay[6];?></dd>
                      </dl>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif;?>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- List End -->
    </div>
  </form>

</section>
