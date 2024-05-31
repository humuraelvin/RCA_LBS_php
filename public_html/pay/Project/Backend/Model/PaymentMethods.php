<?php

  Namespace Project\Model;

  Class PaymentMethods {

    Public Static $tableName = 'sta_system_payment_methods';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      $data = array(
        'method_name' => p("method_name"),
        'method_price' => p("method_price"),
        'method_limit' => p("method_limit")

      );
      return $data;
    }


    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $_GET["query"] ? $condition[] = "method_name LIKE ?" : NULL;
      $condition   = array_values(array_filter($condition));
      $where       = count($condition)>0 ? " WHERE " : NULL;
      return $where.implode(" AND ", $condition);
    }

    Public Static Function paramaters()
    {
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      return array_values(array_filter($paramater, 'strlen'));
    }

    Public Static Function orderby()
    {
      return "ORDER BY id ASC";
    }

  }
