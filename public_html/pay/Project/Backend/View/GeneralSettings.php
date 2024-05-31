<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\GeneralSettings;

  /**
  * METHODS
  */
  $single = $app->single();

  /**
  * CRUD
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
  $dropzone   = true;
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
            <?php echo $translate->dropDown($single->slug);?>
          </div>

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#tab01" data-toggle="tab" class="nav-link active">Website Bilgileri</a>
            </li>

          </ul>



          <form action="" method="post" class="needs-validation" novalidate>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab01">
                <div class="form-group row">
                  <label for="form1" class="label-text col-md-3 col-form-label">Marka:</label>
                  <div class="col-md-9">
                    <input id="form1" type="text" name="brandName" class="form-control" value="<?php echo $DBGetID->config("brandName");?>" required>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="form2" class="label-text col-md-3 col-form-label">Website Title :</label>
                  <div class="col-md-9">
                    <?php echo $translate->input("metaTitle", $DBGetID->config("metaTitle"), true, "form2");?>
                    <div class="invalid-feedback">
                      Lütfen bu alanı boş bırakmayın.
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="form3" class="label-text col-md-3 col-form-label">Script Code:</label>
                  <div class="col-md-9">
                    <textarea name="footerCode" class="form-control" rows="8"><?php echo $DBGetID->config("footerCode");?></textarea>
                  </div>
                </div>
              </div>




              <div class="row mt-3">
                <div class="col-md-9 offset-md-3">
                  <input name="edit" type="submit" value="Güncelle" class="btn btn-rounded btn-success">
                </div>
              </div>

            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
