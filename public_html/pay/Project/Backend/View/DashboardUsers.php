<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\DashboardUsers;

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
          <h6 class="h6">Yenİ Kullanıcı Ekle</h6>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#tab01" data-toggle="tab" class="nav-link active">Kullanıcı Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Kullanıcı Adı:</label>
                <div class="col-md-9">
                  <input id="form1" type="text" name="username" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">E-mail Adresi:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="email" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label">Şifre:</label>
                <div class="col-md-9">
                  <input id="form3" type="text" name="password" class="form-control" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="label-text col-md-3 col-form-label">Yetki Tipi:</label>
                <div class="col-md-9">
                  <?php
                    $query = Library\Database::fetch("SELECT * FROM sta_administrator_permissions ORDER BY id ASC");
                    foreach ($query as $row) {
                      echo '
                      <div class="custom-control custom-radio">
                        <input id="radioValidation'.$row->id.'" class="custom-control-input" name="permission" type="radio" value="'.$row->id.'" required>
                        <label class="custom-control-label" for="radioValidation'.$row->id.'">'.__($row->name).'</label>
                      </div>
                      ';
                    }
                  ?>
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
            <a href="#tab01" data-toggle="tab" class="nav-link active">Kullanıcı Bilgileri</a>
          </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab01">
            <form action="" method="post" class="needs-validation" novalidate>
              <div class="form-group row">
                <label for="form1" class="label-text col-md-3 col-form-label">Kullanıcı Adı:</label>
                <div class="col-md-9">
                  <input id="form1" type="text" name="username" class="form-control" value="<?php echo $edit->username;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form2" class="label-text col-md-3 col-form-label">E-mail Adresi:</label>
                <div class="col-md-9">
                  <input id="form2" type="text" name="email" class="form-control" value="<?php echo $edit->email;?>" required>
                  <div class="invalid-feedback">
                    Lütfen bu alanı boş bırakmayın.
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="form3" class="label-text col-md-3 col-form-label"> Yeni Şifre:</label>
                <div class="col-md-9">
                  <input type="hidden" name="protectPassword" value="<?php echo $edit->password;?>">
                  <input id="form3" type="text" name="password" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <label class="label-text col-md-3 col-form-label">Yetki Tipi:</label>
                <div class="col-md-9">
                  <?php
                    $query = Library\Database::fetch("SELECT * FROM sta_administrator_permissions ORDER BY id ASC");
                    foreach ($query as $row) {
                      echo '
                      <div class="custom-control custom-radio">
                        <input id="radioValidation'.$row->id.'" class="custom-control-input" name="permission" type="radio" value="'.$row->id.'" required '.($edit->permission==$row->id ? 'checked' : NULL).'>
                        <label class="custom-control-label" for="radioValidation'.$row->id.'">'.__($row->name).'</label>
                      </div>
                      ';
                    }
                  ?>
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
      <strong>Yeni Kullanıcı İzni</strong> tanımlamak ya da <strong>Kullanıcı izinlerini</strong> düzenlemek için
      <a href="<?php echo PATH_DASHBOARD.'/userPermissions';?>"><strong>buraya</strong></a> tıklayın.
    </div>

    <div class="panel">
      <div class="records--header">
        <div class="title">
          <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListFullView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
          <p>Toplam <strong><?php echo $total;?></strong> panel kullanıcısı bulundu.</p>
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
          <a href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/add';?>" class="addProduct btn btn-lg btn-rounded btn-warning">Yeni Kullanıcı Ekle</a>
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
                <th width="30" class="not-sortable">GÖRSEL</th>
                <th class="not-sortable">KULLANICI</th>
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
                    <img src="<?=PATH_UPLOAD;?>/DashboardProfile/<?=$row->photo ? $row->photo : "admin.png";?>">
                  </td>
                  <td>
                    <strong><?php echo $row->username;?> <span class="badge badge-pill badge-success"><?php echo $app->getPermission($row->permission);?></span></strong>
                    <br />
                    <i class="fa fa-envelope"></i> <?php echo $row->email;?>
                    <br />
                    <i class="fa fa-clock"></i> <?php echo $row->created_at;?>
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
