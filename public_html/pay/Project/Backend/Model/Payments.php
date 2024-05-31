<?php

  Namespace Project\Model;

  Class Payments {

    Public Static $tableName = 'sta_data_user_payments';

    Public Static $tableSelect = '*';

    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $_GET["payment_method"] ? $condition[] = "payment_method=?" : NULL;
      $condition   = array_values(array_filter($condition));
      $where       = count($condition)>0 ? " WHERE " : NULL;
      return $where.implode(" AND ", $condition);
    }

    Public Static Function paramaters()
    {
      $_GET["payment_method"] ? $paramater[] = $_GET["payment_method"] : NULL;
      return array_values(array_filter($paramater, 'strlen'));
    }

    Public Static Function orderby()
    {
      return "ORDER BY id DESC";
    }

  }
