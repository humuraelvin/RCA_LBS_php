<?php

  Namespace Helper;

  Use Library\Database as DB;

  Class DashboardPermission {

    Public Static Function rooter($userPermission,$cat)
    {
      return DB::rowCount("SELECT * FROM sta_administrator_permissions WHERE id=? AND cats LIKE ?", array($userPermission,$cat));
    }

    Public Static Function create($userPermission,$cat)
    {
      return DB::rowCount("SELECT * FROM sta_administrator_permissions WHERE id=? AND cats LIKE ? and cr=?", array($userPermission,$cat,1));
    }

    Public Static Function update($userPermission,$cat)
    {
      return DB::rowCount("SELECT * FROM sta_administrator_permissions WHERE id=? AND cats LIKE ? and u=?", array($userPermission,$cat,1));
    }

    Public Static Function delete($userPermission,$cat)
    {
      return DB::rowCount("SELECT * FROM sta_administrator_permissions WHERE id=? AND cats LIKE ? and d=?", array($userPermission,$cat,1));
    }

  }
