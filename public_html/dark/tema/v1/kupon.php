<style type="text/css">
	table td {border-right: 1px solid #ddd; text-align: center;}
	.kupon .ust td {
		background: #C0202F;
		border-right: 1px solid #9b0404;
		color: #fff;
		font-weight: bold;
		text-align: center;
		padding: 10px;
	}
</style>




<section class="panel">
	<div class="panel-body" style="width: 100% !important;padding-right: 20px;">
		<!-- table ust -->
		<table class="table kupon">
			<tr class="ust">
			
				<td>Kupon Id</td>
				<td>Evsahibi</td>
				<td>Deplasman</td>
				<td>Tarih</td>
				<td>Tercih</td>
				<td>Açıklama</td>
				<td>Oran</td>
				<td>DK/skor</td>
				<td>İlk Yarı</td>
				<td>Skor</td>
				<td>Süre</td>
				<td>Durum</td>
				<td>Sonuç</td>
				<td>İşlem</td>
			</tr>
			<!-- <tr>
				<td>006</td>
				<td>Ukrayna</td>
				<td>Polonya</td>
				<td>21/06 19:00</td>
				<td>0</td>
				<td>Maç Sonucu (Beraberlik)</td>
				<td>3.15</td>
				<td>Devam ediyor</td>
				<td>0/</td>
				<td>Devam/</td>
				<td>0</td>
				<td>0</td>
			</tr> -->
			
			<!-- maclar -->
			<?php foreach ( $maclar as $m => $mac ) { ?>
				<?php
					$az 	= $db->query('SELECT * FROM maclar WHERE id = "'.$mac['macid'].'"')->fetch();
					$oran 	= $db->query('SELECT * FROM oranlar WHERE kisaad = "'.$mac['tur'].'"')->fetch();
					$mac_kupon = $db->query("SELECT * FROM kupon_mac WHERE macid = '".$mac['macid']."'")->fetch();
					
					if($mac["tur"]=="1"){
						$oran["ad"]="Maç Sonucu (Evsahibi)";
					}elseif($mac["tur"]=="2"){
						$oran["ad"]="Maç Sonucu (Deplasman)";
					}elseif($mac["tur"]=="0"){
						$oran["ad"]="Maç Sonucu (Beraberlik)";
					}
					
					$style="";
					
					if($mac["sonuc"]=="3" ){
						$style="style='color:blue;font-size:15px'";
					}elseif($mac["sonuc"]=="1"){
						$style="style='color:#4E874B;;font-size:15px'";
					}elseif($mac["sonuc"]=="2"){
						$style="style='color:#FF0000;;font-size:15px'";
					}
					
					if(!$az["mackodu"]){
						$az["mackodu"] = $az["botid"];
					}
					
					$ek="";
					
					if((substr($mac["tur"],-1)=="0" OR substr($mac["tur"],-1)==2 OR substr($mac["tur"],-1)==1) && 1==2){
						$mackodu= $az["mackodu"].strtoupper(substr($mac["tur"],0,-1));
						$tur=substr($mac["tur"],-1);
					}else{
						$mackodu= $az["mackodu"];
						$tur=$mac["tur"];
					}
					
					if($mac["tur"]=="TT1" OR $mac["tur"]=="TT2" OR $mac["tur"]=="HK 1" OR $mac["tur"]=="HK 2"){
						$mo = $db->query("select * from mac_oranlar where id='$mac[oranid]'")->fetchAll();
						$tur .= end(explode(" ", $mo["aciklama"]));		
					}
					
					if($mac["canli"]==1){$ek .="(c)";}
					
					if($az["sistem"]=="basket"){
						$sadi=str_replace("Gol","Basket",$oran["ad"]);
						$sadi=str_replace("2.5","",$sadi);
					}else{
						$sadi=$oran["ad"];
					}
					
                    //$betradar = json_decode(file_get_contents('https://ls.betradar.com/ls/feeds/?/interwetten/tr/Europe:Istanbul/gismo/match_timeline/' . $mac['mackodu'] ), true);

					// die( print_r($betradar["doc"][0]["data"]["match"]["periods"]["p1"]["home"]) );
					$p1_home = $betradar["doc"][0]["data"]["match"]["periods"]["p1"]["home"];
					$p1_away = $betradar["doc"][0]["data"]["match"]["periods"]["p1"]["away"];

					$full_home = $betradar["doc"][0]["data"]["match"]["result"]["home"];
					$full_away = $betradar["doc"][0]["data"]["match"]["result"]["away"];

					$statuss = $betradar["doc"][0]["data"]["match"]["status"]["name"];

	
				?>
				
				<tr class="bet-history-table-mackodu" data-id="<?php echo $mac['mackodu']; ?>">
	
					<td><?php echo $mac['id']; ?></td>
					<td><?php echo $mac["evsahibi"]; ?></td>
					<td><?php echo $mac["deplasman"]; ?></td>
					<td><?php echo date("d/m H:i",strtotime($mac["matchdate"])); ?></td>
					<td><?php echo $tur; ?></td>
					<td><?php echo $mac['aciklamasi']; ?></td>
					<td><?php echo mf($mac["oran"]); ?></td>
				
					<td><?php echo $mac["canlidakika"]. " / " . $mac["skor"]; ?></td>
					
					<td><?php echo $p1_home; ?> - <?php echo $p1_away; ?></td>
				    <td><?php echo $full_home; ?> - <?php echo $full_away; ?></td>
				    <td><?php echo $statuss; ?></td>
				    <td <?php echo $style; ?>><?php
                        if ($mac['sonuc'] == "1") {
                            echo 'Kazandı';
                        } else if ($mac['sonuc'] == "2") {
                            echo 'Kaybetti';
                        } else if ($mac['sonuc'] == "3") {
                            echo 'İade';
                        } else if ($mac['sonuc'] == "0") {
                            echo 'Beklemede';
                        } ?></td>
					<td><a target="_blank" href="http://href.li?https://cs.betradar.com/ls/widgets/?/interwetten/tr/Europe:Istanbul/page/widgets_lmts#matchId=<?php echo $mac['mackodu']; ?>">Git</a></td>
					<td>
					<?php if ($mac["oran"] != "1") { ?>					
					<button class="btn btn-primary admin-action" data-action="adminKuponMacIade" data-id="<?php echo $mac['id']; ?>">Iade</button>
					<?php } ?>
					</td>

				</tr>
				
			<?php } ?>
			<!-- #maclar -->
		</table>
		<!-- #table ust -->
		
		<table class="table">
			<tr>
				<td>Kupon No: <b><?php echo $kupon['id']; ?></b></td>
				<td>Toplam Bahis Tutarı : <?php echo mf($kupon['miktar']); ?></td>
				<td>Max Oran : <?php echo mf($kupon['oran']); ?></td>
				<td>Max Kazanç : <?php echo mf($kupon['oran']*$kupon['miktar']); ?></td>
				<td>Durum : <?php
					if ($kupon['durum'] == "1") {
						echo 'Kazandı';
					} else if ($kupon['durum'] == "2") {
						echo 'Kaybetti';
					} else if ($kupon['durum'] == "3") {
						echo 'İptal';
					} else if ($kupon['durum'] == "0") {
                        echo 'Beklemede';
					} ?>
                </td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td>Ip Adresi : <?php echo $kupon['ip']; ?></td>
				<td><?php echo $kupon['tarih']; ?></td>
				<td>Tarayıcı : Chrome</td>
				<td><button class="btn btn-primary admin-action" data-action="adminKuponIade" data-id="<?php echo $kupon['id']; ?>">Iade et</button></td>
<td><a href="#" class="btn btn-success admin-action" data-action="adminKuponGuncelle" data-durum="1" data-id="<?php echo $kupon['id']; ?>">Kazandı Yap</a></td>
<td><a href="#" class="btn btn-danger admin-action" data-action="adminKuponGuncelle" data-durum="2" data-id="<?php echo $kupon['id']; ?>">Kaybetti Yap</a></td>
<td><a href="#" class="btn btn-warning admin-action" data-action="adminKuponGuncelle" data-durum="0" data-id="<?php echo $kupon['id']; ?>">Beklemeye Al</a></td>
			</tr>
		</table>
	</div>
</section>