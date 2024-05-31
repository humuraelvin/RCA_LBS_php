<?php if(empty($bulten)){ ?>
<div  align="center" style="padding:5px;">Seçtiğiniz kriterlerde karşılaşma bulunmamaktadır.</div>
<?php }else{?>
<div id="interval-bets-container" class="bets no-padding-sm">     
<?php $sonlig="";
$arrowcount = 0 ;
function replace_tr($text) {
            $text = trim($text);
            $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
            $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
            $new_text = str_replace($search,$replace,$text);
            return $new_text;
} 
function maco($id,$b)
  {
	$s = mysql_query("select * from mac_oran  where macid='$id'");
	$a = mysql_fetch_array($s);
	return nf($a[$b]);
  } ?>
<?php foreach($bulten as $a => $i){ ?>
<?php if($sonlig != $i["lig"]){ ?>
<div class="panel panel-gray panel-odds" style="padding-bottom: 0px !important;">
<div class="panel-heading collapsed" data-toggle="collapse" href="#odds" >
<i class="flag flag-<?php  echo replace_tr($i["ulkeisim"]);  ?>" style="height:10px !important;width: 15px !important;margin-right: 10px !important;margin-top:3px; "></i><h4><?php if(isset($i["ulkeisim"])) { echo $i["ulkeisim"];}?> -> <?php if(isset($i["lig"])) { echo $i["lig"];}?></h4></div></div>
<?php } ?>
<div id="match_<?php if(isset($i["id"])) { echo $i["id"];}?>" data-matchid="<?php if(isset($i["id"])) { echo $i["id"];}?>" data-datasource="1" class="CL-OP RND-OP match_list_row event" style="margin-bottom: 10px;">

    <span class="game">          
        <span class="team1"><?php if(isset($i["evsahibi"])) { echo $i["evsahibi"];}?></span>
        <span class="sep"> - </span>
        <span class="team2"><?php if(isset($i["deplasman"])) { echo $i["deplasman"];}?></span>
        <div class="time"><i class="icon-time"></i> <?php echo date("d.m H:i",strtotime($i["tarih"])); ?></div>
    </span>

    <span class="right">
<span class="odds">   
<span class="odd " <?php  echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___1___'.maco($i["id"], 1)).'\');"';  ?>><i>1</i><?php echo maco($i["id"],1) ; ?></span>
<?php if(maco($i["id"],0) > 0){ ?>       
<span class="odd"  <?php  echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___0___'.maco($i["id"], 0)).'\');"';  ?>><i>X</i><?php echo maco($i["id"],0) ; ?></span>
<?php } ?>  
<span class="odd "  <?php  echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___2___'.maco($i["id"], 2)).'\');"';  ?>><i>2</i><?php echo maco($i["id"],2) ; ?></span>
<span class="icon icon-stats active" onclick="StatsDetails(<?php if(isset($i['mackodu'])) { echo $i['mackodu'];}?>)"></span>
        <span class="iconDetails text" onclick="matchDetails(<?php if(isset($i['id'])) { echo $i['id'];}?>, this)">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
        </span>

</span>

    </span>
    
<div class="match_list_sides_2_content" data-id="<?php if(isset($i['id'])) { echo $i['id'];}?>"></div>
</div>
<?php 
$sonlig=$i["lig"];							
 ?>
<?php } ?>
</div>
 <?php } ?>