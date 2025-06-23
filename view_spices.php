<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch spices from database
$result = $conn->query("SELECT * FROM spice");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Added Spices</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Added Spices</h2>
<div>
    <table>
        <tr>
            <th>Spice ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
          
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['spice_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['price_per_unit'] . "</td>
                        <td>" . $row['stock_quantity'] . "</td>
                       
                        <td>
                            <a href='edit_spice.php?edit_id=" . $row['spice_id'] . "' onclick='return confirm(\"Do you want to edit this spice?\");'>Edit</a>
                        </td>
                        <td>
                            <a href='add_spice_action.php?delete_id=" . $row['spice_id'] . "' onclick='return confirm(\"Are you sure you want to delete this spice?\");'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No spices found</td></tr>";
        }
        ?>
    </table>
</div>
<br>
<h2><a href="add_spice.html">Back to Add Spice</a></h2>

</body>
</html>

<?php
$conn->close();
?>
