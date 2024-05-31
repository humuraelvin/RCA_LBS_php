$(function(){





	jQuery(document).on('keyup',function(evt) {
		if (evt.keyCode == 27) {
		   return false;
		}
	});

	$('.ajaxForm').submit(function(){ return false; });
	$('.ajaxUrl').click(function(e){ e.preventDefault(); });

	/* Static */
	var $popupForm 		= $("#popup_form");
	var $popupFormInner = $("#popup_form .form");

	// Modal Form
	var $modalForm		= $("#modalForm");
	var $modalFormButtons = $("#modalForm .footer-buttons");
	var $modalFormTitle = $("#modalForm").find('.panel-title');

	// Load
	var $loader = $("#loading_bar");

	/* Ajax Options */
	$.ajaxSetup({
		type: "POST",
		url: SITE_URL + "/ajax/admin.ajax.php",
		dataType: "json"
	});

	/* Ajax */
	$(document).on("click",".admin-action", function(e){
		e.preventDefault();

		var t = $(this);
		var hedef = t.data("action");

		if (t.data('popup') == true) {
			localStorage.setItem("popup", "active");
		}

		switch(hedef){

			// AJAX Page //
			case "page":
				$loader.fadeIn("slow");
				var url = t.attr('href');
				var slash = url.slice(-1);
				if (slash != '/') {
					url = url + '/';
				}
				$.ajax({
					url: url + '&ajax=true',
					dataType: "html",
					success: function(c){
						// $("body").addClass("loading-overlay-showing").attr('data-loading-overlay');
						history.pushState('', '', url);
						$(".content-body").html(c);
						init(url);
						$loader.fadeOut("slow");
					}
				});
			break;

			case "adminGiris":
				$.adminAJAX._adminGiris(t);
			break;
			// ANASAYFA //
			case "adminKuponGrafik":
				$.adminAJAX._adminKuponGrafik(t);
			break;
			// ANASAYFA //
			case "adminKullanicilar":
				var sayfa = t.data("sayfa");
				$.adminAJAX._adminKullanicilar(t, sayfa);
			break;
			case "adminKullaniciDuzenle":
				// $("#popup_form .form").css("left", "40%");
				// $("#popup_form").fadeIn("slow");
				var id = t.data("id");
				if (t.data('type') != 'update') {
					$.adminAJAX._adminKullaniciBilgi(t, id);
				} else $.adminAJAX._adminKullaniciDuzenle(t, id);
			break;
			case "adminKullaniciSifreDegistir":
				var id = t.data("id");
				var type = t.data("type");

				if (type == "ajax") {
					$.ajax({
						data: $("#kullaniciSifreDegistirForm").serialize() + "&tip=adminKullaniciSifreDegistir",
						success: function (c) {
							if (c.success) {
								alert("Başarıyla Güncellenmiştir!");
							} else alert(c.error);
						}
					});
				}
			break;
			case "adminKullaniciSayfa":
				var page = t.attr("data-page");
				$.adminAJAX._adminKullaniciSayfa(t, page);
			break;
			case "adminKullaniciSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._adminKullaniciSil(t, t.data('id'));
				});
			break;
			case "adminPromosSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._adminPromosSil(t, t.data('id'));
				});
			break;
			case "adminKullaniciFinansalIslemler":
				$.adminAJAX._adminKullaniciFinansalIslemler(t, t.data('id'));
			break;
			case "adminBakiyeGonder":
				if (t.data('id')) {

					localStorage.adminGeriDon = JSON.stringify({
						url: window.location.href,
						html: $(".content-body").html()
					});

					$.ajax({
						url: SITE_URL + '/bakiye/'+ t.data('id') +'/&ajax=true',
						type: "post",
						data: {"type": "adminGeriDon", "islem": t.data('type')},
						dataType: "html",
						success: function(c){
							history.pushState('', '', SITE_URL + '/bakiye/' + t.data('id') + '/');
							$(".content-body").html(c);
							init();
						}
					});

				} else {
					$.adminAJAX._adminBakiyeGonder(t);
				}
			break;
			case "adminGeriDon":
				if (typeof localStorage.adminGeriDon != "undefined") {
					var values = JSON.parse(localStorage.adminGeriDon);
					history.pushState('', '', values.url);
					$(".content-body").html(values.html);
				}
			break;
			case "adminBakiyeListele":
				var sayfa = t.data("sayfa");
				$.adminAJAX._adminBakiyeListele(t, sayfa);
			break;
			case "adminBakiyeRapor":
				$.adminAJAX._adminBakiyeRapor(t);
			break;
			case "cacheClear":
				swal({
					title: "UYARI",
					text: "Önbellek temizlenecektir.",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._cacheClear(t);
				});

			break;
			case "adminKuponHareketleri":
				$.adminAJAX._adminKuponHareketleri(t);
			break;
			case "adminKuponlar":
				var sayfa = t.data("sayfa");
				$.adminAJAX._adminKuponlar(t, sayfa);
			break;
			case "adminKuponGuncelle":
				var id = t.data("id"),
					durum = t.data("durum");

				/*swal({
					title: "Emin misin?",
					text: id + " numaralı kupon guncellenecektir.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Evet, eminim.",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) { */
						$.adminAJAX._adminKuponGuncelle(t, id, durum);
				/*	} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});*/

			break;
			case "adminKuponMacGuncelle":
				var id = t.attr('data-id'),
						durum = t.attr('data-durum');

				swal({
					title: "Emin misin?",
					text: id + " numaralı maç guncellenecektir.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Evet, eminim.",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminKuponMacGuncelle(t, id, durum);
					} else swal("Iptal edildi!", "Isleme devam edebilirsiniz!", "warning");
				});
			break;
			case "adminKuponIade":
				var id = t.data("id");

				swal({
					title: "Emin misin?",
					text: id + " numaralı kupon iade edilecektir.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Evet, eminim.",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminKuponIade(t, id);
					} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});

			break;
			case "adminKuponMacIade":
				var id = t.data("id");

				swal({
					title: "Emin misin?",
					text: id + " numaralı kupondaki maç iade edilecektir.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Evet, eminim.",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminKuponMacIade(t, id);
					} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});

			break;
			case "adminKullaniciKuponlari":
				var id = t.data("id");
				localStorage.setItem("returnUrl", window.location.href);
				$.ajax({
					url: SITE_URL + '/kuponlar/&ajax=true',
					type: "post",
					data: {"kullanici": id, "popup": true},
					dataType: "html",
					success: function(c){
						//localStorage.setItem("popup", "active");
						history.pushState('', '', SITE_URL + '/kuponlar/');
						//$popupFormInner.css("left", "10%");
						//$popupForm.fadeIn("slow");
						//$popupFormInner.html(c);
						//alert("ok");
						$modalFormTitle.text('Kullanıcı Kuponları');
						$modalForm.find('.panel-body').html(c);
						$modalFormButtons.html('\
							<button class="btn btn-default modal-dismiss">Kapat</button>\
						');
						$modalForm.css("max-width", "980px");
						init();
					}
				});
			break;
			case "adminKuponDetay":
				var id = t.data("id");
				//t.parent().style("background", "#000");
				$("table tr").removeClass("row-active");
				t.parents("tr").addClass("row-active");
				localStorage.setItem("returnUrl", window.location.href);
				$.ajax({
					url: SITE_URL + '/kupon/' + id + '/&ajax=true',
					type: "post",
					data: {"kullanici": id, "popup": true},
					dataType: "html",
					success: function(c){
						//localStorage.setItem("popup", "active");
						history.pushState('', '', SITE_URL + '/kuponlar/');
						//$popupFormInner.css("left", "15%");
						//$popupForm.fadeIn("slow");
						//$popupFormInner.html(c);
						$modalFormTitle.text('Kupon Detay');
						$modalForm.find('.panel-body').html(c);
						$modalFormButtons.html('\
							<button class="btn btn-default modal-dismiss">Kapat</button>\
						');
						$modalForm.css("max-width", "980px");
						init();
					}
				});
			break;
			// sms
			case "adminSmsGonder":
				if (t.data('id')) {

					localStorage.adminGeriDon = JSON.stringify({
						url: window.location.href,
						html: $(".content-body").html()
					});

					$.ajax({
						url: SITE_URL + '/smsekle/'+ t.data('id') +'/&ajax=true',
						type: "post",
						data: {"type": "adminGeriDon"},
						dataType: "html",
						success: function(c){
							history.pushState('', '', SITE_URL + '/bakiye/' + t.data('id') + '/');
							$(".content-body").html(c);
							init();
						}
					});

				} else {
					$.adminAJAX._adminSmsGonder(t);
				}
			break;
			case "adminMacDuzenle":
				var id = t.data("id");
				$.adminAJAX._adminMacDuzenle(t, id);
			break;
			case "adminMacGuncelle":
				var id = t.data("id");
				$.adminAJAX._adminMacGuncelle(t, id);
			break;
			case "adminMacBultenGuncelle":
				var id = t.data("id"),
					value = t.data("value");
				$.adminAJAX._adminMacBultenGuncelle(t, id, value);
			break;
			// Banka İşlemleri //
			case "adminBankaYatirimTalepOnayla":
				var id = t.data("id");
				swal({
					title: "Emin misin?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#23CF5F",
					confirmButtonText: "Devam",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminBankaYatirimTalepOnayla(t, id);
					} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});
			break;
			case "adminBankaYatirimTalepSil":
				var id = t.data("id");
				swal({
					title: "Emin misin?",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
				}, function() {
					$.adminAJAX._adminBankaYatirimTalepSil(t, id);
				});
			break;
			case "adminBankaYatirimTalepDetay":
				var id = t.data("id");
				$.adminAJAX._adminBankaYatirimTalepDetay(t, id);
			break;
			case "adminBankaCekimTalepOnayla":
				var id = t.data("id");
				swal({
					title: "Emin misin?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#23CF5F",
					confirmButtonText: "Devam",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminBankaCekimTalepOnayla(t, id);
					} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});
			break;
			case "adminBankaCekimTalepBekleyen":
				var id = t.data("id");
				swal({
					title: "Emin misin?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#23CF5F",
					confirmButtonText: "Devam",
					cancelButtonText: "Iptal",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.adminAJAX._adminBankaCekimTalepBekleyen(t, id);
					} else swal("Iptal edildi.", "İşleme devam edebilirsiniz.", "error");
				});
			break;
			case "adminBankaCekimTalepSil":
				var id = t.data("id");
				swal({
					title: "Emin misin?",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
				}, function() {
					$.adminAJAX._adminBankaCekimTalepSil(t, id);
				});
			break;
			case "adminBankaCekimTalepDetay":
				var id = t.data('id');
				$.adminAJAX._adminBankaCekimTalepDetay(t, id);
			break;
			case "adminBankaCekimTalepNot":
				var id = t.data('id');
				$.adminAJAX._adminBankaCekimTalepNot(t, id);
			break;
			case "adminBankaYatirim":
				$.adminAJAX._adminBankaYatirim(t);
			break;
            case "adminSiteSettings":
                $.adminAJAX._adminSiteSettings(t);
                break;
            case "adminSettings":
                $.adminAJAX._adminSettings(t);
                break;
			case "adminKullaniciTab":
				$loader.fadeIn("slow");
				var url = window.location.href;
				var data;
				if (t.data('page') == 'hareketler') {
					data = 'islem=' + t.data('islem');
				}
				$.ajax({
					url: SITE_URL + '/profil/'+t.data('id')+'/'+ t.data('page') +'&ajax=true',
					dataType: "html",
					data: data,
					success: function(c){
						// $("body").addClass("loading-overlay-showing").attr('data-loading-overlay');
						history.pushState('', '', SITE_URL + '/profil/'+t.data('id')+'/'+ t.data('page'));
						$(".tab-content").html(c);
						init(url);
						$loader.fadeOut("slow");
					}
				});
			break;
			case "adminKullaniciTab_FormGuncelle":
				var id = t.data('id');
				$.adminAJAX._adminKullaniciTab_FormGuncelle( t , id );
			break;
			case "adminKullaniciTab_Hareketler":
				$.adminAJAX._adminKullaniciTab_Hareketler( t );
			break;
			case "adminKullaniciTab_Bahis":
				$.adminAJAX._adminKullaniciTab_Bahis( t );
			break;
			case "adminKullaniciTab_StatusDegistir":
				var values = $.parseJSON( t.attr('data-values') );
				$.ajax({
					data: $.param(values) + "&tip=adminKullaniciTab_FormGuncelle",
					success: function(c) {
						if (c.error) {
							swal("Opps!", c.error, "error");
						} else {
							if ( values[t.attr('data-name')] == 1 ) {
								t.html('<i class="fa fa-check"></i> Açık');
								t.attr('data-values', '{"'+t.attr('data-name')+'": 0, "id": '+ values.id +'}');
							} else {
								t.html('<i class="fa fa-remove"></i> Kapalı');
								t.attr('data-values', '{"'+t.attr('data-name')+'": 1, "id": '+ values.id +'}');
							}
						}
					}
				});
			break;
			case "adminGenelRapor":
				$.ajax({
					data: {
						"baslangic": $("input[name=baslangic]").val(),
						"bitis": $("input[name=bitis]").val(),
						"tip": "adminGenelRapor"
					},
					type: "post",
					dataType: "json",
					success: function(c){

						$.each(c, function(a) {
						  $.each(this, function(k, v) {
							  if (v != null && typeof v == 'object') {
								  $.each(this, function(sk, sv) {
									  $("." + a + "." + k + "." + sk).html(sv);
								  });
							  } else {
								  //v = (typeof v == 'object' ? 0 : v);
								  $("." + a + "." + k).html(v);
							  }
						  });
						});
					}
				});
			break;

			// Bonus 02.09.2016 //
			case "adminBonusGonder":
				var form = $("#bonusGonderForm").serialize() + "&id=" + t.data('id') + "&tip=adminBonusGonder";
				$.adminAJAX._adminBonusGonder( t, form );
			break;


			// Rakeback 07.09.2016 //
			case "adminRakebackGonder":
				var form = $("#rakebackGonderForm").serialize() + "&id=" + t.data('id') + "&tip=adminRakebackGonder";
				$.adminAJAX._adminRakebackGonder( t, form );
			break;

			case "adminDiscountGonder":
				var form = $("#discountGonderForm").serialize() + "&id=" + t.data('id') + "&tip=adminDiscountGonder";
				$.adminAJAX._adminDiscountGonder( t, form );
			break;

			case "adminCanliDiscountGonder":
				var form = $("#canliDiscountGonderForm").serialize() + "&id=" + t.data('id') + "&tip=adminCanliDiscountGonder";
				$.adminAJAX._adminCanliDiscountGonder( t, form );
			break;

			case "adminBannerSil":
				var id = t.data('id');
                $.adminAJAX._adminBannerSil(t, id);
			break;

			case "adminSportActive":
                var id = t.data('id');
                var name = t.data('name');
                var durum = (t.is(':checked')) ? '1' : '0';
				$.adminAJAX._adminSportActive(t, id, name, durum);
			break;



			case "adminYoneticiEkle":
				$.adminAJAX._adminYoneticiEkle( t );
			break;

			case "adminYoneticiSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._adminYoneticiSil(t, t.data('id'));
				});
			break;

			case "adminYonetimTab":
				$loader.fadeIn("slow");
				var url = window.location.href;
				var data;
				if (t.data('page') == 'hareketler') {
					data = 'islem=' + t.data('islem');
				}
				$.ajax({
					url: SITE_URL + '/yonetici/'+t.data('id')+'/'+ t.data('page') +'&ajax=true',
					dataType: "html",
					data: data,
					success: function(c){
						// $("body").addClass("loading-overlay-showing").attr('data-loading-overlay');
						history.pushState('', '', SITE_URL + '/yonetici/'+t.data('id')+'/'+ t.data('page'));
						$(".tab-content").html(c);
						init(url);
						$loader.fadeOut("slow");
					}
				});
			break;

			case "adminYonetimSifreGuncelle":
				$.adminAJAX._adminYonetimSifreGuncelle( t, t.data('id') );
			break;

			case "adminBonusSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._adminBonusSil(t, t.data('id'));
				});
			break;

            case "adminDomainGuncelle":
                swal({
                    title: "Emin misin?",
                    text: "Geri dönüşü olamaz!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function() {
                    $.adminAJAX._adminDomainGuncelle(t, t.data('id'));
                });
            break;

			case "adminYeniBonusEkleForm":
				$("[data-action=adminYeniBonusEkleForm]").hide(250);
				$(".bonusListe").prepend('<tr><form id="adminBonusEkleForm">\
						<td></td>\
						<td><div class="input-group input-group-sm"><input type="text" name="baslik" placeholder="Başlık" class="form-control" /></div></td>\
						<td><div class="input-group input-group-sm"><input type="text" name="yuzde" placeholder="Yüzde" class="form-control" /></div></td>\
						<td><button class="btn btn-success btn-xs admin-action" data-action="adminBonusEkle"><i class="fa fa-check"></i></button></td>\
					</form></tr>');
			break;

			case "adminBonusEkle":
				$.adminAJAX._adminBonusEkle( t );
			break;

			/* banka hesaplari */
			case "adminBankaHesabiGuncelle":
				$.adminAJAX._adminBankaHesabiGuncelle( t, t.data('id') );
			break;

			case "adminBankaHesabiEkle":
				$.adminAJAX._adminBankaHesabiEkle( t );
			break;

			case "adminBankaHesabiSil":
				$.adminAJAX._adminBankaHesabiSil( t, t.data('id') );
			break;

			case "adminKullaniciBan_Ekle":
				$.adminAJAX._adminKullaniciBan_Ekle( t, t.data('id') );
			break;

			case "adminPromosyonGuncelle":
				$.adminAJAX._adminPromosyonGuncelle( t, t.data('id') );
			break;

			case "adminPromosyonPencere":
				$.ajax({
					data: { "id": t.data('id'), "tip": "adminPromosyonPencere" },
					success: function(c) {
						if ( c.success ) {
							$(".modal [data-action='adminPromosyonGuncelle']").data('id', t.data('id'));
							$(".modal-title").html(c.promotion.title);
							$(".form-title").val(c.promotion.title);
							$("input[name=seourl]").val(c.promotion.url);
							$(".form-content").val(decodeURIComponent(c.promotion.content));
						} else alert("Mevcut değil!");
					}
				});
			break;

			case "adminPromosyonSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.adminAJAX._adminPromosyonSil(t, t.data('id'));
				});
			break;

			case "adminDuyuruEkle":
				$.ajax({
					data: $("#duyuruEkleForm").serialize() + "&tip=adminDuyuruEkle",
					success: function(c) {
						if ( c.success ) {
							$(".duyuruListe").prepend(c.html);
							init();
						} else swal("Opps!", c.error, 'error');
					}
				});
			break;

			case "adminDuyuruSil":
				swal({
					title: "Emin misin?",
					text: "Geri dönüşü olamaz!",
					type: "info",
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				}, function() {
					$.ajax({
						data: "id="+ t.data('id') +"&tip=adminDuyuruSil",
						success: function(c) {
							if ( c.success ) {
								$("[duyuru-id='"+ t.data('id') +"']").remove();
								swal("Tamam!", "Silindi.", 'success');
							} else swal("Opps!", c.error, 'error');
						}
					});
				});
			break;

			case "adminPopulerLig":
				$.adminAJAX._adminPopulerLig(t, t.attr('data-id'), t.attr('data-type'));
			break;

		}
	});

	$(document).on("dblclick",'.kullaniciGoruntule',function(){
		var t = $(this);
		var id = t.attr('data-id');
		$loader.fadeIn('slow');
		localStorage.adminGeriDon = JSON.stringify({
			url: window.location.href,
			html: $(".content-body").html()
		});

		$.ajax({
			url: SITE_URL + '/profil/'+ id +'/&ajax=true&page=true',
			type: "post",
			data: {"type": "adminGeriDon"},
			dataType: "html",
			success: function(c){
				history.pushState('', '', SITE_URL + '/profil/' + id + '/');
				$(".content-body").html(c);
				init();
				$loader.fadeOut('slow');
			}
		});
	});

	$(document).on("dblclick",'.yoneticiGoruntule',function(){
		var t = $(this);
		var id = t.attr('data-id');
		$loader.fadeIn('slow');
		localStorage.adminGeriDon = JSON.stringify({
			url: window.location.href,
			html: $(".content-body").html()
		});

		$.ajax({
			url: SITE_URL + '/yonetici/'+ id +'/&ajax=true&page=true',
			type: "post",
			data: {"type": "adminGeriDon"},
			dataType: "html",
			success: function(c){
				history.pushState('', '', SITE_URL + '/yonetici/' + id + '/');
				$(".content-body").html(c);
				init();
				$loader.fadeOut('slow');
			}
		});
	});

    $(".sport-limit-action").on('input',function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var amount = $("#"+ $(this).attr('id')).val();
        $.adminAJAX._adminSportLimit($(this), id,name, amount);

    });


	$.adminAJAX = {

        _adminGiris: function(t){
            $.ajax({
                data: $("form#adminGirisForm").serialize() + "&tip=adminGiris",
                success: function(cevap){
                    if (cevap.success) {
                        swal('Başarılı!', 'Anasayfaya Yönlendiriliyorsunuz.', 'success');
                        setTimeout(function(){
                            window.location.reload(true);
                        }, 1500);
                    } else if (cevap.code) {
                        $("#groupusername").hide();
                        $("#googlecaptcha").hide();
                        $("#grouppassword").hide();
                        $("#groupcode").fadeIn('slow');
                        $("#code").val('');
                    }
                    else {
                        swal({
                            title: "Hata",
                            text: cevap.error,
                            type: "info",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        }, function() {
                            window.location.reload(true);
                        });

                    }
                }
            });
        },

		_adminKuponGrafik: function(t) {
			$.ajax({
				data: $("form#kuponGrafikForm").serialize() + "&tip=adminKuponGrafik",
				success: function(cevap){
					if (cevap.success) {

						$("#morrisLine").html('');
						var kuponGrafik = Morris.Line({
							resize: true,
							element: 'morrisLine',
							data: cevap.results,
							xkey: 'y',
							ykeys: ['a', 'b', 'c', 'd'],
							labels: ['Oynanan', 'Bekleyen', 'Kazanan', 'Kaybeden'],
							hideHover: true,
							lineColors: ['#0D88CC', '#000000', '#6CC334', '#D2312D'],
						});

					} else alert(cevap.error);
				}
			});
		},

		_adminKullanicilar: function (t, sayfa) {
			var column = $("#column").val();
			$.ajax({
				url: SITE_URL + '/kullanicilar/&ajax=true',
				data: {
					"kelime": $("#kullaniciAra").val(),
					"sutun": column,
					"sayfa": sayfa
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".content-body").html(c);
					init();
				}
			});
		},

		_adminKullaniciAra: function() {

			$.ajax({
				data: {
					"kelime": $("#kullaniciAra").val(),
					"sutun": column,
					"tip": "adminKullaniciAra"
				},
				success: function (c) {
					if (c.success) {
						 $(".kullanicilarListe").html('');
						 for (var $i = 0; $i < c.results.length; $i++) {
							 var kullanici = c.results[$i];
							 $(".kullanicilarListe").append(kullaniciListe(kullanici));
						 }
					} else alert(c.error);
				}
			});
		},

		_adminKullaniciBilgi: function (t, id) {
			$.ajax({
				data: {"id": id, "tip": "adminKullaniciBilgi"},
				success: function (c) {
					if (c.success) {

						var kullanici = c.results;

						//$popupFormInner.css("left", "40%");
						//$popupForm.fadeIn("slow");

						$modalFormTitle.text(kullanici['username']);
						$modalFormButtons.html('\
							<button type="submit" class="btn btn-success admin-action" data-action="adminKullaniciDuzenle" data-id="'+ kullanici['id'] +'" data-type="update"><i class="fa fa-pencil"></i> Güncelle</button>\
									<button type="submit" class="btn btn-primary admin-action" data-action="adminKullaniciSifreDegistir" data-id="'+ kullanici['id'] +'"><i class="fa fa-pencil"></i> Şifre Değiştir</button>\
									<button class="btn btn-default modal-dismiss">Kapat</button>\
						');

					} else swal('Opps!', c.error,'error');
				}
			});
		},

		_adminKullaniciDuzenle: function (t, id) {
			var form = $("#kullaniciDuzenleForm").serialize();
			$.ajax({
				data: form + "&id=" + id + "&tip=adminKullaniciDuzenle",
				success: function (c) {
					if (c.success) {
						swal('Harika!', 'Başarıyla güncellendi.', 'success');
					} else swal('Opps!', c.error, 'error');
				}
			});
		},

		_adminKullaniciSil: function (t, id) {
			$.ajax({
				data: "id=" + id + "&tip=adminKullaniciSil",
				success: function (c) {
					if (c.success) {
						swal("Silindi.");
						$(".kullanicilarListe tr[data-id="+ id +"]").hide();
					} else swal(c.error);
				}
			});
		},

		_adminPromosSil: function (t, id) {
			$.ajax({
				data: "id=" + id + "&tip=adminPromosSil",
				success: function (c) {
					if (c.success) {
						swal("Silindi.");
						$(".kullanicilarListe tr[data-id="+ id +"]").hide();
					} else swal(c.error);
				}
			});
		},

		_adminKullaniciFinansalIslemler: function (t, id) {
			var id = t.data("id");
			localStorage.setItem("returnUrl", window.location.href);
			$.ajax({
				url: SITE_URL + '/finansal_islemler/&ajax=true',
				type: "post",
				data: {"kullanici": id, "popup": true},
				dataType: "html",
				success: function(c){
					// localStorage.setItem("popup", "active");
					history.pushState('', '', SITE_URL + '/finansal_islemler/');
					$modalFormTitle.text('Kullanıcı Finansal İşlemler');
					$modalForm.find('.panel-body').html(c);
					$modalFormButtons.html('\
						<button class="btn btn-default modal-dismiss">Kapat</button>\
					');
					$modalForm.css("max-width", "980px");
					init();
				}
			});
		},

		/* Bakiye sayfasi */
		_adminBakiyeGonder: function (t) {
			$.ajax({
				data: t.parent().parent().parent().parent().find('form').serialize() + "&tip=adminBakiyeGonder",
				success: function (c) {
					if (c.success) {
						// alert("İşlem gerçekleştirilmiştir.");
						swal('Harika!', 'İşlem gerçekleştirilmiştir.', 'success');
						t.parent().parent().parent().parent().find('.mevcutbakiye b').text(c.bakiye).css('color', 'red');
					} else swal('Opps', c.error, 'error');
				}
			});
		},

		_adminBakiyeListele: function (t, sayfa) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"filtre": $("select[name=filtre]").val(),
					"kullanici": $("input[name=kullanici]").val(),
					"sayfa": sayfa
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".content-body").html(c);
					init();
				}
			});
		},

		_adminBakiyeRapor: function (t) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"kullanici": $("input[name=kullanici]").val()
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".content-body").html(c);
					init();
				}
			});
		},

		_cacheClear: function (t) {
			$.ajax({
				data: "&tip=cacheClear",
				success: function (c) {
					if (c.success) {
						swal("Başarılı!", "İşlem Tamamlandı.", "success");
					} else swal("Hata Oluştu!", c.error, "error");
				}
			});
		},

		_adminKuponHareketleri: function(t) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"kullanici": $("input[name=kullanici]").val()
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".content-body").html(c);
					init();
				}
			});
		},

		_adminKuponlar: function(t, sayfa) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"kullanici": $("input[name=kullanici]").val(),
					"canli": $("select[name=canli]").val(),
					"durum": $("select[name=durum]").val(),
					"result": $("select[name=result]").val(),
					"sayfa": sayfa,
					"popup": (typeof localStorage.popup != "undefined") ? true : false
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					if (typeof localStorage.popup != "undefined") {
						//$popupFormInner.css("left", "10%");
						//$popupForm.fadeIn("slow");
						//$popupFormInner.html(c);
						$modalFormTitle.text('Kullanıcı Kuponları');
						$modalForm.find('.panel-body').html(c);
					} else {
						$(".content-body").html(c);
					}
					init();
				}
			});
		},

		_adminKuponGuncelle: function(t, id, durum) {
			$.ajax({
				data: {
					"id": id,
					"durum": durum,
					"tip": "adminKuponGuncelle"
				},
				success: function(c) {
					if (c.success) {
						if (durum == "1") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-red").addClass("row-green").html('Kazandı');
						} else if (durum == "2") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-red").addClass("row-red").html('Kaybetti');
						}
						else if (durum == "0") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-orange").addClass("row-orange").html('Beklemeye Alındı');
						}
					} else alert(c.error);
				}
			});
		},

		_adminKuponMacGuncelle: function(t, id, durum) {
			$.ajax({
				data: {
					"id": id,
					"durum": durum,
					"tip": "adminKuponMacGuncelle"
				},
				success: function (c) {
					if (c.success) {
						swal('İşlem Tamam!', 'Başarıyla güncellendi!', 'success');
						if (durum == "1") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-red").addClass("row-green").html('Kazandı');
						} else if (durum == "2") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-red").addClass("row-red").html('Kaybetti');
						}
						else if (durum == "0") {
							$("table tr[data-id="+ c.id +"] .durum").removeClass("row-green row-orange row-red").addClass("row-orange").html('Beklemeye Alındı');
						}
					} else swal('Hata!', c.error, 'error');
				}
			});
		},

		_adminKuponIade: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminKuponIade"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
					} else swal("Ops!", c.error, "error");
				}
			});
		},

		_adminKuponMacIade: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminKuponMacIade"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
					} else swal("Ops!", c.error, "error");
				}
			});
		},

		_adminSmsGonder: function(t) {
			$.ajax({
				data: $("form#smsGonderForm").serialize() + "&tip=adminSmsGonder",
				success: function (c) {
					if (c.success) {
						alert("İşlem gerçekleştirilmiştir.");
						$("#smsGonderForm .mevcutsms b").text(c.sms).css('color', 'red');
					} else alert(c.error);
				}
			});
		},

		_adminMacDuzenle: function(t, id) {
			$.ajax({
				url: SITE_URL + '/mac_duzenle/'+id+'/0&ajax=true',
				data: {
					"popup": (typeof localStorage.popup != "undefined") ? true : false
				},
				type: "post",
				dataType: "html",
				success: function (c) {
					$modalFormTitle.text('Maç Düzenle');
					$modalForm.find('.panel-body').html(c);
					$modalFormButtons.html('\
					Toplam Değişiklik: (<span id="toplamartim">0</span>)\
					<button type="submit" class="btn btn-success admin-action" data-action="adminMacGuncelle" data-id="'+ id +'"><i class="fa fa-pencil"></i> Güncelle</button>\
					<button type="submit" class="btn btn-primary admin-action" onclick="hepsiniar();"><i class="fa fa-plus"></i> Hepsini Arttır</button>\
					<button type="submit" class="btn btn-danger" onclick="hepsiniaz();"><i class="fa fa-minus"></i> Hepsini Azalt</button>\
						<button class="btn btn-default modal-dismiss">Kapat</button>\
					');
					$modalForm.css("max-width", "980px");
				}
			});
		},

		_adminMacGuncelle: function(t, id) {
			$.ajax({
				data: $("#macDuzenleForm").serialize() + "&id=" + id + "&tip=adminMacGuncelle",
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminMacBultenGuncelle: function(t, id, value) {
			$.ajax({
				data: {
					"id": id,
					"value": value,
					"tip": "adminMacBultenGuncelle"
				},
				success: function(c) {
					if (c.success) {
						if (t.attr('data-value') == 1) {
							t.text('Pasif');
							t.attr('data-value', 0);
						} else {
							t.text('Aktif');
							t.attr('data-value', 1);
						}
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminBankaYatirimTalepOnayla: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaYatirimTalepOnayla"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
						t.parent().parent().removeClass('durum0').addClass("durum1");
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminBankaYatirimTalepSil: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaYatirimTalepSil"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
						t.parent().parent().removeClass('durum0').addClass("durum2");
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminBankaYatirimTalepDetay: function(t, id) {
			$.ajax({
				url: SITE_URL + "/yatirim_talepdetay/" + id + "&ajax=true",
				dataType: "html",
				success: function(c) {
					$modalFormTitle.text('Talep Detay');
					$modalForm.find('.panel-body').html(c);
					$modalFormButtons.html('\
						<button class="btn btn-default modal-dismiss">Kapat</button>\
					');
					$modalForm.css("max-width", "980px");
				}
			});
		},

		_adminBankaCekimTalepOnayla: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaCekimTalepOnayla"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
						t.parent().parent().removeClass('durum1').addClass("durum2");
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminBankaCekimTalepBekleyen: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaCekimTalepBekleyen"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
						t.parent().parent().removeClass('durum0').addClass("durum1");
						t.remove();
					} else swal("Opss!", c.error, "error");
				}
			});
		},

		_adminBankaCekimTalepSil: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaCekimTalepSil"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "İşlem tamamlandı!", "success");
						t.parent().parent().removeClass('durum0 durum1 durum2').addClass("durum3");
					} else swal("Opps!", c.error, "error");
				}
			});
		},

		_adminBankaCekimTalepDetay: function(t, id) {
			$.ajax({
				url: SITE_URL + "/cekim_talepdetay/" + id + "&ajax=true",
				dataType: "html",
				success: function(c) {
					$modalFormTitle.text('Talep Detay');
					$modalForm.find('.panel-body').html(c);
					$modalFormButtons.html('\
						<button class="btn btn-success admin-action" data-action="adminBankaCekimTalepNot" data-id="'+ id +'"><i class="fa fa-pencil"></i> Not Güncelle</button>\
						<button class="btn btn-default modal-dismiss">Kapat</button>\
					');
					$modalForm.css("max-width", "980px");
				}
			});
		},

		_adminBankaCekimTalepNot: function(t, id) {
			$.ajax({
				data: {
					"id": id,
					"not": $("#talepDetayForm textarea[id=notttttt]").val(),
					"tip": "adminBankaCekimTalepNot"
				},
				success: function(c) {
					if (c.success) {
						swal("Harika!", "Güncellendi!", "success");
					} else swal('Opps', c.error, "error");
				}
			});
		},

		_adminBankaYatirim: function(t) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"kullanici": $("input[name=kullanici]").val(),
					"tur": $("select[name=tur]").val(),
					"durum": $("select[name=durum]").val()
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".content-body").html(c);
					init();
				}
			});
		},

		_adminPing: function(type) {
			$.ajax({
				data: {
					"tip": "adminPing"
				},
				success: function(c) {
					if (c.success) {
						$(".parayatir_toplam").text( c.parayatir_toplam );
						$(".paracek_toplam").text( c.paracek_toplam );
						if (type == 1) {
							$("body").attr('data-paracek-id', c.paracek_id);
							$("body").attr('data-parayatir-id', c.parayatir_id);
						} else {
							if ( parseInt($("body").attr('data-paracek-id')) < c.paracek_id) {
								$('#notification')[0].play();
								PNotify.desktop.permission();
								(new PNotify({
									title: 'BİLDİRİM',
									text: 'Para Çekme Talebi geldi!',
									type: "success",
									animation:"fade",
									delay: 3000,
									desktop: {
										desktop: true,
										icon: '/images/live.gif'
									}
								})).get().click(function() {
									$loader.fadeIn("slow");
									$.ajax({
										url: SITE_URL + '/cekmetalep&ajax=true',
										dataType: "html",
										success: function(c){
											// $("body").addClass("loading-overlay-showing").attr('data-loading-overlay');
											history.pushState('', '', SITE_URL + '/cekmetalep');
											$(".content-body").html(c);
											init(SITE_URL + '/cekmetalep');
											$loader.fadeOut("slow");
										}
									});
								});
								$("body").attr('data-paracek-id', c.paracek_id);
							}
							if ( parseInt($("body").attr('data-parayatir-id')) < c.parayatir_id) {
								$('#notification')[0].play();
								PNotify.desktop.permission();
								(new PNotify({
									title: 'BİLDİRİM',
									text: 'Para Yatırma Talebi geldi!',
									type: "success",
									animation:"fade",
									delay: 3000,
									desktop: {
										desktop: true,
										icon: '/images/live.gif'
									}
								})).get().click(function() {
									$loader.fadeIn("slow");
									$.ajax({
										url: SITE_URL + '/yatirmatalep&ajax=true',
										dataType: "html",
										success: function(c){
											// $("body").addClass("loading-overlay-showing").attr('data-loading-overlay');
											history.pushState('', '', SITE_URL + '/yatirmatalep');
											$(".content-body").html(c);
											init(SITE_URL + '/yatirmatalep');
											$loader.fadeOut("slow");
										}
									});
								});
								$("body").attr('data-parayatir-id', c.parayatir_id);
							}
						}
					}
				}
			});
		},

		_adminKullaniciTab_FormGuncelle: function(t, id) {
			$.ajax({
				data: t.parent().parent().parent().parent().find('form').serialize() + "&id="+ id +"&tip=adminKullaniciTab_FormGuncelle",
				success: function(c) {
					if (c.success) {
						swal('Harika', 'Güncellendi', 'success');
					} else swal('Hata!', c.error, 'error');
				}
			});
		},

		_adminKullaniciTab_Hareketler: function(t) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"islem": $("select[name=islem_tip]").val(),
					"tur": $("select[name=tur]").val(),
					"durum": $("select[name=durum]").val()
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".tab-content").html(c);
					init();
				}
			});
		},

		_adminKullaniciTab_Bahis: function(t) {
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"canli": $("select[name=canli]").val(),
					"durum": $("select[name=durum]").val(),
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".tab-content").html(c);
					init();
				}
			});
		},

		_adminBonusGonder: function (t, form) {
			$.ajax({
				data: form,
				success: function (c) {
					if (c.success) {
						swal("Harika!", 'Başarıyla gönderildi!', 'success');
					} else swal("Hata!", c.error, 'error');
				}
			});
		},

		_adminRakebackGonder: function (t, form) {
			$.ajax({
				data: form,
				success: function(c) {
					if (c.success) {
						swal("Harika!", 'Başarıyla gönderildi!', 'success');
					} else swal("Hata!", c.error, 'error');
				}
			});
		},

		_adminDiscountGonder: function(t, form){
			$.ajax({
				data: form,
				success: function(c) {
					if (c.success) {
						swal("Harika!", 'Başarıyla gönderildi!', 'success');
					} else swal("Hata!", c.error, 'error');
				}
			});
		},

		_adminCanliDiscountGonder: function(t, form) {
			$.ajax({
				data: form,
				success: function(c) {
					if (c.success) {
						swal("Harika!", 'Başarıyla gönderildi!', 'success');
					} else swal("Hata!", c.error, 'error');
				}
			});
		},

		_adminBannerSil: function(t,id) {
			$.ajax({
				data: {"id": id, "tip": "adminBannerSil"},
				success: function(c) {
					if (c.success) {
						t.parent().remove();
					}
				}
			});
		},

		_adminYoneticiEkle: function(t) {
			$.ajax({
				data: $("#yoneticiEkleForm").serialize(),
				success: function(c) {
					if (c.success) {
						$(".kullanicilarListe").prepend('<tr data-id="'+ c.user_id +'" class="yoneticiGoruntule">\
						<td>'+ c.user_id +'</td>\
						<td>'+ c.name +'</td>\
						<td>@'+ c.username +'</td>\
						<td><code>aktif</code></td>\
						<td>\
							<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminYoneticiSil" data-id="'+ c.user_id +'"><i class="fa fa-remove"></i></button>\
						</td>\
					</tr>');
					} else swal("Hata!", c.error, 'error');
				}
			});
		},

		_adminKullaniciSil: function (t, id) {
			$.ajax({
				data: "id=" + id + "&tip=adminYoneticiSil",
				success: function (c) {
					if (c.success) {
						swal("Silindi.");
						$(".kullanicilarListe tr[data-id="+ id +"]").hide();
					} else swal(c.error);
				}
			});
		},

		_adminYonetimSifreGuncelle: function( t, id ) {
			$.ajax({
				data: $(".yoneticiSifreGuncelleForm").serialize() + "&id=" + id + "&tip=adminYonetimSifreGuncelle",
				success: function( c ) {
					if (c.success) {
						swal("Başarıyla güncellendi.");
					} else swal(c.error);
				}
			});
		},

        _adminSiteSettings: function(t, id) {
			$.ajax({
                data: $("#adminSiteSettings").serialize()+ "&tip=adminSiteSettings",
				success: function( c ) {
					if (c.success) {
						swal("Canlı Oran Servisi Başarılı Şekilde Değiştirildi.");
					} else swal(c.error);
				}
			});
		},

        _adminSettings: function(t, id) {
			$.ajax({
                data: $("#adminSettings").serialize()+ "&tip=adminSettings",
				success: function( c ) {
					if (c.success) {
						swal("İşlem Başarıyla Tamamlandı.");
					} else swal(c.error);
				}
			});
		},

		_adminDomainGuncelle: function(t, id) {
			$.ajax({
				data: "id=" + id + "&tip=adminDomainGuncelle",
				success: function( c ) {
					if (c.success) {
						swal("Domain Başarılı Şekilde Değiştirildi.");
					} else swal(c.error);
				}
			});
		},

        _adminBonusSil: function(t, id) {
            $.ajax({
                data: "id=" + id + "&tip=adminBonusSil",
                success: function( c ) {
                    if (c.success) {
                        swal("Başarıyla silindi.");
                        $(".bonusListe tr[data-id="+ id +"]").hide();
                    } else swal(c.error);
                }
            });
        },

		_adminBonusEkle: function (t) {
			//
			var tablo = t.parent().parent();
			$.ajax({
				// data: "baslik=" + $('input[name=baslik]').val() + "&yuzde=" + $('input[name=yuzde]').val() + "&tip=adminBonusEkle",
				data: {
					"baslik": $('input[name=baslik]').val(),
					"yuzde": $('input[name=yuzde]').val(),
					"tip": "adminBonusEkle"
				},
				success: function(c) {
					if ( c.success ) {
						$("[data-action=adminYeniBonusEkleForm]").show(250);
						tablo.attr('data-id', c.id);
						tablo.find('td').eq(0).html( c.id );
						tablo.find('td').eq(1).html( $('input[name=baslik]').val() );
						tablo.find('td').eq(2).html( $('input[name=yuzde]').val() );
						tablo.find('td').eq(3).html( '<button class="btn btn-danger btn-xs admin-action" data-action="adminBonusSil" data-id="'+ c.id +'"><i class="fa fa-remove"></i></button>' );
					} else swal(c.error);
				}
			});
		},

		_adminBankaHesabiGuncelle: function(t, id) {
			$.ajax({
				data: $("[banka-id='"+ id +"']").serialize() + "&id=" + id + "&tip=adminBankaHesabiGuncelle",
				success: function( c ) {
					if ( c.success ) {
						swal("Başarıyla güncellendi.");
					} else swal(c.error);
				}
			});
		},

		_adminBankaHesabiEkle: function(t) {
			$.ajax({
				data: $("#adminBankaEkleForm").serialize() + "&tip=adminBankaHesabiEkle",
				success: function(c) {
					if ( c.success ) {
						swal("başarıyla eklendi.");
					} else swal( c.error );
				}
			});
		},

		_adminBankaHesabiSil: function(t,id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminBankaHesabiSil"
				},
				success: function( c ) {
					if ( c.success ) {
						swal("Başarıyla kaldırıldı.");
						t.parent().parent().parent().parent().remove();
					} else swal( c.error );
				}
			});
		},

		_adminKullaniciBan_Ekle: function (t,id) {
			$.ajax({
				data: {
					"id": id,
					"not": $("#not").val(),
					"tip": "adminKullaniciBanEkle"
				},
				success: function (c) {
					if ( c.success ) {
						swal('Harika!', 'Başarıyla eklendi', 'success');
						$("#kullaniciBanList").prepend('\
							<tr data-id="'+ c.ban_id +'">\
								<td>'+ c.ban_id +'</td>\
								<td>'+ c.user.username +'</td>\
								<td>'+ c.admin.username +'</td>\
								<td>'+ $("#not").val() +'</td>\
								<td>'+ c.date +'</td>\
							</tr>\
						');
					} else swal( c.error );
				}
			});
		},

		_adminPromosyonGuncelle: function(t, id) {
			$.ajax({
				data: $("#adminPromosyonGuncelleForm").serialize() + "&id=" + id + "&tip=adminPromosyonGuncelle",
				success: function(c) {
					if ( c.success ) {
						swal("Harika!" , 'Başarıyla güncellendi', 'success');
					} else swal('Hata!', 'Bir hata meydana geldi', 'error');
				}
			});
		},

		_adminPromosyonSil: function (t, id) {
			$.ajax({
				data: {
					"id": id,
					"tip": "adminPromosyonSil"
				},
				success: function (c) {
					if ( c.success ) {
						swal("Harika!", "Başarıyla silindi!", "success");
						$("li[data-id='"+ id +"']").remove();
					} else swal("Hata!", "Bir hata meydana geldi!", 'error');
				}
			});
		},

		_adminPopulerLig: function (t, id, type) {
			$.ajax({
				data: {
					"id": id,
					"type": type,
					"tip": "adminPopulerLig"
				},
				success: function (c) {
					if (c.success) {
						if (c.popular == 1) {
							t.css({
								"color": "orange",
								"float": "right"
							});
							t.attr('data-type', 'remove');
						} else {
							t.attr('data-type', 'add');
							t.css({
								"float": "right",
								"color": "black"
							});
						}
					} else swal("Hata", c.error, 'error');
				}
			});
		},

        _adminSportActive: function(t,id,name,durum) {
            $.ajax({
                data: {"id": id, "name": name, "durum": durum, "tip": "adminSportActive"},
                success: function(c) {
                    if (c.success) {
                        if (durum == 0) {
                            $("#sport-"+id).prop('checked', false);
                            $("#sport-limit-"+id).attr("disabled", "disabled");

                        } else if (durum == 1) {
                            $("#sport-"+id).prop('checked', true);
                            $("#sport-limit-"+id).removeAttr("disabled");

                        }
                    }
                }
            });
        },

        _adminSportLimit: function(t,id,name,amount) {
            $("#sport-limit-icon-"+id).toggleClass( "fa-try" );
            $("#sport-limit-icon-"+id).toggleClass( "fa-spinner fa-spin" );

            $.ajax({
                data: {"id": id, "name": name, "amount": amount, "tip": "adminSportLimit"},
                success: function(c) {
                    if (c.success) {
                        $("#sport-limit-icon-"+id).toggleClass( "fa-spinner fa-spin" );
                        $("#sport-limit-icon-"+id).toggleClass( "fa-try" );
                    }
                }
            });
        }

	}

	$.adminAJAX._adminPing(1);
	setInterval(function(){
		$.adminAJAX._adminPing();
	}, 1000 * 20);

	$(document).on('click', '#formGeriDon', function() {
		if (typeof localStorage.adminFormHtml != "undefined") {
			$popupFormInner.html( localStorage.getItem('adminFormHtml') );
		}
		return false;
	});

	$('#datatable-ajax').on( 'dblclick', 'tr', function () {
		var id = $(this).attr('id');
		// alert(id);
    } );

    $.extend( $.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });

	var datatableInit = function() {

		if ( !$.fn.dataTable.isDataTable( '#datatable-default' ) ) {




			if (window.location.pathname == '/kupon_sonucla/' ) {
                $('#datatable-default').dataTable({aaSorting : [[2, 'asc']], "pageLength": 100, "responsive": true});
			} else {
                $('#datatable-default').dataTable({aaSorting : [[0, 'desc']], "pageLength": 100, "responsive": true});
			}



			var $table = $('#datatable-ajax');
			$table.dataTable({
				"ajax": {
					"url": $table.data('url'),
					"data": {
						"tip": "adminKullaniciTab_Hareketler",
						"id": $table.data('id')
					},
					"type": "POST"
				}
			});

			$('#datatable-ajax tfoot th, #datatable-default tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input style="width: 60" class="form-control" type="text" placeholder="'+title+'" />' );
			} );

			var table = $('#datatable-ajax, #datatable-default').DataTable();

			table.columns().every( function () {
				var that = this;

				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						var totalAmount = 0;
						that
							.search( this.value )
							.draw();

						/* */
						if ( $("tfoot th.banka").size() > 0 ) {
							if ( this.value != '' ) {
								if ( $("#datatable-default .dataTables_empty").size() == 0 ) {
									$( "#datatable-default tbody tr" ).each(function( index ) {
										var data = $(this);
										var amount = parseInt(data.find('td:eq(8)').text());

										totalAmount+=amount;
									});
									$(".yoneticiOnayToplam").html(totalAmount);
								} else $(".yoneticiOnayToplam").html(0);
							}
							//console.log($("#datatable-default tbody tr").size());
						}

					}
				} );
			} );

		}

	};


    if (window.location.pathname == '/sportsLimit' ) {
        $('#datatable-default').DataTable( {
            "order": [[ 0, "asc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "language": {
                "searchPlaceholder": "Search"
            }
        } );
        $('#datatable-default tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
        } );
        var table = $('#datatable-default').DataTable();
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );


        $('#datatable-default_filter > label > input[type="search"]').addClass('form-control');

    }


	/* sıralama */

	$.list_getLeagues = function (id) {
		//var id = $(this).data('id');

		// load
		$(".ligListeBody").html('<div class="fa fa-spinner fa-spin"></div>');

		$.ajax({
			data: { id: id, tip: "ligListele" },
			success: function ( c ) {
				if (c.success) {
					$(".ligListeBody").html('');
					var html = '<div class="dd" id="nestable"><ol class="dd-list" id="ligListesi">';
					c.data.forEach (function(k, v){
						if ( k.popular == 0 ) {
							var popular = '<i style="float: right" class="fa fa-star admin-action" data-action="adminPopulerLig" data-type="add" data-id="'+ k.id +'"></i>';
						} else {
							var popular = '<i style="color: orange; float: right" class="fa fa-star admin-action" data-action="adminPopulerLig" data-type="remove" data-id="'+ k.id +'"></i>';
						}
						html+= '<li class="dd-item" data-id="'+ k.leaguesid +'"><div class="dd-handle">'+ k.name +' '+ popular +'</div></li>';
					});
					html += '</ol></div>';

					$(".ligListeBody").html(html);
					init();
				} else swal('Hata!', c.error, 'error');
			}
		});
	}

	$.list_getCountry = function (id) {

		// load
		$(".ulkeListeBody").html('<div class="fa fa-spinner fa-spin"></div>');

		$.ajax({
			data: { id: id, tip: "ulkeListele" },
			success: function ( c ) {
				if (c.success) {

					$(".ulkeListeBody").html('');
					var html = '<div class="dd" id="nestable"><ol class="dd-list" id="ulkeListesi">';
					c.data.forEach (function(k, v){
						html+= '<li class="dd-item list_getLeagues" ondblclick="$.list_getLeagues('+ k.countryid +')" data-id="'+ k.countryid +'"><div class="dd-handle">'+ k.name +'</div></li>';
					});
					html += '</ol></div>';

					$(".ulkeListeBody").html(html);

					init();

				} else swal('Hata!', c.error, 'error');
			}
		});
	}

	init = function(url) {

		$(".duyuruDuzenle").on('change', function(){
			$.ajax({
				data: {
					"id": $(this).find(":selected").data('id'),
					"aktif": this.value,
					"tip": "adminDuyuruAktifDuzenle"
				},
				success: function (c) {
					if ( c.error ) {
						swal('Opps!', c.error, 'error');
					}
				}
			})
		});

		$('.playgo-table tfoot td').each( function () {
			var title = $(this).text();
			$(this).html( '<input style="width: 60" class="form-control" type="text" placeholder="'+title+'" />' );
		} );

		if (window.location.href.split("/promosyon_ekle/")[1] == "") {
			/* promotion -> uploader */
			$("#fileuploader").uploadFile({
				url: SITE_URL + "/ajax/admin.ajax.php",
				fileName: "promotion",
				formData: {
					"tip":'adminPromotionUpload'
				},
				onSuccess:function(files,data,xhr,pd)
				{
					//files: list of files
					//data: response from server
					//xhr : jquer xhr object
					var obj = JSON.parse(xhr.responseText),
						url = obj.url,
						id  = obj.promotion_id;

					if ( obj.success ) {
						$(".results ul").prepend('\
							<li class="promotion" data-id="'+ id +'">\
								<form id="adminPromosyonGuncelleForm">\
								<div class="left l">\
									<div class="promotionUploadImage">\
										<img src="'+ url +'" alt="" />\
									</div>\
								</div>\
								<div class="right l">\
									<div class="promotionUploadTitle">\
										<h5>Başlık: </h5>\
										<input type="text" name="baslik" id="baslik" class="form-control" />\
									</div>\
									<div class="promotionUploadTitle">\
										<h5>İçerik: </h5>\
										<textarea class="form-control" name="icerik" id="icerik" cols="30" rows="8"></textarea>\
									</div>\
								</div>\
								<div class="l">\
									<button class="btn btn-success admin-action" data-action="adminPromosyonGuncelle" data-id="'+ id +'">İşlemi Tamamla</button>\
								</div>\
								<div style="clear: both"></div>\
								</div>\
							</li>\
						');
						$(".promotion-list").prepend('\
							<li data-id="'+ id +'">\
								<img src="'+ url +'" alt="" />\
								<div class="title">\
									<h4></h4>\
									<a href="#" class="btn btn-primary admin-action" data-action="adminPromosyonPencere" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'+ id +'"><i class="fa fa-pencil"></i></a>\
								</div>\
							</li>\
						');
					} else alert(obj.error);
				}
			});
		}

		if (window.location.href.split("/banner_ekle/")[1] == "") {
			/* uploader */
			$("#fileuploader").uploadFile({
				url: SITE_URL + "/ajax/admin.ajax.php",
				fileName: "banner",
				formData: {
					"tip":'adminBannerUpload'
				},
				onSuccess:function(files,data,xhr,pd)
				{
					//files: list of files
					//data: response from server
					//xhr : jquer xhr object
					var obj = JSON.parse(xhr.responseText),
						url = obj.url;

					if ( obj.success ) {
						$(".results ul").prepend('<li><img src="'+ url +'" alt="" /></li>');
					} else alert(obj.error);
				}
			});
		}

		$( "#sortable1, #sortable2" ).sortable({
			connectWith: ".connectedSortable"
		}).disableSelection();
		/*- uploader -*/

		$("select[name=islem_tip]").on('change', function(e){
			$.ajax({
				url: window.location.href + '&ajax=true',
				data: {
					"baslangic": $("input[name=baslangic]").val(),
					"bitis": $("input[name=bitis]").val(),
					"islem": $("select[name=islem_tip]").val(),
					"tur": $("select[name=tur]").val(),
					"durum": $("select[name=durum]").val()
				},
				type: "post",
				dataType: "html",
				success: function(c) {
					$(".tab-content").html(c);
					init();
				}
			});
		});

		/* Popup Form */
		$(".modal-dismiss").on('click', function(e)
		{
			history.pushState('', '', localStorage.returnUrl);
			delete localStorage.popup;
			delete localStorage.returnUrl;
		});

		/* Select2 Init */
		$('[data-plugin-selectTwo]').each(function() {
			var $this = $( this ),
				opts = {};
			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;
			$this.themePluginSelect2(opts);
		});

		$( '[data-plugin-multiselect]' ).each(function() {
			var $this = $( this ),
				opts = {};
			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;
			$this.themePluginMultiSelect(opts);
		});

		$('[data-plugin-masked-input]').each(function() {
			var $this = $( this ),
				opts = {};
			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;
			$this.themePluginMaskedInput(opts);
		});

		datatableInit();

		// Datepicker bug fixed! [26.07.2016]
		$(".datepicker").on('changeDate', function() {
			$(this).attr('value', $(this).val());
		});

		// Anasayfa Tespit OK
		if (url == SITE_URL + '/' || window.location.href == SITE_URL + '/') {

			/* member */
			var target = $('#gaugeBasic_members'),
				opts = $.extend(true, {}, {
					lines: 12, // The number of lines to draw
					angle: 0.12, // The length of each line
					lineWidth: 0.5, // The line thickness
					pointer: {
						length: 0.7, // The radius of the inner circle
						strokeWidth: 0.05, // The rotation offset
						color: '#444' // Fill color
					},
					limitMax: 'true', // If true, the pointer will not go past the end of the gauge
					colorStart: '#0088CC', // Colors
					colorStop: '#0088CC', // just experiment with them
					strokeColor: '#F1F1F1', // to see which ones work best for you
					generateGradient: true
				}, target.data('plugin-options'));

				var gauge = new Gauge(target.get(0)).setOptions(opts);

			gauge.maxValue = opts.maxValue; // set max gauge value
			gauge.animationSpeed = 32; // set animation speed (32 is default value)
			gauge.set(opts.value); // set actual value
			gauge.setTextField(document.getElementById("gaugeBasicTextfield_members"));

			/* amount */
			var target = $('#gaugeAlternative_amount'),
				opts = $.extend(true, {}, {
					lines: 12,
					angle: 0.12,
					lineWidth: 0.5,
					pointer: {
						length: 0.7,
						strokeWidth: 0.05,
						color: '#444'
					},
					limitMax: 'true',
					colorStart: '#2BAAB1',
					colorStop: '#2BAAB1',
					strokeColor: '#F1F1F1',
					generateGradient: true
				}, target.data('plugin-options'));

				var gauge = new Gauge(target.get(0)).setOptions(opts);

			gauge.maxValue = opts.maxValue; // set max gauge value
			gauge.animationSpeed = 32; // set animation speed (32 is default value)
			gauge.set(opts.value); // set actual value
			gauge.setTextField(document.getElementById("gaugeAlternativeTextfield_amount"));

			/* gaugeBasic_yatirim */
			var target = $('#gaugeBasic_yatirim'),
				opts = $.extend(true, {}, {
					lines: 12, // The number of lines to draw
					angle: 0.12, // The length of each line
					lineWidth: 0.5, // The line thickness
					pointer: {
						length: 0.7, // The radius of the inner circle
						strokeWidth: 0.05, // The rotation offset
						color: '#444' // Fill color
					},
					limitMax: 'true', // If true, the pointer will not go past the end of the gauge
					colorStart: '#3D405D', // Colors
					colorStop: '#3D405D', // just experiment with them
					strokeColor: '#F1F1F1', // to see which ones work best for you
					generateGradient: true
				}, target.data('plugin-options'));

				var gauge = new Gauge(target.get(0)).setOptions(opts);

			gauge.maxValue = opts.maxValue; // set max gauge value
			gauge.animationSpeed = 32; // set animation speed (32 is default value)
			gauge.set(opts.value); // set actual value
			gauge.setTextField(document.getElementById("gaugeBasicTextfield_yatirim"));
			/* gaugeAlternative_cekim */
			var target = $('#gaugeAlternative_cekim'),
				opts = $.extend(true, {}, {
					lines: 12, // The number of lines to draw
					angle: 0.12, // The length of each line
					lineWidth: 0.5, // The line thickness
					pointer: {
						length: 0.7, // The radius of the inner circle
						strokeWidth: 0.05, // The rotation offset
						color: '#444' // Fill color
					},
					limitMax: 'true', // If true, the pointer will not go past the end of the gauge
					colorStart: '#A21E3A', // Colors
					colorStop: '#A21E3A', // just experiment with them
					strokeColor: '#F1F1F1', // to see which ones work best for you
					generateGradient: true
				}, target.data('plugin-options'));

				var gauge = new Gauge(target.get(0)).setOptions(opts);

			gauge.maxValue = opts.maxValue; // set max gauge value
			gauge.animationSpeed = 32; // set animation speed (32 is default value)
			gauge.set(opts.value); // set actual value
			gauge.setTextField(document.getElementById("gaugeAlternativeTextfield_cekim"));
		}

		if (typeof morrisLine !== "undefined") {
			var kuponGrafik = Morris.Line({
				resize: true,
				element: 'morrisLine',
				data: morrisLineData,
				xkey: 'y',
				ykeys: ['a', 'b', 'c', 'd'],
				labels: ['Oynanan', 'Bekleyen', 'Kazanan', 'Kaybeden'],
				hideHover: true,
				lineColors: ['#0D88CC', '#000000', '#6CC334', '#D2312D'],
			});
		}

		$( ".datepicker" ).datepicker({
			format: 'yyyy-mm-dd',
			orientation: "bottom",
			onSelect: function (date, d) {
				console.log("ok");
			}
		});

		$("#kullaniciAra").on('keypress', function(e){
			if (e.which == 13) {
				$.adminAJAX._adminKullanicilar();
			}
		});

		//
		var bakiye = $("option:selected", "#bakiyeGonderForm select[name=id]").data('bakiye');
		$("#bakiyeGonderForm .mevcutbakiye b").text(bakiye);

		$("#bakiyeGonderForm select[name=id]").change(function(e) {
			var bakiye = $("option:selected", this).data('bakiye');
			$("#bakiyeGonderForm .mevcutbakiye b").text(bakiye);
		});

		//
		var sms = $("option:selected", "#smsGonderForm select[name=id]").data('sms');
		$("#smsGonderForm .mevcutsms b").text(sms);

		$("#smsGonderForm select[name=id]").change(function(e) {
			var sms = $("option:selected", this).data('sms');
			$("#smsGonderForm .mevcutsms b").text(sms);
		});

		// bonus hesaplama
		$("#bonusGonderForm select[name=bonus]").change(function(e) {
			var yuzde = parseInt($("option:selected", this).data('yuzde'));
			var bakiye = parseInt($("#bonusGonderForm input[name=bakiye]").val());

			var hesapla = (bakiye * yuzde) / 100;
			$(".yuzde-sonuc").fadeIn("slow");
			$(".yuzde-sonuc").find('.cevir').text(hesapla);

		});

		$("#bonusGonderForm input[name=bakiye]").keyup(function(e) {
			var yuzde = parseInt($("option:selected", $("#bonusGonderForm")).data('yuzde'));
			var bakiye = parseInt($("#bonusGonderForm input[name=bakiye]").val());

			var hesapla = (bakiye * yuzde) / 100;
			$(".yuzde-sonuc").fadeIn("slow");
			$(".yuzde-sonuc").find('.cevir').text(hesapla);

		});

		$("#rakebackGonderForm input[name=bakiye]").keyup(function(e) {
			var bakiye = parseInt($("#rakebackGonderForm input[name=bakiye]").val());

			var hesapla = bakiye * 2.1;
			$(".rake-yuzde-sonuc").fadeIn("slow");
			$(".rake-yuzde-sonuc").find('.cevir').text(hesapla);

		});

		// discountGonderForm
		$("#discountGonderForm input[name=bakiye]").keyup(function(e) {
			var yuzde = 15;
			var bakiye = parseInt($("#discountGonderForm input[name=bakiye]").val());

			var hesapla = (bakiye * yuzde) / 100;
			$(".discount-yuzde-sonuc").fadeIn("slow");
			$(".discount-yuzde-sonuc").find('.cevir').text(hesapla);

		});

		$("#canliDiscountGonderForm input[name=bakiye]").keyup(function(e) {
			var yuzde = 20;
			var bakiye = parseInt($("#canliDiscountGonderForm input[name=bakiye]").val());

			var hesapla = (bakiye * yuzde) / 100;
			$(".canlidiscount-yuzde-sonuc").fadeIn("slow");
			$(".canlidiscount-yuzde-sonuc").find('.cevir').text(hesapla);

		});

		/*
		 * autocomplete
		*/


		var $autoComplete_user = $("#autoComplete_user");
		var options = {
		  url: function(phrase) {
			return SITE_URL + "/ajax/admin.ajax.php";
		  },
		  listLocation: "results",
		  list: {
				onClickEvent: function() {
					var value = $autoComplete_user.getSelectedItemData().id;
					$("input[name=kullanici]").val(value);
					$("#bakiyeGonderForm .mevcutbakiye b").text($autoComplete_user.getSelectedItemData().bakiye);
					$("#smsGonderForm .mevcutsms b").text($autoComplete_user.getSelectedItemData().sms);
				},
				maxNumberOfElements: 15
			},
		  getValue: "name",
		  ajaxSettings: {
			dataType: "json",
			method: "POST",
			data: {
			  tip: "adminAutoComplete_uye"
			}
		  },
		  preparePostData: function(data) {
			data.kelime = $autoComplete_user.val();
			return data;
		  },
		  requestDelay: 250
		};
		$autoComplete_user.easyAutocomplete(options);




				var $autoComplete_kupon = $("#autoComplete_kupon");
		var options = {
		  url: function(phrase) {
			return SITE_URL + "/ajax/admin.ajax.php";
		  },
		  listLocation: "results",
		  list: {
				onClickEvent: function() {
					var value = $autoComplete_kupon.getSelectedItemData().id;
					$("input[name=kullanici]").val(value);
					$("#bakiyeGonderForm .mevcutbakiye b").text($autoComplete_kupon.getSelectedItemData().bakiye);
					$("#smsGonderForm .mevcutsms b").text($autoComplete_kupon.getSelectedItemData().sms);
				},
				maxNumberOfElements: 15
			},
		  getValue: "name",
		  ajaxSettings: {
			dataType: "json",
			method: "POST",
			data: {
			  tip: "adminAutoComplete_kupon"
			}
		  },
		  preparePostData: function(data) {
			data.kelime = $autoComplete_kupon.val();
			return data;
		  },
		  requestDelay: 250
		};
		$autoComplete_kupon.easyAutocomplete(options);







		/* moodalform */
		$('.modal-with-form').magnificPopup({
			type: 'inline',
			preloader: false,
			focus: '#name',
			modal: true,

			// When elemened is focused, some mobile browsers in some cases zoom in
			// It looks not nice, so we disable it:
			callbacks: {
				beforeOpen: function() {
					if($(window).width() < 700) {
						this.st.focus = false;
					} else {
						this.st.focus = '#name';
					}
				}
			}
		});

		// Modalbox close
		$(document).keyup(function(e) {
			 if (e.keyCode == 27) {
				$(".modal-dismiss").trigger("click");
			}
		});

		/** Maçlar Double Click **/
		$("table.maclar tr").on('dblclick', function(){
			var id = $(this).data('id');
			if (id != 'undefined') {
				$(this).find('*[data-action="adminMacDuzenle"]').trigger("click");
			}
		});

		var url_split = window.location.href;

		if (url_split.split("/limit")[1] == "") {

			var foo = document.getElementById("foo");
			Sortable.create(foo, { group: "omega", animation: 350,
					onAdd: function(evt) {
						var itemEl = evt.item;
						var permissionId = evt.item.getAttribute('data-id');
						var userId = evt.item.getAttribute('data-user-id');
						$.ajax({
							data: {
								"tip": "adminKullaniciTab_LimitSil",
								"permission": permissionId,
								"user": userId
							},
							success: function(c) {
								if (c.success) {
									return true;
								} else swal("Opps!", c.error, "error");
							}
						});
					}
			});

			var bar = document.getElementById("bar");
			Sortable.create(bar, { group: "omega", animation: 350,
				onAdd: function(evt) {
					var itemEl = evt.item;
					var permissionId = evt.item.getAttribute('data-id');
					var userId = evt.item.getAttribute('data-user-id');
					$.ajax({
						data: {
							"tip": "adminKullaniciTab_LimitEkle",
							"permission": permissionId,
							"user": userId
						},
						success: function(c) {
							if (c.success) {
								return true;
							} else swal("Opps!", c.error, "error");
						}
					});
				}
			});

		} else if ( url_split.split("/banner_duzenle/")[1] == "" ) {
			var foo = document.getElementById("foo");
			Sortable.create(foo, { group: "omega", animation: 350,
					onAdd: function(evt) {
						var itemEl = evt.item;
						var itemId = evt.item.getAttribute('data-id');

						// ##
						var update = {};
						$.each( $("#foo li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminBannerGuncelle';

						$.ajax({
							data: update
						});
					},

					onUpdate: function(evt) {
						var parent = evt.item.parentNode;
						var item = evt.item;

						var index = Array.prototype.indexOf.call(parent.children, item);

						// ##
						var update = {};
						$.each( $("#foo li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminBannerGuncelle';

						$.ajax({
							data: update
						});
					}
			});

			/* var bar = document.getElementById("bar");
			Sortable.create(bar, { group: "omega", animation: 350,
				onAdd: function(evt) {
					var itemEl = evt.item;
					var itemId = evt.item.getAttribute('data-id');

					$.ajax({
						data: {"id": itemId, "tip": "adminBannerGizle"}
					});
				}
			}); */
		} else if ( url_split.split('/promosyon_ekle/')[1] == '' ) {
			var foo = document.getElementById("foo");
			Sortable.create(foo, { group: "omega", animation: 350,
					onAdd: function(evt) {
						var itemEl = evt.item;
						var itemId = evt.item.getAttribute('data-id');

						// ##
						var update = {};
						$.each( $("#foo li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminPromosyonIndexGuncelle';

						$.ajax({
							data: update
						});
					},

					onUpdate: function(evt) {
						var parent = evt.item.parentNode;
						var item = evt.item;

						var index = Array.prototype.indexOf.call(parent.children, item);

						// ##
						var update = {};
						$.each( $("#foo li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminPromosyonIndexGuncelle';

						$.ajax({
							data: update
						});
					}
			});

			/* var bar = document.getElementById("bar");
			Sortable.create(bar, { group: "omega", animation: 350,
				onAdd: function(evt) {
					var itemEl = evt.item;
					var itemId = evt.item.getAttribute('data-id');

					$.ajax({
						data: {"id": itemId, "tip": "adminPromosyonGizle"}
					});
				}
			}); */
		} else if (  url_split.split('/siralama/')[1] == '' ) {
			var sporListesi = document.getElementById("sporListesi");
			Sortable.create(sporListesi, { group: "omega", animation: 350,
					onUpdate: function(evt) {
						var parent = evt.item.parentNode;
						var item = evt.item;

						var index = Array.prototype.indexOf.call(parent.children, item);

						// ##
						var update = {};
						$.each( $("#sporListesi li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminSporIndexGuncelle';

						$.ajax({
							data: update
						});
					}
			});

			var ulkeListesi = document.getElementById("ulkeListesi");

			if ( ulkeListesi ) {

			Sortable.create(ulkeListesi, { group: "omega", animation: 350,
					onUpdate: function(evt) {
						var parent = evt.item.parentNode;
						var item = evt.item;

						var index = Array.prototype.indexOf.call(parent.children, item);

						// ##
						var update = {};
						$.each( $("#ulkeListesi li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminUlkeIndexGuncelle';

						$.ajax({
							data: update
						});
					}
			});

			}

			var ligListesi = document.getElementById("ligListesi");

			if (ligListesi) {

			Sortable.create(ligListesi, { group: "omega", animation: 350,
					onUpdate: function(evt) {
						var parent = evt.item.parentNode;
						var item = evt.item;

						var index = Array.prototype.indexOf.call(parent.children, item);

						// ##
						var update = {};
						$.each( $("#ligListesi li"), function(i, val) {
							var index = ( i + 1 );
							update[ $(this).data('id') ] = index;
						} );

						update['tip'] = 'adminLigIndexGuncelle';

						$.ajax({
							data: update
						});
					}
			});

			}

		}

	}
	init();
});

function hepsiniar() {
	$('#toplamartim').html(Math.round(($('#toplamartim').html()*1+0.05)*100)/100);
	var size = $(".artirr").size();
	for (var i = 0; i < size; i++) {
		$(".artirr").eq(i).trigger("onclick");
	}
}

function hepsiniaz() {
	$('#toplamartim').html(Math.round(($('#toplamartim').html()*1-0.05)*100)/100);
	var size = $(".azzalt").size();
	for (var i = 0; i < size; i++) {
		$(".azzalt").eq(i).trigger("onclick");
	}
}

function orguncelle(e){
	$(e).parent().find(".artis").val($(e).parent().find(".sonucs2").val()-$(e).parent().find(".orans").val());
}

function azzalt(value){
	if($(value).parent().find(".sonucs2").val()*1>1){
		$(value).parent().find(".sonucs2").val(Math.round(($(value).parent().find(".sonucs2").val()*1-0.05)*100)/100);
		orguncelle(value);
	}
}

function arttir(value){
	if($(value).parent().find(".sonucs2").val()*1>1){
		$(value).parent().find(".sonucs2").val(Math.round(($(value).parent().find(".sonucs2").val()*1+0.05)*100)/100);
		orguncelle(value);
	}
}
