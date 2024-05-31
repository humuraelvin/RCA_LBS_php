<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
	.row-active {background:#000; color: #fff}
	.row-active a {
		color: #fff;
	}
	table tr {
		background: #F8F8F8;
	}
	.kullaniciTabHareket:hover{background: rgba(70,140,0,.5); color: #fff; cursor: pointer;}
	table td {font-weight: bold;}
	.table-line {
		width: 100%;
		display: block;
		border: 1px solid #f3f3f3;
		margin: 10px 0 10px 0;
	}
	table tr.durum1 {
		background: #58753B;
		color: #fff;
	}
	table tr.durum2 {
		background: #F64744;
		color: #fff;
	}
	table tr.durum0 {
		background: #54B1F6;
		color: #fff;
	}
	.table-money {
		font-size: 18px;
	}
	.dataTables_filter {display: none;}
</style>

<script type="text/javascript">
  $(function(){
    $(".sonucMacDetay").on('click', function(){
      var $id = $(this).data('id');
      var t = $id;

       // var id = t.data("id");
        $("table tr").removeClass("row-active");
        $('#'+ t).addClass("row-active");
        //t.parents("tr").addClass("row-active");

      $(".betRadarEmbed, .sonuclandirma").show();
      $(".betRadarEmbed").html('<embed src="https://href.li/?https://cs.betradar.com/ls/widgets/?/evona/tr/Europe:Berlin/page/widgets_lmts#matchId='+ $(this).data('mac-kodu') +'" width="100%" height="430">');
      $(".btn-group button").attr('data-id', $id);
      $("#returnCouponDetail").attr('data-id', $id);
      $("#match-detail").attr('href', 'https://<?php echo ACTIVE_DOMAIN; ?>/services/detay/'+ $(this).data('mac-kodu'));


    });
  });
</script>

<?php if (!@p('popup') || @p('popup') == "false") { ?>

<header class="page-header">
	<h2><i class="fa fa-thumbs-up"></i> Kupon Sonuçla</h2>
</header>

<?php } ?>

		<!-- secenekler -->
		<div class="row">
			<div class="col-md-3">
				<div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-plugin-datepicker="">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
					<span class="input-group-addon">-</span>
					<input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
				</div>
			</div>
			<div class="col-md-2">
				<select name="durum" id="durum" class="form-control">
					<option value="0" <?php echo (@$_POST['durum'] == '0') ? 'selected=selected' : null; ?>>Bekleyen</option>
					<option value="1" <?php echo (@$_POST['durum'] == '1') ? 'selected=selected' : null; ?>>Kazanan</option>
					<option value="2" <?php echo (@$_POST['durum'] == '2') ? 'selected=selected' : null; ?>>Kaybeden</option>
					<option value="3" <?php echo (@$_POST['durum'] == '3') ? 'selected=selected' : null; ?>>İptal</option>
					<option value="4" <?php echo (@$_POST['durum'] == '4') ? 'selected=selected' : null; ?>>İade</option>
				</select>
			</div>
			<div class="col-md-1">
				<select name="result" id="result" class="form-control">
				    <option value="0" <?php echo (@$_POST['result'] == '0') ? 'selected=selected' : null; ?>>Manual</option>
					<option value="1" <?php echo (@$_POST['result'] == '1') ? 'selected=selected' : null; ?>>Auto</option>
				</select>
			</div>
			<div class="col-md-1">
				<button class="btn btn-primary admin-action" data-action="adminKuponlar">Listele</button>
			</div>
		</div>
		<!-- #secenekler -->
		<hr class="dotted short">
		<!-- kuponlar liste -->
    <div class="row">
      <div class="col-md-7">
    		<table class="table mb-none kupon table-responsive dt-responsive" id="datatable-default">
    			<thead>
    				<tr>
              <td>Kupon No</td>
              <td></td>
    					<td>Ev Sahibi</td>
    					<td>Deplasman</td>
    					<td>Tarih</td>
    					<td>Tercih</td>
    					<td>Açıklama</td>
    					<td>Oran</td>
    					<td>DK/Skor</td>
              <td>Sonuç</td>
    				</tr>
    			</thead>
    			<tfoot>
    				<tr>
              <th>Kupon No</th>
              <th></th>
    					<th>Ev Sahibi</th>
    					<th>Deplasman</th>
    					<th>Tarih</th>
    					<th>Tercih</th>
    					<th>Açıklama</th>
    					<th>Oran</th>
    					<th>DK/Skor</th>
              <th>Sonuç</th>
    				</tr>
    			</tfoot>
    			<tbody>
    				<?php
              foreach ( $query->fetchAll() as $row ) {

              //$betradar = json_decode(file_get_contents('https://ls.betradar.com/ls/feeds/?/interwetten/tr/Europe:Berlin/gismo/match_timeline/' . $row['mackodu'] ), true);

              $p1_home = $betradar["doc"][0]["data"]["match"]["periods"]["p1"]["home"];
    					$p1_away = $betradar["doc"][0]["data"]["match"]["periods"]["p1"]["away"];

    					$full_home = $betradar["doc"][0]["data"]["match"]["result"]["home"];
    					$full_away = $betradar["doc"][0]["data"]["match"]["result"]["away"];

    					$statuss = $betradar["doc"][0]["data"]["match"]["status"]["name"];

            ?>
            <tr id="<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" class="sonucMacDetay" data-mac-kodu="<?php echo $row['mackodu']; ?>">
              <td><?php echo $row['id']; ?></td>
              <td><?php echo ( !empty($row['skor']) ) ? '<img width="16" height="16" src="/images/live.gif" />' : null; ?></td>
              <td><?php echo $row['evsahibi']; ?></td>
              <td><?php echo $row['deplasman']; ?></td>
              <td><?php echo date("d/m H:i",strtotime($row["matchdate"])); ?></td>
              <td><?php echo $row['tur']; ?></td>
              <td><?php echo $row['aciklamasi']; ?></td>
              <td><?php echo $row['oran']; ?></td>
              <td><?php echo $row["canlidakika"]. " / " . $row["skor"]; ?></td>
              <td class="durum <?php echo ( $row['sonuc'] == '0' ) ? null : ( $row['sonuc'] == '1' ? 'row-green' : 'row-red' );  ?>">
                <?php if ( $row['sonuc'] == '0' ) { ?>
                    Beklemede
                <?php } else if ( $row['sonuc'] == '1' ) { ?>
                    Kazandı
                <?php } else if ( $row['sonuc'] == '2' ) { ?>
                    Kaybetti
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
    			</tbody>
    		</table>
      </div>
      <div class="col-md-5" style="position: fixed;right: 0;">
          <div class="betRadarEmbed" style="display: none"></div>
          <div class="sonuclandirma" style="display: none; background: #fff; padding: 10px">
            <center>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-success admin-action" data-action="adminKuponMacGuncelle" data-durum="1">Kazandı</button>
                <button type="button" class="btn btn-danger admin-action" data-action="adminKuponMacGuncelle" data-durum="2">Kaybetti</button>
                <button type="button" class="btn btn-warning admin-action" data-action="adminKuponMacGuncelle" data-durum="0">Beklemede</button>
                <button type="button" class="btn btn-info admin-action" data-action="adminKuponMacIade" id="returnCouponDetail" data-id="" >Iade</button>
                 <a id="match-detail" class="btn btn-dark" target="_blank">Akış</a>
              </div>
            </center>
          </div>
      </div>
    </div>
		<!-- #kuponlar liste -->
