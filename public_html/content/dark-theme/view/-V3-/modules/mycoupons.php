

    <div class="container profile-my-bets">
      <div class="row">

        <?php include "includes/sidebar-account.php"; ?>

        <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
          <div class="panel panel-default border-radius">
            <div class="panel-heading border-bottom">
              <div class="dropdown pull-right hidden-lg">
                <button class="btn btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  TÜMÜ
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <li><a href="#">KAZANILAN</a></li>
                  <li><a href="#">KAYBEDİLEN</a></li>
                  <li><a href="#">İADE</a></li>
                  <li><a href="#">İPTAL EDİLEN</a></li>
                </ul>
              </div>
              <div class="panel-title">BAHİSLERİM</div>
              <ul class="nav nav-pills v2 pull-right visible-lg">
                <li role="presentation" class="active"><a href="#">TÜMÜ</a></li>
                <li role="presentation"><a href="#">KAZANILAN</a></li>
                <li role="presentation"><a href="#">KAYBEDİLEN</a></li>
                <li role="presentation"><a href="#">İADE</a></li>
                <li role="presentation"><a href="#">İPTAL EDİLEN</a></li>
              </ul>
            </div>

            <div class="panel-body panel-bg panel-date">
            <form class="form-inline">
                  <span class="heading">TARİH SEÇİNİZ:</span>
                  <div class="form-group first">
                      <div class='input-group date' id='dtp_mybets'>
                          <input type='text' class="form-control" placeholder="Başlangıç Tarihi" />
                          <span class="input-group-addon">
                              <i class="fa fa-calendar" aria-hidden="true"></i>
                          </span>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class='input-group date' id='dtp_mybets2'>
                          <input type='text' class="form-control" placeholder="Bitiş Tarihi" />
                          <span class="input-group-addon">
                              <i class="fa fa-calendar" aria-hidden="true"></i>
                          </span>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-bg btn-primary btn-search">ARA <i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
              </div>

            <div class="panel-body text-center panel-info">

              Bu sayfada görüntülenen bahis geçmişi sadece son bir aylık dönemi kapsamaktadır.
            </div>
            <div class="panel-body">
              <table id="bet-history-table" class="table table-bordered table-striped ab-table text-center clear-margin display nowrap" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th><span data-toggle="tooltip" data-placement="top" title="KUPON NO">K. NO</span></th>
                    <th>TARİH</th>
                    <th>TÜRÜ</th>
                    <th>YATIRILAN</th>
                    <th>ORAN</th>
                    <th>KAZANÇ</th>
                    <th>DURUM</th>
                    <th><span data-toggle="tooltip" data-placement="top" title="DETAY">D.</span></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">01</th>
                    <td>2578</td>
                    <td>21/07 02:37</td>
                    <td>Kombine Kupon</td>
                    <td>5.00 TL</td>
                    <td>2.27</td>
                    <td>246.37</td>
                    <td class="pending">Bekliyor</td>
                    <td><a href="#" class="fa fa-search-plus"  data-toggle="modal" data-target="#ab-detail" aria-hidden="true"></a></td>
                  </tr>
                  <tr>
                    <th scope="row">02</th>
                    <td>2579</td>
                    <td>21/07 14:44</td>
                    <td>Kombine Kupon</td>
                    <td>5.00 TL</td>
                    <td>2.27</td>
                    <td>246.37</td>
                    <td class="paid">Ödendi</td>
                    <td><a href="#" class="fa fa-search-plus"  data-toggle="modal" data-target="#ab-detail" aria-hidden="true"></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="panel-body text-center">
              <div class="h5">DAHA FAZLA KAZANMAK İÇİN:</div>
              <a href="#" class="btn btn-success btn-bg">BAHİS YAPIN</a>
            </div>
          </div>
        </div>
      </div>
    </div>