<header class="page-header">
    <h2><i class="fa fa-money"></i>Detaylı Raporlar</h2> </header>
<!-- Tablo -->
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Detaylı Raporlar</h2>Toplam Tutar : <b><?php echo number_format($toplambakiye, 2, '.', ','); ?> ₺ </b></header>
    <div class="panel-body">
        <!-- form -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input placeholder="Kullanıcı arayın." type="text" class="form-control" id="autoComplete_user" />
                    <input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" /> </div>
            </div>
        </div>
        <hr class="dotted short">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Başlangıç Tarihi: </label>
                    <input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic"> </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Bitiş Tarihi: </label>
                    <input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis"> </div>
            </div>
        </div>
        <hr class="dotted short">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <select name="tur" id="tur" class="form-control">
                        <option value="0">Hepsi</option>
                        <option value="1">Bakiye Ekleme</option>
                        <option value="2">Bakiye Çıkarma</option>
                        <option value="3">RakeBack</option>
                        <option value="4">Bonus Ekleme</option>
                    </select>
                </div>
            </div>
        </div>
        <hr class="dotted short">
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary admin-action" data-action="adminBankaYatirim">Listele</button>
            </div>
        </div>
        <hr class="dotted short">
        <!-- #form -->
        <table class="table table-bordered mb-none playgo-table" id="datatable-default">
            <thead>
            <tr>
                <td>#</td>
                <td>UYE</td>
                <td>RUMUZ</td>
                <td>MIKTAR</td>
                <td>ISLEM</td>
                <td>TARIH</td>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td>#</td>
                <td>UYE</td>
                <td>RUMUZ</td>
                <td>MIKTAR</td>
                <td>ISLEM</td>
                <td>TARIH</td>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach ($raporlar as $rapor) {
                $kullanici = kullanici( $rapor['userid'] );
                $game = $db->query("SELECT * FROM klaspoker_users WHERE mid = '".$rapor['userid']."'");
                $game = $game->fetch();
                ?>
                <tr>
                    <td><?php echo $rapor['id']; ?></td>
                    <td><?php echo $kullanici['username']; ?></td>
                    <td><?php echo $game['username']; ?></td>
                    <td><?php echo number_format($rapor['tutar'], 2, ',', ','); ?></td>
                    <td><?php echo $rapor['islemad'] ; ?></td>
                    <td><?php echo $rapor['tarih']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<!-- #Tablo -->