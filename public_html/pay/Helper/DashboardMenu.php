<?php

  Namespace Helper;

  Use Helper\Database\DBGetSlug as DBGetSlug;
  Use Helper\DashboardPermission as Permission;
  Use Library\Database as DB;

  Class DashboardMenu {

    Public Static Function get($section)
    {
      $query = DB::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? and section=? ORDER BY ord ASC", array("0",$section));
      foreach ($query as $row)
      {
        $subQuery = DB::fetch("SELECT * FROM sta_sections_dashboard WHERE parent=? ORDER BY ord ASC", array($row->id));
        if(count($subQuery) and Permission::rooter($_SESSION['adminPermission'],"%{".$row->id."}%"))
        {
          /*
           * Kullanıcının görebileceği sayfaların kontrolü
          */
          if(Permission::rooter($_SESSION['adminPermission'],"%{".$row->id."}%"))
          {
            echo '<li '.($row->id==DBGetSlug::dashboard("parent") ? 'class="active open"' : NULL).'><a href="#"><i class="fa '.$row->icon.'"></i> <span>'.$row->name.'</span></a><ul>';
          }
          foreach ($subQuery as $row)
          {
            /*
             * Kullanıcının görebileceği sayfaların kontrolü
            */
            if(Permission::rooter($_SESSION['adminPermission'],"%{".$row->id."}%"))
            {
              echo '<li '.($row->slug==PSLUG1 ? 'class="active"' : NULL).'><a href="'.PATH_DASHBOARD.'/'.$row->slug.'">'.$row->name.'</a></li>';
            }
          }
          echo '</ul></li>';
        }
        else
        {
          /*
           * Kullanıcının görebileceği sayfaların kontrolü
          */
          if(Permission::rooter($_SESSION['adminPermission'],"%{".$row->id."}%"))
          {
            echo '<li><a href="'.PATH_DASHBOARD.'/'.$row->slug.'"><i class="fa '.$row->icon.'"></i> <span>'.$row->name.'</span></a></li>';
          }
        }
      }
    }

  }
