<?php

  Namespace Project\Model;

  Class SiteSections {

    Public Static $tableName = 'sta_data_sections';

    Public Static $tableSelect = '*';

    Public Static Function slug()
    {
      return p("slug");
    }

    Public Static Function postData($type=null)
    {
      if($type=='website')
      {
        $data = array(
          'slug' => self::slug(),
          'type' => "SpecialSiteSectionName"
        );
      }
      else if($type=='meta')
      {
        $data = array(
          'slug' => self::slug(),
          'title' => implode(" {lang} ", $_POST["title"]) ? implode(" {lang} ", $_POST["title"]) : implode(" {lang} ", $_POST["name"]),
          'description' => implode(" {lang} ", $_POST["description"])
        );
      }
      else
      {
        $data = array(
          'slug' => self::slug(),
          'name' => implode(" {lang} ", $_POST["name"]),
          'content' => implode(" {lang} ", $_POST["content"])
        );
      }
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
