<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$supplier_id = $_POST['supplier_id'];
$name = $_POST['name'];


$sql = "INSERT INTO supplier (supplier_id, name) VALUES ('$supplier_id', '$name')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Supplier added successfully!'); window.location.href='add_supplier.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
