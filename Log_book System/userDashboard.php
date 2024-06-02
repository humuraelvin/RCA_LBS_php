<?php

session_start();

if (!isset($_SESSION['user_name'])) {
    header("location:login_form.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT DASHBOARD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        * {
            font-family: sans-serif;
        }

        .nav_bar {
            
            position: sticky;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
            background: #ff5722;
        }

        .nav_bar h1 {
            margin: 15px;
        }

        .nav_bar ul {
            list-style: none;
            padding: 5px;
            margin: 5px;
            display: flex;
            align-items: center;
            float: right;
        }

        .nav_bar li {
            margin: 5px 10px;
        }

        .nav_bar a {
            display: flex;
            position: absolute;
            top: 7%;
            left: 90%;
            text-decoration: none;
            color: white;
        }

        .side_bar {
            background: #2d4059;
            width: 20%;
            height: 900px;
            padding-bottom: 5rem;
        }

        .side_bar li {
            list-style: none;
        }

        .side_bar a {
            text-decoration: none;
            color: white;
            position: static;
            top: 20%;

        }

        .intro {
            position: absolute;
            align-items: center;
            top: 30%;
            left: 30%;
        }
    </style>
</head>


<body>
    <div class="nav_bar">
        <nav>
            <ul>
                <li>
                    <h1><strong>STUDENT DASHBOARD</strong></h1>
                </li>
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
                <li><a href="./userDashboard.php">DASHBOARD</a></li>
                <br><br>
                <li><a href="./logs.php">LOG REGISTRY DATA</a></li>
            </ul>
        </aside>
    </div>

    <div class="intro">
        <h1><strong>WELCOME TO STUDENT DASHBOARD !</strong></h1>
        <p>Welcome to the Logbook Registry System. This platform empowers you to efficiently 
        manage logbook entries with ease and precision. From here, you can oversee logbook registrations, 
        update logbook profiles, reset passwords, and monitor logbook activity. With our intuitive interface
         and robust features, you can streamline administrative tasks and ensure a seamless logbook Management
          experience. Whether it's creating new entries, modifying permissions, or addressing logbook inquiries,
           this system serves as your central hub for all logbook-related operations. 
           Take control of your logbook management processes and enhance the functionality 
           of your platform with our comprehensive suite of tools.
            </p>

    </div>

</body>

</html>





