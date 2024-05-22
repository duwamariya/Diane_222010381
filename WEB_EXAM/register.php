<?php
include('db_conn.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $User_id = $_POST["User_id"];
    $Password = $_POST["Password"];
    $Email = $_POST["Email"];
    $Fullname = $_POST["Fullname"];
    $Gender = $_POST["Gender"];
    $Phonenumber = $_POST["Phonenumber"];
    $RegistrationDate = $_POST["RegistrationDate"];
   
     // Preparing SQL query with placeholders to prevent SQL injection
    $sql = "INSERT INTO users (User_id, Password, Email, Fullname, Gender, Phonenumber, RegistrationDate) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparing and binding parameters
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssss", $User_id, $Password, $Email, $Fullname, $Gender, $Phonenumber, $RegistrationDate);

    // // Executing SQL query
    if ($stmt->execute()) {
        // Redirecting to login page on successful registration
        header("Location: login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $stmt->error;
    }

    // Closing statement
    $stmt->close();
}

// Closing database connection
$conn->close();
?>


  <footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designed by: @Diane UWAMARIYA_222010381</h2></b>
  </center>
</footer>

