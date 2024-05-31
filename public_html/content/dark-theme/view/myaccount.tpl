{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
    <a class="page-title"><i class="icon-policy"></i>HESABIM</a>
</div>

<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left" style="background: none;">
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">

                {php} include "content/dark-theme/view/sidebar.php";{/php}

                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                </div>
            </div>

            <div id="main-center" style="min-height: 500px;">
                <div class="center-container" style="">
                    <form accept-charset="UTF-8" action="/withdraw" autocomplete="off" class="panel panel-white no-padding-sm" method="post">
                        <div class="panel-heading" style="">
                            <h2><i class="icon-policy"></i>HESABIM</h2>
                        </div>
                        <div class="panel-footer for-validation">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            İsim Soyisim
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{$bilgi["name"]}" readonly="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Doğum Tarihi
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{$bilgi["dt"]}" readonly="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Kimlik No
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{php} echo substr($bilgi["tc"],0,3);{/php}*******" readonly="">
                                    </div>
                                </div>
                            </div>

                            <div class="row bwt-details">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            E-mail
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{php} echo substr($bilgi["email"],0,5);{/php}***********" readonly="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Telefon No
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{php} echo substr($bilgi["telefon"],0,3);{/php}*******" readonly="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Kullanıcı Adı
                                            <small></small>
                                        </label>
                                        <input class="form-control" type="text" value="{$bilgi["username"]}" readonly="">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>



                    <!--- RAKEBACK BİLGİLERİ
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-group panel-collapse" id="acc-accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading show" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse2">
                                    <h4>RAKEBACK AKTAR</h4>
                                    <i class="icon-arrow-down pull-right"></i>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Kullanılabilir RakeBack :
                                                </label>
                                                <input class="form-control" type="text" id="rakeback" name="rakeback" disabled="disabled" value="{php} echo $rakee; {/php}">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Aktarılacak Miktar :
                                                </label>
                                                <input class="form-control" type="text" id="miktar" name="miktar"  ">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="hidden-xs">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <button class="btn btn-success btn-sm-wide btn-icon" onclick="fnrakeupdate();">
                                                    RakeBack Aktar
                                                    <i class="icon-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                   RAKEBACK BİLGİLERİ --->





                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-group panel-collapse" id="acc-accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading show" data-toggle="collapse" data-parent="#acc-accordion" href="#collapse2">
                                    <h4>Şifre Değiştir</h4>
                                    <i class="icon-arrow-down pull-right"></i>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Mevcut Şifre :
                                                </label>
                                                <input class="form-control" type="password" id="old_password" name="old_password">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Yeni Şifre :
                                                </label>
                                                <input class="form-control" type="password" id="new_password" name="new_password">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Yeni Şifre Tekrar :
                                                </label>
                                                <input class="form-control" type="password"  id="new_password_repeat" name="new_password_repeat">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="hidden-xs">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <button class="btn btn-primary btn-sm-wide btn-icon" onclick="fnProfileUpdate();">
                                                    Şifre Değiştir
                                                    <i class="icon-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>











                </div>
            </div>
        </div>
    </div>
</section>

{php} include "content/dark-theme/view/dark_footer.php";{/php}