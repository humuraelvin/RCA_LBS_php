function popupwindow(url, title, w, h) {
  var left = screen.width / 2 - w / 2;
  var top = screen.height / 2 - h / 2;
  return window.open(
    url,
    title,
    "directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no, width=" +
      w +
      ", height=" +
      h +
      ", top=" +
      top +
      ", left=" +
      left
  );
}

var serviceUrl = "/services/";
function matchDetails(id, tis) {
  var before = $(tis).html();
  $(tis).html(
    "<i class='fa fa-spinner fa-spin' style='display: block; color: #fff;padding-top: 5px;'></i>"
  );
  $(tis).toggleClass("active");
  if ($(tis).hasClass("active")) {
    $.ajax({
      url: serviceUrl + "matchdetails",
      type: "POST",
      data: { MatchID: id },
      success: function (c) {
        $(tis).html(before);
        $(".match_list_sides_2_content[data-id='" + id + "']").html(c);
      },
    });
  } else {
    $(tis).html(before);
    $(".match_list_sides_2_content[data-id='" + id + "']").html("");
  }
}

$(function () {
  var path = window.location.pathname;

  $(".odd").click(function () {
    $(this).toggleClass("odd-active");
  });

  if (path == "/live") {
    $("#bt-live").addClass("current");
    content_block($(".live_left_content_wait"));
    list_livematch();
    fnUpdateCoupon();
    //setTimeout(function(){list_livematchh();},10000);
  }

  if (path == "/sports") {
    $("#main-left").addClass("sidebar-open");
  }

  if (path == "/") {
    $("#bt-home").addClass("current");
  }
  if (path == "/sports") {
    $("#bt-sport").addClass("current");
    fnUpdateCoupon();
  }

  if (path == "/casino") {
    $("#bt-casino").addClass("current");
  }
  if (path == "/livecasino") {
    $("#bt-livecasino").addClass("current");
  }
  if (path == "/promotions") {
    $("#bt-promo").addClass("current");
  }

  if (path == "/myaccount") {
    $("#aa").addClass("active");
    $(document).on("click", "#btn_change_password", function (e) {
      GetPasswordForm();
      e.preventDefault();
    });
    $(document).on("click", "#frm_btn_password_update", function (e) {
      ChangePassword();
      e.preventDefault();
    });
  }

  if (path == "/deposit") {
    $("#bb").addClass("active");
  }

  if (path == "/withdraw") {
    $("#cc").addClass("active");
  }

  if (path == "/mycoupons") {
    $("#dd").addClass("active");
  }

  if (path == "/mytransactions") {
    $("#ee").addClass("active");
  }

  if (path == "/myextract") {
    $("#ff").addClass("active");
  }

  if (path == "/mybonuses") {
    $("#gg").addClass("active");
  }

  $(document).on("click", "#captcha_img", function (e) {
    $(this).attr("src", "/services/securitycode?" + Math.random());
    e.preventDefault();
  });

  $(document).on("click", ".reset-coupon", function (e) {
    fnClearCoupon();
  });
  $(document).on("click", ".passpass", function (e) {
    popup_resetpassword();
  });

  $(document).on("click", "#frm_btn_signin", function (e) {
    fnresetpassword();
  });

  $(document.body).on("keyup", "#edtUsername", function (e) {
    if (e.which == 13) {
      $("#edtPassword").focus();
    }
  });
  $(document.body).on("keyup", "#edtPassword", function (e) {
    if (e.which == 13) {
      fnLoginCheck();
    }
  });
  $(document).on("click", "#signupbutton", function (e) {
    fnNewCustomer();
  });

  $(document).on("click", ".btn_accept_coupon", function (e) {
    //alert(1);

    savecouponnew();
  });

  $(".hour-li").click(function () {
    $(".hour_selected").html($(this).html());
    $(".hour-li").removeClass("selected");
    $(this).addClass("selected");
    fnPreListfilter($(this).attr("data-hour"));
  });

  $(document).on("click", ".banktransfer", function (e) {
    $("#formDeposit").show();
    $("#formDepositMobileBank").hide();
    $("#formDepositwebnakit").hide();
  });

  $(document).on("click", ".cepbank", function (e) {
    $("#formDeposit").hide();
    $("#formDepositMobileBank").show();
    $("#formDepositwebnakit").hide();
  });

  $(document).on("click", ".webnakit", function (e) {
    $("#formDeposit").hide();
    $("#formDepositMobileBank").hide();
    $("#formDepositwebnakit").show();
  });
});

var macekliyor = 0;
function addslip(id, grup, tur, oran) {
  $(".count-in-betslip").html(parseInt($(".count-in-betslip").html()) + 1);

  if (macekliyor == 1) return false;

  $.ajax({
    url: "/services/addmatch/" + id + "/" + grup + "/" + tur + "/" + oran,
    success: function (cevap) {
      macekliyor = 0;
      if (cevap == "var") {
        alert("Bu maç kuponda ekli");
      } else {
        lecevap = cevap.split("-----");
        $("#kupon").append(lecevap[0]);

        oranhesapla();
        fnUpdateCoupon();
      }
    },
  });

  oranhesapla();
}

