<?php

session_start();

include_once '../db/dbcon.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $random_id = rand(time(), 1000000);

    $sql = "INSERT INTO users (unique_id, name, email, password, usertype) VALUES ($random_id, '$name', '$email', '$password', 'user')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sql2 = "SELECT * FROM users WHERE email = '$email' ";
        $res = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($res) > 0) {
            $resi = mysqli_fetch_assoc($res);
            $_SESSION['unique_id'] = $resi['unique_id'];
            header("location:login.php");
        }
    }


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
    
    <center style="margin-top: 15rem;">
        <form action="">
            <div>
                <label for="">User name:</label>
                <input type="text" name="name">
            </div>
            <div>
                <label for="">Email:</label>
                <input type="email" name="email">
            </div>
            <div>
                <label for="">Password:</label>
                <input type="password" name="password">
            </div>
            <div>
                <input type="submit" name="submit">
            </div>
            <div>
              <p>Alreayd have an account? <a href="./login.php">Login</a></p>
            </div>
        </form>
    </center>

</body>
</html>