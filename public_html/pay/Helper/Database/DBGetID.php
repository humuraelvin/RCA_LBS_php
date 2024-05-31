<?php

  Namespace Helper\Database;

  Use Library\Database as DB;
  Use Library\Databasee as DBE;

  Class DBGetID {

    Public Static Function config($configType)
    {
      $query = DB::single("SELECT configName FROM sta_config WHERE configType=?", array($configType));
      return ss($query->configName);
    }

    Public Static Function photo($id, $columb)
    {
      $query = DB::single("SELECT ".$columb." FROM sta_sections_website_photo WHERE id=?", array($id));
      return ss($query->$columb);
    }

    Public Static Function administrator($columb)
    {
      $query = DB::single("SELECT ".$columb." FROM sta_administrator WHERE id=?", array($_SESSION['adminID']));
      return ss($query->$columb);
    }

    Public Static Function userget($columb)
    {
      $query = DB::single("SELECT ".$columb." FROM sta_administrator WHERE id=?", array(9));
      return ss($query->$columb);
    }

    Public Static Function user($columb)
    {
      $query = DB::single("SELECT * FROM sta_data_user WHERE username=? and password=?", array($_SESSION['webUserName'], $_SESSION['webPassword']));
      return $query->$columb;
    }

    Public Static Function peymentMethod($id, $columb)
    {
      $query = DB::single("SELECT $columb FROM sta_system_payment_methods WHERE id=?", array($id));
      return ss($query->$columb);
    }

    Public Static Function userId($id, $columb)
    {
      $query = DB::single("SELECT $columb FROM sta_data_user WHERE user_id=?", array($id));
      return ss($query->$columb);
    }

    Public Static Function userUsername($id, $columb)
    {
      $query = DB::single("SELECT $columb FROM sta_data_user WHERE username=?", array($id));
      return ss($query->$columb);
    }

    Public Static Function userIdE($id, $columb)
    {
      $query = DBE::single("SELECT $columb FROM admin WHERE id=?", array($id));
      return ss($query->$columb);
    }

  }
