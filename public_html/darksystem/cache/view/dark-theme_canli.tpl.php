<?php if($ajax == "3"){ ?>
<script>


var t;
var a;
var sonid=0;

var refresh;
var ilkmac = 0;

//
var interval;
var ready = 0;


$('#main-left').addClass('sidebar-open');


function left_close(id){
    $('#main-left').removeClass('sidebar-open');
    $('.main-overlay').removeClass('show');
    $("html").removeClass("fix-position");
    $(".livematch-box").removeClass('livematch-active');
    $("[mac-id='"+ id +"']").addClass('livematch-active');

}

    function handleImageError(imageElement) {
    // Resimi değiştir
        console.log("handleImageError tetiklendi!"); // Bu satırı ekleyin

    imageElement.src = '/images/sports-icon/E-Sports.png';
    
    // left-text elementini bul
    var leftTextElement = $(imageElement).parent().next(".left-text");
    
    // left-text içeriğini değiştir
    if(leftTextElement.length > 0) {
        leftTextElement.text('Diğerleri');
    }
}


function livedetails(id,status,intervalStatus){

    if ( ready == 0 ) {

        if ( intervalStatus == 1 ) {
            $("#live_event_info").hide();
            $("#liveLoaders").show();
        }
    
        ready = 1;


        $.ajax({
            url:"/sports/livedetails/"+id,
            success:function(data){
                history.pushState(null, null,'/live/events/'+ id);
                 $('#livematchdetail').html(data);
                 ready = 0;
                 if ( intervalStatus == 1 ) {
                        GetTracker(id);
                        $("#liveLoaders").hide();
                        $("#live_event_info").show();
                }
                 
            }
        });
    
    } else return false;

    
}

setInterval(function(){
    livedetails(window.location.pathname.split('/')[3], 'true', 0);
}, 6000);

$.liveMatches = function() {
    var maclar_ids = {};
    var ulkeler_slugs = {};
    var sporlar_ids = {};

    $.ajax({
        url: "/services/getLiveMatches",
        dataType: "json",
        success: function( c ) {
        
            var Sporlar = Object.keys(c.list);
            

            if ( ilkmac == 0 ) {

                ilkmac = c.list[ Sporlar[0] ][Object.keys(c.list[ Sporlar[0] ])[0]].id;

            
                livedetails(ilkmac,'true',1);
                
                refresh = ilkmac;
                
            }
                
            /* sporlar */
            $.each( c.list, function(i, val) {
                var Spor = i;

                if ( $("#sport-" + val[Object.keys(val)[0]].sport_id).size() == 0 ) {

                    if (val[Object.keys(val)[0]].sport_id == 1) {
                        var collapsed = "collapsed";
                        var colin = "in";
                    } else {

                        var collapsed = "";
                        var colin = "";

                    }
                    
                // ok


    $(".bultenler").append('<div id="liveSportMenux" class="megadiv ' + collapsed +  '" data-toggle="collapse" sport-id="' + val[Object.keys(val)[0]].sport_id + '" onclick="resize();" data-target="#sport-' + val[Object.keys(val)[0]].sport_id + '">' + '<h4 aria-expanded="true">' + '<div class="leftdiv"> <img src="/images/sports-icon/' + Spor + '.png" onerror="handleImageError(this)" /></div>' + '<div class="left-text">' + Spor + '</div>' + '<div class="rightdiv"><span id="b1">' + Object.keys(val).length + '</span></div>' + '</h4>' + '</div>' + '<div class="collapse ' + colin +  '" sport-id="' + val[Object.keys(val)[0]].sport_id + '" id="sport-' + val[Object.keys(val)[0]].sport_id + '"></div>');


                } else {
                    $("[data-target='#sport-"+ val[Object.keys(val)[0]].sport_id +"'] #b1").html( Object.keys(val).length );
                }
                
                $.each( val, function(k, v) {
                    var mac_id = k;
                    var mac = v;

                    maclar_ids[ mac_id ] = true;
                    ulkeler_slugs[ mac['sport_id'] + "_" + mac['country_id'] ] = true;
                    sporlar_ids[ mac['sport_id'] ] = true;

                    // ok
                    if ( $("[ulke='"+ mac['sport_id'] +"_"+ mac['country_id'] +"']").size() == 0 ) {
                        $("#sport-" + mac['sport_id']).append('<div ulke="'+ mac['sport_id'] +'_'+ mac['country_id'] +'" class="countryone collapsed" data-toggle="collapse" data-target="#matches-'+mac['country_id']+'"><span class="countrynamex">'+ mac['country_name'] +'</span></div><div id="matches-'+mac['country_id']+'" class="collapse in" maclar="'+ mac['sport_id'] +'_'+ mac['country_id'] +'"></div>');
                    }



                    if ( $("[mac-id='"+ mac_id +"']").size() == 0 ) {

                    $("[maclar='"+ mac['sport_id'] +"_"+ mac['country_id'] +"']").append('<div mac-id="'+ mac_id +'" class="livematch-box" onclick="livedetails('+ mac_id +',true, 1);left_close('+ mac_id +');"><div class="livematch-info"></div><div class="livematch-name"><p>'+ mac['home'] +'</p><p>'+ mac['visitor'] +'</p></div><span class="livematch-score">'+ mac['score'] +'</span></br><div class="livematch-right"><span class="livematch-detail"> '+ mac['detail'] +'</span><span class="livematch-minute">'+ mac['minute'] +'\' <i class="icon-time"></i></span></div>     </div>');

                    } else {
                        $("[mac-id='"+ mac_id +"']").html('<div class="livematch-info"></div><div class="livematch-name"><p>'+ mac['home'] +'</p><p>'+ mac['visitor'] +'</p></div><span class="livematch-score">'+ mac['score'] +'</span></br><div class="livematch-right"><span class="livematch-detail"> '+ mac['detail'] +'</span><span class="livematch-minute">'+ mac['minute'] +'\'<i class="icon-time"></i> </span></div>');
                    }

                } );

            } );

            localStorage.setItem('maclar_ids', JSON.stringify(maclar_ids));
            localStorage.setItem('ulkeler_slugs', JSON.stringify(ulkeler_slugs));
            localStorage.setItem('sporlar_ids', JSON.stringify(sporlar_ids));

        }
    });

    // localStorage check
    var local_maclar = JSON.parse(localStorage.getItem('maclar_ids')),
        local_ulkeler = JSON.parse( localStorage.getItem('ulkeler_slugs') ),
        local_sporlar = JSON.parse( localStorage.getItem('sporlar_ids') );

    $.each( $("[mac-id]"), function(a,b) {
        if ( typeof local_maclar[$(this).attr('mac-id')] === 'undefined' ) {
            $(this).remove();
        }
    } );

    $.each( $("[maclar]"), function(a,b) {
        if ( typeof local_ulkeler[$(this).attr('maclar')] === 'undefined' ) {
            $("[ulke='"+ $(this).attr('maclar') +"']").remove();
            $(this).remove();
        }
    } );

    $.each( $("[sport-id]"), function(a,b) {
        if ( typeof local_sporlar[$(this).attr('sport-id')] === 'undefined' ) {
            $(this).remove();
        }
    } );


}

$.liveMatches();

setInterval(function(){
   $.liveMatches();
}, 10000);


function resize() {
    setTimeout(function(){
        $('#main-center').height($('.live_left_content').height() + 280);
    }, 300);
}

resize();



</script>


<?php } ?>



<div class="bultenler"></div>