<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class Photo {

    Public Static Function small($table,$parent)
    {
      $query = DB::single("SELECT folder,name FROM sta_sections_website_photo WHERE tablename=? and parent=? ORDER BY ord ASC", array($table,$parent));
      if($query->name)
      {
        return PATH_UPLOAD.'/Photos/'.$query->folder.'/small/'.$query->name;
      }
      else
      {
        return PATH_UPLOAD.'/Photos/no-image.jpg';
      }
    }

    Public Static Function single($table,$parent)
    {
      $query = DB::single("SELECT folder,name FROM sta_sections_website_photo WHERE tablename=? and parent=? ORDER BY ord ASC", array($table,$parent));
      if($query->name)
      {
        return PATH_UPLOAD.'/Photos/'.$query->folder.'/large/'.$query->name;
      }
      else
      {
        return PATH_UPLOAD.'/Photos/no-image.jpg';
      }
    }

    Public Static Function fetch($table,$parent)
    {
      $query = DB::fetch("SELECT * FROM sta_sections_website_photo WHERE tablename=? and parent=? ORDER BY ord ASC", array($table,$parent));
      return $query;
    }

  }
