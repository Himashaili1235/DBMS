<?php
// Define the base URL for your site (adjust it accordingly)
$baseUrl = "/Vitaflow"; // Adjust to your actual local project path

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
    $receiverName = $_POST['receiverName'];
    $bloodGroupId = $_POST['bloodGroupId'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];  // Get the password from the form

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Basic form validation
    if (!empty($receiverName) && !empty($bloodGroupId) && !empty($age) && !empty($email) && !empty($phone)) {
        // Insert data into the database with hashed password
        $sql = "INSERT INTO Receiver (ReceiverName, BloodGroupId, Age, Email, Phone, Password)
                VALUES ('$receiverName', '$bloodGroupId', '$age', '$email', '$phone', '$hashedPassword')";

        // Check if the insertion is successful
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New receiver registered successfully!'); window.location.href = '".$baseUrl."/ReceiverData.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Please fill out all required fields.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Receiver Registration</title>
    <style>
        /* Apply background image dynamically using PHP */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url("<?php echo $baseUrl; ?>/images/banner1.jpg");
            background-size: cover;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form container style */
        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"],
        input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 48%;
            margin-right: 4%;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #45a049;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Receiver Registration Form</h2>

    <!-- Receiver Registration Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <!-- Receiver Name -->
        <label for="receiverName">Receiver Name:</label>
        <input type="text" id="receiverName" name="receiverName" required>
        <br><br>

        <!-- Blood Group Selection -->
        <label for="bloodGroupId">Blood Group:</label>
        <select name="bloodGroupId" id="bloodGroupId" required>
            <option value="">Select Blood Group</option>
            <?php
            // Fetch blood group options from the database
            $sql = "SELECT BloodGroupId, BloodType FROM BloodGroup";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Populate dropdown with blood group values
                    echo "<option value='" . $row["BloodGroupId"] . "'>" . $row["BloodType"] . "</option>";
                }
            } else {
                echo "<option value=''>No blood groups available</option>";
            }
            ?>
        </select>
        <br><br>

        <!-- Age -->
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <!-- Phone Number -->
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" pattern="^\(\d{3}\)\s\d{3}-\d{4}$" required 
               placeholder="(123) 456-7890">
        <small>Format: (123) 456-7890</small>
        <br><br>

        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <!-- Form Action Buttons -->
        <div class="form-actions">
            <input type="submit" value="Submit" onclick="window.location.href='<?php echo $baseUrl; ?>/main.php';">>
            <input type="button" value="Cancel" onclick="window.location.href='<?php echo $baseUrl; ?>/main.php';">
        </div>
    </form>
</div>

</body>
</html>

<?php
// Close the connection at the end of the script
$conn->close();
?>
