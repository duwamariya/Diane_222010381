<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['Feedback_ID'])) {
    $Feedback_ID = $_REQUEST['Feedback_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM feedback WHERE Feedback_ID = ?");
    $stmt->bind_param("i", $Feedback_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Feedback_ID'];
        $z = $row['Workshop_ID'];
        $z = $row['User_ID'];
        $y = $row['Rating'];
        $y = $row['Comments'];
        $y = $row['Submission_Date'];
       
    } else {
        echo "feedback not found.";
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
        <label for="Feedback_ID">Feedback_ID:</label>
        <input type="number" name="Feedback_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>  
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="User_ID">User_ID:</label>
        <input type="number" name="User_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Rating">Rating:</label>
        <input type="number" name="Rating" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Comments">Comments:</label>
        <input type="text" name="Comments" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
         <label for="Submission_Date">Submission_Date:</label>
        <input type="date" name="Submission_Date" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Feedback_ID = $_POST['Feedback_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $User_ID = $_POST['User_ID'];
    $Rating = $_POST['Rating'];
    $Comments = $_POST['Comments'];
    $Submission_Date = $_POST['Submission_Date'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE feedback SET Workshop_ID=?, User_ID=?, Rating=?, Comments=?, Submission_Date=? WHERE Feedback_ID=?");
    $stmt->bind_param("ssssss", $Workshop_ID,  $User_ID, $Rating, $Comments,$Submission_Date, $Feedback_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: feedback.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating feedback: " . $stmt->error;
    }
}
?>
