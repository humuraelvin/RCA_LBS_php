<?php  include "content/dark-theme/view/dark_header.php"; ?>


    <style>
        @media (max-width: 767px) {
            /* Label the data */
            .bets-table td:nth-of-type(1):before { content: 'Hareket Tipi : ';font-weight: bold; }
            .bets-table td:nth-of-type(2):before { content: 'Önceki Bakiye : ';font-weight: bold; }
            .bets-table td:nth-of-type(3):before { content: 'Miktar : ';font-weight: bold; }
            .bets-table td:nth-of-type(4):before { content: 'Güncel Bakiye : ';font-weight: bold; }
            .bets-table td:nth-of-type(5):before { content: 'Açıklama : ';font-weight: bold; }
            .bets-table td:nth-of-type(6):before { content: 'Tarih : '; font-weight: bold;}
        }
    </style>
    <link rel="stylesheet" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />


<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" />

    <script type="text/javascript">


        $(document).ready(function() {
            $('#bet-history-table').DataTable( {
                "order": [[0, "asc"]],
                "stripeClasses": [],
                "language": {
                    "search": "",
                    "searchPlaceholder" : "İşlem Ara",
                    "lengthMenu":     "_MENU_",
                    "paginate": {
                        "first":      "İlk",
                        "last":       "Son",
                        "next":       "İleri",
                        "previous":   "Geri"
                    },
                    "info":           "Sayfada _END_ satır görünüyor. Toplam _TOTAL_ satır bulunmaktadır.",
                }
            } );

            $(document).ready(function() {
                $('.dataTables_filter input').addClass('form-control datatable-search');
                $('#bet-history-table_length > label > select').addClass('form-control datatable-select');
            } );


        } );
    </script>



<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
    <a class="page-title"><i class="icon-settings"></i>HESAP HAREKETLERİ</a>
</div>
<section id="main" class="" >
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left" >
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">
                <?php  include "content/dark-theme/view/sidebar.php"; ?>
                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                </div>
            </div>
            <div id="main-center" style="">
                <div class="center-container" style="min-height: 500px;">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h2><i class="icon-settings"></i>Hesap Hareketleri</h2>
                        </div>
                        <div class="panel-body panel-control">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <form action="/myaccount/transactions" method="post">
                                        <div class="input-daterange input-group form-group" id="bet-history">
                                            <input type="text" class="form-control" name="from" id="start" value="<?php echo $tarih1  ?>">
                                            <span class="input-group-addon"> ‐ </span>
                                            <input type="text" class="form-control" name="to" id="end" value="<?php echo $tarih2   ?>">
                                            <span class="input-group-btn"><button class="btn btn-gray" type="submit"><i class="icon-search"></i></button></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="panel-table table-responsive table-mobile">
                            <table class="table table-hover bets-table" id="bet-history-table">
                                <thead>
                                <tr>
                                    <th>Haraket Tipi</th>
                                    <th>Önceki Bakiye</th>
                                    <th>Miktar</th>
                                    <th>Güncel Bakiye</th>
                                    <th>Açıklama</th>
                                    <th>Tarih</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($detaylar as $a => $detay){ ?>
                                        <tr>
                                            <td>Bahis</td>
                                            <td><?php echo nf($detay["oncekibakiye"]) ; ?> TL</td>
                                            <td><?php echo nf($detay["tutar"]) ; ?> TL</td>
                                            <td><?php echo nf($detay["sonrakibakiye"]) ; ?> TL</td>
                                            <td><?php  echo str_replace("( İşlemi Yapan : admin)","",$detay["islemad"])  ?></td>
                                            <td><?php echo date("H:i d/m/y",strtotime($detay["tarih"])) ?></td>
                                        </tr>
                                        <?php  $i++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <p>Bu sayfada görüntülenen bahis geçmişi sadece son bir aylık dönemi kapsamaktadır.</p>
                    </div>
                </div>
            </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>
<?php  include "content/dark-theme/view/dark_footer.php"; ?>