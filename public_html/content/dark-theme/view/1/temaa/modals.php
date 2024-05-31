  <div class="modal modal-dark modal-login fade" id="ab-login" tabindex="-1" role="dialog" aria-labelledby="ab-login">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header padding-30 clear-pb text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
          <img src="img/logo.png" class="img-responsive" alt="ArmaniBet" class="">
        </div>
        <div class="modal-body padding-30">
          <form>
            <div class="form-group">
              <label for="email">E-Posta Adresi</label>
              <input type="email" class="form-control" id="email" placeholder="Eposta adresinizi girin.">
            </div>
            <div class="form-group">
              <label for="password">Şifre</label>
              <input type="password" id="password" class="form-control" id="password" placeholder="Şifrenizi girin." data-toggle="password">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-login btn-bg btn-p-lg pull-right">GİRİŞ YAP</button>
              <a href="/index.php?module=password-reset" class="btn btn-link btn-p-lg clear-pr clear-pl">Şifremi unuttum!</a>
            </div>
          </form>
        </div>
        <div class="modal-footer padding-30 clear-pt text-center">
          <div class="h5">Üye değil misin?</div>
          <a href="index.php?module=singin" class="btn btn-white btn-bg btn-p-lg btn-block">HEMEN ÜYE OL</a>
        </div>
      </div>
    </div>
  </div>


<div class="modal modal-detail fade" id="ab-detail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-radius">
      <div class="modal-header wbg">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">DETAY</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">KAPAT</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->