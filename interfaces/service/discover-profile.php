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
            $birthdate = $row['birthdate'];
            $gender = $row['gender'];
            $location = $row['city'] . ', ' . $row['state'];
            $skills = $row['skill'];
            $rating = $row['rating'];
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

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/profile.css" type="text/css">
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

    <div class="profile-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- profile -->
        <div class="profile">

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
                <a href="#"><?php echo $name; ?></a>
            </div>

            <div class="content">

                <!-- basic info -->
                <div class="basic-info">

                    <!-- info -->
                    <div class="info">

                        <div class="name">
                            <!-- title-->
                            <h1><?php echo $name; ?></h1>

                            <!-- rating -->
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" <?php echo ($rating == 5) ? 'checked' : ''; ?> disabled />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" <?php echo ($rating == 4) ? 'checked' : ''; ?> disabled />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" <?php echo ($rating == 3) ? 'checked' : ''; ?> disabled />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" <?php echo ($rating == 2) ? 'checked' : ''; ?> disabled />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" <?php echo ($rating == 1) ? 'checked' : ''; ?> disabled />
                                <label for="star1" title="text">1 star</label>
                            </div>

                        </div>


                        <h3>Age: <?php echo $birthdate; ?></h3>
                        <h3>Gender: <?php echo $gender; ?></h3>
                        <h3>Location: <?php echo $location; ?></h3>
                        <h3>Skills/Specialty: <?php echo $skills; ?></h3>

                        <!-- service list -->
                        <div class="service-list">
                            <h3>Service Offered: </h3>

                            <!-- retrieve service -->
                            <?php

                            // connect db
                            include('../../database/connect.php');

                            // fetch data
                            $serviceQuery = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE userID =$userID";

                            $serviceResult = mysqli_query($conn, $serviceQuery);

                            echo '<div class="service-container">';
                            $colors = array('#FAD2E1', '#FFD8B5', '#FFEFD1', '#D4F1F4', '#B5EAD7', '#F3D6E4', '#C7E9FF');
                            shuffle($colors);

                            while ($row = mysqli_fetch_assoc($serviceResult)) {
                                foreach ($row as $columnName => $value) {
                                    if ($value == 1) {
                                        $randomColor = array_shift($colors);
                                        echo '<p style="background-color: ' . $randomColor . ';">';
                                        echo $columnName;
                                        echo '</p>';
                                    }
                                }
                            }
                            echo '</div>';
                            ?>
                        </div>

                    </div>

                    <!-- img, btn -->
                    <div class="action-btn">
                        <img src="" alt="user-img">
                        <button class="follow">Follow</button>
                        <a href="request-create.php?userID=<?php echo $userID; ?>">
                            <button class="book">Book Service</button>
                        </a>
                    </div>
                </div>

                <!-- service experience -->
                <div class="experience">
                    <h3>Recent Service Experience:</h3>

                    <!-- experience table-->
                    <table class="experience-table">
                        <thead class="table-head">
                            <tr>
                                <th>Date</th>
                                <th>Duration (hours)</th>
                                <th>Service Involved</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">

                            <?php
                            // connect db
                            include('../../database/connect.php');

                            // fetch data
                            $sql = "SELECT * FROM service_request";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                    echo '<td>' . $serviceDatetime . '</td>';
                                    echo '<td>' . $row['duration'] . '</td>';
                                    $requestID = $row['requestID'];

                                    // fetch service involved
                                    $sql2 = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE requestID = '$requestID'";
                                    $result2 = mysqli_query($conn, $sql2);

                                    if (mysqli_num_rows($result2) > 0) {

                                        echo '<td>';
                                        echo '<div class="service-expereince">';
                                        $colors = array('#FAD2E1', '#FFD8B5', '#FFEFD1', '#D4F1F4', '#B5EAD7', '#F3D6E4', '#C7E9FF');
                                        shuffle($colors);

                                        while ($row2 = mysqli_fetch_assoc($result2)) {
                                            foreach ($row2 as $columnName => $value) {
                                                if ($value == 1) {
                                                    $randomColor = array_shift($colors);
                                                    echo '<p style="background-color: ' . $randomColor . ';">';
                                                    echo $columnName;
                                                    echo '</p>';
                                                }
                                            }
                                        }
                                        echo '</div>';
                                        echo '</td>';

                                    } else {
                                        // No rows found in the database
                                        echo '<tr><td colspan="7">No data available</td></tr>';
                                    }
                                }
                            } else {
                                // No rows found in the database
                                echo '<tr><td colspan="7">No data available</td></tr>';
                            }



                            // close connection
                            mysqli_free_result($result);
                            mysqli_close($conn);
                            ?>

                        </tbody>
                    </table>
                </div>

                <!-- feed -->
                <div>

                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>©2023 HelpConnect. All right reserved.</p>
    </div>

</body>


</html>