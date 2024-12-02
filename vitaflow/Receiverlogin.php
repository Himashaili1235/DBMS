<?php
// Start the session to keep track of user login
session_start();

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

// Handle form submission (backend processing)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $receiverName = $_POST['ReceiverName'];
    $password = $_POST['Password'];

    // Basic form validation
    if (!empty($receiverName) && !empty($password)) {
        // SQL query to get the receiver record by ReceiverName
        $sql = "SELECT * FROM Receiver WHERE ReceiverName = '$receiverName'";
        $result = $conn->query($sql);

        // If a matching receiver is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Compare the provided password with the hashed password from the database
            if (password_verify($password, $row['Password'])) {
                // Password is correct, store receiver's ID in session and redirect
                $_SESSION['ReceiverId'] = $row['ReceiverId']; // Store ReceiverId in session
                header("Location: ReceiverData.php"); // Redirect to ReceiverData.php
                exit();
            } else {
                // Error message for invalid password
                $error = "Invalid Receiver Name or Password!";
            }
        } else {
            // Error message if no matching ReceiverName is found
            $error = "Invalid Receiver Name or Password!";
        }
    } else {
        $error = "Please fill in both fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Receiver Login - VitaFlow</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Receiver Login</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Login form -->
    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="input-group">
            <label for="ReceiverName">Receiver User Name</label>
            <input type="text" name="ReceiverName" id="ReceiverName" required>
        </div>
        <div class="input-group">
            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>

    <p style="text-align: center; margin-top: 10px;">Don't have an account? <a href="ReceiverRegis.php">Sign Up</a></p>
</div>

</body>
</html>

<?php
// Close the connection at the end of the script
$conn->close();
?>
