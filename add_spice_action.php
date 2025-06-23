<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $spice_id = $_POST['spice_id'];
    $name = $_POST['name'];
    $price_per_unit = $_POST['price_per_unit'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO spice (spice_id, name, price_per_unit, stock_quantity) 
            VALUES ('$spice_id', '$name', '$price_per_unit', '$stock_quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Spice added successfully!');
        window.location.href = 'add_spice.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif (isset($_GET['delete_id'])) {
   
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM spice WHERE spice_id='$delete_id'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Spice deleted successfully!');
        window.location.href = 'view_spices.php';</script>"; 
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
