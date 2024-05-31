$(function () {

    var path = window.location.pathname;

    bet = {

        openVirtualGame: function (t) {
            $(".remodal-overlay").fadeIn("slow");
            axios({
                method: 'GET',
                url: '/GoldenRace/Game/'+t.data('id')
            }).then(obj => {
                if (obj.data.status == true) {
                    if(window.matchMedia("(max-width: 767px)").matches){
                        window.open(obj.data.url,"GoldenRace","width=1100,height=836");
                    } else{
                        $(".virtualgames").empty();
                        $(".virtualgames").append('<iframe src="'+obj.data.url+'" class="virtualFrame"></iframe>');
                    }
                    $(".remodal-overlay").fadeOut("slow");
                } else {
                    $(".remodal-overlay").fadeOut("slow");
                    Ply.dialog("alert",{ effect: "3d-sign" }, obj.data.message);
                }
            });
        },
    };


    $(document).on("click",".nw-action", function(e){
        e.preventDefault();
        var t = $(this);
        bet[t.data("action")](t);
    });
});
