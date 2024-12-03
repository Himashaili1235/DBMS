<?php
// Start the session to track the logged-in donor
session_start();

// Check if the user is logged in
if (!isset($_SESSION['DonorId'])) {
    header("Location: DonorLogin.php");
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

// Fetch the logged-in donor's ID
$donorId = $_SESSION['DonorId'];

// SQL query to fetch blood request(s) for the logged-in donor
$sql = "SELECT 
            br.BloodRequestId, 
            br.ReceiverName, 
            br.ReceiverPhone, 
            br.DonorName, 
            bg.BloodType, 
            br.BloodGroupId, 
            br.ReceiverId
        FROM BloodRequest br
        INNER JOIN BloodGroup bg ON br.BloodGroupId = bg.BloodGroupId
        WHERE br.DonorId = '$donorId'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Donor - View Blood Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .request-table {
            width: 100%;
            border-collapse: collapse;
        }

        .request-table th, .request-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .request-table th {
            background-color: #4CAF50;
            color: white;
        }

        .request-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Dropdown Menu */
        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .dropdown a {
            padding: 10px;
            text-decoration: none;
            color: #333;
            display: block;
            background-color: #f4f4f4;
            border-radius: 4px;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .btn:hover .dropdown {
            display: block;
        }

        .menu {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            margin: 0 15px;
            text-decoration: none;
            font-size: 16px;
            color: #333;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }

        .menu a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<!-- Navigation Menu -->
<div class="menu">
    <a href="Profile.php">View Profile</a>
    <a href="DonorData.php">Blood Requests</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Blood Requests for You</h2>

    <?php
    // If there are no requests
    if ($result->num_rows == 0) {
        echo "<p>No blood requests found.</p>";
    } else {
        // Display blood requests in a table
        echo "<table class='request-table'>
                <tr>
                    <th>Receiver Name</th>
                    <th>Receiver Phone</th>
                    <th>Donor Name</th>
                    <th>Blood Type</th>
                    <th>Action</th>
                </tr>";

        // Fetch and display each blood request
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ReceiverName']}</td>
                    <td>{$row['ReceiverPhone']}</td>
                    <td>{$row['DonorName']}</td>
                    <td>{$row['BloodType']}</td>
                    <td>
                        <div class='btn'>
                            Respond
                            <div class='dropdown'>
                                <a href='respondRequest.php?response=accept&bloodRequestId={$row['BloodRequestId']}'>Accept</a>
                                <a href='respondRequest.php?response=decline&bloodRequestId={$row['BloodRequestId']}'>Decline</a>
                            </div>
                        </div>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>

</div>

</body>
</html>

<?php
// Close the connection at the end of the script
$conn->close();
?>
