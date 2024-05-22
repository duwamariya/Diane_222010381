<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['Notification_ID'])) {
    $Notification_ID = $_REQUEST['Notification_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM notifications WHERE Notification_ID = ?");
    $stmt->bind_param("i", $Notification_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Notification_ID'];
        $z = $row['User_ID'];
        $y = $row['Message'];
        $y = $row['Status'];
       
    } else {
        echo "notifications not found.";
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
        <label for="Notification_ID">Notification_ID:</label>
        <input type="number" name="Notification_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>  
        <label for="User_ID">User_ID:</label>
        <input type="number" name="User_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Message">Message:</label>
        <input type="text" name="Message" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Status">Status:</label>
        <input type="text" name="Status" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
         
      <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Notification_ID = $_POST['Notification_ID'];
    $User_ID = $_POST['User_ID'];
    $Message = $_POST['Message'];
    $Status = $_POST['Status'];
   

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE notifications SET User_ID=?, Message=?, Status=? WHERE Notification_ID=?");
    $stmt->bind_param("ssss", $User_ID, $Message, $Status, $Notification_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: notifications.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating notifications: " . $stmt->error;
    }
}
?>
