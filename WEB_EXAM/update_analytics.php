<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['Analytics_ID'])) {
    $Analytics_ID = $_REQUEST['Analytics_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM analytics WHERE Analytics_ID = ?");
    $stmt->bind_param("i", $Analytics_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Analytics_ID'];
        $z = $row['Workshop_ID'];
         $z = $row['Session_ID'];
        $z = $row['User_ID'];
        $y = $row['Attendance_Count'];
        $y = $row['Feedback_Analysis'];
        $y = $row['Report_Date'];

    } else {
        echo "analytics not found.";
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
        <label for="Analytics_ID">Analytics_ID:</label>
        <input type="number" name="Analytics_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>  
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

       <label for="Session_ID">Session_ID:</label>
        <input type="number" name="Session_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="User_ID">User_ID:</label>
        <input type="number" name="User_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Attendance_Count">Attendance_Count:</label>
        <input type="number" name="Attendance_Count" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Feedback_Analysis">Feedback_Analysis:</label>
        <input type="number" name="Feedback_Analysis" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
         <label for="Report_Date">Report_Date:</label>
        <input type="date" name="Report_Date" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Analytics_ID = $_POST['Analytics_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $Session_ID = $_POST['Session_ID'];
    $User_ID = $_POST['User_ID'];
    $Attendance_Count = $_POST['Attendance_Count'];
    $Feedback_Analysis = $_POST['Feedback_Analysis'];
    $Report_Date = $_POST['Report_Date'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE analytics SET Workshop_ID=?, Session_ID=?, User_ID=?, Attendance_Count=?, Feedback_Analysis=?, Report_Date=? WHERE Analytics_ID=?");
    $stmt->bind_param("sssssss", $Workshop_ID, $Session_ID, $User_ID, $Attendance_Count, $Feedback_Analysis,$Report_Date, $Analytics_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: analytics.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating analytics: " . $stmt->error;
    }
}
?>
