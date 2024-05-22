<?php
// Connection details
include('db_conn.php');

// Check if Resource_ID is set
if(isset($_REQUEST['Resource_ID'])) {
    $Resource_ID = $_REQUEST['Resource_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM resources WHERE Resource_ID = ?");
    $stmt->bind_param("i", $Resource_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Resource_ID'];
        $z = $row['Workshop_ID'];
        $z = $row['Title'];
        $y = $row['Description'];
        $y = $row['Type'];
       
    } else {
        echo "resources not found.";
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
        <label for="Resource_ID">Resource_ID:</label>
        <input type="number" name="Resource_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="Title">Title:</label>
        <input type="text" name="Title" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        
        <label for="Description">Description:</label>
        <input type="text" name="Description" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Type">Type:</label>
        <input type="text" name="Type" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
       
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Resource_ID = $_POST['Resource_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $Type = $_POST['Type'];

    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE resources SET Workshop_ID=?, Title=?, Description=?, Type=? WHERE Resource_ID=?");
    $stmt->bind_param("sssss", $Workshop_ID, $Title, $Description, $Type, $Resource_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: resources.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating resources: " . $stmt->error;
    }
}
?>
