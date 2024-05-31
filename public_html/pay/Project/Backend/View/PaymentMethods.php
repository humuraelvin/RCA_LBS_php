<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\PaymentMethods;

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
  $dropzone   = true;

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
          <h6 class="h6">Yeni Yöntem Ekle</h6>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Yöntem Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Ödeme Yöntemi Adı:</label>
                <div class="col-md-9">
                  <input id="form1" type="text" name="method_name" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form12" class="label-text col-md-3 col-form-label">İşlem Ücreti & Zamanı:</label>
                <div class="col-md-9">
                  <input id="form12" type="text" name="method_price" class="form-control"  required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form11" class="label-text col-md-3 col-form-label">İşlem Limiti:</label>
                <div class="col-md-9">
                  <input id="form11" type="text" name="method_limit" class="form-control"  required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
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
            <a href="#tab01" data-toggle="tab" class="nav-link active">Yöntem Bilgileri</a>
          </li>
          <li class="nav-item">
            <a href="#tab02" data-toggle="tab" class="nav-link">Logo</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Ödeme Yöntemi Adı:</label>
                <div class="col-md-9">
                  <input id="form1" type="text" name="method_name" class="form-control" value="<?php echo $edit->method_name;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form12" class="label-text col-md-3 col-form-label">İşlem Ücreti & Zamanı:</label>
                <div class="col-md-9">
                  <input id="form12" type="text" name="method_price" class="form-control" value="<?php echo $edit->method_price;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form11" class="label-text col-md-3 col-form-label">İşlem Limiti:</label>
                <div class="col-md-9">
                  <input id="form11" type="text" name="method_limit" class="form-control" value="<?php echo $edit->method_limit;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-9 offset-md-3">
                  <input name="edit" type="submit" value="Düzenle" class="btn btn-rounded btn-success">
                </div>
              </div>
            </form>
          </div>

          <!-- Tab Pane Start -->
          <div class="tab-pane fade" id="tab02">
            <div class="form-group row">
              <div class="col-md-3">
                <img src="<?=PATH_UPLOAD;?>/PaymentMethods/<?=$edit->logo ? $edit->logo : "no-image.jpg";?>" alt="">
              </div>
              <div class="col-md-9">
                <form action="<?php echo PATH_MODULE.'/DashboardDropzone.php?section=payment-logo&id='.$edit->id;?>" id="dropzone01" class="dropzone" method="post" enctype="multipart/form-data">
                  <div class="dz-message" data-dz-message>Drop files here to upload</div>
                </form>
              </div>
            </div>
          </div>
          <!-- Tab Pane End -->
        </div>
        <!-- End Tab Content -->
      </div>

    </div>

  <?php } else { ?>

    <div class="panel">
      <div class="records--header">
        <div class="title">
          <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
          <p>Toplam <strong><?php echo $total;?></strong> ödeme yöntemi bulundu.</p>
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
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/add';?>" class="addProduct btn btn-lg btn-rounded btn-warning">Yeni Yöntem Ekle</a>
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
                <th width="100">LOGO</th>
                <th class="not-sortable">ÖDEME YÖNTEMLERİ</th>
                <th class="not-sortable">İŞLEM LİMİTİ</th>
                <th class="not-sortable">İŞLEM ÜCRETİ</th>
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
                  <td>
                    <img class="w-100" src="<?=PATH_UPLOAD;?>/PaymentMethods/<?=$row->logo ? $row->logo : "no-image.jpg";?>" alt="">
                  </td>
                  <td><strong><?php echo $row->method_name;?></strong></td>
                  <td><strong><?php echo $row->method_limit;?></strong></td>
                  <td><strong><?php echo $row->method_price;?></strong></td>
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
