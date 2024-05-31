<?php

  Namespace Helper;

  Use Helper\Database\DBGetSlug as DBGetSlug;
  Use Helper\Database\DBGetCount as DBGetCount;
  Use Helper\DashboardPermission as Permission;
  Use Library\Database as DB;

  Class DashboardPageHeader {

    Public Static Function get($brandName,$pageSlug,$pageName)
    {
      echo '
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <h2 class="page--title h5">'.$brandName.'</h2>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="'.PATH_DASHBOARD.'">Dashboard</a></li>
              <li class="breadcrumb-item '.(!PSLUG2 && !$_GET["query"] ? "active" : NULL).'"><a href="'.PATH_DASHBOARD.'/'.$pageSlug.'">'.$pageName.'</a></li>
              <li class="breadcrumb-item active"><span>'.(PSLUG2=='add' ? "Ekle" : NULL).(PSLUG2=='edit' ? "Düzenle" : NULL).'</span></li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="summary--widget">
              <div class="summary--item">
                <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#009378">2,9,7,9,11,9,7,5,7,7,9,11</p>
                <p class="summary--title">Bu Ay</p>
                <p class="summary--stats text-green">'.DBGetCount::visitorThisMount().'</p>
              </div>
              <div class="summary--item">
                <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#e16123">2,3,7,7,9,11,9,7,9,11,9,7</p>
                <p class="summary--title">Geçen Ay</p>
                <p class="summary--stats text-orange">'.DBGetCount::visitorLastMount().'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      ';
    }

  }
