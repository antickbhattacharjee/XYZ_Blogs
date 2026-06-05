<?php
require_once 'config.php';

try {
    // Connect without dbname first if we want to create DB, but PostgreSQL makes DB creation tricky via script if connected to another DB.
    // Usually in PostgreSQL, you connect to 'postgres' default DB to create a new one.
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=postgres";
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist (Postgres doesn't support IF NOT EXISTS for CREATE DATABASE)
    // So we check if it exists first
    $stmt = $conn->query("SELECT 1 FROM pg_database WHERE datname = '" . DB_NAME . "'");
    if (!$stmt->fetch()) {
        $conn->exec("CREATE DATABASE " . DB_NAME);
        echo "Database created successfully!<br>";
    }

    // Now connect to the actual database to create tables
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('schema.sql');
    
    // Execute schema
    $conn->exec($sql);
    echo "Tables created successfully!";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
<br><br>
<a href="index.php">Go to Homepage</a>