function bultenget(veri) {
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/content/betting-theme/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/content/betting-theme/images/spinner.gif" /></div>'
  );

  $.ajax({
    url: "/sports/bulten/1",
    type: "post",
    data: veri,
    success: function (data) {
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function addsliplive(id, grup, tur, oran) {
  if (macekliyor == 1) return false;

  $.ajax({
    url: "/services/addmatchlive/" + id + "/" + grup + "/" + tur + "/" + oran,
    success: function (cevap) {
      macekliyor = 0;
      if (cevap == "var") {
        alert("Bu maç kuponda ekli");
      } else {
        lecevap = cevap.split("-----");
        $("#kupon").append(lecevap[0]);

        oranhesapla();
        fnUpdateCoupon();
      }
    },
  });

  oranhesapla();
}

function removematch(id, macid) {
  $.ajax({
    url: "/sports/removematch/" + id,
    success: function (cevap) {
      $("#main-right").removeClass("sidebar-open");
      $(".main-overlay").removeClass("show");
      $("html").removeClass("fix-position");

      $(".count-in-betslip").html(parseInt($(".count-in-betslip").html()) - 1);
      fnUpdateCoupon();
    },
  });
}
function content_block(container) {
  $(container).append(
    '<i class="fa fa-spinner fa-pulse content_loading_spinner"></i>'
  );
}

function content_unblock(container) {
  $(container).children(".content_loading_spinner").remove();
}
$(document).on("click", "#match_list_sides_1", function (e) {
  $(".match_list_row").removeClass("selected_pre_match");
  $(this).parent(".match_list_row").addClass("selected_pre_match");
  $(".match_list_sides_2_content").slideUp(250);
  $(this)
    .parent(".match_list_row")
    .children(".match_list_sides_2_content")
    .mCustomScrollbar("destroy");
  if (
    $(this)
      .parent(".match_list_row")
      .children(".match_list_sides_2_content")
      .is(":visible") == false
  ) {
    $(this)
      .parent(".match_list_row")
      .children(".match_list_sides_2_content")
      .slideDown(250);
    list_prematchdetail(
      $(this).parent(".match_list_row").attr("data-MatchID"),
      $(this).parent(".match_list_row").attr("data-DataSource")
    );
  } else {
    $(this).parent(".match_list_row").removeClass("selected_pre_match");
  }
  e.preventDefault;
});

function list_prematchdetail(MatchID, DataSource) {
  $(".match_list_sides_2_content").mCustomScrollbar("destroy");
  content_block($("#match_" + MatchID).children(".match_list_sides_2_content"));
  $.ajax({
    type: "POST",
    url: "/services/matchdetails",
    data: "MatchID=" + MatchID,
    success: function (data) {
      $("#match_" + MatchID)
        .children(".match_list_sides_2_content")
        .html(data);
      content_unblock(
        $("#match_" + MatchID).children(".match_list_sides_2_content")
      );
      $(".match_list_sides_2_content").mCustomScrollbar({
        scrollInertia: 2000,
        mouseWheelPixels: 160,
      });
    },
  });
}
function oranhesapla() {
  var sonuc = 1;
  $("#kupon .kupon-rate").each(function (key, val) {
    sonuc *= $(val).html();
  });
  $("#kupon_combine_odd").html(Math.round(sonuc * 100) / 100);
  kazanchesapla();
  if (sonuc == 1) {
    //$('.sag-tablo-kupon-detay').hide();
    $(".kupon-bos").show();
  }
}

function kazanchesapla() {
  $(".makskazanc-rakam").html(
    addCommas(
      Math.round($(".oran-rakam").html() * $(".kmiktar").val() * 100) / 100
    ) + " TL"
  );
}

function fnLoginCheck() {
  $.ajax({
    type: "POST",
    data:
      "username=" +
      $("#edtUsername").val() +
      "&password=" +
      $("#edtPassword").val(),
    url: "/services/login",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        location.reload();
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      }
    },
  });
}

function paparaDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&paparanamesurname=" +
      $("#paparanamesurname").val() +
      "&paparamoney=" +
      $("#paparamoney").val(),
    url: "/myaccount/PaparaDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function paparaIBANDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&paparaibannamesurname=" +
      $("#paparaibannamesurname").val() +
      "&paparaibanmoney=" +
      $("#paparaibanmoney").val(),
    url: "/myaccount/PaparaIBANDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlikartDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&kartnamesurname=" +
      $("#kartnamesurname").val() +
      "&kartmoney=" +
      $("#kartmoney").val(),
    url: "/myaccount/hizlikartDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlifastDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&fastnamesurname=" +
      $("#fastnamesurname").val() +
      "&fastmoney=" +
      $("#fastmoney").val(),
    url: "/myaccount/hizlifastDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlitoslaDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&toslanamesurname=" +
      $("#toslanamesurname").val() +
      "&toslamoney=" +
      $("#toslamoney").val(),
    url: "/myaccount/hizlitoslaDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlikriptoDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&kriptonamesurname=" +
      $("#kriptonamesurname").val() +
      "&kriptomoney=" +
      $("#kriptomoney").val(),
    url: "/myaccount/hizlikriptoDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlimefeteDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&mefetenamesurname=" +
      $("#mefetenamesurname").val() +
      "&mefetemoney=" +
      $("#mefetemoney").val(),
    url: "/myaccount/hizlimefeteDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlipaycellDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&paycellnamesurname=" +
      $("#paycellnamesurname").val() +
      "&paycellmoney=" +
      $("#paycellmoney").val(),
    url: "/myaccount/hizlipaycellDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlipepleDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&peplenamesurname=" +
      $("#peplenamesurname").val() +
      "&peplemoney=" +
      $("#peplemoney").val(),
    url: "/myaccount/hizlipepleDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlipayfixDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&payfixnamesurname=" +
      $("#payfixnamesurname").val() +
      "&payfixmoney=" +
      $("#payfixmoney").val(),
    url: "/myaccount/hizlipayfixDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlicepbankDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&cepbanknamesurname=" +
      $("#cepbanknamesurname").val() +
      "&cepbankmoney=" +
      $("#cepbankmoney").val(),
    url: "/myaccount/hizlicepbankDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlikassaDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&kassanamesurname=" +
      $("#kassanamesurname").val() +
      "&kassamoney=" +
      $("#kassamoney").val(),
    url: "/myaccount/hizlikassaDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlicmtDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&cmtnamesurname=" +
      $("#cmtnamesurname").val() +
      "&cmtmoney=" +
      $("#cmtmoney").val(),
    url: "/myaccount/hizlicmtDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function hizlinaysDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );

  $.ajax({
    type: "POST",
    data:
      "&naysnamesurname=" +
      $("#naysnamesurname").val() +
      "&naysmoney=" +
      $("#naysmoney").val(),
    url: "/myaccount/hizlinaysDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function pepleDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&peplenamesurname=" +
      $("#peplenamesurname").val() +
      "&peplemoney=" +
      $("#peplemoney").val(),
    url: "/myaccount/pepleDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function bitcoinDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&bitcoinnamesurname=" +
      $("#bitcoinnamesurname").val() +
      "&bitcoinmoney=" +
      $("#bitcoinmoney").val(),
    url: "/myaccount/bitcoinDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function tetherDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&tethernamesurname=" +
      $("#tethernamesurname").val() +
      "&tethermoney=" +
      $("#tethermoney").val(),
    url: "/myaccount/tetherDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function mefeteDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&mefetenamesurname=" +
      $("#mefetenamesurname").val() +
      "&mefetemoney=" +
      $("#mefetemoney").val(),
    url: "/myaccount/mefeteDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function jetonDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&jetonnamesurname=" +
      $("#jetonnamesurname").val() +
      "&jetonmoney=" +
      $("#jetonmoney").val(),
    url: "/myaccount/jetonDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function cmtDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&cmtnamesurname=" +
      $("#cmtnamesurname").val() +
      "&cmtmoney=" +
      $("#cmtmoney").val(),
    url: "/myaccount/cmtDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function payfixDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&payfixnamesurname=" +
      $("#payfixnamesurname").val() +
      "&payfixmoney=" +
      $("#payfixmoney").val(),
    url: "/myaccount/payfixDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function paraodeDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&paraodenamesurname=" +
      $("#paraodenamesurname").val() +
      "&paraodemoney=" +
      $("#paraodemoney").val(),
    url: "/myaccount/paraodeDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function bankDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&time=" +
      $("#time").val() +
      "&bank=" +
      $("#bank").val() +
      "&namesurname=" +
      $("#namesurname").val() +
      "&money=" +
      $("#money").val(),
    url: "/myaccount/DepositOk?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        if (json.redirectUrl) {
          window.location.href = json.redirectUrl;
        } else {
          Ply.dialog(
            "alert",
            { effect: "3d-sign" },
            "Para Yatırma Talebiniz, İncelenmek Üzere Kayıt Edilmiştir."
          );
        }
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function qrDeposit() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "&qrbank=" + $("#qrbank").val() + "&qrmoney=" + $("#qrmoney").val(),
    url: "/myaccount/qrDeposit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        $("#qrframe").html(
          "<a href='" +
            json.vUrl +
            "' target='_blank' class='remodal-confirm' style='padding: 15px 20px 15px 20px;'>KOD TARATMAK İÇİN TIKLAYINIZ >> </a>"
        );
        var inst = $("[data-remodal-id=qrcode]").remodal();
        inst.open();
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnMobileBankOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "bonuscep=" +
      $("#bonuscep").val() +
      "&bank=" +
      $("#bank2").val() +
      "&note=" +
      $("#note").val() +
      "&gtel=" +
      $("#gtel").val() +
      "&atel=" +
      $("#atel").val() +
      "&atc=" +
      $("#atc").val() +
      "&referans=" +
      $("#referans").val() +
      "&money=" +
      $("#money2").val(),
    url: "/myaccount/MobileBankOk?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnBkmExpress() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "bonuscep=" +
      "BKM" +
      "&bank=" +
      $("#bkmBank").val() +
      "&note=" +
      $("#bkmNote").val() +
      "&gtel=" +
      $("#bkmGtel").val() +
      "&atel=" +
      $("#bkmAtel").val() +
      "&atc=" +
      $("#bkmAtc").val() +
      "&referans=" +
      $("#bkmRef").val() +
      "&money=" +
      $("#bkmMoney").val(),
    url: "/myaccount/MobileBankOk?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}
function fnCreditCard() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "&creditTel=" +
      $("#creditTel").val() +
      "&creditMoney=" +
      $("#creditMoney").val(),
    url: "/myaccount/CreditCard?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnAstroPay() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "astroCardno=" +
      $("#astroCardno").val() +
      "&astroCardCode=" +
      $("#astroCardCode").val() +
      "&astroMonth=" +
      $("#astroMonth").val() +
      "&astroYear=" +
      $("#astroYear").val() +
      "&astroMoney=" +
      $("#astroMoney").val(),
    url: "/myaccount/AstroPay?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Para Yatırma Talebiniz,İncelenmek Üzere Kayıt Edilmiştir."
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnPaparaWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "cardno=" + $("#cardno").val() + "&quantity=" + $("#quantity").val(),
    url: "/myaccount/PaparaWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnPepleWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "cardnopeple=" +
      $("#cardnopeple").val() +
      "&quantitypeple=" +
      $("#quantitypeple").val(),
    url: "/myaccount/PepleWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnbtcWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "btcno=" + $("#btcno").val() + "&quantitybtc=" + $("#quantitybtc").val(),
    url: "/myaccount/btcWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fntetherWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "tetherno=" +
      $("#tetherno").val() +
      "&quantitytether=" +
      $("#quantitytether").val(),
    url: "/myaccount/tetherWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fncmtWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "cardnocmt=" +
      $("#cardnocmt").val() +
      "&quantitycmt=" +
      $("#quantitycmt").val(),
    url: "/myaccount/cmtWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnpayfixWithdraw() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "cardnopayfix=" +
      $("#cardnopayfix").val() +
      "&quantitypayfix=" +
      $("#quantitypayfix").val(),
    url: "/myaccount/payfixWithdraw?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnPaparaOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "cardno=" + $("#cardno").val() + "&quantity=" + $("#quantity").val(),
    url: "/myaccount/Tlnakit?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnPayzwinOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "payzno=" + $("#payzno").val() + "&payzmik=" + $("#payzmik").val(),
    url: "/myaccount/Payzwin?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnProfileUpdate() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "old_password=" +
      $("#old_password").val() +
      "&new_password=" +
      $("#new_password").val() +
      "&new_password_repeat=" +
      $("#new_password_repeat").val(),
    url: "/myaccount/changepassword?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);

      Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function fnrakeupdate() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "miktar=" + $("#miktar").val(),
    url: "/myaccount/rakeTransfer?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);

      Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function fnPokerPasswordChange() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "poker_password=" +
      $("#poker_password").val() +
      "&poker_password_repeat=" +
      $("#poker_password_repeat").val(),
    url: "/myaccount/pokerpasswordchange?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function fnecoPayzOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "cardno=" + $("#cardno").val() + "&quantity=" + $("#quantity").val(),
    url: "/myaccount/ecoPayz?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnNetellerOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "cardno=" + $("#cardno").val() + "&quantity=" + $("#quantity").val(),
    url: "/myaccount/Neteller?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function StatsDetails(id) {
  var url = "https://s5.sir.sportradar.com/sbtechgi/tr/match/" + id;
  window.open(url, "İstatistik", "width=1100,height=800");
}

