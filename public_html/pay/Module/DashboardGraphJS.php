<?php header('Content-type: application/javascript');?>
<?php include 'autoload.php';?>

var $defaultStatistics = document.getElementById('defaultStatistics');
if ( $defaultStatistics ) {
new Morris.Area({
element: $defaultStatistics.id,
data: [
  <?php
    for($i = 0; $i <= 11; $i++) {
      $month[$i]  = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
      $totalV[$i] = Library\Database::sumColumb("sta_system_statistic", "statisticTotalVisitor", "WHERE statisticTime LIKE '%".$month[$i]."%'");
      $totalP[$i] = Library\Database::sumColumb("sta_system_statistic", "statisticPageViews", "WHERE statisticTime LIKE '%".$month[$i]."%'");
      $totalV[$i]  = $totalV[$i] ? $totalV[$i] : 0;
      $totalP[$i]  = $totalP[$i] ? $totalP[$i] : 0;
      $name[$i]    = date('F Y', strtotime(str_replace("-","",$month[$i])."01"));
      $name[$i]    = explode(" ", $name[$i]);
      $name[$i]    = substr($name[$i][0],0,3)." ".$name[$i][1];
      $print[]     = "{month:'".$name[$i]."', a: ".$totalV[$i].", b: ".$totalP[$i]."},";
    }
    $print = array_reverse($print);
    for($i = 0; $i <= count($print); $i++) {
      echo $print[$i];
    }
  ?>
],
xkey: 'month',
ykeys: ['a', 'b'],
labels: ['Ziyaretçi', 'Sayfa Görüntüleme'],
lineColors: ['#009378', '#2bb3c0'],
preUnits: '',
parseTime: false,
pointSize: 0,
lineWidth: 0,
gridLineColor: '#eee',
resize: true,
hideHover: true,
behaveLikeLine: true
});
}
