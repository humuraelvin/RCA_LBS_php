<?php

  /**
  * START APPLICATION
  */
  $app    = new Project\Controller\Deposit;

?>
<main>
  <router-outlet></router-outlet>
  <app-dashboard class="ng-star-inserted">
    <router-outlet></router-outlet>
    <payment-component class="ng-star-inserted">
      <router-outlet></router-outlet>
      <deposit-money class="ng-star-inserted">
        <deposit-withdraw-money>
          <div class="breadcrumb-wrapper flex-container">
            <div class="breadcrumbs-cont flex-container flex-item">
              <history-back-button>
                <?php if(count($_GET)): ?>
                <a class="breadcrumb" href="<?=PATH.'/para-yatir';?>">
                  <i class="icon chevron-right pg-icons"></i>
                </a>
              <?php else: ?>
                <a class="breadcrumb" href="javascript:;">
                  <i class="icon chevron-right pg-icons"></i>
                </a>
              <?php endif;?>
              </history-back-button>
              <a class="breadcrumb ng-star-inserted" href="javascript:;">Para Yatırma</a>
            </div>
          </div>

          <?php if(count($_GET)==1): ?>
          <div class="modul-accordion-account">
            <div class="modul-content">
              <div class="money-list-cont">
                <ul class="money-list-menu">
                  <?php foreach ($app->paymentMethods() as $item): ?>
                    <li class="ng-star-inserted">
                      <a class="flex-container" href="<?=PATH;?>/para-yatir?id=<?=$_GET['id'];?>&method=<?=$item->id;?>">
                        <div class="img-wrapper">
                          <payment-icon height="33" width="100">
                            <img src="<?=PATH_UPLOAD.'/PaymentMethods/'.$item->logo;?>" width="100" height="33">
                          </payment-icon>
                        </div>
                        <br>
                        <ul class="flex-item info">
                          <li>
                            <b title="Superhavale Deposit" class="ng-star-inserted"><?=$item->method_name;?> Deposit</b>
                            <br class="ng-star-inserted">
                            <small class="ng-star-inserted"><?=$item->method_name;?> ile işlem yap</small>
                          </li>
                          <li>
                            <b>İşlem limiti &amp; İşlem zamanı</b>
                            <br>
                            <small class="ng-star-inserted"><?=$item->method_limit;?></small>
                          </li>
                          <li>
                            <small><?=$item->method_price;?></small>
                          </li>
                        </ul>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <app-static-inner-content contentcode="m_deposit-bottom">
                <div extroutelink=""></div>
                <div></div>
                <div></div>
              </app-static-inner-content>
            </div>
          </div>
          <?php endif;?>

          <?php if($_GET['method']==1): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod1.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==2): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod2.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>
          
          <?php if($_GET['method']==4): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod4.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==5): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod5.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==6): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod6.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==7): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod7.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==8): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod8.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==9): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod9.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

          <?php if($_GET['method']==10): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod10.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>
          
          <?php if($_GET['method']==12): ?>
            <div class="modul-accordion-account" style="margin:0;">
              <iframe src="<?=PATH;?>/Payments/PaymentMethod12.php?id=<?=$_GET['id'];?>" style='width:100%;height:calc(100vh - 191px);border:0'></iframe>
            </div>
          <?php endif;?>

        </para-yatir-withdraw-money>
      </para-yatir-money>
    </payment-component>
  </app-dashboard>
</main>
