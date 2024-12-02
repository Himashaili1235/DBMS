<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ReceiverId'])) {
    header("Location: ReceiverLogin.php");
    exit();
}

// Handle logout if the user clicks the logout link
if (isset($_GET['logout'])) {
    // Destroy the session to log out the user
    session_destroy();
    // Redirect to the main page
    header("Location: main.php");
    exit();
}

// Database connection
$servername = "localhost";  // Change if your database server is not localhost
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (empty if no password)
$dbname = "vitaflow";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of donors and their blood groups
$sql = "SELECT Donor.DonorId, Donor.DonorName, BloodGroup.BloodType, BloodGroup.BloodGroupId 
        FROM Donor 
        INNER JOIN BloodGroup ON Donor.BloodGroupId = BloodGroup.BloodGroupId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Receiver - View Donors</title>
    <style>
        /* Basic styling for the table and buttons */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .dropdown {
            float: right;
            margin-top: 20px;
        }

        .dropdown button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 10px;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Donors</h2>

    <!-- Dropdown Menu for Logout -->
    <div class="dropdown">
        <button>Logout</button>
        <div class="dropdown-content">
            <!-- The logout link with the query parameter `logout` -->
            <a href="ReceiverData.php?logout=true">Logout</a>
        </div>
    </div>

    <!-- Donors Table -->
    <table>
        <thead>
            <tr>
                <th>Donor Name</th>
                <th>Blood Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output each donor's details
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['DonorName'] . "</td>
                            <td>" . $row['BloodType'] . "</td>
                            <td>
                                <form method='GET' action='ReceiverRequest.php'>
                                    <input type='hidden' name='donorId' value='" . $row['DonorId'] . "'>
                                    <input type='hidden' name='bloodGroupId' value='" . $row['BloodGroupId'] . "'>
                                    <button type='submit'>Request Blood</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No donors available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the connection at the end of the script
$conn->close();
?>
