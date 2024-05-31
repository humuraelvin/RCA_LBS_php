<?php

  Namespace Project\Controller;

  Use Library\Database as DB;
  Use Library\Paginator as Paginator;
  Use Project\Model\GeneralSettings as Model;

  Class GeneralSettings extends Model {

    Public Static Function update()
    {
      if(isset($_POST['edit']))
      {
        foreach ($_POST as $key => $value) {
          if($key=='metaTitle')       $value = implode(" {lang} ", $_POST["metaTitle"]);       else $value = $value;
          if($key=='footerCode') $value = $_POST["footerCode"];
          $update = DB::update(self::$tableName, array('configName' => $value), "configType='".$key."'");
        }
        if($update)
        {
          alert("success", "Başarılı!", "İşleminiz başarıyla tamamlandı.");
        }
        else
        {
          alert("error", "Hata!", "İşlem gerçekleştirilirken teknik bir sorun oluştu.");
        }
      }
    }

    Public Static Function single()
    {
      $query = DB::single("SELECT * FROM sta_sections_dashboard WHERE slug=?", array(PSLUG1));
      return $query;
    }

  }
