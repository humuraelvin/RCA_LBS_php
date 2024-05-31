

    <div class="container">
      <div class="row">

        <?php include "includes/sidebar-account.php"; ?>

        <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
          <div class="panel panel-default border-radius">
            <div class="panel-heading border-bottom">
              AFFILIATE
            </div>
            <div class="panel-body">

              <table id="affiliate-table" class="table table-bordered table-striped ab-table clear-margin">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>AD SOYAD</th>
                    <th>KULLANICI ADI</th>
                    <th>KAYIT TARİHİ</th>
                    <th>GROS RAKE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>1</th>
                    <th scope="row">Ali Veli</th>
                    <td>@aliveli</td>
                    <td>1 Nisan 2017</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <th scope="row">John Doe</th>
                    <td>@johndoe</td>
                    <td>19 Ağustos 2017</td>
                    <td>-</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="panel-body">
                <div class="affiliate-alert clearfix" role="alert">
                  <div class="col-md-3 heading">AFFILIATE ADRESİNİZ:</div>
                  <div class="col-md-6"><div class="aff-link">http://example.com/singup?ref=a1b2c3</div></div>
                  <div class="col-md-3">
                  <button class="btn btn-success btn-bg btn-clipboard pull-right" data-clipboard-action="copy" data-clipboard-target=".aff-link">
                    KOPYALA
                  </button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>