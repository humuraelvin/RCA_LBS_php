<?php  include "content/dark-theme/view/dark_header.php"; ?>
<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-help"></i> </button>
    <a class="page-title">Şifremi Unuttum</a>
</div>
<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row ">

            <div id="main-center" style="min-height: 390px;">
                <div class="center-container">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h2><i class="icon-head"></i>ŞİFREMİ UNUTTUM</h2>
                        </div>
                        <div class="panel-footer">
                            <form id="fargotForm" class="loginForm form-container">
                                <div class="form-group">
                                    <input class="form-control"  name="username" placeholder="Kullanıcı Adı" autocomplete="off" type="text">                                    
                                </div>
                                <div class="form-group ">
                                    <input class="form-control" id="mail" name="mail" placeholder="E-Mail" autocomplete="off" type="text"> 
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">
                            <div class="form-container">
                                <button data-action="fargot" class="btn_signup user-action CL-OP RND-OP btn btn-lg btn-primary btn-wide btn-icon">Şifremi Unuttum </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>
<?php  include "content/dark-theme/view/dark_footer.php"; ?>