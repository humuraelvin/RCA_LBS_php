<?php

  Namespace Project\Model;

  Class PanelSections {

    Public Static $tableName = 'sta_sections_dashboard';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      $data = array(
        'parent' => p("parent"),
        'slug' => p("slug"),
        'name' => implode(" {lang} ", $_POST["name"]),
        'icon' => p("icon"),
        'type' => p("type"),
        'tablename' => p("tablename"),
        'identity' => p("identity"),
        'ord' => p("ord"),
        'section' => p("section")
      );
      return $data;
    }

    /**
    * SEARCHING
    */

    Public Static Function conditions()
    {
      $condition[] = "parent=?";
      $_GET["query"] ? $condition[] = "name LIKE ?" : NULL;
      $condition   = array_values(array_filter($condition));
      $where       = count($condition)>0 ? " WHERE " : NULL;
      return $where.implode(" AND ", $condition);
    }

    Public Static Function paramaters()
    {
      $paramater[] = 0;
      $_GET["query"] ? $paramater[] = "%".$_GET["query"]."%" : NULL;
      return array_values(array_filter($paramater, 'strlen'));
    }

    Public Static Function orderby()
    {
      return "ORDER BY ord ASC";
    }

  }
