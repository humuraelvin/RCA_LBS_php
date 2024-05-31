<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\PanelSections;

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
          <h6 class="h6">Yenİ Bölüm Ekle</h6>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Bölüm Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-valxidation" novalidate>
              <div class="form-group row">
                <label class="label-text col-md-3 col-form-label">Kategori:</label>
                <div class="col-md-9">
                  <select name="parent" class="form-control">
                      <?php
                      $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=?", array(0));
                        echo '<option value="0">Seç</option>';
                        foreach ($query as $row) {
                          echo '<option value="'.$row->id.'">'.__($row->name).'</option>';
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Bölüm Adı:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="name[]" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">Slug:</label>
                <div class="col-md-9">
                  <input id="form3" type="text" name="slug" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form4" class="label-text col-md-3 col-form-label">Icon:</label>
                <div class="col-md-9">
                  <input id="form4" type="text" name="icon" class="form-control" >
                </div>
              </div>
              <div class="form-group row">
                <label for="form5" class="label-text col-md-3 col-form-label">Type:</label>
                <div class="col-md-9">
                  <input id="form5" type="text" name="type" class="form-control">
                  <span class="form-text text-muted">Section "class" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form66" class="label-text col-md-3 col-form-label">Table Name:</label>
                <div class="col-md-9">
                  <input id="form66" type="text" name="tablename" class="form-control">
                  <span class="form-text text-muted">Section "table" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form6" class="label-text col-md-3 col-form-label">Identity:</label>
                <div class="col-md-9">
                  <input id="form6" type="text" name="identity" class="form-control">
                  <span class="form-text text-muted">Table "id" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form7" class="label-text col-md-3 col-form-label">Sıra:</label>
                <div class="col-md-9">
                  <input id="form7" type="number" name="ord" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form8" class="label-text col-md-3 col-form-label">Section:</label>
                <div class="col-md-9">
                  <label class="form-radio">
                    <input type="radio" name="section" value="2" class="form-radio-input">
                    <span class="form-radio-label">GENEL KONTROL</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="section" value="3" class="form-radio-input">
                    <span class="form-radio-label">AYARLAR</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="section" value="4" class="form-radio-input">
                    <span class="form-radio-label">DİĞER</span>
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
            <a href="#tab01" data-toggle="tab" class="nav-link active">Bölüm Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-valxidation" novalidate>
              <div class="form-group row">
                <label class="label-text col-md-3 col-form-label">Kategori:</label>
                <div class="col-md-9">
                  <select name="parent" class="form-control">
                    <?php
                      $query = Library\Database::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=?", array(0));
                      echo '<option value="0">Seç</option>';
                      foreach ($query as $row) {
                        echo '<option '.($row->id==$edit->parent ? "selected" : NULL).' value="'.$row->id.'">'.__($row->name).'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">Bölüm Adı:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="name[]" class="form-control" value="<?php echo __($edit->name);?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">Slug:</label>
                <div class="col-md-9">
                  <input id="form3" type="text" name="slug" class="form-control" value="<?php echo $edit->slug;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form4" class="label-text col-md-3 col-form-label">Icon:</label>
                <div class="col-md-9">
                  <input id="form4" type="text" name="icon" class="form-control" value="<?php echo $edit->icon;?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="form5" class="label-text col-md-3 col-form-label">Type:</label>
                <div class="col-md-9">
                  <input id="form5" type="text" name="type" class="form-control" value="<?php echo $edit->type;?>">
                  <span class="form-text text-muted">Section "class" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form66" class="label-text col-md-3 col-form-label">Table Name:</label>
                <div class="col-md-9">
                  <input id="form66" type="text" name="tablename" class="form-control" value="<?php echo $edit->tablename;?>">
                  <span class="form-text text-muted">Section "table" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form6" class="label-text col-md-3 col-form-label">Identity:</label>
                <div class="col-md-9">
                  <input id="form6" type="text" name="identity" class="form-control" value="<?php echo $edit->identity;?>">
                  <span class="form-text text-muted">Table "id" name.</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="form7" class="label-text col-md-3 col-form-label">Sıra:</label>
                <div class="col-md-9">
                  <input id="form7" type="number" name="ord" class="form-control" value="<?php echo $edit->ord;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form8" class="label-text col-md-3 col-form-label">Section:</label>
                <div class="col-md-9">
                  <label class="form-radio">
                    <input type="radio" name="section" value="2" class="form-radio-input" <?php if($edit->section==2) {echo'checked';}?>>
                    <span class="form-radio-label">GENEL KONTROL</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="section" value="3" class="form-radio-input" <?php if($edit->section==3) {echo'checked';}?>>
                    <span class="form-radio-label">AYARLAR</span>
                  </label>
                  <label class="form-radio">
                    <input type="radio" name="section" value="4" class="form-radio-input" <?php if($edit->section==4) {echo'checked';}?>>
                    <span class="form-radio-label">DİĞER</span>
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

    <div class="panel">
      <div class="records--header">
        <div class="title">
          <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListFullView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
          <p>Toplam <strong><?php echo $total;?></strong> bölüm bulundu.</p>
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
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/add';?>" class="addProduct btn btn-lg btn-rounded btn-warning">Yeni Bölüm Ekle</a>
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
        <div class="records--list--full" data-title="">
          <table id="recordsListFullView">
            <thead>
              <tr>
                <th width="20" class="not-sortable" style="padding-right:0;">#</th>
                <th class="not-sortable">Başlık</th>
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
                    <strong><?php echo __($row->name);?></strong>
                    <?php if($row->section==2) { ?>
                      <span class="badge badge-pill badge-info">Genel Kontrol</span>
                    <?php } else if($row->section==3) { ?>
                      <span class="badge badge-pill badge-warning">Ayarlar</span>
                    <?php } else if($row->section==4) { ?>
                      <span class="badge badge-pill badge-danger">Diğer</span>
                    <?php } ?>
                  </td>
                  <td>
                    <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/edit?id='.$row->$identity;?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="DÜZENLE"><i class="fa fa-edit"></i></a>
                    <a onclick="return confirm('Silmek istediğinize emin misiniz ?');" href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/delete?id='.$row->$identity;?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="SİL"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php foreach($app->fetchSubCategories($row->id) as $row) { ?>
                  <tr>
                    <td class="form-group" style="padding-right:0;">
                      <label class="form-check" style="top:-5px;">
                        <input type="checkbox" name="item[]" value="<?php echo $row->$identity;?>" class="checkhour form-check-input">
                        <span class="form-check-label" style="padding-left:0"></span>
                      </label>
                    </td>
                    <td>
                      - <?php echo __($row->name);?>
                    </td>
                    <td>
                      <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/edit?id='.$row->$identity;?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="DÜZENLE"><i class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Silmek istediğinize emin misiniz ?');" href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/delete?id='.$row->$identity;?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="SİL"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- List End -->
      </div>
    </form>

  <?php } ?>

</section>
