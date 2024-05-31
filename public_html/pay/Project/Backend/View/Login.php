<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\Login;

  /**
  * CRUD START
  */
  $app->connect();

?>


<!-- Login Page Start -->
<div class="m-account-w" data-bg-img="<?=PATH_DASHBOARD_ASSET;?>/img/account/wrapper-bg.jpg">
  <div class="m-account">
    <div class="row no-gutters" style="margin-right:33px">
      <div class="col-md-6 offset-md-3">
        <!-- Login Form Start -->
        <div class="m-account--form-w">
          <div class="m-account--form">
            <!-- Logo Start -->
            <div class="logo">
              <img src="<?=PATH_DASHBOARD_ASSET;?>/img/logo.png" alt="">
            </div>
            <!-- Logo End -->
            <form action="" method="post">
              <label class="m-account--title">Hesabınıza giriş yapın</label>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="fas fa-user"></i>
                  </div>
                  <input type="text" name="username" placeholder="Username" class="form-control" autocomplete="off" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="fas fa-key"></i>
                  </div>

                  <input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off" required>
                </div>
              </div>
              <div class="m-account--actions">
                <a href="#" class="btn-link">Şifremi Unuttum?</a>
                <button name="connect" type="submit" class="btn btn-rounded btn-info">Giriş</button>
              </div>
              <div class="m-account--alt">
                <p><span>VEYA</span></p>
                <div class="btn-list">
                  <a href="#" class="btn btn-rounded btn-warning">Facebook</a>
                  <a href="#" class="btn btn-rounded btn-warning">Google</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Login Form End -->
      </div>
    </div>
  </div>
</div>
<!-- Login Page End -->
