            <app-footer>
              <footer class="page-footer">
                <div class="footer-menu">
                </div>
                <div class="playgo-content">
                  <div class="container flex-container">
                    <div class="playgo-text flex-item">Atabet Malta Gaming Lisans Numarası C84078 ve NUMBER1GAMING Financial Office 115A, LEVEL 5, VALLEY ROAD, GC Gaming kayıt adresi ile NUMBER1GAMING şirketi tarafından yönetilmektedir. </div>
                  </div>
                </div>
                <div class="footer-copyright">
                  <div class="container center">
                    <span class="center">© Atabet.bet 2023. Tüm Hakları Saklıdır.</span>
                  </div>
                </div>

              </footer>
            </app-footer>

          </app-main-page>
        </main>
      </div>
    </app-out-component>
  </app-root>

  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/m-main-static.js"></script>
  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/sweetalert.all.min.js"></script>
  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/script.js?v=3"></script>
  <script type="text/javascript" src="<?php echo PATH_ASSET;?>/js/app.js?v=3"></script>

  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
    delay: 2500,
    disableOnInteraction: false,
    },
    pagination: {
    el: ".swiper-pagination",
    clickable: true,
    },
    });
  </script>

  <script type="text/javascript">
    function yukleoyun() {
    Swal.fire({
    icon: 'error',
    title: 'Bağlantı Kurulamadı !',
    text: 'Oyuna Bağlanmak için hesabınıza giriş yapmanız gerekmekte !',
    showConfirmButton: false,
    timer: 3000
    })
    }

    function yukleoyungiris() {
    Swal.fire({
    icon: 'error',
    title: 'Uyarı',
    text: 'Lütfen bakiyenizi güncelleyiniz!',
    showConfirmButton: false,
    timer: 3000
    })
    }

    function logIn() {
      $.ajax({
        type: "POST",
        url: '<?php echo PATH;?>/Module/WebsiteAjax.php?section=login',
        data: $("form#login-form").serialize(),
        success: function (response) {
          $(".response-login").html(response);
        },
      });
    }
  </script>

</body>
</html>
