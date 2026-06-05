<?php
require_once 'config.php';

// Create connection without DB name to create it first
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read schema.sql
$sql = file_get_contents('schema.sql');

// Execute multi query
if ($conn->multi_query($sql)) {
    echo "Database and tables created successfully!";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
<br><br>
<a href="index.php">Go to Homepage</a>
