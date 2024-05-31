{php} include "content/son/view/header.php";{/php}
                {import_js file="jquery.min.js"}
				<script type="text/javascript" src="/content/son/js/jquery.colorbox.js?d"></script>
                {import_js file="yeni/jquery.tinyscrollbar.min.js"}
                {import_js file="yeni/jquery.dataTables.js"}
                {import_js file="yeni/DT_bootstrap.js"}
                {import_js file="ui/jquery.ui.min.js"}
                {import_js file="yeni/icerik.js"}
                <script>var base_url = "{BASE_URL}";</script>
                {import_js file="jquery.pnotify.js"}
                {import_js file="vpb_script.js"}
                {import_js file="jquery.easy-confirm-dialog.js"}
                {import_js file="ui/timepicker.js"}
                {import_js file="iys.js?232s112s"}
                <script>
                    {if $bilgi["canlisure"]==0}
                    var bekleme = 12;
                    {else}
                    var bekleme ={$bilgi["canlisure"]};
                    {/if}
                    {literal}
                        window.alert = function(message) {
                        $.pnotify({
                        animation: 'show',
                                type: 'info',
                                styling: 'bootstrap',
                                text: message
                        });
                        };
						function canlilar() {
									$('#divOrta').html('');
									//$('#bulletin').css("width","660px");
									$('#livemenu').show();
									$('.sport-menu').hide();
                                   $.ajax({
                                    url: "/home/canli",
                                            success: function(data) {
                                           $('#livemenu').html(data).show();
                                            }
                                    });
                                    }
									
	function bultenget(veri) {
                $('#content').html("<center>Yükleniyor</center>");
                $.ajax({
                    url: base_url + "/home/bulten/{/literal}{$idda}{literal}",
                    type: "post",
                    data: veri,
                    success: function(data) {
                        $('#content').html(data);
                    }
                })
            }
						{/literal}
						
						</script>
            {import_css file="colorbox.css?f"}
                {import_css file="jquery.pnotify.default.css"}
                {import_css file="jquery.pnotify.default.icons.css"}
<script>
    {literal}

                                    function oranlar(id) {
                                        $.ajax({
                                            url: "/home/bulten_ayrinti/" + id,
                                            success: function(data) {
                                                $.colorbox({html: data, width: "1000", "height": "auto"});
                                            }
                                        })
                                    }
    {/literal}
</script>
           <div class="content-pro bgmain">
        <div class="content-pro3">
            <div class="content-row">
                <!-- Left -->
                <div class="content-left">
                    <div class="livenow-menuwrap" id="home_live_menu">
                        <div class="livenowalt-title bordertop">
                            <span class="blink-text"><span class="glyphicon glyphicon-record font12"></span> <span>Şu An Canlı</span></span>
                            <span class="badge" id="kaccanlivar">{$tcanli}</span></div>
                        <div class="livenowmenu-content">
                            <ul id="livemenu" class="navprolivenowalt">   
                            </ul>
                        </div>                                  
                    </div>

