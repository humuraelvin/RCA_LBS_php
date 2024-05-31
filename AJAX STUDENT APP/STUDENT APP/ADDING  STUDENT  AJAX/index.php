<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "ajaxproject";
$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Connection Failed(error) :" .$conn->connect_error);
}

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $result = $conn->query("SELECT * FROM students");
        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode($students);
        break;
    case 'POST':
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $grade = $_POST['grade'];
        $prof = $_FILES['prof']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["prof"]["name"]);
        move_uploaded_file($_FILES["prof"]["tmp_name"], $target_file);
        $sql = "INSERT INTO students (name, age, email, password, grade, prof) VALUES ('$name', '$age', '$email', '$password', '$grade', '$prof')";
        if ($conn->query($sql) === TRUE) {
            echo "New student added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $name = $data['name'];
        $age = $data['age'];
        $grade = $data['grade'];
        $sql = "UPDATE students SET name='$name', age='$age', grade='$grade' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Student updated successfully";
        } else {
            echo "Error updating student: " . $conn->error;
        }
        break;
    case 'DELETE':
        $id = $_GET['id'];
        $sql = "DELETE FROM students WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Student deleted successfully";
        } else {
            echo "Error deleting student: " . $conn->error;
        }
        break;
    default:
        echo "Invalid request method";
        break;
}

$conn->close();
?>
