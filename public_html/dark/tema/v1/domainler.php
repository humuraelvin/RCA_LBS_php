<style type="text/css">
    .domainListe tr:hover {
        background: #D3BB8F;
        color: #fff;
        cursor: pointer;
    }
</style>

<header class="page-header">
    <h2><i class="fa fa-users"></i> Domainler</h2>
</header>

<!-- Tablo -->
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Domainler</h2>
    </header>
    <div class="panel-body">
        <table class="table mb-none">
            <thead>
            <tr>
                <th>#</th>
                <th>İsim</th>
                <th>Domain</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tbody class="domainListe">
            <?php foreach ( $domainler as $domain ) { ?>
                <tr data-id="<?php echo $domain['id']; ?>">
                    <td><?php echo $domain['id']; ?></td>
                    <td><?php echo $domain['name']; ?></td>
                    <td><?php echo $domain['status'] == 0 ? 'PASİF' : '<b style="color: green;">AKTİF</b>' ?></td>
                    <?php if ($domain['status'] == '0') { ?>
                    <td><button class="btn btn-success btn-xs admin-action" data-action="adminDomainGuncelle" data-id="<?php echo $domain['id']; ?>">Aktif</button></td>
                    <?php } else echo '<td>-</td>'; ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<!-- #Tablo -->