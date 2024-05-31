<?php

  Namespace Project\Model;

  Class userPermissions {

    Public Static $tableName = 'sta_administrator_permissions';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      /**
      * "$name" sadece slug için name[0]
      */
      $name = explode('{lang}', implode("{lang}", $_POST["name"]));
      $data = array(
        'name' => implode(" {lang} ", $_POST["name"]),
        'cats' => sprintf("{%s}", implode("} {", $_POST["cats"])),
        'cr' => p("cr"),
        'u' => p("u"),
        'd' => p("d")
      );
      return $data;
    }


    /**
    * PAGENATION
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
