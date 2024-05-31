{if $mac["oynuyormu"]=="1" and $mac["aktifmi"]=="1"}

	{php}
		$filter = [
		'Asya Handikap',
		'Asya Toplam',
		'Handikap',
		'GELECEK DAKIKADA NE OLUR (23:00 - 23:59)',
		];

		$turu ="";
		
		$odds ="";

		$arrowcount = "1";

		$url = SITE_MATCH_ODDS.$mac["botid"];

		$bukaynak = file_get_contents($url);

		$xml = simplexml_load_string($bukaynak);

		$kaynak = $xml;

		$radarid=$kaynak->LiveEvents->E['BetRadarID'];

		$ilkbu=$kaynak->LiveEvents->E->Games->G;
		
		$mac_id = $mac["id"];
		$mac_lig = $mac["lig"];
		$evsahibi = $mac["evsahibi"];
		$deplasman = $mac["deplasman"];
		$skor = $mac["skor"];
		$dakika = $mac["dakika"];

		echo '
    		<div class="headernew">
    		    <div class="breadcrumbs">
    		        <span>'.$mac_lig.'</span>
    		    </div>
    		    <div class="events">
    		        <div class="ev-sahibi">
    		            <div class="name">'.$evsahibi.'</div>
    		            <div class="text">EV SAHİBİ</div>
    		        </div>
    		        <div class="stats">
    		         <div class="skor">'.$skor.'</div>
    		         <div class="time">
    		             <span>'.$dakika .'</span>
    		         </div>
    		        </div>
    		        <div class="deplasman">
    		            <div class="name">'.$deplasman.'</div>
    		            <div class="text">MİSAFİR</div>
    		        </div>
    		    </div>
    		    <div class="tv">
    		        <img src="https://'.SITE_URL.'/assets/images/tv.png">
    		    </div>
    		</div>
    		<style>
    		    .headernew {
    		        display: flex;
                    flex-direction: column;
                    height: 180px;
                    background: url(https://'.SITE_URL.'/assets/images/event-page-header-bg.png) 50%/cover;
    		    }
    		    .headernew .breadcrumbs {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 35px;
                    padding: 4px 30px;
                    min-width: 380px;
                    min-height: 28px;
                    max-width: 90%;
                    background: #0f372c;
                    color: #fff;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 11px;
                    clip-path: polygon(0 0,100% 0,calc(100% - 20px) 100%,20px 100%);
                    -webkit-clip-path: polygon(0 0,100% 0,calc(100% - 20px) 100%,20px 100%);
                }
                .headernew .events {
                    display: grid;
                    margin: 0 auto;
                    max-width: 500px;
                    grid-template-columns: 1fr 180px 1fr;
                    grid-template-areas: "participant-home stats participant-away";
                }
                .headernew .events .ev-sahibi {
                    grid-area: participant-home;
                    padding-top: 10px;
                }
                .headernew .events .ev-sahibi .name {
                    position: relative;
                    margin-bottom: 5px;
                    color: #fff;
                    font-size: 17px;
                }
                .headernew .events .ev-sahibi .name:before {
                    position: absolute;
                    top: 0;
                    left: -50px;
                    width: 36px;
                    height: 18px;
                    background: url(https://'.SITE_URL.'/assets/images/event-participant-arrow.png) no-repeat;
                    content: "";
                }
                .headernew .events .ev-sahibi .text {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 3px;
                    background: #e5142e;
                    color: #fff;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 11px;
                }
                
                .headernew .events .deplasman {
                    text-align: right;
                    grid-area: participant-away;
                     padding-top: 10px;
                }
                .headernew .events .deplasman .name {
                    position: relative;
                    margin-bottom: 5px;
                    color: #fff;
                    font-size: 17px;
                }
                .headernew .events .deplasman .name:before {
                    position: absolute;
                    top: 0;
                    width: 36px;
                    height: 18px;
                    background: url(https://'.SITE_URL.'/assets/images/event-participant-arrow.png) no-repeat;
                    content: "";
                    right: -50px;
                    left: auto;
                    transform: rotate(180deg);
                }
                .headernew .events .deplasman .text {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 3px;
                    background: #252531;
                    color: #fff;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 11px;
                    background: #e29d24;
                }
                
                .headernew .events .stats {
                    text-align: center;
                    grid-area: stats;
                }
                .headernew .events .stats .skor {
                    display: block;
                    margin-bottom: 8px;
                    color: #fff;
                    font-weight: 700;
                    font-size: 35px;
                }
                .headernew .events .stats .time {
                    display: inline-block;
                    padding: 8px 28px 6px;
                    background: #51b42a;
                    color: #fff;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 11px;
                    clip-path: polygon(0 0,100% 0,calc(100% - 15px) 100%,15px 100%);
                    -webkit-clip-path: polygon(0 0,100% 0,calc(100% - 15px) 100%,15px 100%);
                }
                
                .headernew .tv {
                    display: flex;
                    width: 100%;
                    height: 100%;
                }
                .headernew .tv img {
                    width: 17px;
                    height: 17px;
                    color: #fff;
                    margin: auto;
                }
    		    
    		</style>
		';
		
        echo "
        <script>
        function loadScore() {
          $.ajax({
            url: 'https://".SITE_URL."/ajax/scoreBoard.php?id=$mac_id&section=skor',
            success: function (response) {
              $('.skor').html(response);
            },
          });
        }
        loadScore();
        
        setInterval(function(){
          loadScore();
        }, 50000);
        
        function loadTime() {
          $.ajax({
            url: 'https://".SITE_URL."/ajax/scoreBoard.php?id=$mac_id&section=time',
            success: function (response) {
              $('.time').html(response);
            },
          });
        }
        loadTime();
        
        setInterval(function(){
          loadTime();
        }, 50000);
        </script>
        ";
		foreach($ilkbu as $ilk){

		if (!in_array($ilk->attributes()->N, $filter) ) {
		

		if(base64_encode($ilk->attributes()->N) != $turu) {
		echo '<div class="panel panel-gray panel-odds">';
		echo '<div class="panel-heading collapsed" data-toggle="collapse" href="#odds-'.$arrowcount.'"> ';
		echo '<h4>'.$ilk->attributes()->N.'</h4><i class="pull-right icon-arrow-up"></i></div>';
		echo '<div id="odds-'.$arrowcount.'" class="panel-collapse collapse in">';
			echo '<div class="panel-body">';
				$arrowcount = $arrowcount + '1';
				}

				$turu = base64_encode($ilk->attributes()->N);
				$a =1;
				$i =0;
				$sayi = count($ilk);

				if ($sayi == 3) {



					echo '<div class="row" data-something="3" >';


					foreach($ilk->R as $val){

						if ($ilk->attributes()->GameIsVisible == 0) {
							$click = '';
							$oran = '<i  class="fa fa-lock"></i>';
						} else {
							$oran = $val->attributes()->O0;

							if ($operation == "increase") {
							$oran = round( ( (float)$oran + ( (float)$oran * (float)$percent ) ),2);
							} else if ($operation == "decrease") {
							$oran = round( ( (float)$oran - ( (float)$oran * (float)$percent ) ),2);
						}


						$click = 'onclick="addsliplive(\''.sifrele($mac["id"].'___'.$ilk->attributes()->N.'___'.$val->attributes()->N.'___'.$oran).'\');"';

						if($oran <= "1") {
							$click = '';
							$oran = '<i  class="fa fa-lock"></i>';
						}
					}
					echo '<div class="hvr-shutter-out-vertical col-sm-4" '.$click.' ><span>'.$oran.'</span>'.$val->attributes()->N.'</div>';
				}
				echo '</div>';

			}

			elseif ( $sayi == 4 || $sayi == 2 || $sayi == 7 || $sayi == 5 || $sayi == 12 ) {

			echo '<div class="row" data-something="3" >';
				$oz = 0;
				foreach($ilk->R as $val){

				if ($ilk->attributes()->GameIsVisible == 0) {
				$click = '';
				$oran = '<i  class="fa fa-lock"></i>';
				}
				else
				{
				$oran = $val->attributes()->O0;
				if ($operation == "increase") {
				$oran = round( ( (float)$oran + ( (float)$oran * (float)$percent ) ),2);
				} else if ($operation == "decrease") {
				$oran = round( ( (float)$oran - ( (float)$oran * (float)$percent ) ),2);
				}

				$click = 'onclick="addsliplive(\''.sifrele($mac["id"].'___'.$ilk->attributes()->N.'___'.$val->attributes()->N.'___'.$oran).'\');"';
				if($oran <= "1")
				{
				$click = '';
				$oran = '<i  class="fa fa-lock"></i>';
				}
				}

				echo '<div class="hvr-shutter-out-vertical col-sm-6" '.$click.' ><span>'.$oran.'</span>'.$val->attributes()->N.'</div>';
			$oz = $oz + '1';
			if ($oz == '2')
			{
			echo '</div>';
		echo '<div class="row" data-something="3" >';
			$oz = '0';
			}
			}
			echo '</div>';
		} else {
		echo '<div class="row" data-something="3" >';
			$oz = 0;
			foreach($ilk->R as $val){

			if ($ilk->attributes()->GameIsVisible == 0) {
			$click = '';
			$oran = '<i  class="fa fa-lock"></i>';
			} else {
			$oran = $val->attributes()->O0;
			if ($operation == "increase") {
			$oran = round( ( (float)$oran + ( (float)$oran * (float)$percent ) ),2);
			} else if ($operation == "decrease") {
			$oran = round( ( (float)$oran - ( (float)$oran * (float)$percent ) ),2);
			}

			$click = 'onclick="addsliplive(\''.sifrele($mac["id"].'___'.$ilk->attributes()->N.'___'.$val->attributes()->N.'___'.$oran).'\');"';
			if($oran <= "1")
			{
			$click = '';
			$oran = '<i  class="fa fa-lock"></i>';
			}
			}

			echo '<div class="hvr-shutter-out-vertical col-sm-4" '.$click.' ><span>'.$oran.'</span>'.$val->attributes()->N.'</div>';
		$oz = $oz + '1';
		if ($oz == '3')
		{
		echo '</div>';
		echo '<div class="row" data-something="3" >';
		$oz = '0';
		}
		}
		echo '</div>';
		}





		echo '</div>';
		echo '</div>';
		echo '</div>';




		}
		}



	{/php}

{/if}

