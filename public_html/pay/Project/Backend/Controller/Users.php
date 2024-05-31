<?php

  Namespace Project\Controller;

  Use Library\Database as DB;
  Use Project\Model\Users as Model;


  Class Users extends Model {

    /**
    * CRUD
    */

    Public Static Function delete($identity)
    {
      if(PSLUG2=='delete')
      {
        $delete = DB::delete(self::$tableName, $identity."=?", array(g("id")));
        if($delete)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
          go(PATH_DASHBOARD."/users",1);
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
          $delete = DB::delete(self::$tableName, $identity."=?", array(reset(explode(":",$_POST['item'][$i]))));
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

    /**
    * PAGENATION
    */

    Public Static Function total()
    {
      $query = DB::rowCount("SELECT user_id FROM ".self::$tableName." ".self::conditions(), self::paramaters());
      return $query;
    }

    Public Static Function fetch()
    {
      $query = DB::fetch("SELECT ".self::$tableSelect." FROM ".self::$tableName." ".self::conditions()." ".self::orderby(), self::paramaters());
      return $query;
    }

  }
