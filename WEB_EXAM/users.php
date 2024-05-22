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
    <h1><u>users Form</u></h1>
    <form method="post">
        
         <label for="User_id">User_id:</label>
        <input type="number" id="User_id" name="User_id"><br><br>
        <label for="Password">Password:</label>
        <input type="text" id="Password" name="Password" required><br><br>
        <label for="Email">Email:</label>
        <input type="text" id="Email" name="Email" required><br><br>
        <label for="Fullname">Fullname:</label>
        <input type="text" id="Fullname" name="Fullname" required><br><br>
        <label for="Gender">Gender:</label><br>
        <select id="text" name="Gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
           </select><br><br>
          <label for="PhoneNumber">PhoneNumber:</label>
        <input type="number" id="PhoneNumber" name="PhoneNumber"><br><br>
         <label for="RegistrationDate">RegistrationDate:</label>
        <input type="date" id="RegistrationDate" name="RegistrationDate"><br><br>
         
       <input type="submit" name="add" value="Insert"><br><br>
    </form>
<?php
// Connection details
include('db_conn.php');

// Check if the form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $connection->prepare("INSERT INTO users(User_id, Password, Email, Fullname, Gender, PhoneNumber, RegistrationDate) VALUES (?, ?, ?, ?, ?, ?, ?)"); 
    $stmt->bind_param("issssss", $User_id, $Password, $Email, $Fullname, $Gender, $PhoneNumber, $RegistrationDate);

    // Set parameters
   $User_id = $_POST['User_id'];    
    $Password = $_POST['Password'];
    $Email = $_POST['Email'];
    $Fullname = $_POST['Fullname'];
    $Gender = $_POST['Gender'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $RegistrationDate = $_POST['RegistrationDate'];
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
$sql = "SELECT * FROM users";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of users</title>
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
    <center><form action="search_users" method="GET"><input type="text" name="query" placeholder="search here">
    <button>search</button></form><h2>Table of users</h2></center>
    <table border="5">
        <tr>
            <th>User_id</th>
            <th>Password</th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Gender</th>
            <th>PhoneNumber</th>
            <th>RegistrationDate</th>
           
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Check if there are any users
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $User_id = $row['User_id']; // Corrected variable name
                echo "<tr>
                    <td>" . $row['User_id'] . "</td>
                   <td>" . $row['Password'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['Fullname'] . "</td>
                    <td>" . $row['Gender'] . "</td>
                    <td>" . $row['PhoneNumber'] . "</td>
                     <td>" . $row['RegistrationDate'] . "</td>
                   
                    
                    
                      <td><a style='padding:4px' href='delete_users.php?User_id=$User_id'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_users.php?User_id=$User_id'>Update</a></td>
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
