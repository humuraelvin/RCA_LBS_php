<?php 

      include 'db/ayar.php';
  include 'db/database.php';
  $single = Library\Database::single("SELECT * FROM maclar WHERE id=?", array($_GET['id']));
  
  if($_GET["section"]=='skor')
  {
      echo "<span style='display: block; margin-bottom: 8px; color: #fff; font-weight: 700; font-size: 35px;'>".$single->skor."</span>";
  }
  
    if($_GET["section"]=='time')
  {
      echo "<span>".$single->dakika."</span>";
  }
  
  //print_r($query);

?>