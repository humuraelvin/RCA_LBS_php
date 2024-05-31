      <!-- Main Footer Start -->
      <footer class="main--footer main--footer-light">
        <p>Copyright &copy; <a target="_blank" href="">Atabet</a>. Tüm Hakları Saklıdır.</p>
      </footer>
      <!-- Main Footer End -->

      </main>
      <!-- Main Container End -->

      </div>
      <!-- Wrapper End -->

      <!-- Scripts -->
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery-ui.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/bootstrap.bundle.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/perfect-scrollbar.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery.sparkline.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/raphael.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/morris.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/select2.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery-jvectormap.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery-jvectormap-world-mill.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/horizontal-timeline.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery.validate.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/jquery.steps.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/dropzone.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/ion.rangeSlider.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/datatables.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/summernote-bs4.min.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/summernote-bs4-init.js"></script>
      <script src="<?=PATH_DASHBOARD_ASSET;?>/js/main.js"></script>

      <!-- iziToast -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

      <!-- Page Level Scripts -->
      <script src="<?=PATH_MODULE;?>/DashboardGraphJS.php"></script>

      <script type="text/javascript">
        $(".payment-check").click(function () {
          var id = this.id;
          var ele = $(this).parent().parent();
          $.ajax({
            url: `<?=PATH;?>/Module/DashboardAjax.php?section=payment-check&id=${id}`,
            success: function (response) {
              $(".payment-check-response").html(response);
              ele.css({'background-color':'#c8f5d2e0'});
            },
          });
        });
        $(".payment-delete").click(function () {
          var id = this.id;
          var ele = $(this).parent().parent();
          $.ajax({
            url: `<?=PATH;?>/Module/DashboardAjax.php?section=payment-delete&id=${id}`,
            success: function (response) {
              $(".payment-delete-response").html(response);
              ele.fadeOut().remove();
            },
          });
        });

        $('.user-balance-update').change(function(){
           var id      = this.id;
           var balance = this.value;
           $.ajax({
             url: '<?=PATH;?>/Module/DashboardAjax.php?section=user-balance-update',
             type: 'POST',
             data: { id:id, balance:balance},
             success: function(response){
               $(".balance-update-response").html(response);
             }
           });
        });


      </script>

      </body>
      </html>
