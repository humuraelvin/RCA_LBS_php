<?php

  Namespace Project\Model;

  Class Profile {

    Public Static $tableName = 'sta_administrator';

    Public Static $tableSelect = '*';

    Public Static Function postData()
    {
      $data = array(
        'username' => p("username"),
        'email' => p("email"),
        'phone' => p("phone"),
        'password' => password(post('password'))
      );
      return $data;
    }


  }
