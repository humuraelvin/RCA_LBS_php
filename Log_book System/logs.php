<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'log_db');  

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['addLog'])) {
    $entry_date = mysqli_real_escape_string($conn, $_POST['entry_date']);
    $entry_time = mysqli_real_escape_string($conn, $_POST['entry_time']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $week = mysqli_real_escape_string($conn, $_POST['week']);
    $activity_description = mysqli_real_escape_string($conn, $_POST['activity_description']);
    $working_hour = mysqli_real_escape_string($conn, $_POST['working_hour']);
    $created_at = date("Y-m-d H:i:s");

    $sqlQuery = "INSERT INTO logbook_entries (entry_date, entry_time, days, week, activity_description, working_hour, created_at) 
                 VALUES ('$entry_date', '$entry_time', '$day', '$week', '$activity_description', '$working_hour', '$created_at')";
    $result = mysqli_query($conn, $sqlQuery);

    if ($result) {
        echo "<script type='text/javascript'> window.alert('Log Added Successfully'); </script>";
    } else {
        echo "<script type='text/javascript'> window.alert('Adding Log Failed'); </script>";
        echo "Error: " . mysqli_error($conn);
    }

    header("location:logs.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * { font-family: sans-serif; }
        .nav_bar { position: sticky; display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding: 5px 10px; background: #ff5722; }
        .nav_bar h1 { margin: 15px; }
        .nav_bar ul { list-style: none; padding: 5px; margin: 5px; display: flex; align-items: center; float: right; }
        .nav_bar li { margin: 5px 10px; }
        .nav_bar a { display: flex; position: absolute; top: 7%; left: 90%; text-decoration: none; color: white; }
        .side_bar { background: #2d4059; width: 20%; height: 800px; }
        .side_bar li { list-style: none; }
        .side_bar a { text-decoration: none; color: white; position: static; top: 20%; }
        .intro { position: absolute; align-items: center; top: 18%; left: 23%; }
        .logs{
            position: absolute;
            padding-top: -5rem;
        }
    </style>
</head>
<body>
<div class="nav_bar">
    <nav>
        <ul>
            <li><h1><strong>Logbook Dashboard</strong></h1></li>
            <li><a class="btn btn-primary" href="./logout.php">Logout</a></li>
        </ul>
    </nav>
</div>

<div class="side_bar">
    <aside>
        <ul>
            <br><br>
            <li><a href="./index.html">HOME</a></li>
            <br><br>
            <li><a href="./adminDash.html">DASHBOARD</a></li>
            <br><br>
            <li><a href="./logs.php">LOG REGISTRY DATA</a></li>
        </ul>
    </aside>
</div>

<div class="intro">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Add Log
    </button>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Log Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3">
                        <form action="#" method="POST">
                            <div class="mb-3 mt-3">
                                <label for="entry_date">Entry Date:</label>
                                <input type="date" class="form-control" placeholder="Enter Entry Date" name="entry_date" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="entry_time">Entry Time:</label>
                                <input type="time" class="form-control" placeholder="Enter Entry Time" name="entry_time" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="day">Day:</label>
                                <select class="form-control" name="day" required>
                                    <option value="MON">Monday</option>
                                    <option value="TUE">Tuesday</option>
                                    <option value="WED">Wednesday</option>
                                    <option value="THUR">Thursday</option>
                                    <option value="FRI">Friday</option>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="week">Week:</label>
                                <input type="number" class="form-control" placeholder="Enter Week Number" name="week" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="activity_description">Activity Description:</label>
                                <textarea class="form-control" placeholder="Enter Activity Description" name="activity_description" required></textarea>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="working_hour">Working Hour:</label>
                                <input type="number" class="form-control" placeholder="Enter Working Hour" name="working_hour" required>
                            </div>
                            <button type="submit" name="addLog" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3 logs">
    <h1><strong>LOG ENTRIES</strong></h1>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Entry Date</th>
            <th>Entry Time</th>
            <th>Day</th>
            <th>Week</th>
            <th>Activity Description</th>
            <th>Working Hour</th>
            <th>Created At</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require './config.php';
        // Retrieving the data
        $retrieveSqlQuery = "SELECT * FROM logbook_entries";
        $whatIsRetrieved = mysqli_query($conn, $retrieveSqlQuery);
        while ($info = $whatIsRetrieved->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo "{$info['id']}"; ?></td>
            <td><?php echo "{$info['entry_date']}"; ?></td>
            <td><?php echo "{$info['entry_time']}"; ?></td>
            <td><?php echo "{$info['days']}"; ?></td>
            <td><?php echo "{$info['week']}"; ?></td>
            <td><?php echo "{$info['activity_description']}"; ?></td>
            <td><?php echo "{$info['working_hour']}"; ?></td>
            <td><?php echo "{$info['created_at']}"; ?></td>
            <td>
                <a class="btn btn-primary" href="./backend/updateLog.php?log_id=<?php echo urlencode($info['id']); ?>">Update</a>
                <a onclick="javascript:return confirm('Are you sure you want to delete this log?');" href="./backend/delete.php?log_id=<?php echo urlencode($info['id']); ?>" class="btn btn-danger">Delete</a>
            </td>


        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
