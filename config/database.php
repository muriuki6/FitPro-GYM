<?php
$host = "sql312.infinityfree.com";
$username = "if0_42286109";
$password = "Muriuki6"; // default for XAMPP
$dbname = "gym_management"; // your local database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>