<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class Dashboard {

    Public Static Function status($status)
    {
      if($status)
      {
        echo '<span class="badge badge-pill badge-success">Aktif</span>';
      }
      else
      {
        echo '<span class="badge badge-pill badge-danger">Pasif</span>';
      }
    }

  }
