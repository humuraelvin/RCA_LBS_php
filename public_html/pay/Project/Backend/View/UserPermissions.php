<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\userPermissions;

  /**
  * METHODS
  */
  $edit = $app->edit();
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
          <h6 class="h6">Yenİ Yetki Ekle</h6>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Yetki Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form0" class="label-text col-md-3 col-form-label">Yetki Adı:</label>
                <div class="col-md-9">
                  <input id="form0" type="text" name="name[]" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Hangi Bölümleri Görebilir?:</label>
                <div class="col-md-9">
                  <?php
                    $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? ORDER BY ord ASC", array(0));
                    foreach ($query as $row) {
                      echo '
                      <label class="form-check">
                          <input type="checkbox" name="cats[]" value="'.$row->id.'" class="form-check-input">
                          <span class="form-check-label"><strong>'.__($row->name).'</strong></span>
                      </label>
                      ';
                        $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? ORDER BY ord ASC", array($row->id));
                        foreach ($query as $row) {
                          echo '
                          <label class="form-check">
                              <input type="checkbox" name="cats[]" value="'.$row->id.'" class="form-check-input">
                              <span class="form-check-label"> - '.__($row->name).'</span>
                          </label>
                          ';
                        }
                    }
                  ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Ekle:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="cr" value="1" class="form-radio-input" checked>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="cr" value="0" class="form-radio-input">
                    <span class="form-radio-label">HAYIR</span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">Düzenle:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="u" value="1" class="form-radio-input" checked>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="u" value="0" class="form-radio-input">
                    <span class="form-radio-label">HAYIR</span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="form4" class="label-text col-md-3 col-form-label">Sil:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="d" value="1" class="form-radio-input" checked>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="d" value="0" class="form-radio-input">
                    <span class="form-radio-label">HAYIR</span>
                  </label>
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
            <a href="#tab01" data-toggle="tab" class="nav-link active">Yetki Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form0" class="label-text col-md-3 col-form-label">Yetki Adı:</label>
                <div class="col-md-9">
                  <input id="form0" type="text" name="name[]" class="form-control" value="<?php echo __($edit->name);?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Hangi Bölümleri Görebilir?:</label>
                <div class="col-md-9">
                  <?php
                    $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? ORDER BY ord ASC", array(0));
                    foreach ($query as $row) {
                      echo '
                      <label class="form-check">
                          <input type="checkbox" name="cats[]" value="'.$row->id.'" class="form-check-input" '.(strstr($edit->cats, '{'.$row->id.'}') ? 'checked' : NULL).'>
                          <span class="form-check-label"><strong>'.__($row->name).'</strong></span>
                      </label>
                      ';
                        $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? ORDER BY ord ASC", array($row->id));
                        foreach ($query as $row) {
                          echo '
                          <label class="form-check">
                              <input type="checkbox" name="cats[]" value="'.$row->id.'" class="form-check-input" '.(strstr($edit->cats, '{'.$row->id.'}') ? 'checked' : NULL).'>
                              <span class="form-check-label"> - '.__($row->name).'</span>
                          </label>
                          ';
                        }
                    }
                  ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Ekle:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="cr" value="1" class="form-radio-input" <?php if($edit->cr) {echo 'checked';}?>>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="cr" value="0" class="form-radio-input"  <?php if($edit->cr==0) {echo 'checked';}?>>
                    <span class="form-radio-label">HAYIR</span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">Düzenle:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="u" value="1" class="form-radio-input"  <?php if($edit->u) {echo 'checked';}?>>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="u" value="0" class="form-radio-input"  <?php if($edit->u==0) {echo 'checked';}?>>
                    <span class="form-radio-label">HAYIR</span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="form4" class="label-text col-md-3 col-form-label">Sil:</label>
                <div class="col-md-9 form-inline">
                  <label class="form-radio mr-3">
                    <input type="radio" name="d" value="1" class="form-radio-input"  <?php if($edit->d) {echo 'checked';}?>>
                    <span class="form-radio-label">EVET</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="d" value="0" class="form-radio-input"  <?php if($edit->d==0) {echo 'checked';}?>>
                    <span class="form-radio-label">HAYIR</span>
                  </label>
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

    <div class="alert alert-primary mb-3" role="alert">
      <strong>Yeni Panel Kullanıcısı</strong> eklemek ya da <strong>Panel Kullanıcılarını</strong> düzenlemek için
      <a href="<?php echo PATH_DASHBOARD.'/dashboardUsers';?>"><strong>buraya</strong></a> tıklayın.
    </div>

    <div class="panel">
      <div class="records--header">
        <div class="title">
          <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
          <p>Toplam <strong><?php echo $total;?></strong> yetki tipi bulundu.</p>
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
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/add';?>" class="addProduct btn btn-lg btn-rounded btn-warning">Yeni Yetki Ekle</a>
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
                <th class="not-sortable">İZİN ADI</th>
                <th width="100" class="not-sortable">İŞLEMLER</th>
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
                    <strong><?php echo __($row->name);?></strong>
                  </td>
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
