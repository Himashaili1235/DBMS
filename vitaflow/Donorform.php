<?php
// Define the base URL for your site (adjust it accordingly)
$baseUrl = "/your-website"; // e.g., "/vitaflow" or "/your-project-folder"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Donor Registration</title>
    <style>
        /* Apply background image dynamically using PHP */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url("<?php echo $baseUrl; ?>/images/vitaflowhome.jpg");
            background-size: cover; /* Make sure image covers the entire page */
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Center the form container */
        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Add slight transparency */
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
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Donor Registration Form</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="donorId">Donor ID:</label>
        <input type="text" id="donorId" name="donorId">
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <label for="donorName">Donor Name:</label>
        <input type="text" id="donorName" name="donorName">
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <label for="bloodGroupId">Blood Group:</label>
        <select name="bloodGroupId" id="bloodGroupId">
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
            }
            ?>
        </select>
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age">
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone">
        <span class="error">* <!-- Display error here if any --></span>
        <br><br>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
