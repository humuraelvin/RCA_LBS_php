<?php

session_start();

if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <div class="container">
        <div class="content">
            <h3>Hi, <span class="name">Admin</span></h3>
            <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
            <p>This is an admin page</p>
            <a href="./login_form.php" class="btn">Login</a>
            <a href="./register_form.php" class="btn">Register</a>
            <a href="./logout.php" class="btn">Logout</a>
        </div>
    </div>
    
</body>
</html>