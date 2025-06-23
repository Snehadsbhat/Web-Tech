


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";  


$customer_id = $_POST['customer_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];


$conn = new mysqli('localhost', 'root','','spice_stores');


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM customer WHERE email = ? OR phone_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $phone_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    echo '<script>alert("Email or phone number already registered! Enter new info.");</script>';
    echo '<a style="color: green;" href="add_customer.html"><h1>Click here to refresh</h1></a>';
} else {
   
    $stmt = $conn->prepare("INSERT INTO customer (customer_id, name, email, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $customer_id, $name, $email, $phone_number);
    
    if ($stmt->execute()) {
        echo '<script>alert("Customer added successfully!");</script>';
        echo '<a style="color: green;" href="add_customer.html"><h1>Click here to refresh</h1></a>';
    } else {
        echo "Error: " . $stmt->error;
    }
}


$stmt->close();
$conn->close();
?>