function fnBitcoin() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data: "bitcoinamount=" + $("#bitcoinamount").val(),
    url: "/myaccount/bitCoin?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        $("#btciframe").html(
          "<iframe  id='frame' name='frame' src='" +
            json.vUrl +
            "' width='600'  height='600'   allowfullscreen></iframe>"
        );
        var inst = $("[data-remodal-id=bitcoin]").remodal();
        inst.open();
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnWithDrawOk() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "bank=" +
      $("#bank").val() +
      "&sube=" +
      $("#sube").val() +
      "&hesap=" +
      $("#hesap").val() +
      "&iban=" +
      $("#iban").val() +
      "&money=" +
      $("#money").val(),
    url: "/myaccount/WithDawOk?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Çekim İşleminiz Başarıyla Kayıt Edildi"
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
        fnGetBalance();
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnWithDraw2Ok() {
  $("body").append(
    '<div id="loadoverlay" class="paymentpages"><div class="loader">Loading...</div></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "bank2=" +
      $("#bank2").val() +
      "&sube2=" +
      $("#sube2").val() +
      "&hesap2=" +
      $("#hesap2").val() +
      "&iban2=" +
      $("#iban2").val() +
      "&money2=" +
      $("#money2").val(),
    url: "/myaccount/WithDraw2Ok?rand=" + Math.random(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Çekim İşleminiz Başarıyla Kayıt Edildi"
        );
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
        fnGetBalance();
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
        $("body").children("#loadoverlay").fadeOut(250);
        setTimeout(function () {
          $("body").children("#loadoverlay").remove();
        }, 250);
      }
    },
  });
}

