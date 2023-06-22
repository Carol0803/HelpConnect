<!DOCTYPE html>
<html>

<head>
    <title>About Us</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/aboutUs.css">

    <script>
        // function toggleAvatar() {
        //     var userDetails = document.getElementById("userDetails");
        //     userDetails.style.display = (userDetails.style.display === "block") ? "none" : "block";
        // }
    </script>
</head>

<body>

    <!-- header -->
    <header>
        <div class="header">
            <img src="../../assets/logo.svg" alt="logo" height="55px">

            <!-- menu -->
            <nav class="menu">
                <a href="#" class="active">Home</a>
                <a href="../../interfaces/service/discover.php">Service</a>
                <a href="">Community</a>
                <a href="">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <span class="avatar-text">DJ</span>
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role">Elderly</p>
                <p><strong>Username: </strong> John Doe</p>
                <p><strong>Email: </strong> johndoe@example.com</p>
                <button><a href="./authentication/logout.php"></a>Logout</button>
            </div>
        </div>

    </header>

    <!--Side Nav-->
    <div id='frame5' class='frame5'>
        <div id='frame6' class='frame6'>
            <div id='frame61' class='frame61'>
                <div id='aboutus' class='aboutus'>About Us</div>
            </div>
            <div id='frame62' class='frame62'>
                <div id='missionGoal' class='missionGoal' onClick="location.href='missionGoal.php'">Mission & Goal</div>
            </div>
            <div id='frame63' class='frame63'>
                <div id='contactus' class='contactus' onClick="location.href='contactUs.php'">Contact Us</div>
            </div>
        </div>


        <div id='frame7' class='frame7'>
            <!--Breadcrumbs-->
            <div class="breadcrumbs">
                <img id='icon' class='icon' src="../../assets/home-icon.svg" style="background-color: transparent;">
                <strong> / </strong>
                <a href="#" style="color: black; text-decoration: none;">About Us</a>
            </div>

            <!--About us-->
            <div id='aboutUs3' class='aboutUs3'><strong>About Us</strong></div>
            <div id='frame8' class='frame8' style="top: 50px !important;">
                <!--About us-->
                <div id='text2' class='text2'>
                    Who Are We?
                </div>
                <div id='text3' class='text3'>
                    Founded in 2020, HelpConnect is a organisation that helps senior citizens, caretakers, guardians and volunteers
                    to communicate with each other. First started as an offline facility and with only 30 staffs. Now, HelpConnect have
                    widen their platform to online service. With this expansion, HelpConnect has gain over 150 staffs including verified
                    volunteers.
                </div>

                <div class="rectangle">
                    <img src="../../assets/about-us-volunteer.png" alt="volunteer" height="200px" width="900px">
                </div>
                <div id='text5' class='text5'>
                    Why HelpConnect?
                </div>
                <div id='text4' class='text4'>
                    HelpConnect is a web application that helps senior citizens, caretakers, and guardians find volunteer
                    or paid helpers. The platform allows users to post requests for help with tasks such as transportation,
                    companionship, and homemaking. Volunteers and paid helpers can then browse these requests and offer their
                    services. HelpConnect is a free service that is available to anyone in the United States.
                </div>
                <div id='rectangle' class='rectangle'></div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <?php include('../authentication/footer.php') ?>
    <!-- <footer id="footer" class="footer">
            <div id='copyright' class='copyright'>
                ©2023 HelpConnect. All right reserved. 
            </div>
        </footer> -->

</body>

</html>