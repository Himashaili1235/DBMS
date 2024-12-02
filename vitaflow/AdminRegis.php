<?php
// Database connection
$host = 'localhost'; // Replace with your host
$username = 'root';  // Replace with your username
$password = '';      // Replace with your password
$dbname = 'vitaflow'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blood groups from the BloodGroup table
$query = "SELECT * FROM BloodGroup";
$result = $conn->query($query);

$bloodGroups = [];
if ($result->num_rows > 0) {
    // Fetch rows and store them in the $bloodGroups array
    while ($row = $result->fetch_assoc()) {
        $bloodGroups[] = $row;
    }
} else {
    $error_message = "No blood groups found in the database.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adminName']) && isset($_POST['bloodGroupId']) && isset($_POST['password']) && !empty($_POST['adminName']) && !empty($_POST['bloodGroupId']) && !empty($_POST['password'])) {
        $adminName = mysqli_real_escape_string($conn, $_POST['adminName']);
        $bloodGroupId = mysqli_real_escape_string($conn, $_POST['bloodGroupId']);
        $password = $_POST['password']; // Get password input
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        // Insert query
        $insertQuery = "INSERT INTO Admin (AdminName, BloodGroupId, Password) VALUES ('$adminName', '$bloodGroupId', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            $success_message = "Admin registered successfully.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $error_message = "All fields are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        /* Your existing styles */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .form-group .error {
            color: red;
            font-size: 0.9em;
            text-align: center;
        }
        .form-group p {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Registration</h2>

    <!-- Display success or error message -->
    <?php if (!empty($success_message)) { ?>
        <div class="form-group">
            <p style="color: green;"><?php echo $success_message; ?></p>
        </div>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <div class="form-group">
            <p style="color: red;"><?php echo $error_message; ?></p>
        </div>
    <?php } ?>

    <!-- Admin Registration Form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="adminName">Admin Name</label>
            <input type="text" id="adminName" name="adminName" required>
        </div>

        <div class="form-group">
            <label for="bloodGroupId">Blood Group</label>
            <select id="bloodGroupId" name="bloodGroupId" required>
                <option value="">Select Blood Group</option>
                <?php
                foreach ($bloodGroups as $group) {
                    echo "<option value='" . $group['BloodGroupId'] . "'>" . $group['BloodType'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit" name="register">Register Admin</button>
        </div>
    </form>
</div>

</body>
</html>
