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
        <label for="Attendance_ID">Attendance_ID:</label>
        <input type="number" name="Attendance_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="User_ID">User_ID:</label>
        <input type="number" name="User_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Attendance_Status">Attendance_Status:</label>
        <input type="text" name="Attendance_Status" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Attendance_Date">Attendance_Date:</label>
        <input type="date" name="Attendance_Date" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Attendance_ID = $_POST['Attendance_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $User_ID = $_POST['User_ID'];
    $Attendance_Status = $_POST['Attendance_Status'];
    $Attendance_Date = $_POST['Attendance_Date'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE attendees SET Workshop_ID=?, User_ID=?, Attendance_Status=?, Attendance_Date=? WHERE Attendance_ID=?");
    $stmt->bind_param("sssss", $Workshop_ID, $User_ID, $Attendance_Status, $Attendance_Date, $Attendance_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: attendees.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating attendees: " . $stmt->error;
    }
}
?>