function fnPreListBySearch() {
  $.ajax({
    type: "POST",
    data: "&letter=" + $("#header_search_input").val(),
    url: "/services/search",
    success: function (data) {
      $("#content").html(data);
      $("#main-left").removeClass("sidebar-open");
      $(".main-overlay").removeClass("show");
      scrollToTop(0);
    },
  });
}

function fnPreListfilter(type) {
  $.ajax({
    type: "POST",
    data: "&type=" + type,
    url: "/services/filterhour",
    success: function (data) {
      $("#content").html(data);

      scrollToTop(0);
    },
  });
}

function fnPreListBySport(SportID) {
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/content/betting-theme/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/content/betting-theme/images/spinner.gif" /></div>'
  );
  $.ajax({
    type: "POST",
    data: "hour=" + $("#slider").attr("data-hour") + "&SportID=" + SportID,
    url: "/prelistbysport",
    success: function (data) {
      $("#mainContent").html(data);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);

      scrollToTop(0);
    },
  });
}
function fnPreListByDefault(slider_hour) {
  var hour = slider_hour;
  if (hour == "") hour = $("#slider").attr("data-hour");
  if (hour > 12) hour = 12;
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/images/spinner.gif" /></div>'
  );
  $.ajax({
    type: "POST",
    data: "hour=" + hour,
    url: "/prelistbydefault",
    success: function (data) {
      $("#mainContent").html(data);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);
    },
  });
}

