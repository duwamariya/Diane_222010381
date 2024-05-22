<?php
// Connection details
include('db_conn.php');

// Check if Workshop_ID is set
if(isset($_REQUEST['Workshop_ID'])) {
    $Workshop_ID = $_REQUEST['Workshop_ID'];
    
    // First, delete related records in the attendees table
    $stmt_attendees = $connection->prepare("DELETE FROM attendees WHERE Workshop_ID=?");
    $stmt_attendees->bind_param("i", $Workshop_ID);
    $stmt_attendees->execute();
    $stmt_attendees->close();
    
    // Prepare and execute the DELETE statement for the workshop
    $stmt = $connection->prepare("DELETE FROM workshops WHERE Workshop_ID=?");
    $stmt->bind_param("i", $Workshop_ID);
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            // Redirect to workshops.php after successful deletion
            header('location: workshops.php?msg=Data deleted successfully');
            exit(); // Ensure that no other content is sent after the header redirection
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="Workshop_ID" value="<?php echo $Workshop_ID; ?>">
        <input type="submit" value="Delete">
    </form>
</body>
</html>
<?php
    $stmt->close();
} else {
    echo "Workshop_ID is not set.";
}

$connection->close();
?>
