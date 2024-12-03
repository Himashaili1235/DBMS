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

// Handle delete request
if (isset($_GET['delete'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];
    
    if ($table == 'Donor') {
        $sql = "DELETE FROM Donor WHERE DonorId = ?";
    } elseif ($table == 'Receiver') {
        $sql = "DELETE FROM Receiver WHERE ReceiverId = ?";
    } elseif ($table == 'BloodGroup') {
        $sql = "DELETE FROM BloodGroup WHERE BloodGroupId = ?";
    } elseif ($table == 'BloodRequest') {
        $sql = "DELETE FROM bloodrequest WHERE BloodRequestId = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id); // 's' denotes the parameter type (string)
    
    if ($stmt->execute()) {
        echo "<p>Record deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    
    if ($table == 'Donor') {
        $name = $_POST['donorName'];
        $bloodGroupId = $_POST['bloodGroup'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "UPDATE Donor SET DonorName = ?, BloodGroupId = ?, Age = ?, Email = ?, Phone = ? WHERE DonorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiss', $name, $bloodGroupId, $age, $email, $phone, $id);
    } elseif ($table == 'Receiver') {
        $name = $_POST['receiverName'];
        $bloodGroupId = $_POST['bloodGroup'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "UPDATE Receiver SET ReceiverName = ?, BloodGroupId = ?, Age = ?, Email = ?, Phone = ? WHERE ReceiverId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiss', $name, $bloodGroupId, $age, $email, $phone, $id);
    } elseif ($table == 'BloodGroup') {
        $bloodType = $_POST['bloodType'];

        $sql = "UPDATE BloodGroup SET BloodType = ? WHERE BloodGroupId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $bloodType, $id);
    } elseif ($table == 'BloodRequest') {
        $receiverName = $_POST['receiverName'];
        $donorName = $_POST['donorName'];
        $bloodGroupId = $_POST['bloodGroup'];
        $receiverPhone = $_POST['receiverPhone'];
        $donorPhone = $_POST['donorPhone'];

        $sql = "UPDATE bloodrequest SET ReceiverName = ?, DonorName = ?, BloodGroupId = ?, ReceiverPhone = ?, DonorPhone = ? WHERE BloodRequestId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiss', $receiverName, $donorName, $bloodGroupId, $receiverPhone, $donorPhone, $id);
    }

    if ($stmt->execute()) {
        echo "<p>Record updated successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data for Donor, Receiver, BloodGroup, and BloodRequest
$donors = $conn->query("SELECT * FROM Donor");
$receivers = $conn->query("SELECT * FROM Receiver");
$bloodGroups = $conn->query("SELECT * FROM BloodGroup");
$bloodRequests = $conn->query("SELECT * FROM bloodrequest");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Admin Data Management</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your custom CSS -->
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Main container */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 2.2em;
            margin-bottom: 20px;
            color: #004d40;
        }

        /* Tabs */
        .tabs {
            display: flex;
            justify-content: center;
            background-color: #004d40;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .tabs div {
            padding: 15px 25px;
            cursor: pointer;
            color: #fff;
            font-weight: bold;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .tabs div.active {
            background-color: #00796b;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            margin-top: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #004d40;
            color: white;
        }

        /* Action buttons */
        .action-buttons button {
            padding: 6px 15px;
            font-size: 14px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #004d40;
        }

        /* Modal for Updating */
        .update-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .update-form button {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-form button:hover {
            background-color: #004d40;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 60%;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d32f2f;
            color: white;
            font-size: 16px;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 50%;
            border: none;
        }

        .modal-close:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Data Management</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div id="donorTab" class="active" onclick="showTab('donor')">Donors</div>
        <div id="receiverTab" onclick="showTab('receiver')">Receivers</div>
        <div id="bloodGroupTab" onclick="showTab('bloodGroup')">Blood Groups</div>
        <div id="bloodRequestTab" onclick="showTab('bloodRequest')">Blood Requests</div> <!-- New Tab -->
    </div>

    <!-- Donors Tab -->
    <div id="donorTabContent" class="tab-content active">
        <h3>Donors</h3>
        <table>
            <tr>
                <th>Donor ID</th>
                <th>Donor Name</th>
                <th>Blood Group</th>
                <th>Age</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php while ($donor = $donors->fetch_assoc()): ?>
            <tr>
                <td><?php echo $donor['DonorId']; ?></td>
                <td><?php echo $donor['DonorName']; ?></td>
                <td><?php echo $donor['BloodGroupId']; ?></td>
                <td><?php echo $donor['Age']; ?></td>
                <td><?php echo $donor['Email']; ?></td>
                <td><?php echo $donor['Phone']; ?></td>
                <td class="action-buttons">
                    <a href="?delete=1&id=<?php echo $donor['DonorId']; ?>&table=Donor">
                        <button>Delete</button>
                    </a>
                    <button onclick="showUpdateForm('Donor', '<?php echo $donor['DonorId']; ?>', '<?php echo $donor['DonorName']; ?>', '<?php echo $donor['BloodGroupId']; ?>', '<?php echo $donor['Age']; ?>', '<?php echo $donor['Email']; ?>', '<?php echo $donor['Phone']; ?>')">Update</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Receivers Tab -->
    <div id="receiverTabContent" class="tab-content">
        <h3>Receivers</h3>
        <table>
            <tr>
                <th>Receiver ID</th>
                <th>Receiver Name</th>
                <th>Blood Group</th>
                <th>Age</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php while ($receiver = $receivers->fetch_assoc()): ?>
            <tr>
                <td><?php echo $receiver['ReceiverId']; ?></td>
                <td><?php echo $receiver['ReceiverName']; ?></td>
                <td><?php echo $receiver['BloodGroupId']; ?></td>
                <td><?php echo $receiver['Age']; ?></td>
                <td><?php echo $receiver['Email']; ?></td>
                <td><?php echo $receiver['Phone']; ?></td>
                <td class="action-buttons">
                    <a href="?delete=1&id=<?php echo $receiver['ReceiverId']; ?>&table=Receiver">
                        <button>Delete</button>
                    </a>
                    <button onclick="showUpdateForm('Receiver', '<?php echo $receiver['ReceiverId']; ?>', '<?php echo $receiver['ReceiverName']; ?>', '<?php echo $receiver['BloodGroupId']; ?>', '<?php echo $receiver['Age']; ?>', '<?php echo $receiver['Email']; ?>', '<?php echo $receiver['Phone']; ?>')">Update</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Blood Groups Tab -->
    <div id="bloodGroupTabContent" class="tab-content">
        <h3>Blood Groups</h3>
        <table>
            <tr>
                <th>Blood Group ID</th>
                <th>Blood Type</th>
                <th>Actions</th>
            </tr>
            <?php while ($bloodGroup = $bloodGroups->fetch_assoc()): ?>
            <tr>
                <td><?php echo $bloodGroup['BloodGroupId']; ?></td>
                <td><?php echo $bloodGroup['BloodType']; ?></td>
                <td class="action-buttons">
                    <a href="?delete=1&id=<?php echo $bloodGroup['BloodGroupId']; ?>&table=BloodGroup">
                        <button>Delete</button>
                    </a>
                    <button onclick="showUpdateForm('BloodGroup', '<?php echo $bloodGroup['BloodGroupId']; ?>', '<?php echo $bloodGroup['BloodType']; ?>')">Update</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Blood Requests Tab -->
    <div id="bloodRequestTabContent" class="tab-content">
        <h3>Blood Requests</h3>
        <table>
            <tr>
                <th>Blood Request ID</th>
                <th>Receiver Name</th>
                <th>Receiver Phone</th>
                <th>Donor Name</th>
                <th>Blood Group</th>
                <th>Actions</th>
            </tr>
            <?php while ($bloodRequest = $bloodRequests->fetch_assoc()): ?>
            <tr>
                <td><?php echo $bloodRequest['BloodRequestId']; ?></td>
                <td><?php echo $bloodRequest['ReceiverName']; ?></td>
                <td><?php echo $bloodRequest['ReceiverPhone']; ?></td>
                <td><?php echo $bloodRequest['DonorName']; ?></td>
                <td><?php echo $bloodRequest['BloodGroupId']; ?></td>
                <td class="action-buttons">
                    <a href="?delete=1&id=<?php echo $bloodRequest['BloodRequestId']; ?>&table=BloodRequest">
                        <button>Delete</button>
                    </a>
                    <button onclick="showUpdateForm('BloodRequest', '<?php echo $bloodRequest['BloodRequestId']; ?>', '<?php echo $bloodRequest['ReceiverName']; ?>', '<?php echo $bloodRequest['ReceiverPhone']; ?>', '<?php echo $bloodRequest['DonorName']; ?>', '<?php echo $bloodRequest['BloodGroupId']; ?>')">Update</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<script>
    function showTab(tab) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(function(tabContent) {
            tabContent.classList.remove('active');
        });
        
        // Deactivate all tabs
        document.querySelectorAll('.tabs div').forEach(function(tabDiv) {
            tabDiv.classList.remove('active');
        });

        // Show selected tab and activate the respective tab
        document.getElementById(tab + 'TabContent').classList.add('active');
        document.getElementById(tab + 'Tab').classList.add('active');
    }

    // Display update form for Donor, Receiver, BloodGroup, and BloodRequest
    function showUpdateForm(table, id, receiverName, receiverPhone, donorName, bloodGroupId) {
        document.getElementById('updateFormModal').style.display = 'flex';
        document.getElementById('updateTable').value = table;
        document.getElementById('updateId').value = id;

        let formFields = '';

        if (table === 'BloodRequest') {
            formFields += '<label for="receiverName">Receiver Name:</label><input type="text" name="receiverName" value="' + receiverName + '" required><br>';
            formFields += '<label for="receiverPhone">Receiver Phone:</label><input type="text" name="receiverPhone" value="' + receiverPhone + '" required><br>';
            formFields += '<label for="donorName">Donor Name:</label><input type="text" name="donorName" value="' + donorName + '" required><br>';
            formFields += '<label for="bloodGroup">Blood Group:</label><input type="text" name="bloodGroup" value="' + bloodGroupId + '" required><br>';
        }

        document.getElementById('updateFormFields').innerHTML = formFields;
    }
</script>

</body>
</html>
