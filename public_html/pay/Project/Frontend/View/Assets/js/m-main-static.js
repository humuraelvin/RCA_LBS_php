function scrollFunction() {
  if (document.documentElement.scrollTop <= $("#tt-ayrac").offset().top - 270) {
    $("#fixSpor").fadeOut("slow");
  }
}
function mTab(tab) {
  if (tab == 1) {
    $("html,body").animate(
      {
        scrollTop: $("#type4").offset().top - 50,
      },
      "slow"
    );
    $("#fixSpor").fadeIn("slow");
    setTimeout(function () {
      window.onscroll = function () {
        scrollFunction();
      };
    }, 1000);
  } else if (tab == 2) {
    $("html,body").animate(
      {
        scrollTop: $("#tt-ayrac").offset().top - 270,
      },
      "slow"
    );
  }
}

var dateFormat = (function () {
  var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
    timezoneClip = /[^-+\dA-Z]/g,
    pad = function (val, len) {
      val = String(val);
      len = len || 2;
      while (val.length < len) val = "0" + val;
      return val;
    };
  return function (date, mask, utc) {
    var dF = dateFormat;
    if (
      arguments.length == 1 &&
      Object.prototype.toString.call(date) == "[object String]" &&
      !/\d/.test(date)
    ) {
      mask = date;
      date = undefined;
    }
    date = date ? new Date(date) : new Date();
    if (isNaN(date)) throw SyntaxError("invalid date");
    mask = String(dF.masks[mask] || mask || dF.masks["default"]);
    if (mask.slice(0, 4) == "UTC:") {
      mask = mask.slice(4);
      utc = true;
    }
    var _ = utc ? "getUTC" : "get",
      d = date[_ + "Date"](),
      D = date[_ + "Day"](),
      m = date[_ + "Month"](),
      y = date[_ + "FullYear"](),
      H = date[_ + "Hours"](),
      M = date[_ + "Minutes"](),
      s = date[_ + "Seconds"](),
      L = date[_ + "Milliseconds"](),
      o = utc ? 0 : date.getTimezoneOffset(),
      flags = {
        d: d,
        dd: pad(d),
        ddd: dF.i18n.dayNames[D],
        dddd: dF.i18n.dayNames[D + 7],
        m: m + 1,
        mm: pad(m + 1),
        mmm: dF.i18n.monthNames[m],
        mmmm: dF.i18n.monthNames[m + 12],
        yy: String(y).slice(2),
        yyyy: y,
        h: H % 12 || 12,
        hh: pad(H % 12 || 12),
        H: H,
        HH: pad(H),
        M: M,
        MM: pad(M),
        s: s,
        ss: pad(s),
        l: pad(L, 3),
        L: pad(L > 99 ? Math.round(L / 10) : L),
        t: H < 12 ? "a" : "p",
        tt: H < 12 ? "am" : "pm",
        T: H < 12 ? "A" : "P",
        TT: H < 12 ? "AM" : "PM",
        Z: utc
          ? "UTC"
          : (String(date).match(timezone) || [""])
              .pop()
              .replace(timezoneClip, ""),
        o:
          (o > 0 ? "-" : "+") +
          pad(Math.floor(Math.abs(o) / 60) * 100 + (Math.abs(o) % 60), 4),
        S: ["th", "st", "nd", "rd"][
          d % 10 > 3 ? 0 : (((d % 100) - (d % 10) != 10) * d) % 10
        ],
      };
    return mask.replace(token, function ($0) {
      return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
    });
  };
})();
dateFormat.masks = {
  default: "ddd mmm dd yyyy HH:MM:ss",
  shortDate: "m/d/yy",
  mediumDate: "mmm d, yyyy",
  longDate: "mmmm d, yyyy",
  fullDate: "dddd, mmmm d, yyyy",
  shortTime: "h:MM TT",
  mediumTime: "h:MM:ss TT",
  longTime: "h:MM:ss TT Z",
  isoDate: "yyyy-mm-dd",
  isoTime: "HH:MM:ss",
  isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
  isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'",
};
dateFormat.i18n = {
  dayNames: [
    "Sun",
    "Mon",
    "Tue",
    "Wed",
    "Thu",
    "Fri",
    "Sat",
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ],
  monthNames: [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ],
};
Date.prototype.format = function (mask, utc) {
  return dateFormat(this, mask, utc);
};

