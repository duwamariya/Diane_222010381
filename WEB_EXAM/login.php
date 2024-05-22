<?php
session_start(); // Start the session

include('db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $user_password = $_POST['password']; // Use a different variable name here

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email=?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($user_password, $row['password'])) { // Use the correct column name here
            $_SESSION['user_id'] = $row['id'];
            header("Location: home.html");
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "User not found";
    }
}

$connection->close();
?>
