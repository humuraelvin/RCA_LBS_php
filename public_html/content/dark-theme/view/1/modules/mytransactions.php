

    <div class="container profile-history">
      <div class="row">

        <?php include "includes/sidebar-account.php"; ?>

        <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
          <div class="panel panel-default border-radius">
            <div class="panel-heading border-bottom">
              HESAP HAREKETLERİ
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
            <div class="panel-body">
              <table id="bet-history-table" class="table table-bordered table-striped ab-table text-center clear-margin display nowrap" cellspacing="0">
                <thead>
                  <tr>
                    <th>HAREKET TİPİ</th>
                    <th>ÖNCEKİ BAKİYE</th>
                    <th>MİKTAR</th>
                    <th>GÜNCEL BAKİYE</th>
                    <th>YÖNETİCİ NOTU</th>
                    <th>TARİH</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">BAHİS</th>
                    <td>191.50 TL</td>
                    <td>5.00 TL</td>
                    <td>186.50 TL</td>
                    <td>6553565 N. KUPON</td>
                    <td>21/07 02:37</td>
                  </tr>
                  <tr>
                    <th scope="row">POKER</th>
                    <td>451.50 TL</td>
                    <td>5.00 TL</td>
                    <td>436.50 TL</td>
                    <td>6553565 N. KUPON</td>
                    <td>21/07 02:37</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>