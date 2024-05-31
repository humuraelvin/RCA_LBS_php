{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-help"></i> </button>
    <a class="page-title">Şifremi Unuttum</a>
</div>
<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left">
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">
                <div class="left-container nano-content" tabindex="0" style="right: -15px;">

                    <div class="panel panel-gray no-padding-sm">
                        <div class="panel-heading">
                            <h4><i class="icon-bonus"></i>PROMOSYONLAR</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="bets help list-unstyled">
                                <li>
                                    <i class="icon-bonus"></i>
                                    <b>500 TL</b>
                                    <div>HOŞGELDİN BONUSU</div>
                                </li>
                                <li>
                                    <i class="icon-bonus"></i>
                                    <b>500 TL</b>
                                    <div>YATIRIM BONUSU</div>
                                </li>
                                <li>
                                    <i class="icon-bonus"></i>
                                    <b>%20</b>
                                    <div>CASİNO BONUSU</div>
                                </li>
                                <li>
                                    <i class="icon-bonus"></i>
                                    <b>%30</b>
                                    <div>RAKEBACK</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 485px; transform: translate(0px, 0px);"></div>
                </div>
            </div>
            <div id="main-center">
                <div class="center-container">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h2><i class="icon-head"></i>ŞİFREMİ UNUTTUM</h2>
                        </div>
                        <div class="panel-footer">
                            <form id="fargotForm2" class="loginForm form-container">
                                <div class="form-group">
                                    <input class="form-control"  name="password" id="password" placeholder="Yeni Şifre" type="password">                                    
                                </div>
                                <div class="form-group ">
                                    <input class="form-control" id="password2" name="password2" placeholder="Yeni Şifre" type="password"> 
    <input id="token" name="token" maxlength="100" class="form_item_input input_watermark input_not_null_input" value="{php} echo $token; {/php}" type="hidden">
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">
                            <div class="form-container">
                                <button data-action="fargot2" class="btn_signup user-action CL-OP RND-OP btn btn-lg btn-primary btn-wide btn-icon">Şifremi Sıfırla </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}


