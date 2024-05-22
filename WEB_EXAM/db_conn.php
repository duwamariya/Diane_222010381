<?php
// Connection details
$servername = "localhost";
$username = "Benitha";
$password = "Benitha";
$dbname = "virtual_retirement_planning_platform";

// Create the connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
