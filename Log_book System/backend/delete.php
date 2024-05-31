<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "log_db";

$connection = mysqli_connect($host, $user, $password, $dbname);

if (isset($_GET['log_id'])) {
    $log_id = $_GET['log_id'];

    $sqlDeleteQuery = "DELETE FROM logbook_entries WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sqlDeleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $log_id);
    mysqli_stmt_execute($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);

    if ($affected_rows > 0) {
        header("Location: ../logs.php");
        exit();
    } else {
        header("Location: ../logs.php?error=delete_failed");
        exit();
    }
} else {
    header("Location: ../logs.php");
    exit();
}
?>
