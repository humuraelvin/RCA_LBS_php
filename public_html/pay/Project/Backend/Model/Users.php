<?php

  Namespace Project\Model;

  Class Users {

    Public Static $tableName = 'sta_data_user';

    Public Static $tableSelect = '*';

    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $_GET["query"] ? $condition[] = "sta_data_user.firstname LIKE ?" : NULL;
      $_GET["query"] ? $condition[] = "sta_data_user.lastname LIKE ?" : NULL;
      $_GET["query"] ? $condition[] = "sta_data_user.email LIKE ?" : NULL;
      $_GET["query"] ? $condition[] = "sta_data_user.phone LIKE ?" : NULL;
      $_GET["query"] ? $condition[] = "sta_data_user.username LIKE ?" : NULL;
      $condition   = array_values(array_filter($condition));
      $where       = count($condition)>0 ? " WHERE " : NULL;
      return $where.implode(" OR ", $condition);
    }

    Public Static Function paramaters()
    {
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      return array_values(array_filter($paramater, 'strlen'));
    }

    Public Static Function orderby()
    {
      return "ORDER BY sta_data_user.user_id DESC LIMIT 0,100";
    }

  }
