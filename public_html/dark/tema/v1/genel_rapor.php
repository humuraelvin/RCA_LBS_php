<header class="page-header">
    <h2><i class="fa fa-money"></i> GENEL RAPOR</h2>
</header>

<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">GENEL RAPOR</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-plugin-datepicker="">
			<span class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</span>
                    <input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary admin-action" data-action="adminGenelRapor">Listele</button>
            </div>
        </div>
    </div>

    </br>
    <header class="panel-heading">
        <h2 class="panel-title">FINANS</h2>
    </header>
    <div class="panel-body" style="padding: 10px 25px 10px 25px;">
        <div class="row ">
            <div class="col">
                <section class="card">

                    <div class="card-body">
                        <table class="table table-no-more table-bordered table-striped mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">Tür</th>
                                <th class="text-left">Gelen</th>
                                <th class="text-left">Giden</th>
                                <th class="text-left">Kalan</th>
                            </tr>
                            </thead>
                            <tbody>
                      

                            <tr>
                                <td class="text-left">TOPLAM</td>
                                <td class="text-left"><strong class="finance deposit"></strong></td>
                                <td class="text-left"><strong class="finance withdraw"></strong></td>
                                <td class="text-left"><strong class="finance remaining"></strong></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </br>

    <header class="panel-heading">
        <h2 class="panel-title">SPOR BAHİSLERİ</h2>
    </header>
    <div class="panel-body" style="padding: 10px 25px 10px 25px;">
        <div class="row">
            <div class="col">
                <section class="card">

                    <div class="card-body">
                        <table class="table table-no-more table-bordered table-striped mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">Tür</th>
                                <th class="text-left">Miktar</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-left">TOPLAM BAHİS</td>
                                <td class="text-left"><strong class="sportsbook total"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">KAZANAN BAHİS</td>
                                <td class="text-left"><strong class="sportsbook winning"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">KAYBEDEN BAHİS</td>
                                <td class="text-left"><strong class="sportsbook loser"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">BEKLEMEDE BAHİS</td>
                                <td class="text-left"><strong class="sportsbook pending"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">IADE BAHİS</td>
                                <td class="text-left"><strong class="sportsbook return"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">BAHİS KARI</td>
                                <td class="text-left"><strong class="sportsbook profit"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">KOMİSYON %10</td>
                                <td class="text-left"><strong class="sportsbook commission"></strong></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <br>


    <header class="panel-heading">
        <h2 class="panel-title">OYUNLAR</h2>
    </header>
    <div class="panel-body" style="padding: 10px 25px 10px 25px;">
        <div class="row">
            <div class="col">
                <section class="card">

                    <div class="card-body">
                        <table class="table table-no-more table-bordered table-striped mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">Tür</th>
                                <th class="text-left">Gelen</th>
                                <th class="text-left">Giden</th>
                                <th class="text-left">Kalan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left">CASINO (HOGAMING)</td>
                                <td class="text-left"><strong class="casino hogaming deposit"></strong></td>
                                <td class="text-left"><strong class="casino hogaming withdraw"></strong></td>
                                <td class="text-left"><strong class="casino hogaming total"></strong></td>
                            </tr>
                            <tr>
                                <td class="text-left">TOMBALA (LIVEGAMES)</td>
                                <td class="text-left"><strong class="bingo livegames deposit"></strong></td>
                                <td class="text-left"><strong class="bingo livegames withdraw"></strong></td>
                                <td class="text-left"><strong class="bingo livegames total"></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>


</section>
