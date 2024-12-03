<?php
// Start the session to track the logged-in receiver
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ReceiverId'])) {
    header("Location: ReceiverLogin.php");
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

// Fetch donor details from the URL parameter
if (isset($_GET['donorId']) && isset($_GET['bloodGroupId'])) {
    $donorId = $_GET['donorId'];
    $bloodGroupId = $_GET['bloodGroupId'];

    // Fetch donor details based on the donorId
    $sql = "SELECT DonorId, DonorName, BloodGroup.BloodType, BloodGroup.BloodGroupId 
            FROM Donor 
            INNER JOIN BloodGroup ON Donor.BloodGroupId = BloodGroup.BloodGroupId 
            WHERE Donor.DonorId = '$donorId' AND BloodGroup.BloodGroupId = '$bloodGroupId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $donor = $result->fetch_assoc();
    } else {
        echo "No donor found.";
        exit();
    }
}

// Handle form submission for requesting blood
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiverId = $_SESSION['ReceiverId'];
    $donorId = $_POST['donorId'];
    $receiverName = $_POST['receiverName'];
    $receiverPhone = $_POST['receiverPhone'];
    $bloodGroupId = $_POST['bloodGroupId'];
    $donorName = $_POST['donorName'];
    $bloodType = $_POST['bloodType'];

    // Basic form validation
    if (!empty($receiverName) && !empty($receiverPhone)) {
        // Insert blood request into the database
        $sql = "INSERT INTO BloodRequest (ReceiverId, DonorId, ReceiverName, ReceiverPhone, DonorName, BloodGroupId, BloodType)
                VALUES ('$receiverId', '$donorId', '$receiverName', '$receiverPhone', '$donorName', '$bloodGroupId', '$bloodType')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Blood request sent successfully!'); window.location.href='ReceiverData.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Please fill in all required fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Request Blood - VitaFlow</title>
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

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            width: 48%;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Request Blood from Donor</h2>

    <!-- Error message if any -->
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Request blood form -->
    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <!-- Donor details (auto-populated) -->
        <div class="input-group">
            <label for="donorName">Donor Name:</label>
            <input type="text" id="donorName" name="donorName" value="<?= $donor['DonorName'] ?>" readonly>
        </div>

        <div class="input-group">
            <label for="bloodType">Blood Type:</label>
            <input type="text" id="bloodType" name="bloodType" value="<?= $donor['BloodType'] ?>" readonly>
        </div>

        <div class="input-group">
            <label for="receiverName">Your Name:</label>
            <input type="text" id="receiverName" name="receiverName" required>
        </div>

        <div class="input-group">
            <label for="receiverPhone">Your Phone Number:</label>
            <input type="text" id="receiverPhone" name="receiverPhone" required>
        </div>

        <!-- Hidden fields for Donor info -->
        <input type="hidden" name="donorId" value="<?= $donor['DonorId'] ?>">
        <input type="hidden" name="bloodGroupId" value="<?= $donor['BloodGroupId'] ?>">

        <!-- Form actions -->
        <div class="form-actions">
            <button type="submit" class="btn">Submit Request</button>
            <button type="button" class="btn" onclick="window.location.href='ReceiverData.php';">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
// Close the connection at the end of the script
$conn->close();
?>
