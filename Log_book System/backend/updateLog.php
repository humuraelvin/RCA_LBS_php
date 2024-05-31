<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "log_db";

$connection = mysqli_connect($host, $user, $password, $dbname);

$id = $_GET['log_id'];

$sqlGetQuery = "SELECT * FROM logbook_entries WHERE id = ?";
$stmt = mysqli_prepare($connection, $sqlGetQuery);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$info = mysqli_fetch_assoc($result);

if (isset($_POST['updateLog'])) {
    $entry_date = $_POST['entry_date'];
    $entry_time = $_POST['entry_time'];
    $day = $_POST['day'];
    $week = $_POST['week'];
    $activity_description = $_POST['activity_description'];
    $working_hour = $_POST['working_hour'];

    $sqlUpdateQuery = "UPDATE logbook_entries SET entry_date = ?, entry_time = ?, days = ?, week = ?, activity_description = ?, working_hour = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sqlUpdateQuery);
    mysqli_stmt_bind_param($stmt, "sssissi", $entry_date, $entry_time, $day, $week, $activity_description, $working_hour, $id);
    $updateResult = mysqli_stmt_execute($stmt);

    if ($updateResult) {
        header("location:../logs.php");
    } else {
        echo "Log updating failed: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Log</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <h1><strong>Update Log</strong></h1>
    <form action="#" method="POST">
        <div class="mb-3 mt-3">
            <label for="entry_date">Entry Date:</label>
            <input type="date" class="form-control" value="<?php echo $info['entry_date']; ?>" name="entry_date" required>
        </div>
        <div class="mb-3 mt-3">
            <label for="entry_time">Entry Time:</label>
            <input type="time" class="form-control" value="<?php echo $info['entry_time']; ?>" name="entry_time" required>
        </div>
        <div class="mb-3 mt-3">
            <label for="day">Day:</label>
            <select class="form-control" name="day" required>
                <option value="MON" <?php echo $info['days'] == 'MON' ? 'selected' : ''; ?>>Monday</option>
                <option value="TUE" <?php echo $info['days'] == 'TUE' ? 'selected' : ''; ?>>Tuesday</option>
                <option value="WED" <?php echo $info['days'] == 'WED' ? 'selected' : ''; ?>>Wednesday</option>
                <option value="THUR" <?php echo $info['days'] == 'THUR' ? 'selected' : ''; ?>>Thursday</option>
                <option value="FRI" <?php echo $info['days'] == 'FRI' ? 'selected' : ''; ?>>Friday</option>
            </select>
        </div>
        <div class="mb-3 mt-3">
            <label for="week">Week:</label>
            <input type="number" class="form-control" value="<?php echo $info['week']; ?>" name="week" required>
        </div>
        <div class="mb-3 mt-3">
            <label for="activity_description">Activity Description:</label>
            <textarea class="form-control" name="activity_description" required><?php echo $info['activity_description']; ?></textarea>
        </div>
        <div class="mb-3 mt-3">
            <label for="working_hour">Working Hour:</label>
            <input type="number" class="form-control" value="<?php echo $info['working_hour']; ?>" name="working_hour" required>
        </div>
        <button type="submit" name="updateLog" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
