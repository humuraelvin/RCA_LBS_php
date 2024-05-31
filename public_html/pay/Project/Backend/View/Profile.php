<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\Profile;

  /**
  * METHODS
  */
  $single = $app->single();

  /**
  * CRUD START
  */
  $app->update();

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
  <div class="row gutter-20">
    <div class="col-md-12">

      <div class="panel">

        <div class="records--body">

          <div class="title">
            <h6 class="h6">Profil Detayları</h6>
          </div>

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#tab01" data-toggle="tab" class="nav-link active">Hesap Bilgileri</a>
            </li>
            <li class="nav-item">
              <a href="#tab02" data-toggle="tab" class="nav-link">Görsel</a>
            </li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane fade show active" id="tab01">
              <form action="" method="post" class="needs-validation" novalidate>
                <div class="form-group row">
                  <label for="form1" class="label-text col-md-3 col-form-label">Kullanıcı Adı:</label>
                  <div class="col-md-9">
                    <input id="form1" type="text" name="username" class="form-control" value="<?php echo $DBGetID::administrator("username");?>" required>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="form2" class="label-text col-md-3 col-form-label">Whatsapp No:</label>
                  <div class="col-md-9">
                    <input id="form2" type="text" name="phone" class="form-control" value="<?php echo $DBGetID::administrator("phone");?>" required>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="form2" class="label-text col-md-3 col-form-label">E-mail Adresi:</label>
                  <div class="col-md-9">
                    <input id="form2" type="text" name="email" class="form-control" value="<?php echo $DBGetID::administrator("email");?>" required>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="form3" class="label-text col-md-3 col-form-label">Yeni Şifre:</label>
                  <div class="col-md-9">
                    <input id="form3" type="text" name="password" class="form-control" required>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-9 offset-md-3">
                    <input type="submit" name="edit" value="Bilgilerimi Güncelle" class="btn btn-rounded btn-success">
                  </div>
                </div>
              </form>
            </div>

            <!-- Tab Pane Start -->
            <div class="tab-pane fade" id="tab02">
              <div class="form-group row">
                <div class="col-md-3">
                  <img src="<?=PATH_UPLOAD;?>/DashboardProfile/<?=$DBGetID::administrator("photo") ? $DBGetID::administrator("photo") : "admin.png";?>" alt="">
                </div>
                <div class="col-md-9">
                  <form action="<?php echo PATH_MODULE.'/DashboardDropzone.php?section=profile&id='.$DBGetID::administrator("id");?>" id="dropzone01" class="dropzone" method="post" enctype="multipart/form-data">
                    <div class="dz-message" data-dz-message>Drop files here to upload</div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Tab Pane End -->

          </div>

        </div>

      </div>

    </div>
  </div>
</section>
