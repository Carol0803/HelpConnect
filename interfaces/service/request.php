<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/request.css" type="text/css">

    <!-- import script -->
    <script src="../../scripts/request.js"></script>
</head>

<body>

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

    <div class="request-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php">Discover</a>
            <a href="#" class="active">Service Request</a>
            <a href="history.php">History</a>
        </div>

        <!-- request -->
        <div class="request">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="#">Service Request</a>
            </div>

            <!-- title-->
            <h1>Service Request</h1>

            <div class="content">

                <!-- request-container -->
                <div class="table-container">

                    <!-- request table-->
                    <table class="request-table">
                        <thead class="table-head">
                            <tr>
                                <th>Request ID</th>
                                <th>Date</th>
                                <th>Duration (hours)</th>
                                <th>Volunteer Name</th>
                                <th>Service Involved</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                    echo '<td>' . $row['requestID'] . '</td>';
                                    $serviceDatetime = date('Y-m-d h:i A', strtotime($row['service_datetime']));
                                    echo '<td>' . $serviceDatetime . '</td>';
                                    echo '<td>' . $row['duration'] . '</td>';

                                    // get volunteer name
                                    $volunteer_involved = $row['volunteer_involved'];
                                    $sql3 = "SELECT * FROM user WHERE userID = '$volunteer_involved'";
                                    $result3 = mysqli_query($conn, $sql3);

                                    if (mysqli_num_rows($result3) > 0) {
                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                            echo '<td>' . $row3['firstname'] . '</td>';
                                        }
                                    } else {
                                        // No rows found in the database
                                        echo '<tr><td colspan="7">No data available</td></tr>';
                                    }

                                    // fetch service involved
                                    $requestID = $row['requestID'];
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

                                    echo '<td>' . $row['status'] . '</td>';
                                    echo '<td>';
                                    echo '<div class="table-button">';
                                    echo '<button><img src="../../assets/icon-edit.svg" alt="Edit" /></button>';
                                    echo '<button><img src="../../assets/icon-delete.svg" alt="Delete" /></button>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
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
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>©2023 HelpConnect. All right reserved.</p>
    </div>

    <!-- js for fetch data -->
    <!-- // Fetch data from PHP backend
    fetch('fetch_data.php')
    .then(response => response.json())
    .then(data => {
    const tableBody = document.getElementById('tableBody');

    // Iterate through the data and populate table rows
    data.forEach(row => {
    const newRow = document.createElement('tr');

    // Iterate through each column in the row and create table cells
    for (let i = 0; i < 7; i++) { const cell=document.createElement('td'); cell.textContent=row[i];
        newRow.appendChild(cell); } tableBody.appendChild(newRow); }); }) .catch(error=> {
        console.log('Error fetching data:', error);
        }); -->

</body>

</html>