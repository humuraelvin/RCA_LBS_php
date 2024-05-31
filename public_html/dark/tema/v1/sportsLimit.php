<section role="main" >
    <header class="page-header">
        <h2>Spor Limitlendirme</h2>

    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Spor Limitlendirme</h2>
        </header>
        <div class="card-body">
            <form action="/sportsLimit" method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="type" >
                                <option value="0" <?php echo ($type == 0) ? 'selected' : '' ?>>Maç Öncesi</option>
                                <option value="1" <?php echo ($type == 1) ? 'selected' : '' ?>>Canlı</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block">Listele</button>
                        </div>
                    </div>
                </div>
            </form>

            <hr class="dotted short">


            <table class="table table-bordered table-striped dataTables_wrapper" id="datatable-default" >
                <thead>
                <tr>
                    <th class="text-center" width="5%">Id</th>
                    <th class="text-center" width="5%">Sport</th>
                    <th class="text-center" align="right" >İsim</th>
                    <th class="text-center" width="15%">Limit</th>
                    <th class="text-center" width="10%">Durum</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Sport Id</th>
                    <th>İsim</th>
                    <th>Limit</th>
                    <th>Durum</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($sports as $index => $sport) { ?>
                    <tr>
                        <td><?=$sport['id'];?></td>
                        <td><?=$sport['sportid'];?></td>
                        <td style="font-weight: bold;"><?=$sport['name'];?></td>
                        <td class="text-center">
                            <div class="input-daterange input-group" >
                                <span class="input-group-addon">
                                    <i id="sport-limit-icon-<?php echo $sport['id'] ?>" class="fa fa-try" aria-hidden="true"></i>
                                </span>
                                <input type="text" id="sport-limit-<?php echo $sport['id'] ?>" data-id="<?php echo $sport['id'] ?>"  class="form-control sport-limit-action" data-action="adminSportLimit" data-name="sport" value="<?=$sport['coupon_limit'];?>" name="limit" <?php echo $sport['status'] == 0 ? 'disabled="disabled"' : '' ?> >
                            </div>
                        </td>
                        <td class="text-center">
                            <label class="switch">
                                <input type="checkbox" id="sport-<?php echo $sport['id'] ?>" data-id="<?php echo $sport['id'] ?>" class="aktifPasif admin-action" data-action="adminSportActive" data-name="sport" <?php echo $sport['status']==1?'checked':'' ?> >
                                <span class="slider round"></span>
                            </label>
                        </td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
