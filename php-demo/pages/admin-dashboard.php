<?php

include_once "db/dbcon.php";

session_start();

if (!isset($_SESSION['unique_id'])) {
    header('location:authentication/login.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

  <h1>ADMIN DASHBOARD</h1>

</body>
</html>