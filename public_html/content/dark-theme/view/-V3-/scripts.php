<!-- Core JavaScript
  ================================================== -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-sp.js"></script>
<script src="js/flexmenu.js"></script>
<script src="js/slideout.js"></script>
<script src="js/custom.js"></script>



<?php if($module=='index') { ?>
<script src="js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript">
$(function() {
    $(".carousel-inner").swipe({
      swipeLeft: function (event, direction, distance, duration, fingerCount) {
        $(this).parent().carousel('next');
      },
      swipeRight: function () {
        $(this).parent().carousel('prev');
      },
      threshold: 0
  });
  });
</script>
<?php } ?>

<?php if($module=='myaccount' or $module=='singin') { ?>
<script src="js/moment-wl.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script src="js/intlTelInput.min.js"></script>
<script src="js/validator.js"></script>
<script type="text/javascript">
  $(function() {
    $('#birthdate').datetimepicker({
      viewMode: 'years',
      format: 'DD/MM/YYYY'
    });
    $("#tel").intlTelInput();
  });
</script>
<?php } ?>

<?php if($module=='mycoupons' or $module=='mytransactions') { ?>
<script src="js/jquery.dataTables.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<script src="js/dataTables.responsive.min.js"></script>
<script src="js/moment-wl.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(function() {

    $('#bet-history-table').DataTable({
      responsive: true,
      language: {
        "url": "js/dataTables.tr.lang"
      }
    });
    $('#dtp_mybets').datetimepicker({
      viewMode: 'years',
      format: 'DD/MM/YYYY'
    });
    $('#dtp_mybets2').datetimepicker({
      viewMode: 'years',
      format: 'DD/MM/YYYY',
      useCurrent: false //Important! See issue #1075
    });
    $("#dtp_mybets").on("dp.change", function(e) {
      $('#dtp_mybets2').data("DateTimePicker").minDate(e.date);
    });
    $("#dtp_mybets2").on("dp.change", function(e) {
      $('#dtp_mybets').data("DateTimePicker").maxDate(e.date);
    });
  });
</script>
<?php } ?>

<?php if($module=='deposit' or $module=='withdraw') { ?>
<script src="js/moment-wl.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('#dtp_time').datetimepicker({
      format: 'LT'
    });
  });
</script>
<?php } ?>

<?php if($module=='liveTombala') { ?>
<script src="js/iframe-load.js"></script>
</script>
<?php } ?>


<?php if($module=='affiliate') { ?>
<script src="js/jquery.dataTables.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<script src="js/dataTables.responsive.min.js"></script>
<script src="js/moment-wl.js"></script>
<script src="js/clipboard.js"></script>
<script type="text/javascript">
  $(function() {
    new Clipboard('.btn-clipboard');
    $('#affiliate-table').DataTable({
      responsive: true,
      language: {
        "url": "js/dataTables.tr.lang"
      }
    });
  });
</script>
<?php } ?>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>


<!-- FOR DEMO
  ================================================== -->
<script type="text/javascript">
  $(function() {
      $(".btn-login").click(function(e) {
        e.preventDefault();
        location.href = '/index.php?module=<?=($module=='login')?'profile':$module?>&user=logged';
      });
  });
</script>
