<?php

  Namespace Project\Model;

  Class Banks {

    Public Static $tableName = 'sta_system_banks';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      $data = array(
        'bankID' => p("bankID"),
        'bank_name' => p("bank_name"),
        'accountName' => p("accountName"),
        'iban' => p("iban")
      );
      return $data;
    }


    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $_GET["query"] ? $condition[] = "name LIKE ?" : NULL;
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
