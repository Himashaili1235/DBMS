<?php
// Define the base URL for your site (adjust it accordingly)
$baseUrl = "/Vitaflow"; // Adjust to your actual local project path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Admin Access</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 30px auto;
            position: relative;
            z-index: 10;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 2.2em;
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            background-color: #28a745; /* Green button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 20px;
        }

        .cta-button:hover {
            background-color: #218838;
            transform: translateY(-5px);
        }

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
    </style>
</head>
<body>

<!-- Full-Screen Background Image -->
<div class="full-screen-background"></div>

<!-- Admin Access Content Section -->
<div class="container">
    <h2>Admin Access</h2>

    <!-- Sign In and Sign Up Buttons -->
    <a href="<?php echo $baseUrl; ?>/AdminLogin.php" class="cta-button">Sign In</a>
    <a href="<?php echo $baseUrl; ?>/AdminRegis.php" class="cta-button">Sign Up</a>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 VitaFlow | <a href="<?php echo $baseUrl; ?>/terms.php">Terms & Conditions</a> | <a href="<?php echo $baseUrl; ?>/privacy.php">Privacy Policy</a></p>
</footer>

</body>
</html>
