<?php
// connect db
include('../../database/connect.php');

// retrieve user data based on the user ID from the URL parameter
if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Query to retrieve user data
    $query = "SELECT * FROM user WHERE userID = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {

            // retrieve user data
            $row = mysqli_fetch_assoc($result);
            $name = $row['firstname'] . ' ' . $row['lastname'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
        } else {
            // No user found with the provided ID
            echo "User not found";
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Query execution failed
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // No userID parameter provided in the URL
    echo "Invalid request";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form inputs
    $date = $_POST["service_datetime"];
    $duration = $_POST["duration"];
    $description = $_POST["description"];

    // Prepare the INSERT query
    $insertQuery = "INSERT INTO service_request (service_involved, elderly_involved, volunteer_involved, service_datetime, duration, description)
                    VALUES ('1', '1', '$userID', '$date', '$duration', '$description')";

    // Execute the INSERT query
    if (mysqli_query($conn, $insertQuery)) {
        // Success message
        echo "Service request stored in the database.";
    } else {
        // Error message
        echo "Error storing service request: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/create.css" type="text/css">
</head>

<body>

    <!-- header -->
    <div class="header">
        <img src="../../assets/logo.svg" alt="logo" height="55px">

        <!-- menu -->
        <div class="menu">
            <a href="">Home</a>
            <a href="#" class="active">Service</a>
            <a href="">Community</a>
            <a href="">Profile</a>
        </div>

        <!-- avatar -->
        <button class="avatar-button" id="" type="button">
            <span class="avatar-text">DJ</span>
        </button>
    </div>

    <div class="create-request-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- create request -->
        <div class="create-request">

            <!-- back button -->
            <a href="discover.php" class="back-button">
                <span>
                    < Back</span>
            </a>

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="#">Service</a>
                <strong> / </strong>
                <a href="discover.php">Discover</a>
                <strong> / </strong>
                <a href="#">
                    <?php echo $name; ?>
                </a>
                <strong> / </strong>
                <a href="#">Create Service Request</a>
            </div>

            <!-- title-->
            <h1>Create Service Request</h1>

            <div class="content">

                <form id="serviceRequestForm" method="POST">

                    <!-- request by -->
                    <label>Request by:</label><br>
                    <div class="by">
                        <input type="text" placeholder="Elderly's First Name"><br>
                        <input type="text" placeholder="Elderly's Last Name"><br>
                    </div>

                    <!-- request to -->
                    <label>Request to:</label><br>
                    <div class="to">
                        <input type="text" placeholder="<?php echo $firstname; ?>" disabled><br>
                        <input type="text" placeholder="<?php echo $lastname; ?>" disabled><br>
                    </div>

                    <!-- date -->
                    <label for="service_datetime">Date:</label>
                    <input type="date" id="service_datetime" name="service_datetime" placeholder="Date">

                    <!-- duration -->
                    <label for="duration">Duration(hours): </label>
                    <input type="number" id="duration" name="duration" placeholder="Duration">

                    <!-- service type -->
                    <label for="service_involved ">Service Type: </label>
                    <div class="checkbox">
                        <input type="checkbox" id="companionship" value="Companionship">
                        <label for="companionship">Companionship</label><br>
                        <input type="checkbox" id="daily" value="Daily Living Assistance">
                        <label for="daily">Daily Living Assistance</label><br>
                        <input type="checkbox" id="medical" value="Medical care">
                        <label for="medical">Medical care</label><br>
                        <input type="checkbox" id="transportation" value="Transportation">
                        <label for="transportation">Transportation</label><br>
                        <input type="checkbox" id="counseling" value="Counseling">
                        <label for="counseling">Counseling</label><br>
                        <input type="checkbox" id="hospice" value="Hospice care">
                        <label for="hospice">Hospice care</label><br>
                        <input type="checkbox" id="respite" value="Respite care">
                        <label for="respite">Respite care</label><br>
                        <input type="checkbox" id="other" value="Other">
                        <label for="other">Other</label><br>
                    </div>

                    <!-- decription -->
                    <label for="description">Description</label><br>
                    <textarea id="description" name="description" rows="4" cols="50"></textarea>

                    <!-- rewards -->
                    <input type="checkbox" id="payCheckbox" name="payCheckbox" value="pay" onchange="togglePaymentInput()">
                    <label for="payCheckbox">Rewards</label><br>
                    <input type="number" id="paymentInput" name="paymentInput" placeholder="Amount(RM)" disabled><br>

                    <!-- btn -->
                    <div class="button">
                        <button type="submit" form="serviceRequestForm">Send</button>
                        <button class="cancel">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>©2023 HelpConnect. All right reserved.</p>
    </div>
</body>

<script>
    function togglePaymentInput() {
        var payCheckbox = document.getElementById('payCheckbox');
        var paymentInput = document.getElementById('paymentInput');

        if (payCheckbox.checked) {
            paymentInput.disabled = false;
        } else {
            paymentInput.disabled = true;
        }
    }
</script>

</html>