<?php

/**
 * Database connection parameters.
 *
 * @var string $servername The database server name.
 * @var string $username   The database username.
 * @var string $password   The database password.
 * @var string $database   The database name.
 */
$servername = "localhost";
$username = "root";
$password = "";
$database = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // Handle connection error
    die("Connection failed: " . $conn->connect_error);
}

// Get all table names
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result === false) {
    // Handle error if fetching tables fails
    die("Error fetching tables: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Optimize each table
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $tablename) {
            $optimize_sql = "OPTIMIZE TABLE `$tablename`";
            $optimize_result = $conn->query($optimize_sql);
            if ($optimize_result === false) {
                // Handle error if optimizing table fails
                echo "Error optimizing table `$tablename`: " . $conn->error . "<br>";
            } else {
                // Output success message if table is optimized successfully
                echo "Table `$tablename` optimized successfully<br>";
            }
        }
    }
} else {
    // Output message if no tables are found
    echo "No tables found";
}

// Close connection
$conn->close();