function fnPreListByTournament(TournamentID) {
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/images/spinner.gif" /></div>'
  );
  $.ajax({
    type: "POST",
    data:
      "hour=" +
      $("#slider").attr("data-hour") +
      "&TournamentID=" +
      TournamentID,
    url: "/prelistbytournament",
    success: function (data) {
      $("#mainContent").html(data);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);

      scrollToTop(0);
    },
  });
}

function fnPreListByCategory(CategoryID, tis) {
  $(tis).toggleClass("active");

  if ($(tis).hasClass("active")) {
    $(".subtype").hide();

    $("#content").html(
      '<div align="center"><div class="loader" style="color:#000;">Loading...</div></div>'
    );
    GetMatchs(CategoryID);
    $.ajax({
      type: "POST",
      data: "&CategoryID=" + CategoryID,
      url: "/sports/countrys/" + CategoryID,
      success: function (data) {
        $("#mnt" + CategoryID).html(data);
        $("#mnt" + CategoryID).show();

        scrollToTop(0);
      },
    });
  } else {
    $("#mnt" + CategoryID).html("");
    $("#mnt" + CategoryID).hide();
  }
}

function fnPreListByCategoryindex(CategoryID) {
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/content/betting-theme/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/content/betting-theme/images/spinner.gif" /></div>'
  );
  $.ajax({
    type: "POST",
    data: "&CategoryID=" + CategoryID,
    url: "/sports/upcomingevents/" + CategoryID,
    success: function (data) {
      $("#betmanin").html(data);
      $("body").children("#loadoverlay").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay").remove();
      }, 250);

      scrollToTop(0);
    },
  });
}

function GetMatchs(CategoryID) {
  if ($("#mnt" + CategoryID).css("display") == "none") {
    content_block("#content");

    $.ajax({
      type: "POST",
      data: "&CategoryID=" + CategoryID,
      url: "/sports/bulten/1/" + CategoryID,
      success: function (data) {
        $("#content").html(data);
        scrollToTop(0);
      },
    });
  } else {
    $(".manticancik").css("display", "none");
  }
}

function fnPreListByCountry(CategoryID, Type) {
  //content_block('#content');
  $.ajax({
    type: "POST",
    data: "&CategoryID=" + CategoryID,
    url: "/sports/CountryMatch/" + CategoryID + "/" + Type,
    success: function (data) {
      $("#content").html(data);
      scrollToTop(0);
    },
  });
}

function GetTracker(id) {
  content_block(".lmt-container");
  $.ajax({
    type: "POST",
    data: "matchid=" + id,
    url: "/services/livematchtracker",
    success: function (data) {
      $(".lmt-container").html(data);
    },
  });

  content_block(".lmt-container1");
  $.ajax({
    type: "POST",
    data: "matchid=" + id,
    url: "/services/livematchtracker1",
    success: function (data) {
      $(".lmt-container1").html(data);
    },
  });
}

function getpromo(id) {
  $.ajax({
    type: "POST",
    data: "promo=" + id,
    url: "/services/getpromo",
    success: function (data) {
      $("#data").html(data);
    },
  });
}

function mtoggle2(id) {
  $("." + id).slideToggle();
}

function fnDeleteCoupon(couponid) {
  $.ajax({
    type: "POST",
    data: "couponid=" + couponid,
    url: "/deletecoupon",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.success(json.vContent);
        $(".coupon_sil[data-couponid=" + couponid + "]")
          .parent("td")
          .parent("tr")
          .children("td")
          .addClass("deleted_coupon");
        $(".coupon_sil[data-couponid=" + couponid + "]")
          .parent("td")
          .parent("tr")
          .children("td")
          .eq(7)
          .html("");
        fnGetBalance();
      } else {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
    },
  });
}
function fnClearCoupon() {
  document.cookie = "coupons=;path=/; expires=Thu, 01-Jan-70 00:00:01 GMT;";

  $("#main-right").removeClass("sidebar-open");
  $(".main-overlay").removeClass("show");
  $("html").removeClass("fix-position");

  fnUpdateCoupon();
}

function fnAddPreMatch(OddsID, Odds, OddsOrder, DataSource) {
  $.ajax({
    type: "POST",
    data:
      "OddsID=" +
      OddsID +
      "&Odds=" +
      Odds +
      "&OddsOrder=" +
      OddsOrder +
      "&DataSource=" +
      DataSource,
    url: "/addprematch",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        fnUpdateCoupon();
      } else {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
    },
  });
}

function list_livematch() {
  $.ajax({
    url: "/services/livematchs/3",
    success: function (data) {
      $(".live_left_content").html(data);
    },
  });
}

function list_livematchh() {
  $.ajax({
    url: "/services/livematchs",
    success: function (data) {
      $(".live_left_content").html(data);
    },
  });
}

function fnAddLiveMatch(OddsID, Odds, OddsOrder, DataSource) {
  $.ajax({
    type: "POST",
    data:
      "OddsID=" +
      OddsID +
      "&Odds=" +
      Odds +
      "&OddsOrder=" +
      OddsOrder +
      "&DataSource=" +
      DataSource,
    url: "/addlivematch",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        fnUpdateCoupon();
      } else {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
    },
  });
}

function fnAddOutright(OddsID, Odds, OddsOrder, DataSource) {
  $.ajax({
    type: "POST",
    data:
      "OddsID=" +
      OddsID +
      "&Odds=" +
      Odds +
      "&OddsOrder=" +
      OddsOrder +
      "&DataSource=" +
      DataSource,
    url: "/addoutright",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        fnUpdateCoupon();
      } else {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
    },
  });
}

