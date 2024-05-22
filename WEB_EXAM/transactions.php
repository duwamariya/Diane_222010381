<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        /* Global styles for links */
        a {
            padding: 4px;
            color: white;
            background-color: pink;
            text-decoration: none;
            margin-right: 4px;
        }

        a:visited {
            color: purple;
        }

        a:link {
            color: brown;
        }

        a:hover {
            background-color: yellow;
        }

        a:active {
            background-color: red;
        }

        /* Styles for search button and input */
        button.btn {
            margin-left: 10px;
            margin-top: 6px;
            background-color: blue;
            border: none;
        }

        input.form-control {
            width: 150px; /* Adjust width as needed */
            padding: 8px;
        }

        /* Styles for table */
        table {
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<header>
 <body bgcolor="skyblue">
    <!-- Navigation Menu -->
    <ul style="list-style-type: none; padding: 0;">
        <li style="display: inline;"><a href="./home.html">HOME</a></li>
        <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
        <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./users.php">users</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./analytics.php">analytics</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./resources.php">resources</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./workshops.php">workshops</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./transactions.php">transactions</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./sessions.php">sessions</a>
    <li style="display: inline; margin-right: 10px;"><a href="./notifications.php">notifications</a>
  </li>

    <li style="display: inline; margin-right: 10px;"><a href="./instructors.php">instructors</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./feedback.php">feedback</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./attendees.php">attendees</a>
  </li>
        <li class="dropdown" style="display: inline; margin-right: 10px;">
            <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 10px;">Settings</a>
            <div class="dropdown-contents">
                <!-- Dropdown Links -->
                <a href="login.html">Login</a>
                <a href="register.html">Register</a>
                <a href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</header>
<section>
    <h1><u>transactions Form</u></h1>
    <form method="post">
        <label for="Transaction_ID">Transaction_ID:</label>
        <input type="number" id="Transaction_ID" name="Transaction_ID"><br><br>
         <label for="User_ID">User_ID:</label>
        <input type="number" id="User_ID" name="User_ID"><br><br>
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" id="Workshop_ID" name="Workshop_ID" required><br><br>
        <label for="Amount">Amount:</label>
        <input type="decimal" id="Amount" name="Amount" required><br><br>
        <label for="Payment_Method">Payment_Method:</label>
        <input type="text" id="Payment_Method" name="Payment_Method" required><br><br>
        <label for="Transaction_Date">Transaction_Date:</label>
        <input type="date" id="Transaction_Date" name="Transaction_Date" required><br><br>
         
       <input type="submit" name="add" value="Insert"><br><br>
    </form>
<?php
// Connection details
include('db_conn.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $connection->prepare("INSERT INTO transactions(Transaction_ID, User_ID, Workshop_ID, Amount, Payment_Method, Transaction_Date) VALUES (?, ?, ?, ?, ?, ?)"); 
    $stmt->bind_param("isssss", $Transaction_ID, $User_ID, $Workshop_ID, $Amount, $Payment_Method, $Transaction_Date);

    // Set parameters
    $Transaction_ID = $_POST['Transaction_ID']; // Corrected variable name
    $User_ID = $_POST['User_ID'];    
    $Workshop_ID = $_POST['Workshop_ID']; // Corrected variable name
    $Amount = $_POST['Amount'];
    $Payment_Method = $_POST['Payment_Method'];
    $Transaction_Date = $_POST['Transaction_Date'];
   
    // Execute the statement

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// SQL query to fetch data from the users table
$sql = "SELECT * FROM transactions";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of transactions</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            border: 5px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><form action="search_users" method="GET"><input type="text" name="query" placeholder="search here">
    <button>search</button></form><h2>Table of transactions</h2></center>
    <table border="5">
        <tr>
            <th>Transaction_ID</th>
            <th>User_ID</th>
            <th>Workshop_ID</th>
            <th>Amount</th>
            <th>Payment_Method</th>
            <th>Transaction_Date</th>

            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Check if there are any users
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $Transaction_ID = $row['Transaction_ID']; // Corrected variable name
                echo "<tr>
                    <td>" . $row['Transaction_ID'] . "</td>
                    <td>" . $row['User_ID'] . "</td>
                    <td>" . $row['Workshop_ID'] . "</td>
                    <td>" . $row['Amount'] . "</td>
                    <td>" . $row['Payment_Method'] . "</td>
                    <td>" . $row['Transaction_Date'] . "</td>
                    
                     <td><a style='padding:4px' href='delete_transactions.php?Transaction_ID=$Transaction_ID'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_transactions.php?Transaction_ID=$Transaction_ID'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
    <br>
    </center>
<center>
<button style="background-color: green; width: 150px;height: 40px;" ><a href="home.html" style=" font-size: 15px;color: skyblue;text-decoration: none" >Back Home</a></button>
</center>
</body>
</html>
  <footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designed by: @Diane UWAMARIYA_222010381</h2></b>
  </center>
</footer>
