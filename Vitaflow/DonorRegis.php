<?php
// Database connection (adjust your database credentials)
$servername = "localhost";  // Adjust if using a different host
$username = "root";         // Adjust your DB username
$password = "";             // Adjust your DB password
$dbname = "vitaflow";       // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted, process the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $donorName = $_POST['donorName'];
    $bloodGroupId = $_POST['bloodGroup'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];  // Get the password from the form

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a new DonorId (this can be adjusted based on your preferred logic)
    $donorId = uniqid('D_'); // For example, use a unique ID with prefix "D_"

    // Clean the phone number (remove non-numeric characters)
    $phone = preg_replace('/\D/', '', $phone);

    // Check if the phone number has the correct length (e.g., 10 digits)
    if (strlen($phone) !== 10) {
        echo "<p>Error: Phone number should contain exactly 10 digits.</p>";
        exit;
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Donor (DonorId, DonorName, BloodGroupId, Age, Email, Phone, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $donorId, $donorName, $bloodGroupId, $age, $email, $phone, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New receiver registered successfully!'); window.location.href = 'Profile.php';</script>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Get available blood groups for the dropdown
$bloodGroups = [];
$sql = "SELECT BloodGroupId, BloodType FROM BloodGroup";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bloodGroups[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Donor Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        /* Ensure body and html take full height */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Center the form container in the middle of the page */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Apply Flexbox to center the form */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Take up the full height */
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
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
        }
    </style>
</head>
<body>

<!-- Flexbox container to center the form -->
<div class="form-wrapper">
    <div class="container">
        <h2>Donor Registration Form</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="donorName">Donor Name</label>
                <input type="text" id="donorName" name="donorName" required>
            </div>

            <div class="form-group">
                <label for="bloodGroup">Blood Group</label>
                <select id="bloodGroup" name="bloodGroup" required>
                    <option value="">Select Blood Group</option>
                    <?php
                    foreach ($bloodGroups as $group) {
                        echo "<option value='" . $group['BloodGroupId'] . "'>" . $group['BloodType'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" pattern="^\(\d{3}\)\s\d{3}-\d{4}$" required placeholder="(123) 456-7890">
                <small>Format: (123) 456-7890</small>
            </div>

            <!-- New Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Register Donor</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>