function fnRemoveMatch(MatchID, DataSource) {
  $("#waiting").show();
  $.ajax({
    type: "POST",
    data: "MatchID=" + MatchID + "&DataSource=" + DataSource,
    url: "/removematch",
    success: function (data) {
      fnUpdateCoupon();
    },
  });
}

function fnUpdateCoupon() {
  content_block(".right_coupon");
  $.ajax({
    type: "POST",
    data: "dummy=dummy",
    url: "/sports/mycoupons",
    success: function (data) {
      $(".right_coupon").html(data);
      var matchesCount = $(".remove-match").length;
      $(".count-in-betslip").html(matchesCount);
      if (matchesCount != 0) {
        $("#betSlipHeader").show("");
      } else {
        $("#betSlipHeader").hide("");
      }
    },
  });
}

function fnCalculatePayout() {
  var checkboxvalues = $('input[name="edtSystem"]:checked')
    .map(function () {
      return this.value;
    })
    .get();
  $.ajax({
    type: "POST",
    data:
      "amount=" +
      $("#edtAmount").val().replace(/\./g, "").replace(",", ".") +
      "&system=" +
      checkboxvalues.join(","),
    url: "/calculatepayout",
    //contentType: "application/json; charset=utf-8",
    success: function (data) {
      //alert(data);
      var result = $.parseJSON(data);
      try {
        $("#totalAmount").html(
          addCommas(result.data.Payout.toFixed(2)) + " " + sesi_currency
        );
        $("#totalCoupons").html(result.data.CouponCount);
      } catch (ex) {
        $("#totalAmount").html("0,00");
        $("#totalCoupons").html("0");
      }
    },
  });
}
function addCommas(nStr) {
  nStr += "";
  x = nStr.split(".");
  x1 = x[0];
  x2 = x.length > 1 ? "," + x[1] : "";
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, "$1" + "." + "$2");
  }
  return x1 + x2;
}

function fnConfirmCouponHide() {
  $("#kuponOnayPopup").fadeOut(250);
  $("#overlayBG").hide();
  $("body").css({ overflow: "auto" });
}
function fnConfirmCoupon() {
  if (
    $("#totalAmount").has(".dot_anim").length == 0 &&
    $("#totalAmount").html() != "0,00 TRY" &&
    $("#totalAmount").html() != "0,00" &&
    $(".cBet").length > 0
  ) {
    $("body").css({ overflow: "hidden" });
    var checkboxvalues = $('input[name="edtSystem"]:checked')
      .map(function () {
        return this.value;
      })
      .get();
    $.ajax({
      type: "POST",
      data:
        "oran=" +
        $(".oran-rakam").html() +
        "&mac_sayisi=" +
        $(".cBet").length +
        "&totalCoupons=" +
        $("#totalCoupons").html() +
        "&totalAmount=" +
        $("#totalAmount").html() +
        "&edtAmount=" +
        $("#edtAmount").val() +
        "&edtSystem=" +
        checkboxvalues.join(","),
      url: "/confirmcoupon",
      success: function (data) {
        $("#kuponOnayPopup").html(data);
        $("#kuponOnayPopup").fadeIn(200);
        $("#overlayBG").show();
      },
    });
  }
}
function fnSaveCoupon() {
  $("body").append(
    '<div id="loadoverlay_coupon" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/images/spinner.gif" /></div>'
  );
  var checkboxvalues = $('input[name="edtSystem"]:checked')
    .map(function () {
      return this.value;
    })
    .get();
  if ($("#edtAcceptChanges").is(":checked")) {
    var pAcceptChanges = "TRUE";
  } else {
    var pAcceptChanges = "FALSE";
  }
  $.ajax({
    type: "POST",
    data:
      "edtAmount=" +
      $("#edtAmount").val() +
      "&edtSystem=" +
      checkboxvalues.join(",") +
      "&edtAcceptChanges=" +
      pAcceptChanges,
    url: "/savecoupon",
    success: function (data) {
      var json = $.parseJSON($.trim(data));
      if (json.vResult == "TRUE") {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.success(json.vContent);
        fnConfirmCouponHide();
        fnUpdateCoupon();
        fnGetBalance();
      } else {
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
      $("body").children("#loadoverlay_coupon").fadeOut(250);
      setTimeout(function () {
        $("body").children("#loadoverlay_coupon").remove();
      }, 250);
    },
  });
}

function fnGetBalance() {
  $.ajax({
    type: "POST",
    data: "dummy=dummy",
    url: "/myaccount/mybalance",
    success: function (data) {
      $("#balances").html(data);
    },
  });
}
function sendmessage(message_to_error, message_text_error) {
  $("#btn_send_message").css({
    background: "url(/messageimages/sendpush.png)",
  });
  if ($("#message_to").val() == "") {
    toastr.options = {
      progressBar: true,
      closeButton: true,
      positionClass: "toast-top-right",
    };
    toastr.error(message_to_error);
    $("#btn_send_message").css({ background: "url(/messageimages/send.png)" });
  } else if ($("#message_text").val() == "") {
    toastr.options = {
      progressBar: true,
      closeButton: true,
      positionClass: "toast-top-right",
    };
    toastr.error(message_text_error);
    $("#btn_send_message").css({ background: "url(/messageimages/send.png)" });
  } else {
    $.ajax({
      type: "POST",
      data:
        "tocustomerid=" +
        $("#message_to").val() +
        "&messagetext=" +
        $("#message_text").val(),
      url: "/sendmessage",
      success: function (data) {
        var json = $.parseJSON(data);
        if (json.vResult == "TRUE") {
          clearInterval(msg_int);
          getmessages();
          msg_int = setInterval(function () {
            getmessages();
          }, 10000);
          $("#message_text").val("");
        } else {
          toastr.options = {
            progressBar: true,
            closeButton: true,
            positionClass: "toast-top-right",
          };
          toastr.error(message_to_error + "<br />" + message_text_error);
        }
        $("#btn_send_message").css({
          background: "url(/messageimages/send.png)",
        });
      },
    });
  }
}
function getmessages() {
  $.ajax({
    type: "POST",
    url: "/getmessagelist",
    success: function (data) {
      $("#messages").html(data);
      $("#messages").mCustomScrollbar("destroy");
      $("#messages").mCustomScrollbar({ scrollInertia: 20 });
      $("#messages").mCustomScrollbar("scrollTo", "bottom");
      //setTimeout(function(){ fnGetMessageCount(); }, 5000);
    },
  });
}
function fnGetMessageCount() {
  $.ajax({
    type: "POST",
    url: "/getmessagecount",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.result == true) {
        if (json.data != 0) {
          $("#message_envelope")
            .children("img")
            .addClass("messegae_blink")
            .attr("src", "/icons/envelope_orange.png");
          $("#message_envelope");
        } else
          $("#message_envelope")
            .children("img")
            .removeClass("messegae_blink")
            .attr("src", "/icons/envelope_green.png");
      } else {
        $("#message_envelope")
          .children("img")
          .removeClass("messegae_blink")
          .attr("src", "/icons/envelope_green.png");
      }
    },
  });
}

