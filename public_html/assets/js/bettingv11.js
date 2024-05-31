$(function(){


	$(document).on("click",".user-action", function(e){

		e.preventDefault();



		var t = $(this);

		var target = t.data("action");



		switch(target){

			case "login":

				var form = t.data('form');

				$.playgoAJAX._login(t, form);

			break;

			case "signup":

				var form = t.data('form');

				$.playgoAJAX._signup( t, form );

			break;

			case "transfer":
				$.playgoAJAX._transfer( t );
			break;

			case "okeyTavlaTransfer":
				$.playgoAJAX._okeyTavlaTransfer(t);
			break;

			case "poker":
				$.playgoAJAX._poker( t );
			break;

			case "okey":
				$.playgoAJAX._okey(t);
			break;

			case "tombala":
				$.playgoAJAX._tombala(t);
			break;

			case "tombalaTransfer":
				$.playgoAJAX._tombalaTransfer(t);
			break;

			case "betonTransfer":
				$.playgoAJAX._betonTransfer( t );
			break;

			case "xproTransfer":
				$.playgoAJAX._xproTransfer( t );
			break;

			case "livegamesTransfer":
				$.playgoAJAX._liveGamesTransfer( t );
			break;

			case "fargot":
				$.playgoAJAX._fargot(t);
			break;

			case "fargot2":
				$.playgoAJAX._fargot2(t);
			break;

			case "usernamepoker":
				$.playgoAJAX._usernamepoker(t);
			break;

			case "casinoTransfer":
				$.playgoAJAX._casinoTransfer( t );
			break;

			case "bingoTransfer":
				$.playgoAJAX._bingoTransfer( t );
			break;

			case "vivoCanliTransfer":
				$.playgoAJAX._vivoCanliTransfer( t );
			break;

			case "ezugiTransfer":
				$.playgoAJAX._ezugiTransfer( t );
			break;

			case "evolutionTransfer":
				$.playgoAJAX._evolutionTransfer( t );
			break;
			case "goldenTransfer":
				$.playgoAJAX._goldenTransfer( t );
			break;
            case "eBetOnTransfer":
                $.playgoAJAX._eBetOnTransfer( t );
            break;
            case "couponFilter":
                $.playgoAJAX._couponFilter( t );
            break;
            case "balanceUpdate":
                $.playgoAJAX._amount( t );
            break;
		}



	});


	$.playgoAJAX = {

		_login: function(t, form){

			var form = $("#" + form).serialize();

			$.ajax({

				type: 'POST',

				data: form,

				url: '/services/login',

				success: function (data) {

					var json = $.parseJSON(data);

					if (json.vResult == 'TRUE') {

						location.reload();

					} else {

						alert( json.vContent );

					}

				}

			});

		},

        _couponFilter: function(t){
			$(".coupon-btn").removeClass("btn-primary");
			$("#"+t.attr('id')).addClass("btn-primary");
            if (t.data('id') == 100) {
            	$('.coupon-filter').show();
			} else if (t.data('id') == 0) {
                $('.coupon-filter').hide();
                $('.coupon-pending').show();
			} else if (t.data('id') == 1) {
                $('.coupon-filter').hide();
                $('.coupon-won').show();
			} else if (t.data('id') == 2) {
                $('.coupon-filter').hide();
                $('.coupon-lost').show();
			} else if (t.data('id') == 3) {
                $('.coupon-filter').hide();
                $('.coupon-return').show();
			}

        },




        _signup: function(t, form) {

			var form_ = $("#" + form).serialize();

			$.ajax({

				type: 'POST',

				data: form_,

				url: '/services/signin',

				success: function (data) {

					var json = $.parseJSON(data);

					if (json.vResult == 'TRUE') {

						location.reload();

						/* $("#girisForm input[name=username]").val( $("#" + form + " input[name=username]").val() );

						$("#girisForm input[name=password]").val( $("#" + form + " input[name=password]").val() );

						$("#girisForm button").trigger("click"); */

					} else {

						alert( json.vContent );

					}

				}

			});

		},



        _amount: function() {
			$("#balance > i").hide();
			$(".balance").html(" <i class='fa fa-spinner fa-spin'></i>");
            $.ajax({
                type: "GET",
                url: "/myaccount/get_info",
                dataType: "json",
                success: function(c) {
					$("#balance > i").show();
                    $(".balance").html(c.bakiye + " <i class='fa fa-try'></i>");
                    $(".username").html(c.username);
                }
            });
        },

		
		_transfer: function (t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#transferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Klaspoker_transfer",
				data: form,
				success: function(c) {
				$.allBalan._balance();
				alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);

				}
			});
		},

		_okeyTavlaTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#okeyTavlaTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Klasokey_Transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_xproTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#xproTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Xpro_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_tombalaTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#tombalaTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Tombala_transfer",
				data: form,
				success: function(c) {
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_liveGamesTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#livegamesTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Tombala_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_fargot: function(t) {
			var form = $("#fargotForm").serialize();
			$.ajax({
				type: "POST",
				url: "/resetpassword/reset",
				data: form,
				success: function(c) {
					alert(c);
					window.location="/";
				}
			});
		},

		_fargot2: function(t) {
			var form = $("#fargotForm2").serialize();
			$.ajax({
				type: "POST",
				url: "/resetpassword/sifirla",
				data: form,
				success: function(c) {
					alert(c);
					window.location="/";

				}
			});
		},

        _usernamepoker: function(t) {
            $('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
            var form = $("#usernamepokerForm").serialize();
            $.ajax({
                type: "post",
                url: "/games/pokerusernameinsert",
                data: {
                    "usernamepoker": $("#usernamepoker").val()
                },
                dataType: "json",
                success: function(c) {
                    if (c.success) {
                        window.location.href = c.url;
                    } else alert(c.error);
                    $('body').children('#loadoverlay').fadeOut(250);
                    setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
                }

            });



        },

		_betonTransfer: function (t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#betonTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Beton_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_casinoTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#casinoTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/LiveCasino/Transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_bingoTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#bingoTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Bingo/Transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_vivoCanliTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#vivoCanliTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Vivo_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_ezugiTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#ezugiTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Ezugi_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_evolutionTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#evolutionTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/Evolution_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

		_goldenTransfer: function(t) {
			$('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
			var form = $("#goldenTransferForm").serialize();
			$.ajax({
				type: "POST",
				url: "/Account/golden_transfer",
				data: form,
				success: function(c) {
					$.allBalan._balance();
					alert(c);
				$('body').children('#loadoverlay').fadeOut(250);
                setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
				}
			});
		},

        _eBetOnTransfer: function(t) {
            $('body').append('<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>');
            var form = $("#eBetOnTransferForm").serialize();
            $.ajax({
                type: "POST",
                url: "/Account/eBetOn_transfer",
                data: form,
                success: function(c) {
                    $.allBalan._balance();
                    alert(c);
                    $('body').children('#loadoverlay').fadeOut(250);
                    setTimeout(function () { $('body').children('#loadoverlay').remove(); }, 250);
                }
            });
        },

		_poker: function(t) {
			pokerWindow = window.open("/games/pokerusernamechange","PLAYGONETWORK","location=1,status=1,scrollbars=1,width=1280,height=836");
			pokerWindow.moveTo(0, 0);
		},

		_okey: function(t) {
			pokerWindow = window.open("/games/okeyLogin","PLAYGONETWORK","location=1,status=1,scrollbars=1,width=800,height=666");
			pokerWindow.moveTo(0, 0);
		},

		_tombala: function(){
			pokerWindow = window.open("/games/tombala","PLAYGONETWORK","location=1,status=1,scrollbars=1,width=1024,height=836");
			pokerWindow.moveTo(0, 0);
		}

	}



	$(".modalShow").on('click', function(){

		$(".modal-content").load($(this).attr('href'));

	});

	$('#poker_username_post').click(function(){
		$.ajax({
			type: "post",
			url: "/games/pokerusername",
			data: {
				"username": $("#poker_username").val()
			},
			dataType: "json",
			success: function(c) {
				if (c.success) {
					window.location.href = c.url;
				} else alert(c.error);
			}
		});
	});





});
