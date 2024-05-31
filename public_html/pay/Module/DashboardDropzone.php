<?php

  include 'autoload.php';

  /**
  * Login Kontrolü [ve demo hesabı değilse]
  */
  if((Helper\Login::dashboard()) and $_SESSION['adminPermission']!=10)
  {

    /**
    * "Dashboard/Profile" Profil görseli yükleme işlemi.
    */
    if($_GET["section"]=='profile')
    {
      $target_dir  = "../Files/Upload/DashboardProfile/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);
      $file_name   = explode('.', $_FILES["file"]["name"]);
      $file_name   = createSlug($file_name[0]).'-'.rand(100000,999999).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file_name))
      {
        $update = Library\Database::update("sta_administrator", array('photo' => $file_name), "id='".$_GET['id']."'");
      }
    }

    /**
    * Logo
    */
    if($_GET["section"]=='payment-logo')
    {
      $target_dir  = "../Files/Upload/PaymentMethods/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);
      $file_name   = explode('.', $_FILES["file"]["name"]);
      $file_name   = rand(100000,999999).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file_name))
      {
        $update = Library\Database::update("sta_system_payment_methods", array('logo' => $file_name), "id='".$_GET['id']."'");
      }
    }

    /**
    *  Fotoğraf yükleme işlemi.
    */
    if($_GET["section"]=='photo')
    {
      include '../Library/Exception/ImageUpload.php';
      $image = new Upload($_FILES["file"]["tmp_name"]);
      $imagename  = randomKey(16);
      $foldername = date("Y-m");
      if($image->uploaded) {
        ## Large
        $image->file_new_name_body = $imagename;

        $newimagename = $image->file_new_name_body.'.'.end(explode(".",$_FILES["file"]["name"]));

        if($image->image_src_x>1280) {
          $image->image_resize = true;
          $image->image_ratio_y = true;
          $image->image_x = 1280;
        }
        $image->Process("../Files/Upload/Photos/".$foldername."/large/");
        ## Medium
        $image->file_new_name_body = $imagename;

        $newimagename = $image->file_new_name_body.'.'.end(explode(".",$_FILES["file"]["name"]));

        if($image->image_src_x>300) {
          $image->image_resize = true;
          $image->image_ratio_y = true;
          $image->image_x = 300;
        }
        $image->Process("../Files/Upload/Photos/".$foldername."/medium/");
        ## Small
        $image->file_new_name_body = $imagename;

        $newimagename = $image->file_new_name_body.'.'.end(explode(".",$_FILES["file"]["name"]));

        $image->image_resize = true;
        $image->image_ratio_y = true;
        $image->image_x = 125;
        $image->Process("../Files/Upload/Photos/".$foldername."/small/");
        ## Success
        if($image->processed) {
          $insert = Library\Database::insert("sta_sections_website_photo", array('tablename' => $_GET['table'], 'parent' => $_GET['parent'], 'folder' => $foldername, 'name' => $newimagename));
        } else {
          print 'Bir sorun oluştu: '.$image->error;
        }
      }
    }

    /**
    * Slider yükleme işlemi.
    */
    if($_GET["section"]=='slider')
    {
      $target_dir  = "../Files/Upload/Sliders/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);
      $file_name   = explode('.', $_FILES["file"]["name"]);
      $file_name   = createSlug($file_name[0]).'-'.rand(100000,999999).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file_name))
      {
        $update = Library\Database::insert("sta_data_slider_list", array('area' => $_GET["area"], 'name' => $file_name));
      }
    }

  }
