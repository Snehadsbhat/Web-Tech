<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spice_stores";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$spice_id = '';
$name = '';
$price_per_unit = '';
$stock_quantity = '';


if (isset($_POST['fetch'])) {
    $spice_id = $_POST['spice_id'];
    $result = $conn->query("SELECT * FROM spice WHERE spice_id='$spice_id'");

    if ($result && $result->num_rows == 1) {
        $spice = $result->fetch_assoc();
        $name = $spice['name'];
        $price_per_unit = $spice['price_per_unit'];
        $stock_quantity = $spice['stock_quantity'];
    } else {
        echo "<script>alert('Spice not found.');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $spice_id = $_POST['spice_id'];
    $name = $_POST['name'];
    $price_per_unit = $_POST['price_per_unit'];
    $stock_quantity = $_POST['stock_quantity'];
   
    
    $sql = "UPDATE spice SET 
    name='$name', 
    price_per_unit='$price_per_unit', 
    stock_quantity='$stock_quantity' 
WHERE spice_id='$spice_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Spice updated successfully!'); window.location.href = 'view_spices.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 2em;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        label {
            font-size: 0.9em;
            color: #555;
        }
        input[type="text"], input[type="number"] {
            padding: 0.5em;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        button {
            padding: 0.7em;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #218838;
        }
        .cancel-link {
            margin-top: 1em;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }
        .cancel-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Spice by Spice ID</h2>
        
        <!-- Fetch details form -->
        <form method="POST">
            <label for="spice_id">Enter Spice ID:</label>
            <input type="number" name="spice_id" value="<?php echo htmlspecialchars($spice_id); ?>" required>
            <button type="submit" name="fetch">Fetch Details</button>
        </form>

        <!-- Update form (only visible if details are fetched) -->
        <?php if (!empty($name)): ?>
        <form method="POST">
            <input type="hidden" name="spice_id" value="<?php echo htmlspecialchars($spice_id); ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label for="price_per_unit">Price:</label>
            <input type="number" name="price_per_unit" value="<?php echo htmlspecialchars($price_per_unit); ?>" step="0.01" required>
            
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="text" name="stock_quantity" value="<?php echo htmlspecialchars($stock_quantity); ?>" required>
            
            <button type="submit" name="update">Update Spice</button>
        </form>
        <?php endif; ?>

        <a href="view_spices.php" class="cancel-link">Cancel</a>
    </div>
</body>
</html>
