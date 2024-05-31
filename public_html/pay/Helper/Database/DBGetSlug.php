<?php

  Namespace Helper\Database;

  Use Library\Database as DB;

  Class DBGetSlug {

    Public Static Function dashboard($columb)
    {
      $query = DB::single("SELECT $columb FROM sta_sections_dashboard WHERE slug=?", array(PSLUG1));
      return ss($query->$columb);
    }

    Public Static Function website($columb)
    {
      $query = DB::single("SELECT $columb FROM sta_sections_website WHERE slug=?", array(slug()));
      return ss($query->$columb);
    }

  }
