<?php
// Start the session to check if the donor is logged in
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['DonorId'])) {
    header("Location: DonorLogin.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$host = 'localhost'; // Database host
$dbname = 'vitaflow'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Get the donor's ID from the session
$donorId = $_SESSION['DonorId'];

// Fetch the donor details along with the blood type
$stmt = $pdo->prepare("
    SELECT Donor.*, BloodGroup.BloodType 
    FROM Donor 
    JOIN BloodGroup ON Donor.BloodGroupId = BloodGroup.BloodGroupId
    WHERE Donor.DonorId = :DonorId
");
$stmt->bindParam(':DonorId', $donorId, PDO::PARAM_INT);
$stmt->execute();

$donor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donor) {
    // If donor doesn't exist (this shouldn't happen), redirect to login page
    header("Location: DonorLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Profile - VitaFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Sliding Menu Styles */
        .menu-container {
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            height: 100%;
            background-color: #333;
            color: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .menu-container.open {
            transform: translateX(0);
        }

        .menu-container .menu-header {
            padding: 20px;
            font-size: 24px;
            text-align: center;
            background-color: #4CAF50;
        }

        .menu-container .menu-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-container .menu-content a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-size: 18px;
            width: 100%;
            text-align: center;
            background-color: #555;
            margin-bottom: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .menu-container .menu-content a:hover {
            background-color: #4CAF50;
        }

        /* Button to toggle the menu */
        .menu-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 30px;
            background-color: transparent;
            border: none;
            color: #4CAF50;
            cursor: pointer;
        }

        /* Profile container styling */
        .profile-container {
            padding: 50px;
            background-color: #fff;
            margin-right: 300px; /* Adjust for the sliding menu width */
            transition: margin-right 0.3s ease;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .profile-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-info .info-item {
            flex: 1 1 calc(33.333% - 20px);
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-info .info-item h4 {
            font-size: 20px;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .profile-info .info-item p {
            font-size: 18px;
            color: #555;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .profile-info .info-item {
                flex: 1 1 100%;
                margin-bottom: 20px;
            }

            .profile-container {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

<!-- Menu toggle button -->
<button class="menu-toggle" onclick="toggleMenu()">&#9776; Menu</button>

<!-- Sliding menu container -->
<div id="menu" class="menu-container">
    <div class="menu-header">
        <h3>Welcome</h3>
    </div>
    <div class="menu-content">
        <a href="profile.php">View Profile</a>
		<a href="DonorData.php"> Blood Request </a>
        <a href="logout.php">Logout</a>
		
    </div>
</div>

<!-- Profile container -->
<div class="profile-container">
    <h2>Welcome, <?= htmlspecialchars($donor['DonorName']) ?>!</h2>

    <div class="profile-info">
        <div class="info-item">
            <h4>Donor ID</h4>
            <p><?= htmlspecialchars($donor['DonorId']) ?></p>
        </div>
        <div class="info-item">
            <h4>Age</h4>
            <p><?= htmlspecialchars($donor['Age']) ?></p>
        </div>
        <div class="info-item">
            <h4>Blood Type</h4>
            <p><?= htmlspecialchars($donor['BloodType']) ?></p>
        </div>
        <div class="info-item">
            <h4>Email</h4>
            <p><?= htmlspecialchars($donor['Email']) ?></p>
        </div>
        <div class="info-item">
            <h4>Phone</h4>
            <p><?= htmlspecialchars($donor['Phone']) ?></p>
        </div>
    </div>
</div>

<!-- JavaScript to handle the sliding menu -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        const profileContainer = document.querySelector('.profile-container');

        // Toggle the menu's open state
        menu.classList.toggle('open');

        // Adjust profile container's margin when menu is open
        if (menu.classList.contains('open')) {
            profileContainer.style.marginRight = '250px';
        } else {
            profileContainer.style.marginRight = '0';
        }
    }
</script>

</body>
</html>