<div class="sport-menu">
    <div class="main-title bordertop">Spor Bahisleri <span class="badge">{$fmac+$bmac+$tmac}</span></div>
    <ul id="betmenu" class="navpro">
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten')"><span class="sportmain"><i class="sporttype1"></i></span> Futbol <span class="badge">{$fmac}</span></a>
                <ul>
                     {foreach from="$ligleria" item="it" key="key"}
                <li><a href="javascript:;" onclick="getcontent('/home/sports/{$it["ulkeisim"]}');" title="{$it["ulkeisim"]}"><span class="flagmain"><img src="{$it["ligresim"]}" width="16"/></span> <span class="country-name">{$it["ulkeisim"]}</span> <span class="badge">{kacmacvar($it["ulkeisim"])}</span></a>
                    {/foreach}
                        </li>
                </ul>
            </li>
           <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/2')"><span class="sportmain"><i class="sporttype2"></i></span> Basketbol <span class="badge">{$bmac}</span></a>
                <ul>
                </ul>
            </li>
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/5')"><span class="sportmain"><i class="sporttype4"></i></span> Buz Hokeyi <span class="badge">0</span></a>
                <ul>
           
                </ul>
            </li>
 <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/3')"><span class="sportmain"><i class="sporttype36"></i></span> Tenis<span class="badge">{$tmac}</span></a>
                <ul>
           
                </ul>
            </li>
            
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/4')"><span class="sportmain"><i class="sporttype37"></i></span> Voleybol <span class="badge">0</span></a>
              <ul>
           
                </ul>  
            </li>
        
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/29')"><span class="sportmain"><i class="sporttype29"></i></span> Snooker <span class="badge">0</span></a>
                <ul>
                    
                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/55')"><span class="sportmain"><i class="sporttype5"></i></span> Hentbol <span class="badge">0</span></a>
               <ul>
                    
                </ul> 
            </li>
        
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/6')"><span class="sportmain"><i class="sporttype6"></i></span> Beyzbol <span class="badge">0</span></a>
                <ul>
                    
                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/23')"><span class="sportmain"><i class="sporttype23"></i></span> Futsal <span class="badge">0</span></a>
                <ul>
            
                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)"  onclick="getcontent('home/bulten/1/24')"><span class="sportmain"><i class="sporttype24"></i></span> Golf <span class="badge">0</span></a>
                <ul>

                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)"  onclick="getcontent('home/bulten/1/28')"><span class="sportmain"><i class="sporttype28"></i></span> Rugby <span class="badge">0</span></a>
                <ul>

                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)"  onclick="getcontent('home/bulten/1/22')"><span class="sportmain"><i class="sporttype22"></i></span> Floorball <span class="badge">0</span></a>
        <ul>

                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)" onclick="getcontent('home/bulten/1/17')"><span class="sportmain"><i class="sporttype17"></i></span> Motor Sporlari <span class="badge">0</span></a>
                 <ul>
                    
                </ul>
            </li>
        
            <li id="menumain"><a href="javascript:void(0)"  onclick="getcontent('home/bulten/1/16')"><span class="sportmain"><i class="sporttype16"></i></span> Kriket <span class="badge">0</span></a>
                 <ul>

                </ul>
            </li>
    </ul>
</div>
                                        
                    <!-- Left Bottom Hizmet -->
                    <div>
                        <div class="sport_services">
                            <div class="second-title bordertop accordion-toggle" data-toggle="collapse" data-target="#sport_services">
                                <span class="glyphicon glyphicon-flash font12"></span> Spor Servisleri</div>
                            <ul class="listmenu accordian-body collapse in" id="sport_services">
                                <li>
                                    <a href="/process/livescore"><span class="glyphicon glyphicon-sound-5-1"></span> Canlı Sonuçlar</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="statistics('index',1)"><span class="glyphicon glyphicon-stats"></span> İstatistikler</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End of Left -->
                <!-- Center -->
                <div class="content-center">
                    <div id="content">
         
                    </div>
                </div>
                <!-- End of Center -->
                <!-- Right -->
                <div class="content-right">
                    <div id="coupon_block">
                        
<div class="kupon-pro-fixed">
<div class="kupon-pro">
    <div class="loading"><div class="imgload"></div></div>
   <!-- Kupon Title -->
   <div class="kupon-titlewrap bordertop">
        <div class="kupon-title bordertop">
            <span class="glyphicon glyphicon-list"></span> <h1>Bahis Kuponu</h1>
            <a onclick="setCouponPosition(this);" class="change-static" title="Kuponu sabitle"></a> 
        </div>
     </div>
   <!-- // Kupon Title -->
   
   <div class="kupon-wrap">
       <!-- Kupon Content -->
       <div class="kupon-pro-icon-line">

           <a onclick="kupontemizle();" class="kupon-icons">
                <span class="glyphicon glyphicon-remove font10"></span>
                <b>Kuponu Temizle</b>
            </a>
        </div>
       <div class="kupon-pro-content" id="kupon_content">
        
           
      {php}$canlis=0;{/php}

                                                <table class="kuponum" style="padding-top:5px; width:100%;">
                                                    <tbody >
													<tr>
													<td  id="kupon">
													
                                                        {foreach from="$okupon" item="z" key="k"}
                                                       <div class="kupon-pro-selection kupon-pro-sel-item mac{$z["macid"]}" >
                <div class="kupon-pro-selection-block kupon-block1">
                    
                    <span class="kupon-event" title="{$z["evsahibi"]}-{$z["deplasman"]}">{$z["evsahibi"]}-{$z["deplasman"]}</span>
                    <span class="kupon-delete pull-right" onclick="mackaldir('{$z["id"]}', '{$z["macid"]}');"></span>  
                </div>

                <div class="kupon-pro-selection-block">
                    <span class="kupon-selection-name">Tercih: {$z["tur"]}</span>
                    <span class="kupon-rate pull-right add">{nf($z["oran"])}</span>    
                </div>
 </div>
													
                                                                    {php}
                    if($z["canli"]=="1"){
                        $canlis=1;
                    }
