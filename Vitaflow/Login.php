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
        /* Reset margin and padding for consistent layout across browsers */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        /* Full-Screen Background Image */
        .full-screen-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("<?php echo $baseUrl; ?>/images/vitaflowhome.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            filter: brightness(50%); /* Darken the background image for readability */
        }

        /* Navigation Bar */
        .navbar {
            background-color: rgba(0, 123, 255, 0.85); /* Healthcare-inspired color */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .navbar h2 {
            font-size: 1.8em;
            color: white;
            letter-spacing: 1px;
        }

        .navbar a {
            color: white;
            font-size: 1.1em;
            padding: 10px 20px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: rgba(0, 123, 255, 0.6); /* Darker blue on hover */
            border-radius: 5px;
        }

        .navbar a.active {
            background-color: rgba(0, 123, 255, 0.7);
            font-weight: bold;
        }

        /* Login Container Styling */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 150px auto;
            z-index: 10;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Button Group Styling */
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Space between buttons */
        }

        .button-group button {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            background-color: #28a745; /* Green button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button-group button:hover {
            background-color: #218838;
            transform: translateY(-5px);
        }

        /* Footer Styling */
        footer {
            background-color: #333;
            padding: 15px 0;
            color: white;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 1em;
        }

        footer a {
            color: #28a745;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Media Query for Mobile */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .navbar a {
                margin-bottom: 10px;
            }

            .container {
                width: 90%;
                padding: 30px;
            }

            .button-group button {
                font-size: 1.1em;
            }
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
    <a href="<?php echo $baseUrl; ?>/Donorbuttons.php">Donor</a>
    <a href="<?php echo $baseUrl; ?>/Receiverbuttons.php">Receiver</a>
    <a href="<?php echo $baseUrl; ?>/contact.php">Contact Us</a> 
    <a href="<?php echo $baseUrl; ?>/login.php">Login</a>
</div>

<!-- Login Container -->
<div class="container">

    <h2>Login As</h2>

    <!-- Buttons for Login -->
    <div class="button-group">
        <!-- Redirect to AdminLogin.php -->
        <button onclick="window.location.href='<?php echo $baseUrl; ?>/AdminButton.php'">Admin</button>
        <button onclick="window.location.href='<?php echo $baseUrl; ?>/Receiverlogin.php'">Receiver</button>
        <button onclick="window.location.href='<?php echo $baseUrl; ?>/Donorlogin.php'">Donor</button>
    </div>

</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 VitaFlow | <a href="<?php echo $baseUrl; ?>/terms.php">Terms & Conditions</a> | <a href="<?php echo $baseUrl; ?>/privacy.php">Privacy Policy</a></p>
</footer>

</body>
</html>
