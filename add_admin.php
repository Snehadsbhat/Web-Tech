<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE name='$name' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $name;
        header('Location:index1.html'); 
    } else {
        echo "Invalid admin login credentials";
    }
}

$conn->close();
?>