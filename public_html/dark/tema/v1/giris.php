
<!-- start: page -->
<section class="body-sign body-locked">
    <div class="center-sign">
        <div class="panel panel-sign">
            <div class="panel-body">
                <form id="adminGirisForm">
                    <div class="current-user text-center">
                        <h2 class="user-name text-dark m-none">Yönetim Paneli</h2>
                        <p class="user-email m-none">Lütfen bilgilerinizi yazınız.</p>
                    </div>
                    <div class="form-group mb-lg">
                        <div class="input-group input-group-icon" id="groupusername">
                            <input name="username" id="pwd" type="text" class="form-control input-lg" placeholder="Kullanıcı Adı" />
                            <span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-user"></i>
								</span>
							</span>
                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <div class="input-group input-group-icon" id="grouppassword">
                            <input name="password" id="pwd" type="password" class="form-control input-lg" placeholder="Şifre" />
                            <span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-lock"></i>
								</span>
							</span>
                        </div>
                    </div>
                    <div class="form-group mb-lg" id="groupcode" style="display: none;">
                        <div class="input-group input-group-icon">
                            <input name="code" id="code" type="text" class="form-control input-lg" placeholder="Code" value="code"/>
                            <span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-key"></i>
								</span>
							</span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary btn-lg btn-block admin-action" data-action="adminGiris">Giriş Yap</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>