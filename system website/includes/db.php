<?php
/**
 * Website Database Configuration
 * Shared database connection for website pages
 */

if (!isset($conn)) {
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "gym_management";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }
}
?>
