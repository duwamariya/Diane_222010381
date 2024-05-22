<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['User_id'])) {
    $User_id = $_REQUEST['User_id'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM users WHERE User_id = ?");
    $stmt->bind_param("i", $User_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['User_id'];
        $z = $row['Password'];
        $z = $row['Email'];
        $y = $row['Fullname'];
        $y = $row['Gender'];
        $y = $row['PhoneNumber'];
        $y = $row['RegistrationDate'];

    } else {
        echo "users not found.";
    }
}

?>

<html>
<head><title></title>
<!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script></head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="User_id">User_id:</label>
        <input type="number" name="User_id" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>  
        <label for="Password">Password:</label>
        <input type="text" name="Password" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="Email">Email:</label>
        <input type="text" name="Email" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Fullname">Fullname:</label>
        <input type="text" name="Fullname" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Gender">Gender:</label><br>
         <select type="text" name="Gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
           </select><br><br>
        <label for="PhoneNumber">PhoneNumber:</label>
        <input type="number" name="PhoneNumber" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="RegistrationDate">RegistrationDate:</label>
        <input type="date" name="RegistrationDate" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $User_id = $_POST['User_id'];
    $Password = $_POST['Password'];
    $Email = $_POST['Email'];
    $Fullname = $_POST['Fullname'];
    $Gender = $_POST['Gender'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $RegistrationDate = $_POST['RegistrationDate'];
   

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE users SET Password=?, Email=?, Fullname=?, Gender=?, PhoneNumber=?, RegistrationDate=? WHERE User_id=?");
    $stmt->bind_param("sssssss", $Password, $Email, $Fullname, $Address, $PhoneNumber, $RegistrationDate, $User_id);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: users.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating users: " . $stmt->error;
    }
}
?>
