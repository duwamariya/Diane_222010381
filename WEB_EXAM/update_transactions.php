<?php
// Connection details
include('db_conn.php');

// Check if analytics is set
if(isset($_REQUEST['Transaction_ID'])) {
    $Transaction_ID = $_REQUEST['Transaction_ID'];
    
    // Prepare and execute SELECT statement to retrieve departments details
    $stmt = $connection->prepare("SELECT * FROM transactions WHERE Transaction_ID = ?");
    $stmt->bind_param("i", $Transaction_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Transaction_ID'];
        $z = $row['User_ID'];
        $z = $row['Workshop_ID'];
         $y = $row['Amount'];
        $y = $row['Payment_Method'];
        $y = $row['Transaction_Date'];
       
    } else {
        echo "transactions not found.";
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
        <label for="Transaction_ID">Transaction_ID:</label>
        <input type="number" name="Transaction_ID" value="<?php echo isset($x) ? $x : ''; ?>">
        <br><br>  
         <label for="User_ID">User_ID:</label>
        <input type="number" name="User_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" name="Workshop_ID" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="Amount">Amount:</label>
        <input type="number" name="Amount" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <label for="Payment_Method">Payment_Method:</label>
        <input type="text" name="Payment_Method" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="Transaction_Date">Transaction_Date:</label>
        <input type="date" name="Transaction_Date" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        
       <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Transaction_ID = $_POST['Transaction_ID'];
    $User_ID = $_POST['User_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $Amount = $_POST['Amount'];
    $Payment_Method = $_POST['Payment_Method'];
    $Transaction_Date = $_POST['Transaction_Date'];
    
    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE transactions SET User_ID=?, Workshop_ID=?, Amount=?, Payment_Method=?, Transaction_Date=? WHERE Transaction_ID=?");
    $stmt->bind_param("ssssss",$User_ID, $Workshop_ID,  $Amount, $Payment_Method, $Transaction_Date, $Transaction_ID);
    
    if ($stmt->execute()) {
        // Redirect to attendees.php after successful update
        header('Location: transactions.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating transactions: " . $stmt->error;
    }
}
?>
