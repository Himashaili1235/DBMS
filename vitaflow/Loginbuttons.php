<?php
// Define the base URL for your site (adjust it accordingly)
$baseUrl = "/Vitaflow"; // Adjust to your actual local project path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        /* Reset the margin and padding */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Full-screen background image */
        .full-screen-background {
            position: fixed; /* Fix the image in place */
            top: 60px; /* Position the image just below the navbar */
            left: 0;
            width: 100%;
            height: 100%; /* Use 100% height to cover the entire viewport */
            background-image: url("<?php echo $baseUrl; ?>/images/vitaflowhome.jpg"); /* Local image path */
            background-size: cover; /* Make the image cover the area */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling of the image */
            z-index: -1; /* Ensure the image stays in the background */
        }

        /* Navigation bar styling */
        .navbar {
            background-color: rgba(76, 175, 80, 0.8); /* Slightly transparent background */
            overflow: hidden;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #45a049;
        }

        /* Content styling */
        .content {
            position: relative;
            padding: 120px 20px 20px 20px; /* Adjust padding to leave space for navbar */
            text-align: center;
            color: white;
        }

        .content h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        /* Button Styling */
        .button-container {
            margin-top: 30px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Full-Screen Background Image -->
<div class="full-screen-background"></div>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="<?php echo $baseUrl; ?>/main.php"><h2>VitaFlow</h2></a>
    <a href="<?php echo $baseUrl; ?>/main.php">Home</a>
    <a href="<?php echo $baseUrl; ?>/DonorRegis.php">Donor</a>
    <a href="<?php echo $baseUrl; ?>/ReceiverRegis.php">Receiver</a>
    <a href="<?php echo $baseUrl; ?>/AdminButton.php">Admin</a>
    <a href="<?php echo $baseUrl; ?>/loginbuttons.php">Login</a>
</div>

<!-- Content Section -->
<div class="content">
    <h1>Welcome Back to VitaFlow</h1>
    <p>Please choose an option to get started.</p>

    <!-- Sign In and Sign Up buttons -->
    <div class="button-container">
        <a href="<?php echo $baseUrl; ?>/signin.php" class="btn">Sign In</a>
        <a href="<?php echo $baseUrl; ?>/signup.php" class="btn">Sign Up</a>
    </div>
</div>

<footer>
    <p>&copy; 2024 VitaFlow. All rights reserved.</p>
</footer>

</body>
</html>
