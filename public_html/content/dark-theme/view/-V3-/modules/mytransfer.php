<div class="container">
  <div class="row">

    <?php include "includes/sidebar-account.php"; ?>

    <div class="col-sm-7 col-md-8 col-lg-9 ab-content-account">
      <div class="panel panel-default border-radius">
        <div class="panel-heading border-bottom">
          TRANSFER
        </div>
        <div class="panel-body">





          <div class="panel-group" id="transfer-accordion" role="tablist" aria-multiselectable="true">

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="transferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#transferForm" aria-expanded="true" aria-controls="transferForm">
                        POKER
                      </a>
                    </h4>
              </div>
              <div id="transferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="transferHead">
                <div class="panel-body">
                  <div class="row">

                    <form id="transferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Poker Bakiyeniz :
                          </label>
                          <input class="form-control" name="balancepoker" id="balancepoker" type="text" value="" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Poker Bakiyesi</option>
                            <option value="1">Poker Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="transfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>





            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="okeyTavlaTransferrHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#okeyTavlaTransferForm" aria-expanded="true" aria-controls="okeyTavlaTransferForm">
                        OKEY / TAVLA
                      </a>
                    </h4>
              </div>
              <div id="okeyTavlaTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="okeyTavlaTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="okeyTavlaTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Okey Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" name="okey" id="okey" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Okey / Tavla Bakiyesi</option>
                            <option value="1">Okey / Tavla Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="okeyTavlaTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="vivoTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#vivoTransferForm" aria-expanded="true" aria-controls="vivoTransferForm">
                        CASINO & SLOT
                      </a>
                    </h4>
              </div>
              <div id="vivoTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vivoTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="vivoTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Casino Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" name="vivo" id="vivo" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Casino Bakiyesi</option>
                            <option value="1">Casino Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="vivoTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="vivoCanliTransferFormHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#vivoCanliTransferForm" aria-expanded="true" aria-controls="vivoCanliTransferForm">
                        CANLI CASINO (VIVO)
                      </a>
                    </h4>
              </div>
              <div id="vivoCanliTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vivoCanliTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="vivoCanliTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Casino Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" name="vivo" id="vivo" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Casino Bakiyesi</option>
                            <option value="1">Casino Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="vivoCanliTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="xproTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#xproTransferForm" aria-expanded="true" aria-controls="xproTransferForm">
                        CANLI CASINO (xpro)
                      </a>
                    </h4>
              </div>
              <div id="xproTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="xproTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="xproTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Casino Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" name="casino" id="casino" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Casino Bakiyesi</option>
                            <option value="1">Casino Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="xproTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="ezugiTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#ezugiTransferForm" aria-expanded="true" aria-controls="ezugiTransferForm">
                        CANLI CASINO (ezugi)
                      </a>
                    </h4>
              </div>
              <div id="ezugiTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ezugiTransferFormHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="ezugiTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Ezugi Bakiyeniz :
                          </label>
                          <input class="form-control" name="ezugi" id="ezugi" type="text" value="" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Ezugi Bakiyesi</option>
                            <option value="1">Ezugi Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="ezugiTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="evolutionTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#evolutionTransferForm" aria-expanded="true" aria-controls="evolutionTransferForm">
                        CANLI CASINO (Evolution)
                      </a>
                    </h4>
              </div>
              <div id="evolutionTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="evolutionTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="evolutionTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Evolution Bakiyeniz :
                          </label>
                          <input class="form-control" name="evolution" id="evolution" type="text" value="" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Evolution Bakiyesi</option>
                            <option value="1">Evolution Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="evolutionTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="goldenTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#goldenTransferForm" aria-expanded="true" aria-controls="goldenTransferForm">
                        SANAL BAHİSLER
                      </a>
                    </h4>
              </div>
              <div id="goldenTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="goldenTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="goldenTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Sanal Bakiyeniz :
                          </label>
                          <input class="form-control" name="evolution" id="evolution" type="text" value="" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Sanal Bakiyesi</option>
                            <option value="1">Sanal Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="goldenTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="eBetOnTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#eBetOnTransferForm" aria-expanded="true" aria-controls="eBetOnTransferForm">
                        E-BETONGAMES
                      </a>
                    </h4>
              </div>
              <div id="eBetOnTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="eBetOnTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="eBetOnTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            eBetOn Bakiyeniz :
                          </label>
                          <input class="form-control" name="ebeton" id="ebeton" type="text" value="" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; eBetOnGames Bakiyesi</option>
                            <option value="1">eBetOnGames Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="eBetOnTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel panel-default panel-transfer">
              <div class="panel-heading" role="tab" id="livegamesTransferHead">
                <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" class="collapsed" data-parent="#transfer-accordion" href="#livegamesTransferForm" aria-expanded="true" aria-controls="livegamesTransferForm">
                        TOMBALA (LiveGames)
                      </a>
                    </h4>
              </div>
              <div id="livegamesTransferForm" class="panel-collapse collapse" role="tabpanel" aria-labelledby="livegamesTransferHead">
                <div class="panel-body">
                  <div class="row">
                    <form id="livegamesTransferForm" method="post">
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" value="0" name="balancebet" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Tombala Bakiyeniz :
                          </label>
                          <input class="form-control" type="text" name="livegames" id="livegames" disabled="disabled">
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Tutarı :
                          </label>
                          <input class="form-control" type="text" name="miktar">
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-3">
                        <div class="form-group">
                          <label class="control-label">
                            Transfer Türü :
                            <small></small>
                          </label>
                          <select class="form-control" name="tur">
                            <option value="0">Spor Bakiyesi &gt;&gt; Tombala(LiveGames) Bakiyesi</option>
                            <option value="1">Tombala(LiveGames) Bakiyesi &gt;&gt; Spor Bakiyesi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                          <div class="hidden-xs">
                            <label>&nbsp;</label>
                          </div>
                          <button class="btn btn-primary btn-block btn-icon user-action" data-action="livegamesTransfer">
                            TRANSFER ET
                            <i class="icon-arrow-right"></i>
                          </button>
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
    </div>
  </div>
</div>