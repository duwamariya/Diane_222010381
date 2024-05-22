<?php
// Connection details
include('db_conn.php');

// Check if Analytics_ID is set
if(isset($_REQUEST['Analytics_ID'])) {
    $Analytics_ID = $_REQUEST['Analytics_ID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM analytics WHERE Analytics_ID=?");
    $stmt->bind_param("i", $Analytics_ID);
    
    
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
            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    if ($stmt->execute()) {
        // Redirect to departmentstable.php after successful deletion
        header('location: analytics.php?msg=Data deleted successfully');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error deleting data: " . $stmt->error;
    }

    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Analytics_ID is not set.";
}

$connection->close();
?>
