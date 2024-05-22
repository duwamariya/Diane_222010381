<?php
// Connection details
include('db_conn.php');

// Check if department_code is set
if(isset($_REQUEST['Attendance_ID'])) {
    $Attendance_ID = $_REQUEST['Attendance_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM attendees WHERE Attendance_ID = ?");
    $stmt->bind_param("i", $Attendance_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Attendance_ID'];
        $z = $row['Workshop_ID'];
        $z = $row['User_ID'];
        $y = $row['Attendance_Status'];
        $y = $row['Attendance_Date'];
       
    } else {
        echo "attendees not found.";
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
        <label for="Instructor_ID">Instructor_ID:</label>
        <input type="number" name="Instructor_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>
        <label for="First_Name">First_Name:</label>
        <input type="text" name="First_Name" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="Last_Name">Last_Name:</label>
        <input type="text" name="Last_Name" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Email">Email:</label>
        <input type="text" name="Email" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Expertise_Area">Expertise_Area:</label>
        <input type="text" name="Expertise_Area" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Instructor_ID = $_POST['Instructor_ID'];
    $First_Name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $Email = $_POST['Email'];
    $Expertise_Area = $_POST['Expertise_Area'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE instructors SET Expertise_Area=?, Email=?, Last_Name=?, First_Name=? WHERE Instructor_ID=?");
    $stmt->bind_param("sssss", $Expertise_Area, $Email, $Last_Name, $First_Name, $Instructor_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: instructors.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating instructors: " . $stmt->error;
    }
}
?>
