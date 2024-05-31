<!-- Main Content Start -->
<section class="main--content">
  <div class="row gutter-20">
    <div class="col-md-4">
      <div class="panel">
        <div class="miniStats--panel text-white bg-orange">
          <div class="miniStats--body">
            <i class="miniStats--icon fa fa-user text-white"></i>
            <p class="miniStats--caption">Tüm Zamanlar</p>
            <h3 class="miniStats--title h4 text-white">TOPLAM ÜYE</h3>
            <p class="miniStats--num"><?=Helper\Database\DBGetCount::users();?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel">
        <div class="miniStats--panel text-white bg-red">
          <div class="miniStats--body">
            <i class="miniStats--icon fa fa-users text-white"></i>
            <p class="miniStats--caption">Onay Bekleyen Ödeme</p>
            <h3 class="miniStats--title h4 text-white">GÜNCEL</h3>
            <p class="miniStats--num"><?=Helper\Database\DBGetCount::approvePayments();?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel">
        <div class="miniStats--panel text-white bg-green">
          <div class="miniStats--body">
            <i class="miniStats--icon fa fa-wifi text-white"></i>
            <p class="miniStats--caption">Onaylanan Ödemeler</p>
            <h3 class="miniStats--title h4 text-white">TÜM ZAMANLAR</h3>
            <p class="miniStats--num"><?=Helper\Database\DBGetCount::allPayments();?></p>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Yıllık Genel Bakış Grafiği</h3>
          <div class="dropdown">
            <button type="button" class="btn-link dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a href="<?=PATH_DASHBOARD;?>"><i class="fa fa-sync"></i>Grafiği Güncelle</a></li>
            </ul>
          </div>
        </div>

        <div class="panel-chart">
          <div id="defaultStatistics" class="chart--body area--chart style--1"></div>
        </div>
        <div class="chart--stats style--1">
          <ul class="nav">
            <li data-overlay="1 green">
              <p class="amount"><?=Helper\Database\DBGetCount::visitor();?></p>
              <p>
                <span class="label">Tekil Ziyaretçi Sayısı</span>
              </p>
            </li>
            <li data-overlay="1 blue">
              <p class="amount"><?=Helper\Database\DBGetCount::pageView();?></p>
              <p>
                <span class="label">Sayfa Görüntüleme Sayısı</span>
              </p>
            </li>
          </ul>
        </div>


      </div>
    </div>

  </div>
</section>
<!-- Main Content End -->
