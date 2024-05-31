<?php

  Namespace Project\Controller;

  Use Library\Database as DB;
  Use Library\Paginator as Paginator;
  Use Helper\Database\DBGetID as DBGetID;
  Use Project\Model\Profile as Model;

  Class Profile extends Model {

    /**
    * CRUD
    */
    Public Static Function update()
    {
      if($_POST and PSLUG2=='edit')
      {
        if(p("username") and p("email") and p("password"))
        {
          $update = DB::update(self::$tableName, self::postData(), "id='".DBGetID::administrator("id")."'");
          if($update)
          {
            $_SESSION['adminUserName'] = post('username');
            $_SESSION['adminPassword'] = password(post('password'));
            alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
            go(PATH_DASHBOARD."/profile/edit",1);
          }
          else
          {
            alert("error", "Hata!", "İşlem gerçekleştirilirken teknik bir sorun oluştu.");
          }
        }
        else
        {
          alert("warning", "Dikkat!", "Lütfen, zorunlu alanları boş bırakmayın!");
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

  }
