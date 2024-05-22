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
            padding: 8px;
            color: white;
            background-color: pink;
            text-decoration: none;
            margin-right: 7px;
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
            margin-left: 15px;
            margin-top: 4px;
            background-color: blue;
            border: none;
        }

        input.form-control {
            width: 200px; /* Adjust width as needed */
            padding: 8px;
        }

        /* Styles for table */
        table {
            width: 100%;
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
 <body bgcolor="pink">
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
            <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
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
    <h1><u>resources Form</u></h1>
    <form method="post">
        <label for="Resource_ID">Resource_ID:</label>
        <input type="number" id="Resource_ID" name="Resource_ID"><br><br>
        <label for="Workshop_ID">Workshop_ID:</label>
        <input type="number" id="Workshop_ID" name="Workshop_ID"><br><br>
        <label for="Title">Title:</label>
        <input type="text" id="Title" name="Title"><br><br>
        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description"><br><br>
        <label for="Type">Type:</label>
        <input type="text" id="Type" name="Type" required><br><br>
        
         
        <input type="submit" name="add" value="Insert"><br><br>
    </form>
<?php
// Connection details
include('db_conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $connection->prepare("INSERT INTO resources( Resource_ID, Workshop_ID, Title, Description, Type) VALUES (?, ?, ?, ?, ?)"); 
    $stmt->bind_param("issss", $Resource_ID, $Workshop_ID, $Title, $Description, $Type);

    // Set parameters
    $Resource_ID = $_POST['Resource_ID'];
    $Workshop_ID = $_POST['Workshop_ID'];
    $Title = $_POST['Title'];    
    $Description = $_POST['Description']; // Corrected variable name
    $Type = $_POST['Type'];
  
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
$sql = "SELECT * FROM resources";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of resources</title>
    <style>
        table {
            width: 100%;
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
    <center><form action="search_attendees" method="GET"><input type="text" name="query" placeholder="search here">
    <button>search</button></form><h2>Table of resources</h2></center>
    <table border="5">
        <tr>
            <th>Resources_ID</th>
            <th>Workshop_ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Type</th>
            
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Check if there are any users
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $Resource_ID = $row['Resource_ID']; // Corrected variable name
                echo "<tr>
                    <td>" . $row['Resource_ID'] . "</td>
                    <td>" . $row['Workshop_ID'] . "</td>
                    <td>" . $row['Title'] . "</td>
                    <td>" . $row['Description'] . "</td>
                    <td>" . $row['Type'] . "</td>
                    
                   
                     <td><a style='padding:4px' href='delete_resources.php?Resource_ID=$Resource_ID'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_resources.php?Resource_ID=$Resource_ID'>Update</a></td>
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

