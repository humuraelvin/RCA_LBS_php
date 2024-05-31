{if empty($bulten)}
<div  align="center" style="padding:5px;">Seçtiğiniz kriterlerde karşılaşma bulunmamaktadır</div>
{else}
<div id="interval-bets-container" class="bets no-padding-sm">     
{php}$sonlig="";
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
  }{/php}
{foreach from="$bulten" item="i" key="a"}
{if $sonlig != $i["lig"]}
<div class="panel panel-gray panel-odds" style="padding-bottom: 0px !important;">
<div class="panel-heading collapsed" data-toggle="collapse" href="#odds" >
<i class="flag flag-{php} echo replace_tr($i["ulkeisim"]); {/php}" style="height:10px !important;width: 15px !important;margin-right: 10px !important;margin-top:3px; "></i><h4>{$i["ulkeisim"]} -> {$i["lig"]}</h4></div></div>
{/if}
<div id="match_{$i["id"]}" data-matchid="{$i["id"]}" data-datasource="1" class="CL-OP RND-OP match_list_row event" style="margin-bottom: 10px;">

    <span class="game">          
        <span class="team1">{$i["evsahibi"]}</span>
        <span class="sep"> - </span>
        <span class="team2">{$i["deplasman"]}</span>
        <div class="time"><i class="icon-time"></i> {php}echo date("d.m H:i",strtotime($i["tarih"]));{/php}</div>
    </span>

    <span class="right">
<span class="odds">   
<span class="odd" {php} echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___1___'.maco($i["id"], 1)).'\');"'; {/php}><i>1</i>{maco($i["id"],1)}</span>
{if maco($i["id"],0) > 0}       
<span class="odd"  {php} echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___0___'.maco($i["id"], 0)).'\');"'; {/php}><i>X</i>{maco($i["id"],0)}</span>
{/if}  
<span class="odd" {php} echo 'onclick="addslip(\''.sifrele($i["id"].'___1X2___2___'.maco($i["id"], 2)).'\');"'; {/php}><i>2</i>{maco($i["id"],2)}</span>
 <span class="icon icon-stats active" onclick="StatsDetails({$i['mackodu']})"></span>
        <span class="iconDetails text" onclick="matchDetails({$i['id']}, this)"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
   
</span>


    </span>
    
<div class="match_list_sides_2_content" data-id="{$i['id']}"></div>
</div>
{php}
$sonlig=$i["lig"];              
{/php}
{/foreach}
</div>
 {/if}