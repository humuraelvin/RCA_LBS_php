<?php

  include 'autoload.php';

  header('Content-Type: text/html; charset=utf-8');

  /*
  $i = 0;
  $query = Library\Database::fetch("SELECT * FROM sta_system_terms");
  foreach ($query as $row) {
    $term[$i] = array ($row->tr => array("tr" => $row->tr, "en" => $row->en));
    $i++;
  }
  file_put_contents("../Files/lang.json", json_encode($term));
  echo json_encode($term);

  */

  $query = Library\Database::fetch("SELECT * FROM sta_system_terms WHERE section NOT IN (?)", array('courseName'));
  $termsTR.= '<?php ';
  foreach ($query as $row) {
    $termsTR.= '$GLOBALS["'.$row->define.'"] = "'.$row->tr.'";';
  }
  $termsTR.= '?>';
  file_put_contents("../Files/Terms/tr.php", $termsTR);


  $query = Library\Database::fetch("SELECT * FROM sta_system_terms WHERE section NOT IN (?)", array('courseName'));
  $termsEN.= '<?php ';
  foreach ($query as $row) {
    $termsEN.= '$GLOBALS["'.$row->define.'"] = "'.$row->en.'";';
  }
  $termsEN.= '?>';
  file_put_contents("../Files/Terms/en.php", $termsEN);
