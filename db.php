<?php
$host = 'localhost';
$dbname = 'voting_system';  // The database name
$username = 'root';  // Default MySQL username
$password = '';  // Default MySQL password (empty)

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    // Uncomment this line to confirm the connection is successful
    // echo "Connected successfully to the database!";
} catch (PDOException $e) {
    // If an error occurs, show a message
    echo "Connection failed: " . $e->getMessage();
}
?>