$bosmula=1;
                                                                    {/php}
                                                                {/foreach}
														</td>
														</tr>	
                                                    </tbody>
                                                </table>
            
                    <input type="hidden" id="kcanli" value="{$canlis}" />
           
       </div>
       <!-- // Kupon Content -->
       <!--  Kupon Alt -->
       <div class="kupon-pro-alt borderbottom">

           <div class="kupon-pro-combine">
               Kombine
               <span class="oran">Toplam Oran: <b id="kupon_combine_odd">{nf(round($toporan,2))}</b></span>
           </div>
           
           <div class="kupon-pro-combine-content">
               <div class="kupon-pro-selection-block">
                   <span class="kupon-single-amount">
                       <div class="input-group input-group-xxsm">
                           <input type="text" class="form-control combine_amount kmiktar" onkeyup="{literal}kazanchesapla(); if (event.keyCode == 13){kuponkaydet(); }{/literal}" placeholder="0.00">
                           <span class="input-group-addon kupon-currency"> TL</span>
                       </div>
                   </span>
                                  <span class="kupon-win-amountw">Olası Kazanç: <b id="kupon_combine_amount">0.00</span></b>
               </div>
           </div>

           <div class="kupon-pro-selection-block-button">
<div class="kupon-pro-ratechange">
               
               <label class="ratechange-label"><input type="checkbox" name="accept" id="coupon_accept" >Oran değişikliklerini kabul ediyorum</label>
                
            </div>               <input type="hidden" name="cptk" id="cptk" value="">
               <a onclick="kuponkaydet();" class="kupon-pro-button"><span id="coupon-dobet-btn">Bahis Yap </span><span class="glyphicon glyphicon-chevron-right"></span> </a>
    
           </div>
       </div>
       <!-- // Kupon Alt -->
   </div>
 
</div>
</div>

                    <div class="search-block">
                        <div class="searchmsg">
                            <div class="searcherror" style="display: none;" id="search_error_box">
                                <div class="searchblock">Arama yapmak için en az 4 harfli bir kelime yazmalısınız.</div>
                            </div>
                            <div class="form-group">
                                <p class="footer-text upper font16">Takım / Ülke Arama</p>
                                <input type="text" class="form-control" id="search_string" onkeyup="bultenget('mantican=' + $(this).val())">
                            </div>
                        </div>
                        <div class="search-icon pointer"> <span class="glyphicon glyphicon-search font18"></span> </div>
                    </div>
                    <div class="right-area">
                        
                    </div>
                </div>
                <!-- End of Right -->
                <div class="hidden" id="livehome-showall-lbl">Hepsini Göster </div>
                <div class="hidden" id="livehome-showmin-lbl">Daha Az Göster </div>
            </div>
        </div>
    </div>
    <!-- End of Content -->
	<!-- Fixture Modal -->
<div class="modal fade" id="modalPanelFixture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div><!-- /.modal -->
	<!-- Dynamic Content Modal -->
<div class="modal fade" id="modalDynContentPanel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-vertical-centered">
        <div class="modal-content">
            <div class="loading" style="display: none;">
                <span class="imgload"></span>
            </div>
            <a data-dismiss="modal" aria-hidden="true" class="glyphicon glyphicon-remove modalclose"></a>
            <div class="modal-body">
                <div  id="modalPanelDynContentBody"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{php} include "content/son/view/footer.php";{/php}