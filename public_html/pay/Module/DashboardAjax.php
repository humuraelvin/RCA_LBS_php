<?php

  include 'autoload.php';

  /**
  * Login Kontrolü [ve demo hesabı değilse]
  */
  if((Helper\Login::dashboard()) and $_SESSION['adminPermission']!=10)
  {

    /**
    * Onayla
    */
    if($_GET["section"]=='payment-check')
    {
      $parse  =  explode("|", $_GET["id"]);
      $update = Library\Database::update("sta_data_user_payments", array('payment_status' => 1), "id=".$parse[0]);
      $update = Library\Database::update("sta_data_user", array('balance' => $parse[2]), "user_id=".$parse[1]);
    }

    /**
    * Delete
    */
    if($_GET["section"]=='payment-delete')
    {
      $delete = Library\Database::delete("sta_data_user_payments", "id=?", array($_GET["id"]));
    }

    /**
    * Bakiye Tanımla
    */
    if($_GET["section"]=='user-balance-update')
    {
      if($_POST["id"])
      {
        $update= Library\Database::update("sta_data_user", array('balance' => $_POST["balance"]), "user_id=".$_POST["id"]);
        if($update)
        {
          alert("info", "Başarılı!", "Bakiye tanımlandı.");
        }
      }
    }

    /**
    * "Dashboard" fotoğraf silme işlemi
    */
    if($_GET["section"]=='photo-delete')
    {
      unlink("../Files/Upload/Photos/".Helper\Database\DBGetID::photo($_POST["photoID"], "folder")."/small/".Helper\Database\DBGetID::photo($_POST["photoID"], "name"));
      unlink("../Files/Upload/Photos/".Helper\Database\DBGetID::photo($_POST["photoID"], "folder")."/medium/".Helper\Database\DBGetID::photo($_POST["photoID"], "name"));
      unlink("../Files/Upload/Photos/".Helper\Database\DBGetID::photo($_POST["photoID"], "folder")."/large/".Helper\Database\DBGetID::photo($_POST["photoID"], "name"));
      $delete = Library\Database::delete("sta_sections_website_photo", "id=?", array($_POST["photoID"]));
    }

    /**
    * "Dashboard" fotoğraf sıralama
    */
    if($_GET["section"]=='photo-update')
    {
      if($_POST["photoID"] and $_POST["order"])
      {
        $update= Library\Database::update("sta_sections_website_photo", array('ord' => $_POST["order"]), "id=".$_POST["photoID"]);
      }
    }


    /**
    * "Dashboard" slider silme işlemi
    */
    if($_GET["section"]=='slider-delete')
    {
      unlink("../Files/Upload/Sliders/".Helper\Database\DBGetID::slider($_POST["sliderID"], "name"));
      $delete = Library\Database::delete("sta_data_slider_list", "id=?", array($_POST["sliderID"]));
    }

    /**
    * "Dashboard" slider sıralama
    */
    if($_GET["section"]=='slider-update')
    {
      if($_POST["sliderID"] and $_POST["order"])
      {
        $update= Library\Database::update("sta_data_slider_list", array('ord' => $_POST["order"]), "id=".$_POST["sliderID"]);
      }
    }

    /**
    * "Dashboard" slider content
    */
    if($_GET["section"]=='slider-content-update')
    {
      if($_POST["sliderID"] and $_POST["content"])
      {
        $update= Library\Database::update("sta_data_slider_list", array('content' => $_POST["content"]), "id=".$_POST["sliderID"]);
      }
    }


    /**
    * "TERM" UPDATE
    */
    if($_GET["section"]=='term-section-update')
    {
      if($_POST["termID"])
      {
        $update= Library\Database::update("sta_system_terms", array('section' => $_POST["termSection"]), "id=".$_POST["termID"]);
      }
    }
    if($_GET["section"]=='term-define-update')
    {
      if($_POST["termID"])
      {
        $update= Library\Database::update("sta_system_terms", array('define' => $_POST["termDefine"]), "id=".$_POST["termID"]);
      }
    }
    if($_GET["section"]=='term-tr-update')
    {
      if($_POST["termID"])
      {
        $update= Library\Database::update("sta_system_terms", array('tr' => $_POST["termContent"]), "id=".$_POST["termID"]);
      }
    }
    if($_GET["section"]=='term-en-update')
    {
      if($_POST["termID"])
      {
        $update= Library\Database::update("sta_system_terms", array('en' => $_POST["termContent"]), "id=".$_POST["termID"]);
      }
    }


  }
