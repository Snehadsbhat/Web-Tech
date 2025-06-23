<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "spice_stores";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$resultData = '';
$queryResult = '';



    if (isset($_POST['sql_query'])) {
        $sql_query = trim($_POST['sql_query']); 

        if (!empty($sql_query)) {
            if (stripos($sql_query, 'SELECT') === 0) {
              
                $queryResult = $conn->query($sql_query);
                if ($queryResult) {
                    if ($queryResult->num_rows > 0) {
                        $resultData = "Query executed successfully. Rows fetched: " . $queryResult->num_rows;
                    } else {
                        $resultData = "No results found.";
                    }
                } else {
                    $resultData = "Error: " . $conn->error;
                }
            } else {
               
                if ($conn->query($sql_query) === TRUE) {
                    $resultData = "Query executed successfully.";
                } else {
                    $resultData = "Error: " . $conn->error;
                }
            }
        } else {
            $resultData = "Please enter a SQL query.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Query Executor</title>
    <style>
        body {
            background-color: lightgreen;
            font-family: Arial, sans-serif;
            margin: 50px auto;
            max-width: 900px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 80%;
            padding: 10px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd; /* Adds vertical and horizontal lines */
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Check your query!</h1>

    <h2><?= htmlspecialchars($actionMessage ?? "Enter your SQL Query") ?></h2>
    <form method="POST">
        <textarea name="sql_query" rows="5" cols="60" placeholder="Enter your SQL query here..."></textarea><br>
        <input type="submit" value="Run Query">
    </form>

    <div class="result-msg <?= empty($resultData) ? '' : ($queryResult ? 'success' : 'error') ?>">
        <?= htmlspecialchars($resultData) ?>
    </div>

    <?php if ($queryResult && $queryResult->num_rows > 0): ?>
        <h2>Query Results</h2>
        <table>
            <tr>
                <?php while ($field = $queryResult->fetch_field()): ?>
                    <th><?= htmlspecialchars($field->name) ?></th>
                <?php endwhile; ?>
            </tr>
            <?php while ($row = $queryResult->fetch_assoc()): ?>
            <tr>
                <?php foreach ($row as $value): ?>
                    <td><?= htmlspecialchars($value) ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
