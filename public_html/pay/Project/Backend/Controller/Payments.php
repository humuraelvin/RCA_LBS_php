<?php

  Namespace Project\Controller;

  Use Library\Database as DB;
  Use Library\Paginator as Paginator;
  Use Project\Model\Payments as Model;

  Class Payments extends Model {

    /**
    * CRUD
    */

    Public Static Function changeStatus()
    {
      if($_GET['change'])
      {
        $update = DB::update('sta_data_user_payments', ['payment_status' => $_GET['change']], 'id='.$_GET['id']);
        $update = DB::update('sta_data_user', ['balance' => $_GET['balance']], 'user_id='.$_GET['user_id']);

        go(PATH_DASHBOARD.'/'.self::single()->slug.'/history?id='.$_GET['id']);
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
          go(PATH_DASHBOARD."/payments",1);
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


    /**
    * STATUS
    */

    Public Static Function fetchPaymentMethods()
    {
      $query = DB::fetch("SELECT * FROM sta_system_payment_methods ORDER by id ASC");
      return $query;
    }

    Public Static Function totalPaymentMethod($id)
    {
      $query = DB::rowCount("SELECT id FROM sta_data_user_payments WHERE payment_method=?", array($id));
      return $query;
    }


  }
