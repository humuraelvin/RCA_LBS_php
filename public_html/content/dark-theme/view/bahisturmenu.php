<?php
function kacadet($tur)
{
    $fmac = mysql_query("select id from maclar where canli='$tur' and tarih>'" . date("Y-m-d H:i:s") . "' order by mackodu asc");
    $tt = mysql_num_rows($fmac);
    return $tt;
}
?>


<script>
$(function() {

    var aktif = false;
    var loading =
        '<div class="loading"><img src="/images/load/loader.gif" width="16" height="16" alt="" /></div>';
    var lig_aktif = false;

    $("#sportsLoaders").show();

    // ajax 1
    $.get('/services/premenu', function(json) {
        $("#sportsLoaders").hide();
        $.each(json.list, function(k, v) {
            if (v.count > 0) {
                $(".sol-spor-listesi").append('<li><a onclick="$.ulkeListele(' + v.id + ', ' + v
                    .sportid +
                    ')"><div  class="megadiv"><h4 class="hmargin" data-toggle="collapse" ><div class="leftdiv"> <i class="' +
                    v.icon + '" style="color:#fff;"></i></div><div class="left-text">' + v
                    .name + ' </div><div class="rightdiv" sport-id="' + v.sportid + '">' + v
                    .count +
                    '</div></h4></div> </a></li><div ulke-liste class="ulke-liste-' + v.id +
                    '"></div>');
            }
        });
    });

    // ajax 2
    $.ulkeListele = function(id, sportid, ele) {

        $("[ulke-liste]").html('');

        $.ajax({
            type: 'POST',
            url: '/sports/bulten/1/' + sportid,
            success: function(data) {
                $('#content').html(data);
                scrollToTop(0);
            }
        });

        if (aktif != id) {

            localStorage.setItem('count', $("[sport-id='" + sportid + "']").html());
            $("[sport-id='" + sportid + "']").html(loading);

            $.post('/services/preCountry', {
                "id": sportid
            }, function(json) {
                $("[sport-id='" + sportid + "']").html(localStorage.getItem('count'));
                $(".ulke-liste-" + id).html('');
                $.each(json.list, function(k, v) {
                    if (v.count > 0) {
                        $(".ulke-liste-" + id).append('<div onclick=\'$.ligListele("' + v
                            .name + '",' + v.id + ', ' + sportid + ', ' + v.countryid +
                            ')\' class="countrySports " style="padding: 0px;left:0px;"><span class="SportsFlag-wrapper"><div class="SportsFlag SportsFlag-' +
                            v.slug + '"></div></span><span class="countrythree">' + v
                            .name + '<span ulke-id="' + v.id +
                            '" class="countrySportsCount">' + v.count +
                            '</span></span></div><div class="lig-liste-' + v.id +
                            '" lig-liste ></div>');
                    }
                });
            });

            aktif = id;

        } else aktif = false;



    }

    // ajax 3
    $.ligListele = function(name, id, sportid, countryid) {

        // ---
        $("[lig-liste]").html('');

        if (lig_aktif != id) {

            localStorage.setItem('count', $("[ulke-id='" + id + "']").html());
            $("[ulke-id='" + id + "']").html(loading);

            fnPreListByCountry(name, sportid);
            $.post('/services/preLeagues', {
                "countryid": countryid,
                "sportid": sportid
            }, function(json) {
                $(".lig-liste-" + id).html('');

                //localStorage.setItem('count', $("[ulke-id='"+ id +"']").html());

                $.each(json.list, function(k, v) {

                    $("[ulke-id='" + id + "']").html(localStorage.getItem('count'));

                    if (v.count > 0) {
                        $(".lig-liste-" + id).append('<div onclick="$.ligBulten(' + v
                            .leaguesid + ', ' + sportid +
                            ')" class="countryone blackbox" style="padding: 0px;left:0px;"><span class="countrytwo" style="padding-left: 15px;text-align: center;margin-top: -2px;"><i class="fa fa-angle-right leaguesIcon" ></i></span><span class="leaguesName">' +
                            v.name.substring(0, 18) +
                            '<span class="countrycount" lig-id="' + v.leaguesid + '">' +
                            v.count + '</span></span></div>');
                    }
                });
            });

            lig_aktif = id;

        } else lig_aktif = false;

    }

    $.ligBulten = function(id, sportid) {
// alert('hehe')
        $('#main-left').removeClass('sidebar-open');
        $('.main-overlay').removeClass('show');
        $("html").removeClass("fix-position");

        localStorage.setItem('count', $("[lig-id='" + id + "']").html());
        $("[lig-id='" + id + "']").html(loading);

        $.ajax({
            type: 'POST',
            url: '/sports/LeagueMatch/' + id + '/' + sportid,
            success: function(data) {
                $("[lig-id='" + id + "']").html(localStorage.getItem('count'));
                $('#content').html(data);
                scrollToTop(0);
            }
        });
    };




});
</script>

<ul class="sol-spor-listesi" style="padding-left: 0px;"></ul>