
<div align="center">
<iframe src="" width="100%" height="1" scrolling="no" frameborder="0"></iframe>

</div>


<div style="height: 600px; overflow: auto" class="pre_detail_match_list_holder CL-OP RND-OP">
<?php 
function replace_tr($text) {
$text = trim($text);
$search = array('u00e7','u0131','u0130','u00c7','u00dc','u011f');
$replace = array('ç','ı','İ','Ç','Ü','ğ');
$new_text = str_replace($search,$replace,$text);
return $new_text;
}  
$turu = "";
			foreach ($xml->MatchDetails->E->Games->Game as $key => $game) {		
				$gamename = $game->attributes()->Name;
				if($gamename !=$turu) {
					echo '<div class="panel panel-gray "><h4 style="color:#fff;padding-left:10px;">'.replace_tr($gamename).'</h4></div>';
				}	

			echo '<div class="panel panel-gray panel-odds">
			    <div id="odds-1" class="panel-collapse collapse in">
			        <div class="panel-body">';
			        $sayi = $game->attributes()->Columns;

			        if ($sayi == "3") {
			            echo '<div class="row rowc" data-something="3">';
						foreach ($game->Odds as $key => $Odds) {
			            	echo ' 
			            	<div  class="col-sm-4 hvr-shutter-out-vertical"  onclick="addslip(\''.sifrele($id.'___'.replace_tr($gamename).'___'.$Odds->attributes()->Name.'___'.nokta($Odds->attributes()->Odds)).'\');">
			                <span>'.nokta($Odds->attributes()->Odds).'</span>'.$Odds->attributes()->Name.'
			                    <div class="progress-holder" id="progress-holder-43211888"></div>
			                </div>';
						}     
						echo '</div>';
					}

					else
					{
						$oz = 0;
						echo '<div class="row rowc" data-something="3">';
						foreach ($game->Odds as $key => $Odds) {
			            	echo ' 
			            	<div  class="col-sm-6 hvr-shutter-out-vertical"  onclick="addslip(\''.sifrele($id.'___'.replace_tr($gamename).'___'.$Odds->attributes()->Name.'___'.nokta($Odds->attributes()->Odds)).'\');">
			                <span>'.nokta($Odds->attributes()->Odds).'</span>'.$Odds->attributes()->Name.'
			                    <div class="progress-holder" id="progress-holder-43211888"></div>
			                </div>';
			            $oz = $oz + '1';
			            if ($oz == '2') 
							{
								echo '</div><div class="row rowc" data-something="3">';	
								$oz = '0';							
							}
						}     
						echo '</div>';
					}
			echo '</div></div></div>';
			}
 ?>



