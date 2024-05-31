{php} include "content/dark-theme/view/dark_header.php";{/php}

{literal}
<style type="text/css">
    .loadinggif
{
     background:url('/images/loader.gif') no-repeat center;
     background-position:6px;
}
</style>
<script type="text/javascript">

$(function(){
    $.allBalan = {
        _balance: function() {
            $('#casino, #bingo, #user').val('');
            $('#casino, #bingo, #user').addClass('loadinggif');
            $('').addClass('loadinggif');
            $.ajax({
                type: "GET",
                url: "/myaccount/balanceinfo",
                dataType: "json",
                success: function(c) {
                    $('input[name="casino"]').val(c.casino + " ₺");
                    $('input[name="bingo"]').val(c.bingo + " ₺");
                    $('input[name="user"]').val(c.user + " ₺");
                    $('.balance').html(c.user + " ₺");
                    $('#casino, #bingo, #user').removeClass('loadinggif');
                }
            });

        }
    }

    $.allBalan._balance();
});
</script>
{/literal}

 <div class="navbar-title visible-sm visible-xs">
        <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
        <a class="page-title"><i class="icon-transactions"></i>TRANSFER</a>
    </div>
    <section id="main" class="" style="">
        <div class="container">
            <div id="main-panel" class="row have-sidebar-left" >
                <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">

                    {php} include "content/dark-theme/view/sidebar.php";{/php}

                    <div class="nano-pane" style="display: none;">
                        <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div id="main-center" style="min-height: 500px;">
                    <div class="center-container" style="">
                        <form accept-charset="UTF-8" autocomplete="off" class="panel panel-white no-padding-sm">
                            <div class="panel-heading" style="">
                                <h2><i class="icon-transactions"></i>HESAPLAR ARASI TRANSFER</h2>
                            </div>
                        </form>
                        <div class="panel panel-white no-padding-sm">



                            <div class="panel-group panel-collapse" id="acc-accordion">
                                <div class="panel panel-default">
                                        <div class="panel-heading show" data-toggle="collapse" data-parent="#acc-accordion" href="#casinoTransferForm">
                                            <h4>CASINO</h4>
                                            <i class="icon-arrow-down pull-right"></i>
                                        </div>
                                        <form class="panel-collapse collapse in" id="casinoTransferForm" method="post" >
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Bakiyeniz :
                                                            </label>
                                                            <input class="form-control" type="text" value="{$bilgi['bakiye']}" name="user" id="user" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Casino Bakiyeniz :
                                                            </label>
                                                            <input class="form-control" name="casino" id="casino" type="text" value="" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Transfer Tutarı :
                                                            </label>
                                                            <input class="form-control" type="text" name="amount" id="amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Transfer Türü :
                                                                <small></small>
                                                            </label>
                                                            <select class="form-control" name="method" id="method">
                                                                <option value="Deposit">Spor Bakiyesi >> Casino Bakiyesi</option>
                                                                <option value="Withdraw">Casino Bakiyesi >> Spor Bakiyesi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <div class="hidden-xs">
                                                                <label>&nbsp;</label>
                                                            </div>
                                                            <button class="btn btn-primary btn-sm-wide btn-icon user-action" data-action="casinoTransfer" >
                                                                TRANSFER ET
                                                                <i class="icon-arrow-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
									 </div>
                            </div>


                            <div class="panel-group panel-collapse" id="livegames">
                                <div class="panel panel-default">
                                    <div class="panel-heading show" data-toggle="collapse" data-parent="#livegames" href="#bingoTransferForm">
                                        <h4>TOMBALA</h4>
                                        <i class="icon-arrow-down pull-right"></i>
                                    </div>
                                    <form class="panel-collapse collapse in" id="bingoTransferForm" method="post" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Bakiyeniz :
                                                        </label>
                                                        <input class="form-control" type="text" value="{$bilgi['bakiye']}" name="user" id="user" disabled="disabled">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Tombala Bakiyeniz :
                                                        </label>
                                                        <input class="form-control" name="bingo" id="bingo" type="text" value="" disabled="disabled">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Transfer Tutarı :
                                                        </label>
                                                        <input class="form-control" type="text" name="amount" id="amount">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Transfer Türü :
                                                            <small></small>
                                                        </label>
                                                        <select class="form-control" name="method" id="method">
                                                            <option value="Deposit">Spor Bakiyesi >> Tombala Bakiyesi</option>
                                                            <option value="Withdraw">Tombala Bakiyesi >> Spor Bakiyesi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <div class="hidden-xs">
                                                            <label>&nbsp;</label>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm-wide btn-icon user-action" data-action="bingoTransfer" >
                                                            TRANSFER ET
                                                            <i class="icon-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}
