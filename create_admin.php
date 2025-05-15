<?php
// Your database connection
include('db.php'); // Ensure this file contains your database connection settings

// Password to hash
$password = '18062004'; // This is the password for the admin user

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hashes the password

// Prepare the SQL query to insert the admin user into the database
$sql = "INSERT INTO users (username, password, role) VALUES ('admin', :password, 'admin')";

// Prepare the statement
$stmt = $pdo->prepare($sql);

// Bind the hashed password and execute the query
$stmt->execute(['password' => $hashedPassword]);

echo "Admin user created successfully!";
?>
