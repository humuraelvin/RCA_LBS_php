<?php

  Namespace Project\Controller;

  Use Library\Database as DB;
  Use Library\Paginator as Paginator;
  Use Project\Model\Banks as Model;

  Class Banks  extends Model {

    /**
    * CRUD
    */

    Public Static Function create()
    {
      if(isset($_POST['add']) and PSLUG2=='add')
      {
        $insert = DB::insert(self::$tableName, self::postData());
        if($insert)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
          go(PATH_DASHBOARD."/banks",1);
        }
        else
        {
          alert("error", "Hata!", "İşlem gerçekleştirilirken teknik bir sorun oluştu.");
        }
      }
    }

    Public Static Function update($identity)
    {
      if(isset($_POST['edit']) and PSLUG2=='edit')
      {
        $update = DB::update(self::$tableName, self::postData(), $identity."='".g("id")."'");
        if($update)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
          go(PATH_DASHBOARD."/banks/edit?id=".g("id"),1);
        }
        else
        {
          alert("error", "Hata!", "İşlem gerçekleştirilirken teknik bir sorun oluştu.");
        }
      }
    }

    Public Static Function delete($identity)
    {
      if(PSLUG2=='delete')
      {
        $delete = DB::delete(self::$tableName, $identity."=?", array(g("id")));
        if($delete)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
          go(PATH_DASHBOARD."/banks",1);
        }
        else
        {
          alert("error", "Hata!", "İşlem gerçekleştirilirken teknik bir sorun oluştu.");
        }
      }
    }

    Public Static Function deleteSelected($identity)
    {
      if(count($_POST['item']))
      {
        for ($i=0; $i < count($_POST['item']) ; $i++) {
          $delete = DB::delete(self::$tableName, $identity."=?", array($_POST['item'][$i]));
        }
        if($i)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
        }
      }
    }

    /**
    * METHODS
    */

    Public Static Function single()
    {
      $query = DB::single("SELECT * FROM sta_sections_dashboard WHERE slug=?", array(PSLUG1));
      return $query;
    }

    Public Static Function edit()
    {
      $query = DB::single("SELECT * FROM ".self::$tableName." WHERE id=?", array(g("id")));
      return $query;
    }

    /**
    * PAGENATION
    */

    Public Static Function total()
    {
      $query = DB::rowCount("SELECT id FROM ".self::$tableName." ".self::conditions(), self::paramaters());
      return $query;
    }

    Public Static Function fetch()
    {
      $query = DB::fetch("SELECT ".self::$tableSelect." FROM ".self::$tableName." ".self::conditions()." ".self::orderby(), self::paramaters());
      return $query;
    }

  }
