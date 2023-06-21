<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/discover.css" type="text/css">

    <!-- import script -->
    <script src="../../scripts/discover.js"></script>
</head>

<body>

    <!-- header -->
    <?php include('../authentication/header.php') ?>


    <div class="discover-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="#" class="active">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- discover -->
        <div class="discover">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="#">Service</a>
                <strong> / </strong>
                <a href="#">Discover</a>
            </div>

            <!-- title-->
            <h1>Discover</h1>

            <div class="content">

                <!-- search bar -->
                <div class="search-bar">
                    <img src="../../assets/icon-search.svg" alt="search-icon">
                    <p>Search</p>
                </div>

                <!-- profile-container -->
                <div class="profile-container">

                    <!-- retrieve user data -->
                    <?php

                    // calculate age
                    function calculateAge($dateString)
                    {
                        $today = new DateTime();
                        $birthDate = new DateTime($dateString);
                        $age = $today->diff($birthDate)->y;
                        return $age;
                    }

                    // connect db
                    include('../../database/connect.php');

                    // fetch user data
                    $sql = "SELECT * FROM user WHERE role = 'volunteer'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) :
                        while ($row = mysqli_fetch_assoc($result)) :
                            $userID = $row['userID'];
                            $name = $row['firstname'] . ' ' . $row['lastname'];
                            $birthdate = $row['birthdate'];
                            $age = calculateAge($birthdate);
                            $gender = $row['gender'];
                    ?>

                            <!-- profile -->
                            <div class="profile">
                                <img src="" alt="user-img">
                                <div class="profile-block">
                                    <h3>Name: </h3>
                                    <h4><?php echo $name; ?></h4>
                                </div>
                                <div class="profile-block">
                                    <h3>Age: </h3>
                                    <h4><?php echo $age; ?></h4>
                                </div>
                                <div class="profile-block">
                                    <h3>Gender: </h3>
                                    <h4><?php echo $gender; ?></h4>
                                </div>

                                <div class="profile-block">
                                    <h3>Service Offered: </h3>
                                </div>
                                <div class="profile-block">
                                    <h3>Service Needed: </h3>
                                </div>

                                <!-- retrieve service -->
                                <?php

                                // connect db
                                include('../../database/connect.php');

                                // fetch data
                                $serviceQuery = "SELECT companionship,counseling,transportation,respite_care,medical_care,hospice_care,daily_living_assistance FROM service WHERE userID ='1'";

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

                                echo '<a class="view-profile" href="discover-profile.php?userID=' . $userID . '">View Profile</a>';

                                ?>
                            </div>

                    <?php
                        endwhile;
                    endif;

                    // close connection
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    ?>

                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>
</body>

</html>