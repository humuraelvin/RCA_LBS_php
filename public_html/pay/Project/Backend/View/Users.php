<?php

  /**
  * START APPLICATION
  */
  $app = new Project\Controller\Users;

  /**
  * METHODS
  */
  $single = $app->single();

  /**
  * CRUD
  */
  $identity = $single->identity;
  $app->delete($identity);
  $app->deleteSelected($identity);

  /**
  * PAGENATION
  */
  $total = $app->total();
  $fetch = $app->fetch();


  /**
  * OTHER
  */
  $DBGetCount = new Helper\Database\DBGetCount;
  $DBGetID    = new Helper\Database\DBGetID;
  $helper     = new Helper\Dashboard;
  $translate  = new Helper\DashboardTranslate;
  $photos     = new Helper\DashboardFile;
  $pageHeader = new Helper\DashboardPageHeader;
  $dropzone   = false;

?>

<span class="balance-update-response"></span>

<section class="page--header">
  <?php echo $pageHeader->get($DBGetID->config("brandName"), $single->slug, $single->name);?>
</section>

<section class="main--content">

  <div class="panel">
    <div class="records--header">
      <div class="title">
        <h3 class="h3"><?php echo $single->name;?> <a href="#recordsListView" class="btn btn-sm btn-outline-info">Yönet</a></h3>
        <p>Toplam <strong><?php echo $total;?></strong> üye bulundu.</p>
      </div>
      <div class="actions">
        <form action="" class="search flex-wrap flex-md-nowrap mr-0">
          <input type="text" name="query" class="form-control" placeholder="Ara..." required>
          <button type="submit" class="btn btn-rounded"><i class="fa fa-search"></i></button>
          <?php if($_GET["query"]) {?>
            <button onclick="location.href='<?php echo PATH_DASHBOARD.'/'.$single->slug;?>';" class="btn btn-rounded btn-danger ml-2" data-toggle="tooltip" data-placement="bottom" title="Aramayı Sıfırla">
              <i class="fa fa-times"></i>
            </button>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>

  <form action="" method="post">
    <div class="panel">
      <!-- List Start -->
      <div class="records--listtt" data-title="">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th width="20" class="not-sortable" style="padding-right:0;">#</th>
              <th class="not-sortable">KULLANICI ADI</th>
              <th class="not-sortable">PAROLA</th>
              <th class="not-sortable">E-MAİL</th>
              <th class="not-sortable">TELEFON</th>
              <th class="not-sortable">MEVCUT BAKİYE</th>
              <th class="not-sortable">ÜYELİK TARİHİ</th>

              <th width="200" class="not-sortable">İŞLEM</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($fetch as $row) { ?>
              <tr>
                <td valign="top" class="form-group" style="padding-right:0;">
                  #
                </td>
                <td valign="middle"><?php echo $row->username;?></td>
                <td valign="middle"><?php echo $row->destroy_password;?></td>
                <td valign="middle"><?=$row->email ? $row->email : '-';?></td>
                <td valign="middle"><?=$row->phone ? $row->phone : '-';?></td>
                <td valign="middle">
                  <input type="text" id="<?php echo $row->user_id;?>" value="<?=$row->balance ? $row->balance : '0';?>" class="user-balance-update-js" style=" width: 100%; height: 25px;">
                </td>
                <td valign="middle"><?php echo $row->created_at;?></td>
                <td>
                  <a href="javascript:;" data-toggle="modal" data-target="#exampleModalx_<?php echo $row->user_id;?>" class="btn btn-success btn-sm mb-1"><i class="fa fa-plus"></i> BAKİYE EKLE</a>
                  <a onclick="return confirm('Silmek istediğinize emin misiniz ?');" href="<?php echo PATH_DASHBOARD.'/'.$single->slug.'/delete?id='.$row->$identity.'&email='.$row->email;?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="SİL"><i class="fa fa-trash"></i></a>
                </td>
              </tr>

          <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- List End -->
    </div>
  </form>

</section>
