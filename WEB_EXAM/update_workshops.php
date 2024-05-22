<?php
// Connection details
include('db_conn.php');

// Check if Workshop_ID is set
if(isset($_REQUEST['Workshop_ID'])) {
    $Workshop_ID = $_REQUEST['Workshop_ID'];
    
    // Prepare and execute SELECT statement to retrieve workshop details
    $stmt = $connection->prepare("SELECT * FROM workshops WHERE Workshop_ID = ?");
    $stmt->bind_param("i", $Workshop_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Workshop_ID = $row['Workshop_ID'];
        $Title = $row['Title'];
        $Description = $row['Description'];
        $Start_Date = $row['Start_Date'];
        $End_Date = $row['End_Date'];
        $Duration = $row['Duration'];
        $Instructor_ID = $row['Instructor_ID'];
        $Maximum_Capacity = $row['Maximum_Capacity'];
    } else {
        echo "Workshop not found.";
    }
}

?>

<html>
<head>
    <title>Edit Workshop</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Workshop_ID">Workshop ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($Workshop_ID) ? $Workshop_ID : ''; ?>">
        <br><br>
        <label for="Title">Title:</label>
        <input type="text" name="Title" value="<?php echo isset($Title) ? $Title : ''; ?>">
        <br><br>
        <label for="Description">Description:</label>
        <input type="text" name="Description" value="<?php echo isset($Description) ? $Description : ''; ?>">
        <br><br>
        <label for="Start_Date">Start Date:</label>
        <input type="date" name="Start_Date" value="<?php echo isset($Start_Date) ? $Start_Date : ''; ?>">
        <br><br>
        <label for="End_Date">End Date:</label>
        <input type="date" name="End_Date" value="<?php echo isset($End_Date) ? $End_Date : ''; ?>">
        <br><br>
        <label for="Duration">Duration:</label>
        <input type="number" name="Duration" value="<?php echo isset($Duration) ? $Duration : ''; ?>">
        <br><br>
        <label for="Instructor_ID">Instructor ID:</label>
        <input type="number" name="Instructor_ID" value="<?php echo isset($Instructor_ID) ? $Instructor_ID : ''; ?>">
        <br><br>
        <label for="Maximum_Capacity">Maximum Capacity:</label>
        <input type="number" name="Maximum_Capacity" value="<?php echo isset($Maximum_Capacity) ? $Maximum_Capacity : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Workshop_ID = $_POST['Workshop_ID'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $Start_Date = $_POST['Start_Date'];
    $End_Date = $_POST['End_Date'];
    $Duration = $_POST['Duration'];
    $Instructor_ID = $_POST['Instructor_ID'];
    $Maximum_Capacity = $_POST['Maximum_Capacity'];

    // Update the workshop in the database
    $stmt = $connection->prepare("UPDATE workshops SET Title=?, Description=?, Start_Date=?, End_Date=?, Duration=?, Instructor_ID=?, Maximum_Capacity=? WHERE Workshop_ID=?");
    $stmt->bind_param("sssssssi", $Title, $Description, $Start_Date, $End_Date, $Duration, $Instructor_ID, $Maximum_Capacity, $Workshop_ID);
    
    if ($stmt->execute()) {
        // Redirect to workshops.php after successful update
        header('Location: workshops.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating workshop: " . $stmt->error;
    }
}
?>
