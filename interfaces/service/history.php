<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/history.css" type="text/css">

    <!-- import script -->
    <script src="../../scripts/history.js"></script>

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

    <div class="history-container">

        <!-- side bar -->
        <div class="sidebar">
            <a href="discover.php">Discover</a>
            <a href="request.php">Service Request</a>
            <a href="#" class="active">History</a>
        </div>

        <!-- history -->
        <div class="history">

            <!-- breadcrumb -->
            <div class="breadcrumb">
                <a href="discover.php">Service</a>
                <strong> / </strong>
                <a href="#">History</a>
            </div>

            <!-- title-->
            <h1>History</h1>

            <div class="content">

                <!-- history-container -->
                <div class="table-container">

                    <!-- history table-->
                    <table class="history-table">
                        <thead class="table-head">
                            <tr>
                                <th>Request ID</th>
                                <th>Date</th>
                                <th>Duration</th>
                                <th>Volunteer Name</th>
                                <th>Service Involved</th>
                                <th>Status</th>
                                <th>Rating</th>
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
                                        echo '<div class="service">';
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
                                    if ($row['user_rating'] == 0) {
                                        echo '<button id="rateButton" class="rate-button" onclick="openRatingPopup()">Rate</button>';
                                        // echo '<button class="rate-button" onclick="openRatingPopup(' . $row['requestID'] . ')">Rate</button>';
                                    } else {
                                        echo '<div class="rate">';
                                        echo '<input type="radio" id="star5" name="rate" value="5" ' . ($row['user_rating'] == 5 ? 'checked' : '') . ' disabled />';
                                        echo '<label for="star5" title="text">5 stars</label>';
                                        echo '<input type="radio" id="star4" name="rate" value="4" ' . ($row['user_rating'] == 4 ? 'checked' : '') . ' disabled />';
                                        echo '<label for="star4" title="text">4 stars</label>';
                                        echo '<input type="radio" id="star3" name="rate" value="3" ' . ($row['user_rating'] == 3 ? 'checked' : '') . ' disabled />';
                                        echo '<label for="star3" title="text">3 stars</label>';
                                        echo '<input type="radio" id="star2" name="rate" value="2" ' . ($row['user_rating'] == 2 ? 'checked' : '') . ' disabled />';
                                        echo '<label for="star2" title="text">2 stars</label>';
                                        echo '<input type="radio" id="star1" name="rate" value="1" ' . ($row['user_rating'] == 1 ? 'checked' : '') . ' disabled />';
                                        echo '<label for="star1" title="text">1 star</label>';
                                        echo '<span id="selectedRating">' . $row['user_rating'] . ' stars</span>';
                                        echo '</div>';
                                    }
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

    <!-- Rating Popup -->
    <div class="rating-popup" id="ratingPopup">
        <div class="rating-content">
            <button class="close-button" onclick="closeRatingPopup()">Close</button> <!-- Add this line -->
            <h2>Rate the Service</h2>
            <div class="rate-popup">
                <input type="radio" id="rate5" name="rate-popup" value="5" />
                <label for="rate5" title="text">5 stars</label>
                <input type="radio" id="rate4" name="rate-popup" value="4" />
                <label for="rate4" title="text">4 stars</label>
                <input type="radio" id="rate3" name="rate-popup" value="3" />
                <label for="rate3" title="text">3 stars</label>
                <input type="radio" id="rate2" name="rate-popup" value="2" />
                <label for="rate2" title="text">2 stars</label>
                <input type="radio" id="rate1" name="rate-popup" value="1" />
                <label for="rate1" title="text">1 star</label>
            </div>
            <button onclick="submitRating()">Submit</button>
            <button onclick="closeRatingPopup()">Cancel</button>
        </div>
    </div>


    <!-- Footer -->
    <div class="footer">
        <p>©2023 HelpConnect. All right reserved.</p>
    </div>
</body>

<script>
    function openRatingPopup() {
        const ratingPopup = document.getElementById('ratingPopup');
        ratingPopup.style.display = 'flex';
    }

    function closeRatingPopup() {
        const ratingPopup = document.getElementById('ratingPopup');
        ratingPopup.style.display = 'none';
    }

    function submitRating() {
        const ratingInputs = document.querySelectorAll('.rating-popup input[name="rate-popup"]');
        let selectedRating = 0;
        ratingInputs.forEach(input => {
            if (input.checked) {
                selectedRating = input.value;
            }
        });

        // Perform the rating submission logic here
        // ...

        // Simulating a successful submission
        setTimeout(() => {
            const rateButton = document.getElementById('rateButton');
            const ratingBar = document.createElement('div');
            ratingBar.classList.add('rate');
            ratingBar.innerHTML = `
            <input type="radio" id="star5" name="rate" value="5" ${selectedRating === '5' ? 'checked' : ''} />
            <label for="star5" title="text">5 stars</label>
            <input type="radio" id="star4" name="rate" value="4" ${selectedRating === '4' ? 'checked' : ''} />
            <label for="star4" title="text">4 stars</label>
            <input type="radio" id="star3" name="rate" value="3" ${selectedRating === '3' ? 'checked' : ''} />
            <label for="star3" title="text">3 stars</label>
            <input type="radio" id="star2" name="rate" value="2" ${selectedRating === '2' ? 'checked' : ''} />
            <label for="star2" title="text">2 stars</label>
            <input type="radio" id="star1" name="rate" value="1" ${selectedRating === '1' ? 'checked' : ''} />
            <label for="star1" title="text">1 star</label>
            <span id="selectedRating">${selectedRating} stars</span>
        `;
            rateButton.parentNode.replaceChild(ratingBar, rateButton);

            closeRatingPopup();

            location.reload();
        }, 2000); // Delay added for demonstration purposes
    }
</script>

</html>