function scrollToTop(padding) {
  $("html, body").animate(
    {
      scrollTop: padding - 100,
    },
    300
  );
}

function fnChangeLanguage() {
  $("body").append(
    '<div id="loadoverlay" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background:url(/images/darkoverlay.png); text-align:center; padding-top:200px; z-index:10000;"><img alt="" src="/images/spinner.gif" /></div>'
  );
  $.ajax({
    type: "POST",
    data: "Language=" + $("#edtLanguage").val(),
    url: "/changelanguage",
    success: function (data) {
      location.reload(true);
      $("html, body").animate({ scrollTop: 0 }, 300);
    },
  });
}

function fnNewCustomer() {
  $.ajax({
    type: "POST",
    data:
      "username=" +
      $("#username").val() +
      "&" +
      "tc=" +
      $("#tc").val() +
      "&" +
      "country=" +
      $("#country").val() +
      "&" +
      "name=" +
      $("#name").val() +
      "&" +
      "surname=" +
      $("#surname").val() +
      "&" +
      "phone=" +
      $("#phone").val() +
      "&" +
      "password=" +
      $("#password").val() +
      "&" +
      "password2=" +
      $("#password2").val() +
      "&" +
      "day=" +
      $("#day").val() +
      "&" +
      "month=" +
      $("#month").val() +
      "&" +
      "year=" +
      $("#year").val() +
      "&" +
      "il=" +
      $("#il").val() +
      "&" +
      "ref=" +
      $("#ref").val() +
      "&" +
      "email=" +
      $("#email").val(),
      // "bonusadds=" +
      // $("#freespin").val(),

    url: "/services/signin",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog(
          "alert",
          { effect: "3d-sign" },
          "Üyelik İşleminiz Tamamlanmıştır. Giriş yapılıyor."
        );

        $.ajax({
          type: "POST",
          data: {
            username: $("#username").val(),
            password: $("#password").val(),
          },
          url: "/services/login",
          success: function (data) {
            var json = $.parseJSON(data);
            if (json.vResult == "TRUE") {
              location.reload();
            }
          },
        });

        //location.reload();
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      }
    },
  });
}

function fnForgotPass() {
  $("body").addClass("loading");
  $.ajax({
    type: "POST",
    data:
      "edtCaptcha=" +
      $("#edtForgotCaptcha").val() +
      "&" +
      "edtEmail=" +
      $("#edtForgotEmail").val(),
    url: "/sendpass",
    success: function (data) {
      $("body").removeClass("loading");
      $("#edtForgotCaptcha").val("");
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        $("#forgotCaptcha").attr("src", "captcha/captcha?" + Math.random());
        $("#forgotPasswordContainer")
          .empty()
          .html("<p>" + json.vContent + "</p>");
        setTimeout(function () {
          fnForgotPassClose();
        }, 10000);
      } else {
        $("#forgotCaptcha").attr("src", "captcha/captcha?" + Math.random());
        toastr.options = {
          progressBar: true,
          closeButton: true,
          positionClass: "toast-top-right",
        };
        toastr.error(json.vContent);
      }
    },
  });
}

function commaSeparateNumber(val) {
  while (/(\d+)(\d{3})/.test(val.toString())) {
    val = val.toString().replace(/(\d+)(\d{3})/, "$1" + "." + "$2");
  }
  return val;
}

function mtoggle(id) {
  $("#" + id).slideToggle();
}

function bakiyeguncel() {
  $.ajax({
    url: "/myaccount/bakiyem",
    cache: false,
    success: function (data) {
      $("#customerBalance").html(data);
    },
  });
}

