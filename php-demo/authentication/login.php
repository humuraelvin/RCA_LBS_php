<?php
session_start();  

include_once "../db/dbcon.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
            $resi = mysqli_fetch_assoc($result);
            if ($resi['usertype'] == "admin") {
             $_SESSION['unique_id'] = $resi['unique_id'];
                 echo "<script>window.location.href = '../pages/admin-dashboard.php';</script>";
            } elseif ($resi['usertype'] == "user") {
             $_SESSION['unique_id'] = $resi['unique_id'];
                 echo "<script>window.location.href = '../pages/user-dashboard.php';</script>";
            }
    } else {
        echo "<script type='text/javascript'>
            alert('Invalid username or password');
        </script>";
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
        <form action="" method="POST"> 
                <label for="">Email:</label>
                <input type="email" name="email" required> 
            </div>
            <div>
                <label for="">Password:</label>
                <input type="password" name="password" required> 
            </div>
            <div>
                <input type="submit" name="submit" value="Login"> 
            </div>
            <div>
              <p>Don't have an account? <a href="./signup.php">Signup</a></p>
            </div>
        </form>
    </center>

</body>
</html>
