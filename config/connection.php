<?php
// connection.php

$host = 'localhost';  // Your database host
$dbname = 'faculty_system';  // Your database name
$username = 'root';  // Your database username (default for XAMPP is 'root')
$password = '';  // Your database password (default for XAMPP is an empty string)

try {
    // Create a PDO instance and assign it to $pdo
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Catch any errors and display an error message
    die("Connection failed: " . $e->getMessage());
}
?>