function loadpage(page) {
  $("#pageblock").hide();
  $.ajax({
    url: "/myaccount/" + page,
    cache: false,
    success: function (data) {
      $("#pageblock").html(data);
      $("#pageblock").show();
      var yuksek = $("#pageblock").outerHeight();
      $("#accountModal").height(yuksek + 50);
      $("#leftleft").height(yuksek + 50);
    },
  });
}

function savecouponnew() {
  if ($("#kcanli").val() == 1) {
    content_block(".right_coupon");
    setTimeout(savecouponnew2, 15 * 1000);
  } else {
    savecouponnew2();
  }
}
function savecouponnew2() {
  $("#couponx").addClass("hidden");
  $("#xcoupon").removeClass("hidden");
  if ($(".kmiktar").val() && $(".kmiktar").val() != "0.00") {
    $.ajax({
      url: "/myaccount/savecoupon",
      data:
        "miktar=" +
        $(".kmiktar").val() +
        "&retain_selection=" +
        $("#retain_selection:checked").val(),
      type: "post",
      success: function (data) {
        if (data == "ok") {
          fnClearCoupon();
          $(".kadi").val("");
          $(".kmiktar").val("");
          random = Math.floor(Math.random() * 10000 + 1);
          fnGetBalance();
          Ply.dialog(
            "alert",
            { effect: "3d-sign" },
            "Kuponunuz Başarıyla Yatırıldı."
          );
          content_unblock(".right_coupon");
          $("#xcoupon").addClass("hidden");
          $("#couponx").removeClass("hidden");
          $(".kmiktar").prop("disabled", false);
        } else {
          Ply.dialog("alert", { effect: "3d-sign" }, data);
          content_unblock(".right_coupon");
          $("#xcoupon").addClass("hidden");
          $("#couponx").removeClass("hidden");
          $(".kmiktar").prop("disabled", false);
        }
      },
    });
  } else {
    Ply.dialog("alert", { effect: "3d-sign" }, "Kupon Miktarı Boş Olamaz");
    $("#xcoupon").addClass("hidden");
    $(".kmiktar").prop("disabled", false);
    $("#couponx").removeClass("hidden");
  }
}

function popup_resetpassword() {
  $.ajax({
    type: "POST",
    url: "/services/popupreset",
    data: "type=sport",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.result) {
        $("#bodymodal").html(json.data);
        $("#bodymodal").modal();
      }
    },
  });
}

function fnresetpassword() {
  $.ajax({
    type: "POST",
    data: "tc=" + $("#tc").val() + "&email=" + $("#email").val(),
    url: "/services/resetpassword",
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.vResult == "TRUE") {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      } else {
        Ply.dialog("alert", { effect: "3d-sign" }, json.vContent);
      }
    },
  });
}

function fngetbankinfo() {
  $.ajax({
    type: "POST",
    data: "bank=" + $("#bank").val(),
    url: "/services/getbankinfo",
    success: function (data) {
      $("#bankinfo").html(data);
    },
  });
}

function GetPasswordForm() {
  content_block($(".member_content_center"));
  $.ajax({
    type: "POST",
    url: "/services/updatepass",
    data: "get_password_form=",
    success: function (data) {
      var json = $.parseJSON(data);

      if (json.result.result) {
        $("#bodymodal").html(json.modal);
        $("#bodymodal").modal();
      }
      content_unblock($(".member_content_center"));
    },
    error: function AjaxFailed(result) {
      content_unblock($(".member_content_center"));
    },
  });
}

function ChangePassword() {
  $("#password-result").html(" ");
  content_block($("#bodymodal"));
  $.ajax({
    type: "POST",
    url: "/myaccount/changepassword",
    data:
      "old_password=" +
      $("#old_password").val() +
      "&new_password=" +
      $("#new_password").val() +
      "&new_password_repeat=" +
      $("#new_password_repeat").val(),
    success: function (data) {
      var json = $.parseJSON(data);
      if (json.result) {
        $("#password-result").html(json.message);
        setTimeout(function () {
          $("#bodymodal").modal("hide");
        }, 2000);
        content_unblock($("#bodymodal"));
      } else {
        if (json.login) {
          $("#password-result").html(json.message);
          content_unblock($("#bodymodal"));
        } else {
          $("#bodymodal").modal("hide");
          setTimeout(function () {
            $("#bodymodal").html(json.modal);
            $("#bodymodal").modal();
          }, 1000);
        }
      }
    },
    error: function AjaxFailed(result) {
      content_unblock($("#bodymodal"));
    },
  });
}

function xproLiveLogin(id, setId) {
  $.ajax({
    url: jsonUrl + "getXproGameUrl",
    type: "POST",
    data: { id: id, limitSetId: setId },
    dataType: "json",
    async: false,
    success: function (c) {
      if (c.error) {
        alert("Lütfen giriş yapınız.");
      } else {
        window.open(
          c.URL,
          "LiveCasino",
          "location=1,status=1,scrollbars=1,width=1024,height=836"
        );
      }
    },
  });
}

function xproLiveLogin(id, setId) {
  $.ajax({
    url: jsonUrl + "getXproGameUrl",
    type: "POST",
    data: { id: id, limitSetId: setId },
    dataType: "json",
    async: false,
    success: function (c) {
      if (c.error) {
        alert("Lütfen giriş yapınız.");
      } else {
        window.open(
          c.URL,
          "LiveCasino",
          "location=1,status=1,scrollbars=1,width=1024,height=836"
        );
      }
    },
  });
}
