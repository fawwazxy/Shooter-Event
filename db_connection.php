<?php
$host = 'localhost';  // Database host
$dbname = 'shooter_event';  // Database name
$user = 'root';  // Database username
$pass = '';  // Database password
$charset = 'utf8mb4'; // Specify charset to avoid encoding issues

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionally set default fetch mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Uncomment for debugging in development environment
    // echo "Database connection successful.<br>"; 
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    echo "An error occurred while connecting to the database. Please try again later.";
    exit();
}
?>
