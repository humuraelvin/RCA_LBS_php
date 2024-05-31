<?php

  /**
  * START APPLICATIONS
  */
  $app = new Project\Controller\SiteSections;

  /**
  * METHODS
  */
  $single = $app->single();
  $meta   = $app->meta();
  $edit   = $app->edit();

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
  $file       = new Helper\DashboardFile;
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
      <div class="title">
        <h6 class="h6">Yeni Bölüm Ekle</h6>
        <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug;?>" class="btn btn-rounded btn-info"><i class="fas fa-chevron-left"></i> GERİ DÖN</a>
      </div>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="#tab01" data-toggle="tab" class="nav-link active">Bölüm Bilgileri</a>
        </li>
        <li class="nav-item">
          <a href="#tab02" data-toggle="tab" class="nav-link">SEO Meta</a>
        </li>
      </ul>
      <form action="" method="post" class="needs-validation" novalidate>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <div class="form-group row">
              <label for="form8" class="label-text col-md-3 col-form-label">Slug:</label>
              <div class="col-md-9">
                <input id="form8" type="text" name="slug" class="form-control" required>
                <div class="invalid-feedback">
                  Lütfen bu alanı boş bırakmayın.
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="form1" class="label-text col-md-3 col-form-label">Başlık:</label>
              <div class="col-md-9">
                <input id="form1" type="text" name="name[]" class="form-control" required>
                <div class="invalid-feedback">
                  Lütfen bu alanı boş bırakmayın.
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="form2" class="label-text col-md-3 col-form-label">İçerik:</label>
              <div class="col-md-9">
                <textarea name="content[]" class="form-control" data-trigger="summernote"></textarea>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab02">
            <div class="form-group row">
              <label for="form3" class="label-text col-md-3 col-form-label">Title:</label>
              <div class="col-md-9">
                <input id="form3" type="text" name="title[]" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label for="form4" class="label-text col-md-3 col-form-label">Description:</label>
              <div class="col-md-9">
                <textarea id="form4" name="description[]" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-9 offset-md-3">
              <input name="add" type="submit" value="Ekle" class="btn btn-rounded btn-success">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php } else if(PSLUG2=='edit') { ?>

  <div class="panel">
    <div class="records--body">
      <div class="title">
        <?php echo $translate->dropDown($single->slug);?>
        <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug;?>" class="btn btn-rounded btn-info"><i class="fas fa-chevron-left"></i> GERİ DÖN</a>
      </div>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="#tab01" data-toggle="tab" class="nav-link tab-link active">Bölüm Bilgileri</a>
        </li>
        <li class="nav-item">
          <a href="#tab02" data-toggle="tab" class="nav-link tab-link">SEO Meta</a>
        </li>
        <?php if($dropzone) { ?>
        <li class="nav-item">
          <a href="#tab03" data-toggle="tab" class="nav-link dropzone-link">Fotoğraflar <span style="padding:0 8px;" class="btn btn-info btn-sm"><?php echo $DBGetCount->photo($single->tablename,$edit->id);?></span></a>
        </li>
        <?php } ?>
      </ul>
      <form id="content-area" action="" method="post" class="needs-validation" novalidate>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <div class="form-group row">
              <label for="form1" class="label-text col-md-3 col-form-label">Slug:</label>
              <div class="col-md-9">
                <input id="form1" type="text" name="slug" value="<?php echo $edit->slug;?>" class="form-control" required>
                <div class="invalid-feedback">
                  Lütfen bu alanı boş bırakmayın.
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="form1" class="label-text col-md-3 col-form-label">Başlık:</label>
              <div class="col-md-9">
                <?php echo $translate->input("name", $edit->name, true, "form1");?>
                <div class="invalid-feedback">
                  Lütfen bu alanı boş bırakmayın.
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="form2" class="label-text col-md-3 col-form-label">İçerik:</label>
              <div class="col-md-9">
                <?php echo $translate->wysiwyg("content", $edit->content);?>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab02">
            <div class="form-group row">
              <label for="form3" class="label-text col-md-3 col-form-label">Title:</label>
              <div class="col-md-9">
                <?php echo $translate->input("title", $meta->title, false, "form3");?>
                <div class="invalid-feedback">
                  Lütfen bu alanı boş bırakmayın.
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="form4" class="label-text col-md-3 col-form-label">Description:</label>
              <div class="col-md-9">
                <?php echo $translate->textarea("description", $meta->description);?>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-9 offset-md-3">
              <input name="edit" type="submit" value="Düzenle" class="btn btn-rounded btn-success">
            </div>
          </div>
        </div>
      </form>
      <?php if($dropzone) { ?>
      <form id="dropzone-area" action="" method="post">
        <div class="tab-content">
          <div class="tab-pane fade" id="tab03">
            <div action="<?php echo PATH_MODULE.'/DashboardDropzone.php?section=photo&table='.$single->tablename.'&parent='.$edit->id;?>" id="dropzone01" class="dropzone" method="post" enctype="multipart/form-data">
              <div class="dz-message" data-dz-message>Drop files here to upload</div>
            </div>
            <?php echo $file->photo($single->tablename,$edit->id);?>
          </div>
        </div>
      </form>
      <?php } ?>
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
                <?php echo $translate->percent($row->name.$row->content,2); ?>
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
