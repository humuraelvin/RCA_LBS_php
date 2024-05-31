<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class Login {

    Public Static Function dashboard()
    {
      return DB::rowCount("SELECT * FROM sta_administrator WHERE username=? and password=?", array($_SESSION['adminUserName'],$_SESSION['adminPassword']));
    }

    Public Static Function frontend()
    {
      return DB::rowCount("SELECT * FROM sta_data_user WHERE username=? and password=?", array($_SESSION['webUserName'],$_SESSION['webPassword']));
    }

  }
