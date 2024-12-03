<?php
// Start session to store login status
session_start();

// Database connection
$servername = "localhost";  // Adjust if using a different host
$username = "root";         // Adjust your DB username
$password = "";             // Adjust your DB password
$dbname = "vitaflow";       // Database name

// Initialize login error message
$errorMessage = "";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted, process the login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $adminName = $_POST['adminName'];
    $inputPassword = $_POST['password'];

    // Check if the adminName exists in the Admin table
    $sql = "SELECT AdminName, Password FROM Admin WHERE AdminName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminName); // Bind the adminName as a string
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching adminName is found
    if ($result->num_rows > 0) {
        // Fetch the stored password from the database
        $row = $result->fetch_assoc();
        $storedPassword = $row['Password'];

        // Verify if the entered password matches the stored hashed password
        if (password_verify($inputPassword, $storedPassword)) {
            // Start a session and store the AdminName
            $_SESSION['adminName'] = $adminName;
            // Redirect to AdminData.php page
            header("Location: AdminData.php");
            exit();
        } else {
            // If password does not match
            $errorMessage = "Invalid Password. Please try again.";
        }
    } else {
        // If no match, display an error message
        $errorMessage = "Invalid Admin Name. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        /* Your existing styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 100px auto;
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
        .form-group input {
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
    <h2>Admin Login</h2>
    
    <!-- Display error message if login failed -->
    <?php if (!empty($errorMessage)) { ?>
        <div class="form-group error">
            <p><?php echo $errorMessage; ?></p>
        </div>
    <?php } ?>

    <!-- Admin Login Form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="adminName">Admin Name</label>
            <input type="text" id="adminName" name="adminName" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit">Login</button>
        </div>
    </form>
</div>

</body>
</html>