var yyhSlider = false;
var mobilSlider = false;
var customercode_slider = sessionStorage.getItem("customerCode");
function startProgressBar() {
  $(".tt-betpas-mobil-slider-slide-progress").css({
    width: "100%",
    transition: "width 5000ms",
  });
}
function resetProgressBar() {
  $(".tt-betpas-mobil-slider-slide-progress").css({
    width: 0,
    transition: "width 0s",
  });
}
$.get("/m/assets/static/slider/slider.json", function (data) {
  var ttYeniMobilSlider =
    '<div id="tt-betpas-mobil-slider" class="owl-carousel owl-theme owl-loaded owl-drag"> <div class="owl-stage-outer" id="tt-betpas-mobil-slider-stage-container"> <div class="owl-stage" id="tt-betpas-mobil-slider-stage" style="transform: translate3d(-2484px, 0px, 0px);">';
  $(data).each(function (index, item) {
    ttYeniMobilSlider +=
      '<div class="owl-item"> <div class="tt-betpas-mobil-slider-item"> <a href="' +
      item.SlideLink +
      '"> <img src="' +
      item.SlideBackground +
      '"> </a> </div> </div>';
  });
  ttYeniMobilSlider += "</div></div></div>";
  $("#tt-betpas-yeni-mobil-slider").html(ttYeniMobilSlider);
  mobilSlider = true;
});
var anaMobilControl = setInterval(anaMobilCheck, 100);
function anaMobilControlStop() {
  clearInterval(anaMobilControl);
}
function anaMobilCheck() {
  if ($.isFunction($().owlCarousel) && mobilSlider == true) {
    anaMobilControlStop();
    $("#tt-betpas-mobil-slider").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      dots: true,
      delay: 5000,
      nav: false,
      onInitialized: startProgressBar,
      onTranslate: resetProgressBar,
      onTranslated: startProgressBar,
    });
    anaMobilControlStop();
  }
}

var anaYyhControl = setInterval(anaYyhCheck, 100);
function anaYyhControlStop() {
  clearInterval(anaYyhControl);
}
function anaYyhCheck() {
  if ($.isFunction($().owlCarousel) && yyhSlider == true) {
    anaYyhControlStop();
    $("#tt-ya-yatSlider").owlCarousel({
      autoWidth: true,
      loop: true,
      autoplay: false,
      dots: true,
      nav: false,
    });
    anaYyhControlStop();
    setTimeout(function () {
      $("#tt-betpas-yeni-mobil-slider").on("click", function () {
        gtmTrigger("Mobil Ana Slider");
      });
      $("#bpm-sports ul li a").on("click", function () {
        gtmTrigger("Kutu -> " + $(this).find(".bpm-text").text());
      });
      $(".tt-gununmaci").on("click", function () {
        gtmTrigger(
          "Günün Maçı Slider (" +
            $(".tt-gm-takim1-adi").text() +
            " : " +
            $(".tt-gm-takim2-adi").text() +
            ") (" +
            $(".tt-gm-oran-adi").eq(0).text() +
            ") (" +
            $(".tt-gm-oran-adi2").eq(0).text() +
            ")"
        );
      });
      $(".tt-ya-slider-con .owl-item").on("click", function () {
        gtmTrigger(
          "Ödeme Yöntemi -> " + $(this).find(".tt-ya-slide-text span").text()
        );
      });
      $(".tt-hizmetlerimiz a").on("click", function () {
        gtmTrigger("Kısayol -> " + $(this).find(".tt-hizmet-isim").text());
      });
    }, 100);
  }
}
