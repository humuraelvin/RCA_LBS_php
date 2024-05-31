<div class="CL-OP RND-OP modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">#{$kupon["id"]} Nolu Kupon Detayı</h4></div>

{literal}
      <style>
        @media (max-width: 767px) {
          /* Label the data */
          .bets-table2 td:nth-of-type(2):before { content: 'Tarih: '; }
          .bets-table2 td:nth-of-type(3):before { content: 'Ev Sahibi : '; }
          .bets-table2 td:nth-of-type(4):before { content: 'Deplasman : '; }
          .bets-table2 td:nth-of-type(5):before { content: 'Tür : '; }
          .bets-table2 td:nth-of-type(6):before { content: 'Tercih : '; }
          .bets-table2 td:nth-of-type(7):before { content: 'Oran : '; }
          .bets-table2 td:nth-of-type(8):before { content: 'İy : '; }
          .bets-table2 td:nth-of-type(9):before { content: 'Ms : '; }
          .bets-table2 td:nth-of-type(10):before { content: 'Durum : '; }
        }
      </style>
	  
	  <script type="text/javascript">
	  $(function(){

			function twoDigits(value) {
				if(value < 10) {
					return '0' + value;
				}
				return value;
			}

		  $( ".bet-history-table-mackodu" ).each(function( index ) {
		  var kupon = $( this ),
			  mac_kodu = kupon.data('id');
			  
			  kupon.parent().find('.bet-history-table-p1').html('<i class="fa fa-spinner fa-spin"></i>');
			  kupon.parent().find('.bet-history-table-date').html('<i class="fa fa-spinner fa-spin"></i>');
			  kupon.parent().find('.bet-history-table-full').html('<i class="fa fa-spinner fa-spin"></i>');
			  
			  $.getJSON('/services/getBetRadar/'  + mac_kodu, function(c){

			  	//console.log( Object.keys(c.doc["0"].data.match.periods).length );

				 if (c.doc["0"].data.match.periods == 'null')  {
					 kupon.parent().find('.bet-history-table-p1').html( "- - -" );
				 } else if ( Object.keys(c.doc["0"].data.match.periods).length > 0 ) { // KONTROL BURADA

					 var p1_home = c.doc["0"].data.match.periods["p1"].home;
					 var p1_away = c.doc["0"].data.match.periods["p1"].away;

					 kupon.parent().find('.bet-history-table-p1').html( p1_home + "-" + p1_away );

				 } else { kupon.parent().find('.bet-history-table-p1').html( "- - -" ); }

				 var full_home = (c.doc["0"].data.match.result.home == 'null') ? '/' : c.doc["0"].data.match.result.home;
				 var full_away = (c.doc["0"].data.match.result.away == 'null') ? '/' : c.doc["0"].data.match.result.away;

				 var mac_tarih = new Date(c.doc["0"].data.match._dt.uts * 1000);
				 //mac_tarih.setHours(mac_tarih.getHours() + 1);
				 var tarih_format = mac_tarih.getUTCDate() + "/" + ( mac_tarih.getUTCMonth() + 1) + "/" + mac_tarih.getFullYear() + " " + twoDigits(mac_tarih.getHours()) + ':' + twoDigits(mac_tarih.getMinutes()) + ':' + twoDigits(mac_tarih.getSeconds())

				 kupon.parent().find('.bet-history-table-date').html( tarih_format );
				 kupon.parent().find('.bet-history-table-full').html( full_home + "-" + full_away );
			  });
		});
	  });
	  </script>
{/literal}  


		<div class="panel panel-white no-padding-sm">
			<div class="panel-table table-responsive table-mobile">
			    <table class="table table-hover bets-table2" id="bet-history-table">
			        <thead>
			            <tr">
							<th>Tarih</th>
							<th>Ev Sahibi</th>
							<th>Deplasman</th>
							<th>Tür</th>
							<th>Tercih</th>
							<th>Oran</th>
							<th>İlk Yarı</th>
							<th>MS</th>
							<th>Durum</th>
			            </tr>
			        </thead>
			        <tbody> 
			        {foreach from="$maclar" item="mac" key="m"}
			            <tr>
				            <td class="bet-history-table-mackodu" data-id="{$mac['mackodu']}" style="display: none;">{$mac["mackodu"]}</td>
				            <td class="bet-history-table-date">1</td>
				            <td>{$mac["evsahibi"]}</td>
				            <td>{$mac["deplasman"]}</td>
				            <td>{$mac["aciklamasi"]}</td>
				            <td>{$mac["tur"]}</td>
				            <td>{nf($mac["oran"])}</td>
				            <td class="bet-history-table-p1">-</td>
				            <td class="bet-history-table-full">-</td>
				            <td>{php}
if ($mac["sonuc"] == "0") {
	echo "<span style='color:#FF7F00;font-weight:bold;'>Beklemede</span>";
}elseif ($mac["sonuc"] == "1") {
	echo "<span style='color:#468C00;font-weight:bold;'>Kazandı</span>";
}elseif ($mac["sonuc"] == "2") {
	echo "<span style='color:#FF0000;font-weight:bold;'>Kaybetti</span>";
}else { echo "Beklemede"; }   
{/php}</td>
			       		</tr> 
			       	{/foreach} 
			       	</tbody>
			    </table>
			</div>
		</div>
	
