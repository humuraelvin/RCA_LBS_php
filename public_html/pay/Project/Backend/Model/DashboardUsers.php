<?php

  Namespace Project\Model;

  Class DashboardUsers {

    Public Static $tableName = 'sta_administrator';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      $password = p("password") ? password(p("password")) : p("protectPassword");
      $data = array(
        'permission' => p("permission"),
        'username' => p("username"),
        'email' => p("email"),
        'password' => $password
      );
      return $data;
    }


    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $_GET["query"] ? $condition[] = "username LIKE ?" : NULL;
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
