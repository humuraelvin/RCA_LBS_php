

    <div class="container">
      <div class="row">

        <?php include "includes/sidebar-account.php"; ?>

        <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
          <div class="panel panel-default border-radius">
            <div class="panel-heading border-bottom">
              HESABIM
            </div>
            <div class="panel-body panel-bg">
              <form class="form-horizontal">
                <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="name">AD SOYAD</label>
                    <input type="text" class="form-control" id="name" disabled placeholder="Ad Soyad">
                  </div>
                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="birthdate">DOĞUM TARİHİ</label>
                    <input type="text" class="form-control" id="birthdate" disabled placeholder="Doğrum Tarihi">
                  </div>
                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="idnumber">KİMLİK NO</label>
                    <input type="text" class="form-control" id="idnumber" disabled placeholder="Kimlik Numarası">
                  </div>
                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="email">E-POSTA</label>
                    <input type="email" class="form-control" id="email" disabled placeholder="E-Posta Adresi">
                  </div>
                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="tel">TELEFON NUMARASI</label>
                    <input type="tel" class="form-control" id="tel" disabled placeholder="Telefon Numarası">
                  </div>
                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="username">KULLANICI ADI</label>
                    <input type="text" class="form-control" id="username" disabled placeholder="Kullanıcı Adı">
                  </div>
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-bg">KAYDET</button>
                  </div>
              </form>
            </div>
          </div>
          <div class="panel panel-default border-radius">

            <div class="panel-heading border-bottom">
              ŞİFRE DEĞİŞTİR
            </div>
            <div class="panel-body panel-bg">
              <form class="form-horizontal"  role="form" data-toggle="validator">
                <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="current_pass">MEVCUT ŞİFRE</label>
                    <input type="password" class="form-control" id="current_pass" placeholder="Mevcut Şifre" data-toggle="password" data-minlength="6" required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="news_pass">YENİ ŞİFRE</label>
                    <input type="password" class="form-control" id="news_pass" placeholder="Yeni Şifre" data-toggle="password" data-minlength="6" required>
                    <div class="help-block with-errors"></div>
                  </div>

                 <div class="form-group ab-form-group col-md-6 col-lg-4 mb-20">
                    <label for="news_pass2">YENİ ŞİFRE TEKRAR</label>
                    <input type="password" class="form-control" id="news_pass2" placeholder="Yeni Şifre Tekrar" data-minlength="6" data-toggle="password" data-match="#news_pass" required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="col-md-12 col-lg-4">
                    <button type="submit" class="btn btn-success btn-bg">DEĞİŞTİR</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>