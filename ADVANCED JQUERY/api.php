<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $connection = mysqli_connect('localhost', 'root', '', 'jquery');

    if ($connection) {
        $sql = "INSERT INTO data (name, email, phone) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($connection, $sql);

        if ($statement) {
            mysqli_stmt_bind_param($statement, "sss", $name, $email, $phone);

            if (mysqli_stmt_execute($statement)) {
                $response = array('message' => 'Form submitted successfully');
                echo json_encode($response);
            } else {
                $response = array('message' => 'Error submitting form');
                echo json_encode($response);
            }

            mysqli_stmt_close($statement);
        } else {
            $response = array('message' => 'Error preparing statement');
            echo json_encode($response);
        }

        mysqli_close($connection);
    } else {
        $response = array('message' => 'Error connecting to the database');
        echo json_encode($response);
    }
}
?>