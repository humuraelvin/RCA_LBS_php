$(document).ready(function(){

  $('.ab-navbar-main').affix({
    offset: {
      top: function() {
        return ( this.top = $('.ab-navbar-main').offset().top )
      }
    }
  }).on('affix.bs.affix,affixed.bs.affix', function(){
    $("html").addClass("ab-navbar-fixed");
    $(this).addClass('navbar-fixed-top').removeClass('navbar-static-top');
  }).on('affix-top.bs.affix,affixed-top.bs.affix', function() {
    $("html").removeClass("ab-navbar-fixed");
    $(this).addClass('navbar-static-top').removeClass('navbar-fixed-top');
  });

  $('#ab-navbar-main .navbar-nav').flexMenu();

  var mobileLeft = new Slideout({
    'panel': document.getElementById('page-wrapper'),
    'menu': document.getElementById('mobile-wrapper-left'),
    'padding': 256,
    'tolerance': 70,
    'touch': false
  });
  var mobileRight = new Slideout({
    'panel': document.getElementById('page-wrapper'),
    'menu': document.getElementById('mobile-wrapper-right'),
    'side': 'right',
    'padding': 256,
    'tolerance': 70,
    'touch': false
  });

  mobileLeft.on('beforeopen', function () {
    $("#mobile-wrapper-left, #menu-toggle").addClass("active");
  }).on('beforeclose', function () {
    $("#menu-toggle").removeClass("active");
  }).on('close', function () {
    $("#mobile-wrapper-left").removeClass("active");
  });

  mobileRight.on('beforeopen', function () {
    $("#mobile-wrapper-right, #login-toggle").addClass("active");
  }).on('beforeclose', function () {
    $("#login-toggle").removeClass("active");
  }).on('close', function () {
    $("#mobile-wrapper-right").removeClass("active");
  });

  $('#menu-toggle').on('click', function() {
      mobileLeft.toggle();
  });

  $('#login-toggle').on('click', function() {
      mobileRight.toggle();
  });

  $(".ab-sidebar-toggle").click(function() {
    var target = $(this).data("target");
    $("html").addClass("overflow-hidden");
    $(target).addClass("active");
  });

  $(".ab-sidebar-close").click(function() {
    var target = $(this).data("target");
      $("html").removeClass("overflow-hidden");
      $(target).removeClass("active");
  });

  $("html.overflow-hidden").on('click',function(e){
    if(e.target != $('.ab-sidebar-coupon')) {
        $("html").removeClass("overflow-hidden");
        $(mouseup).removeClass("active");
        }
  });



  $('.btn-number').click(function(e) {
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
      if (type == 'minus') {

        if (currentVal > input.attr('min')) {
          input.val(currentVal - 1).change();
        }

      } else if (type == 'plus') {

        if (currentVal < input.attr('max')) {
          input.val(currentVal + 1).change();
        }

      }
      /*
      if(parseInt(input.val()) == input.attr('min') && parseInt(input.val()) == input.attr('max')) {
      	$(this).attr('disabled', true);
      } else {
      	$(this).attr('disabled', false);
      }
      */
    } else {
      input.val(0);
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $('#accordion-live > .panel > [id^="collapse-"]').on('show.bs.collapse', function () {
    $(this).parent('.panel').addClass('active').siblings().removeClass('active');
  });

  $(".btn-toggle").click(function(e) {
    e.preventDefault();
    var target = $(this).attr('data-target'),
      put = $(this).attr('data-class');
    $(target).toggleClass(put);
  });

   function reposition() {
       var modal = $(this),
         dialog = modal.find('.modal-dialog');
       modal.css('display', 'block');

       // Dividing by two centers the modal exactly, but dividing by three 
       // or four works better for larger screens.
       dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
       dialog.css("margin-left", Math.max(0, ($(window).width() - dialog.width()) / 2));
     }
     // Reposition when a modal is shown
   $('.modal').on('show.bs.modal', reposition);
   // Reposition when the window is resized
   $(window).on('resize', function() {
     $('.modal:visible').each(reposition);
   });


    $('.go-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 1000);
    });
});
