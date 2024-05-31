{php} include "content/dark-theme/view/dark_header.php";{/php}
{literal}
    <style>
        @media (max-width: 767px) {
            /* Label the data */
            .bets-table td:nth-of-type(1):before { content: 'Kupon No : ';font-weight: bold; }
            .bets-table td:nth-of-type(2):before { content: 'Tarih : ';font-weight: bold; }
            .bets-table td:nth-of-type(3):before { content: 'Tür : ';font-weight: bold; }
            .bets-table td:nth-of-type(4):before { content: 'Miktar : ';font-weight: bold; }
            .bets-table td:nth-of-type(5):before { content: 'Oran : ';font-weight: bold; }
            .bets-table td:nth-of-type(6):before { content: 'Kazanç : ';font-weight: bold; }
            .bets-table td:nth-of-type(7):before { content: 'Durum : ';font-weight: bold; }
            .bets-table td:nth-of-type(8):before { content: 'Detay : ';font-weight: bold; }
        }
    </style>
{/literal}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" />
{literal}
    <script type="text/javascript">
        function couponsdetail(id) {
            $.ajax({
                url:"/myaccount/couponsdetail/" + id,
                success: function(data) {
                    //$('#bodymodal').html(data);
                    //$('#bodymodal').modal();
                    $(".remodal-wrapper, .remodal-overlay").fadeIn("slow");
                    $(".remodal-wrapper").find('#modalDesc').html( data );
                }
            });
        }

        $(document).ready(function() {
            $('#bet-history-table').DataTable( {
                "order": [[0, "desc"]],
                "stripeClasses": [],
                "language": {
                    "search": "",
                    "searchPlaceholder" : "Kupon Ara",
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
    <link rel="stylesheet" href="/assets/css/remodal/remodal.css">
    <script src="/assets/css/remodal/remodal.js"></script>
{/literal}



<div class="remodal" data-remodal-id="modal" aria-labelledby="modalTitle" aria-describedby="modalDesc">

    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>

    <div>

        <p id="modalDesc">



        </p>

    </div>

    <br>

    <button data-remodal-action="confirm" class="remodal-confirm">KAPAT</button>

</div>



<div class="navbar-title visible-sm visible-xs">

    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>

    <a class="page-title"><i class="icon-betslip"></i>BAHİS GEÇMİŞİ</a>

</div>

<section id="main" class="" style="">

    <div class="container">

        <div id="main-panel" class="row have-sidebar-left" style="background: #dfebf9;">

            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">

                {php} include "content/dark-theme/view/sidebar.php";{/php}


                <div class="nano-pane" style="display: none;">

                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>

                </div>

            </div>

            <div id="main-center" style="background: #dfebf9;">

                <div class="center-container" style="min-height: 500px;">

                    <div class="panel panel-white no-padding-sm">

                        <div class="panel-heading">

                            <h2>

                                <i class="icon-betslip"></i>

                                Bahis Geçmişi

                            </h2>

                        </div>

                        <div class="panel-body panel-control">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <form action="/myaccount/coupons" method="post">
                                        <div class="input-daterange input-group form-group" id="bet-history">
                                            <input type="text" class="form-control" name="from" id="start" value="{php}echo $tarih1 {/php}">
                                            <span class="input-group-addon"> ‐ </span>
                                            <input type="text" class="form-control" name="to" id="end" value="{php}echo $tarih2  {/php}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-gray" type="submit"><i class="icon-search"></i></button>
                                                </span>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <div class="tablo-filtre form-group btn-group col-md-8 col-sm-6">
                                        <a id="filter-100" class="btn btn-gray btn-primary coupon-btn user-action" data-action="couponFilter" data-id="100">Tümü</a>
                                        <a id="filter-0" class="btn btn-gray coupon-btn user-action" data-action="couponFilter" data-id="0"">Beklemede</a>
                                        <a id="filter-1" class="btn btn-gray coupon-btn user-action" data-action="couponFilter" data-id="1"">Kazandı</a>
                                        <a id="filter-2" class="btn btn-gray coupon-btn user-action" data-action="couponFilter" data-id="2"">Kaybetti</a>
                                        <a id="filter-3" class="btn btn-gray coupon-btn user-action" data-action="couponFilter" data-id="3"">İade</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-table table-responsive table-mobile">
                            <table class="table table-hover bets-table" id="bet-history-table">
                                <thead>
                                    <tr>
                                        <th>Kupon No</th>
                                        <th>Tarih</th>
                                        <th>Türü</th>
                                        <th>Yatırılan</th>
                                        <th>Oran</th>
                                        <th>Kazanç</th>
                                        <th>Ödenen</th>
                                        <th>Detay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {php}$i= 1{/php}
                                    {foreach from="$kuponlar" item="kupon" key="a"}



                                        <tr onclick="couponsdetail('{$kupon["id"]}');" class="coupon-filter
                                        {if $kupon["durum"] == "1"} coupon-won
                                        {php}}elseif($kupon["durum"] == 2){ {/php} coupon-lost
                                        {php}}elseif($kupon["durum"] == 0){ {/php} coupon-pending
                                        {php}}elseif($kupon["durum"] == 3){ {/php} coupon-return {/if}">
                                            <td>{$kupon["id"]}</td>
                                            <td>{php}echo date("d/m H:i",strtotime($kupon["tarih"])){/php}</td>
                                            <td>{if $kupon["toplam"]>1} Kombine Kupon{else} Tekli Kupon {/if}</td>
                                            <td>{nf($kupon["miktar"])} TL</td>
                                            <td>{nf($kupon["oran"])}</td>
                                            <td>{php}echo nf($kupon["oran"]*$kupon["miktar"]){/php} TL</td>
                                            <td><b>{if $kupon["durum"] eq "1"}
                                                        <span style="color:#4a9613;">KAZANDI</span>
                                                        {php}}elseif($kupon["durum"] == 2){ {/php}
                                                        <span style="color:#a20000;">KAYBETTİ</span>
                                                        {php}}elseif($kupon["durum"] == 0){ {/php}
                                                        <span style="color:#ffaa00;">BEKLEMEDE</span>
                                                        {php}}elseif($kupon["durum"] == 3){ {/php}
                                                        <span style="color:#777;">İADE EDİLDİ</span>
                                                    {/if}</b></td>
                                            <td><b><i style="font-size:16px;cursor: pointer;" class="fa fa-search-plus"></i></b></td>
                                        </tr>
                                        {php}$i++;{/php}
                                    {/foreach}
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
{php} include "content/dark-theme/view/dark_footer.php";{/php}