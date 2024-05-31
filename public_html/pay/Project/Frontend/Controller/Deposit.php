<?php

  Namespace Project\Controller;

  Use Library\Database as DB;

  Class Deposit {

    /**
    * WEBSITE
    */

    Public Static Function paymentMethods()
    {
      $query = DB::fetch("SELECT * FROM sta_system_payment_methods order by id asc");
      return $query;
    }
  }
