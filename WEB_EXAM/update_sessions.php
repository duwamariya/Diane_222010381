<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['Session_ID'])) {
    $Session_ID = $_REQUEST['Session_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM sessions WHERE Session_ID = ?");
    $stmt->bind_param("i", $Sessions_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         $z = $row['Session_ID'];
         $z = $row['Workshop_ID'];
         $z = $row['Title'];
        $z = $row['Description'];
        $y = $row['Start_Time'];
        $y = $row['End_Time'];
        $y = $row['Location'];

    } else {
        echo "sessions not found.";
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
         <label for="Session_ID">Session_ID:</label>
        <input type="number" name="Session_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
         <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

       <label for="Title">Title:</label>
        <input type="text" name="Title" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="Description">Description:</label>
        <input type="text" name="Description" value="<?php echo isset($z) ? $z : ''; ?>">

        <br><br>
        
        <label for="Start_Time">Start_Time:</label>
        <input type="date" name="Start_Time" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="End_Time">End_Time:</label>
        <input type="date" name="End_Time" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
         <label for="Location">Location:</label>
        <input type="text" name="Location" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
   $Session_ID = $_POST['Session_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $Start_Time = $_POST['Start_Time'];
    $End_Time = $_POST['End_Time'];
    $Location = $_POST['Location'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE sessions SET  Workshop_ID=?, Title=?, Description=?, Start_Time=?, End_Time=?, Location=? WHERE Session_ID=?");
    $stmt->bind_param("sssssss",  $Workshop_ID, $Title, $Description, $Start_Time, $End_Time,$Location, $Session_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: sessions.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating sessions: " . $stmt->error;
    }
}
?>
