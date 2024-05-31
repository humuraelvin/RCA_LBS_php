{php} include "content/dark-theme/view/dark_header2.php";{/php}

<div class="navbar-title visible-sm visible-xs">

    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-arrow-left"></i> </button>

    <a href="javascript:window.location.href=window.location.href" class="page-title"><i class="icon-football"></i> SPOR</a>

    <button type="button" class="navbar-toggle toggle-right" data-toggle="sidebar" data-target=".sidebar-right" style="display: none;" > <i class="icon-betslip"></i>

        <span id="mobile-bet-counter" class="bet-counter displaynone">1</span>

    </button>

</div>

<section id="main " class="sportbook-theme" style="">

    <div class="container">

        <div id="main-panel" class="row have-sidebar-right1 have-sidebar-left">

            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano">

                <div class="left-container nano-content">




                    <div class="form-group form-icon">

                        <i class="icon-search"></i>

                        <input type="text" id="header_search_input" onkeyup="{literal}if (event.keyCode == 13){fnPreListBySearch();}{/literal}" class="form-control" autocomplete="off" placeholder="Maç Ara" />

                    </div>




                    <div class="" style="height:35px;width: 100%;margin-bottom: 10px">
                        <ul style="margin:0px !important;padding: 0px !important;">
                            <li data-hour="86400" class="hour-li CL-OP RND-OP newst " >Hepsi</li>
                            <li data-hour="21" class="hour-li CL-OP RND-OP newst " >Bugün</li>
                            <li data-hour="6" class="hour-li CL-OP RND-OP newst " >6 Saat</li>
                            <li data-hour="1" class="hour-li CL-OP RND-OP newst " >1 Saat</li>
                        </ul>
                    </div>

                    <a href="/statics/livescore" target="_blank">
                        <div class="betCouponsHeader" style="margin-bottom: 10px;margin-left: -15px;margin-right: -15px;">
                            <i class="icon-stats"></i> ISTATISTIK
                        </div>
                    </a>

                   
                        <div class="betCouponsHeader" style="margin-left: -15px;margin-right: -15px;">
                             <i class="icon-stats"></i> POPÜLER LİGLER
                        </div> 
                    

                    {literal}
                        <style type="text/css">
                            .league_item {
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                border-bottom: 1px solid #ebebeb;
                                margin-left: -15px;margin-right: -15px;
                                background-color:#0f853d;
                               /* background-image: -webkit-linear-gradient(top, #fff, #f8f8f8);
                                background-image: -moz-linear-gradient(top, #fff, #f8f8f8);
                                background-image: -ms-linear-gradient(top, #fff, #f8f8f8);
                                background-image: -o-linear-gradient(top, #fff, #f8f8f8);
                                background-image: linear-gradient(to bottom, #fff, #f8f8f8);*/
                                color:#fff;
                                font-weight: 600;
                            }

                            .league_img {
                                height: 33px;
                                width: 68px;
                                background-size: cover;
                                background-repeat: no-repeat;
                                background-position: -10px;
                                transition: all .2s ease;
                            }

                            .league_item:hover .league_img {
                                background-position: -3px
                            }

                            .league_item:hover .league_name {
                                color:#fff;
                            }




                        </style>
                    {/literal}


                   <div id="leftbar">
                        <div class="p_left_side">
                           <div class="popular_leagues">
                                <a onclick="$.ligBulten(1000000151, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/cca01456496aab1076f14050cb3d8333.png&quot;);"></div>
                                    <div class="league_name">Türkiye Süper Lig</div>
                                </a>
                                <a onclick="$.ligBulten(1000000262, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/466369f654326a0f536682125a465de1.png&quot;);"></div>
                                    <div class="league_name">Türkiye 1. Lig</div>
                                </a>
                                <a onclick="$.ligBulten(1000000097, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/fd9ca5f14490e65c325c5735479a2123.png&quot;);"></div>
                                    <div class="league_name">İngiltere Premier Lig</div>
                                </a>
                                <a onclick="$.ligBulten(1375, 12)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/75b18717277c66e93b4cf487d1ce0104.png&quot;);"></div>
                                    <div class="league_name">NBA Basketbol Ligi</div>
                                </a>
                                <a onclick="$.ligBulten(1000000149, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/fb2a646e9e3891618abdd6cb9c11c405.png&quot;);"></div>
                                    <div class="league_name">Ispanya La Liga</div>
                                </a>
                                <a onclick="$.ligBulten(1000000279, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/118dac9488ddd3b586a592a016d4e37f.png&quot;);"></div>
                                    <div class="league_name">Almanya Bundesliga</div>
                                </a>
                                <a onclick="$.ligBulten(1000000283, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/f341fc679784338583bc65f56f62b15f.png&quot;);"></div>
                                    <div class="league_name">Italya Serie A</div>
                                </a>
                                <a onclick="$.ligBulten(1000000104, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/bfca6150abaea9a2dbac2e1e8233455e.png&quot;);"></div>
                                    <div class="league_name">Fransa Ligue 1</div>
                                </a>
                                <a onclick="$.ligBulten(1000000490, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/1d8e2def7c948013c63ab02c962d5f57.png&quot;);"></div>
                                    <div class="league_name">Belçika - 1.Lig A</div>
                                </a>
                                <a onclick="$.ligBulten(1000000306, 0)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/209de48f29953b02cdcba04235727b99.png&quot;);"></div>
                                    <div class="league_name">Brezilya - Serie A</div>
                                </a>
                                <a onclick="$.ligBulten(1000007768, 4)" class="league_item">
                                    <div class="league_img" style="background-image: url(&quot;/uploads/leagues/6b205efb5c1da952221aa71987ad8e8d.png&quot;);"></div>
                                    <div class="league_name">WTA Tenis</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- populer link-->

                    <ul class="list-unstyled sport-menu event-menu no-padding">

                        <li class="betCouponsHeader" style="margin-bottom: 0px;text-align: center;"> <a >Spor Bahisleri</a>  </li>


                            <div id="live-menu-holder" style="border:none !important;">

                                <div data-reactroot="">
                                    <div id="sportsLoaders" class="loaderSport"></div>

                                    <div class="subCategories live-sports async-menu all-events sub-sport-menu" id="live-menu" style="border:none;">

                                        <div class=" panel-default border-sm" style="border:none !important;">

                                            <div class="left_content CL-OP RND-OP" style="left: 0px;">



                                                {php} include "content/dark-theme/view/bahisturmenu.php";{/php}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                    </ul>

                </div>

            </div>



            <div id="main-center" style="min-height: 800px;padding-top: 5px;">

                <div class="center-container">


                    <div id="event-slider" class="carousel slide panel no-padding-sm" data-ride="carousel" style="display: none;">
                        <ol class="carousel-indicators">
                            <li data-target="#event-slider" data-slide-to="0" class="active"></li>
                            <li data-target="#event-slider" data-slide-to="1" class=""></li>
                        </ol>

                        <div class="carousel-inner" role="listbox">
                            <div id="fevent-0" class="cursor-pointer item fevent-holder active" data-related-event="0" data-stream-icon="false" > <img src="/uploads/sportsbook/sports-center1.png"></div>
                            <div id="fevent-0" class="cursor-pointer item fevent-holder "  data-related-event="0" data-stream-icon="false" ><img src="/uploads/sportsbook/sports-center2.png"></div>
                        </div>

                        <a class="left carousel-control hidden-xs" href="#event-slider" data-slide="prev">
                            <span class="glyphicon-chevron-left icon-arrow-left"></span> <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control hidden-xs" href="#event-slider" data-slide="next">
                            <span class="glyphicon-chevron-right icon-arrow-right"></span> <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="content_center" id="content">

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

                            {if $i["lig"]  != ""}

                            {if $sonlig != $i["lig"]}

                            <div class="panel panel-gray panel-odds" style="padding-bottom: 0px !important;">

                            <div class="panel-heading collapsed" data-toggle="collapse" href="#odds" >

                            <i class="flag flag-{php} echo replace_tr($i["ulkeisim"]); {/php}" style="height:10px !important;width: 15px !important;margin-right: 10px !important;margin-top:3px; "></i><h4>{$i["ulkeisim"]} -> {$i["lig"]}</h4></div></div>

                            {/if}

                            <div id="match_{$i["id"]}" data-matchid="{$i["id"]}" data-datasource="1" class="CL-OP RND-OP match_list_row event" >



                                <span class="game">

                                    <span class="team1">{$i["evsahibi"]}</span>

                                    <span class="sep"> - </span>

                                    <span class="team2">{$i["deplasman"]}</span>

                                    <div class="time"><i class="icon-time"></i> {php}echo date("d.m H:i",strtotime($i["tarih"]));{/php}</div>

                                </span>



                                <span class="right">

                                    <span class="odds">

                                        <span class="odd "  {php} echo 'onclick="addslip(\''.sifrele($i["id"]."___1X2___1___".maco($i["id"],1)).'\');"'; {/php}><i>1</i>{maco($i["id"],1)}</span>

                                        {if maco($i["id"],0) > 0}

                                        <span class="odd "  {php} echo 'onclick="addslip(\''.sifrele($i["id"]."___1X2___0___".maco($i["id"],0)).'\');"'; {/php}><i>X</i>{maco($i["id"],0)}</span>

                                        {/if}

                                        <span class="odd"  {php} echo 'onclick="addslip(\''.sifrele($i["id"]."___1X2___2___".maco($i["id"],2)).'\');"'; {/php}><i>2</i>{maco($i["id"],2)}</span>

                                    <span class="icon icon-stats active" onclick="StatsDetails({$i['mackodu']})"></span>

                                    <span class="iconDetails text" onclick="matchDetails({$i['id']}, this)"><i class="fa fa-plus-square" aria-hidden="true"></i></span>


                                    </span>




                                </span>

                                <div style="clear: both"></div>



                            <div class="match_list_sides_2_content" data-id="{$i['id']}"></div>

                            </div>

                            {php}

                            $sonlig=$i["lig"];

                            {/php}

                            {/if}

                            {/foreach}

                        </div></div></div></div>



            <div id="main-right1" class="sidebar sidebar-right sidebar-animate sidebar-md-show nano">
                <div class="right-container nano-content" >
                    <div id="betslip" data-show-history="" >
                        <div class="panel-placer"></div>

                        <div class="betCouponsHeader">
                            <i class="icon-betslip"></i> BAHİS KUPONU

                            <div class="reset-coupon">
                                <a class="icon-trash"></a>
                            </div>

                        </div>

                        <div class="right_coupon CL-OP RND-OP"></div>
                    </div>
                </div>
            </div>

            <div class="main-overlay"></div>
        </div>
    </div>


    <div id="betSlipHeader"  data-toggle="sidebar" data-target=".sidebar-right" style="display: none; text-align: center; right:15px;">
        <div class="betSlipBlock">
            <div class="BetslipInner isSelectionInBetslip">
                <div class="count-in-betslip" style="display: block;">1</div>
                <div class="betslip-sign">Kupon</div>
            </div>
        </div>
    </div>

</section>

{php} include "content/dark-theme/view/dark_footer.php";{/php}