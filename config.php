<?php
// Database configuration
$host = "localhost";     // Hostname (usually 'localhost' for local development)
$username = "root";      // MySQL username
$password = "";          // MySQL password (leave empty if there's no password)
$dbname = "torrent_tracker"; // Database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
