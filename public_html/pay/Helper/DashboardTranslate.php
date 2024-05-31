<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class DashboardTranslate {

    Public Static Function dropDown($slug)
    {
      $getLang = $_GET["lang"] ? $_GET["lang"] : "tr";
      if(MULTILANG)
      {
        echo '<div class="btn-group">';
        $query = DB::fetch("SELECT * FROM sta_system_langs WHERE code=?", array($getLang));
        foreach ($query as $row) {
          echo '<button class="btn btn-rounded btn-default dropdown-toggle" data-toggle="dropdown"><strong>DÜZENLE ['.$row->code.']</strong></button>';
        }
        echo '<div class="dropdown-menu" data-x-placement="bottom-start">';
        $query = DB::fetch("SELECT * FROM sta_system_langs WHERE status=?", array(1));
        foreach ($query as $row) {
          echo '<a href="'.PATH_DASHBOARD.'/'.$slug.'/edit?id='.$_GET["id"].'&lang='.$row->code.'" class="dropdown-item">'.$row->name.'</a>';
        }
        echo '</div>';
        echo '</div>';
      }
      else
      {
        echo '<h6 class="h6">Düzenle</h6>';
      }
    }

    Public Static Function percent($value,$ext=null)
    {
      // ekstra alan için $ext değeri 2,3,4 olarak gönderilir. Örn: content varsa 2, content+descripton 3 gönderilir. 2 den fazla her alan için 2 + 1 şeklinde gider.
      if(MULTILANG)
      {
        $i = 1;
        $totalValue =  explode('{lang}',$value);
        foreach ($totalValue as $key => $value) {
          if($key and str_replace(" ", "", $value)) $i++;
        }
        $totalValue =  $ext ? $i+1 : $i;
        $totalLangs =  DB::rowCount("SELECT id FROM sta_system_langs WHERE status=?", array(1));
        $totalLangs =  $ext ? $ext*$totalLangs : $totalLangs;
        $percent    =  100/$totalLangs;
        $percent    =  round($percent*$totalValue);
        $percent    =  '
        <div class="progress h-15px" style="width: 50px;float: left;margin: 5px 10px 0 0;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Çeviri Durumu">
            <div class="progress-bar bg-green w-'.$percent.'">'.$percent.'%</div>
        </div>
        ';
        return $percent;
      }
    }

    Public Static Function input($name,$value,$required,$id)
    {

        $inputRequired  =  $required ? "required" : NULL;
        echo '<input id="'.$id.'" type="'.$type.'" name="'.$name.'[]" class="form-control" value="'.$value.'" '.$inputRequired.'>';

    }

    Public Static Function wysiwyg($name,$value)
    {
      if(MULTILANG)
      {
        $pageLang = $_GET['lang'] ? $_GET['lang'] : "tr";
        $query = DB::fetch("SELECT * FROM sta_system_langs WHERE status=?", array(1));
        foreach ($query as $row) {
          $hidden  = $row->code==$pageLang ? NULL : 'style="display:none;"';
          $trigger = $row->code==$pageLang ? 'data-trigger="summernote"' : NULL;
          echo '<textarea name="'.$name.'[]" class="form-control" '.$trigger.' '.$hidden.'>'.__($value, $row->code).'</textarea>';
        }
      }
      else
      {
        echo '<textarea name="'.$name.'[]" class="form-control" data-trigger="summernote">'.__($value).'</textarea>';
      }
    }

    Public Static Function textarea($name,$value)
    {
      if(MULTILANG)
      {
        $pageLang = $_GET['lang'] ? $_GET['lang'] : "tr";
        $query = DB::fetch("SELECT * FROM sta_system_langs WHERE status=?", array(1));
        foreach ($query as $row) {
          $hidden  = $row->code==$pageLang ? NULL : 'style="display:none;"';
          echo '<textarea name="'.$name.'[]" class="form-control" rows="3" '.$hidden.'>'.__($value, $row->code).'</textarea>';
        }
      }
      else
      {
        echo '<textarea name="'.$name.'[]" class="form-control" rows="3">'.__($value).'</textarea>';
      }
    }

  }
