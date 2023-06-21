<?php

include('../../database/connect.php');

if (isset($_POST['submit'])) {

   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $dob = mysqli_real_escape_string($conn, $_POST['dob']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
   $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
   $address2 = mysqli_real_escape_string($conn, $_POST['address2']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $role = $_POST['role'];

   $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'User already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password does not match!';
      } else {
         mysqli_query($conn, "INSERT INTO `user` (firstname, lastname, gender, birthdate, email, contact, address, address2, city, state, postcode, country, password, role) VALUES ('$firstname', '$lastname', '$gender', '$dob', '$email', '$contactno', '$address1', '$address2', '$city', '$state', '$postcode', '$country', '$pass', '$role')") or die('Query failed');
         // $message[] = 'Registered successfully!';
         // if ($role == 'elderly') {
         //    header('location: elder.php');
         // } else if ($role == 'volunteer') {
         //    header('location: volunteer.php');
         // } else {
         //    header('location: login.php');
         // }
      }
   }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>Sign Up</title>

   <!-- import custom css -->
   <link rel="stylesheet" href="../../styles/main.css" type="text/css">
   <link rel="stylesheet" href="../../styles/header.css" type="text/css">
   <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
   <link rel="stylesheet" href="../../styles/register.css" type="text/css">

   <script>
      function toggleNext() {
         const basicSection = document.querySelector('.basic');
         const addrPassSection = document.querySelector('.addr-pass');
         const role = document.querySelector('input[name="role"]:checked').value;
         console.log(role);
         const elderlyInputSection = document.querySelector('.elderly-input');
         const volunteerInputSection = document.querySelector('.volunteer-input');

         basicSection.style.display = 'none';
         addrPassSection.style.display = 'block';
         elderlyInputSection.style.display = 'none';
         volunteerInputSection.style.display = 'none';

      }

      function toggleRoleInput(event) {
         event.preventDefault();

         const basicSection = document.querySelector('.basic');
         const addrPassSection = document.querySelector('.addr-pass');
         const role = document.querySelector('input[name="role"]:checked').value;
         const elderlyInputSection = document.querySelector('.elderly-input');
         const volunteerInputSection = document.querySelector('.volunteer-input');

         basicSection.style.display = 'none';
         addrPassSection.style.display = 'none';

         if (role === 'elderly') {
            elderlyInputSection.style.display = 'block';
            volunteerInputSection.style.display = 'none';
         } else if (role === 'volunteer') {
            elderlyInputSection.style.display = 'none';
            volunteerInputSection.style.display = 'block';
         }
      }

      function submitForm(event) {

         document.getElementById('signupForm').submit(event);
      }


      // function onClick() {
      //    document.getElementById('signupForm').submit();
      // }
   </script>

</head>

<body class="signup-form">

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <!-- left -> picture -->
   <div class="picture">
      <img src="../../assets/auth-picture.png" alt="hand-pic" height="55px">
   </div>

   <!-- right -> form -->
   <div class="form-container">

      <!-- logo -->
      <img src="../../assets/logo.svg" alt="logo" height="65px">

      <!-- <form id="registerForm" method="POST"> -->
      <!-- <form id="signupForm" action="" method="post" onsubmit="submitForm(event)"> -->
      <form id="signupForm" action="" method="post" onsubmit="submitForm(event)">
         <h3>SIGN UP</h3>
         <p>Already have an account? <a href="./login.php">login now</a></p>

         <div class="basic" style="display: block;">
            <div class="radiobutton">
               <div>
                  <input type="radio" id="elderly" name="role" value="elderly">
                  <label for="elderly">Regsiter as Elderly</label><br>
               </div>
               <div>
                  <input type="radio" id="volunteer" name="role" value="volunteer">
                  <label for="volunteer">Register as Volunteer</label><br>
               </div>
            </div>

            <div class="signup-name">
               <input type="text" name="firstname" placeholder="First Name" required class="box">
               <input type="text" name="lastname" placeholder="Last Name" required class="box">
            </div>
            <div class="radiobutton">
               <p>Gender:</p>
               <div>
                  <input type="radio" id="male" name="gender" value="male">
                  <label for="male">Male</label><br>
               </div>
               <div>
                  <input type="radio" id="female" name="gender" value="female">
                  <label for="female">Female</label><br>
               </div>
            </div>
            <input type="email" name="email" placeholder="Email Address" required class="box">
            <input type="number" name="contactno" placeholder="Contact No." required class="box">
            <div class="birth-date">
               <p class="birth-date-label">Birth Date:</p>
               <input type="date" name="dob" placeholder="Birth Date" required class="box">
            </div>

            <div class="button">
               <button onclick="toggleNext()">Next</button>
            </div>
         </div>

         <div class="addr-pass" style="display: none;">
            <input type="text" name="address1" placeholder="Street Address" required class="box">
            <input type="text" name="address2" placeholder="Street Address Line 2" required class="box">
            <div class="city-state">
               <input type="text" name="city" placeholder="City" required>
               <input type="text" name="state" placeholder="State" required>
            </div>
            <input type="number" name="postcode" placeholder="Postcode" required class="box">
            <input type="text" name="country" placeholder="Country" required class="box">

            <input type="password" name="password" placeholder="Password" required class="box">
            <input type="password" name="cpassword" placeholder="Confirm Password" required class="box">

            <div class="button">
               <button onclick="toggleRoleInput(event)">Next</button>
            </div>
         </div>

         <!-- <div class="role-input" style="display: none;">
            

         </div> -->

         <div class="elderly-input" style="display: none;">
            <p>Health Condition:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="radio" id="healthy" name="health" value="healthy">
                  <label for="healthy">Healthy</label><br>
               </div>
               <div>
                  <input type="radio" id="frail" name="health" value="frail">
                  <label for="frail">Frail</label><br>
               </div>
               <div>
                  <input type="radio" id="disabled" name="health" value="disabled">
                  <label for="disabled">Disabled</label><br>
               </div>
               <div>
                  <input type="radio" id="chronically-ill" name="health" value="chronically-ill">
                  <label for="chronically-ill">Chronically ill</label><br>
               </div>
               <div>
                  <input type="radio" id="terminally-ill" name="health" value="terminally-ill">
                  <label for="terminally-ill">Terminally ill</label><br>
               </div>
            </div>

            <p>Service Type Needed:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="checkbox" id="companionship" name="service-need" value="companionship">
                  <label for="companionship">Companionship</label><br>
               </div>
               <div>
                  <input type="checkbox" id="daily_living_assistance" name="service-need" value="daily_living_assistance">
                  <label for="daily_living_assistance">Daily Living Assistance</label><br>
               </div>
               <div>
                  <input type="checkbox" id="medical_care" name="service-need" value="medical_care">
                  <label for="medical_care">Medical care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="transportation" name="service-need" value="transportation">
                  <label for="transportation">Transportation</label><br>
               </div>
               <div>
                  <input type="checkbox" id="counseling" name="service-need" value="counseling">
                  <label for="counseling">Counseling</label><br>
               </div>
               <div>
                  <input type="checkbox" id="hospice_care" name="service-need" value="hospice_care">
                  <label for="hospice_care">Hospice care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="respite_care" name="service-need" value="respite_care">
                  <label for="respite_care">Respite care</label><br>
               </div>
            </div>

            <div class="button">
               <button type="submit" name="submit">Sign Up</button>
            </div>
         </div>

         <div class="volunteer-input" style="display: none;">
            <p>Available Time:</p>
            <div class="radiobutton-health2">
               <div>
                  <input type="radio" id="weekends" name="available-time" value="weekends">
                  <label for="weekends">Weekends</label><br>
               </div>
               <div>
                  <input type="radio" id="weekdays" name="available-time" value="weekdays">
                  <label for="weekdays">Weekdays</label><br>
               </div>
               <div>
                  <input type="radio" id="both" name="available-time" value="both">
                  <label for="both">Both</label><br>
               </div>
            </div>

            <p>Skill/Specialty:</p>
            <textarea id="skill" name="skill" rows="1" cols="50" placeholder="Type here"></textarea>


            <p>Service Offered:</p>
            <div class="radiobutton-health">
               <div>
                  <input type="checkbox" id="companionship2" name="service-offer" value="companionship">
                  <label for="companionship2">Companionship</label><br>
               </div>
               <div>
                  <input type="checkbox" id="daily_living_assistance2" name="service-offer" value="daily_living_assistance">
                  <label for="daily_living_assistance2">Daily Living Assistance</label><br>
               </div>
               <div>
                  <input type="checkbox" id="medical_care2" name="service-offer" value="medical_care2">
                  <label for="medical_care2">Medical care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="transportation2" name="service-offer" value="transportation">
                  <label for="transportation2">Transportation</label><br>
               </div>
               <div>
                  <input type="checkbox" id="counseling2" name="service-offer" value="counseling">
                  <label for="counseling2">Counseling</label><br>
               </div>
               <div>
                  <input type="checkbox" id="hospice_care2" name="service-offer" value="hospice_care">
                  <label for="hospice_care2">Hospice care</label><br>
               </div>
               <div>
                  <input type="checkbox" id="respite_care2" name="service-offer" value="respite_care">
                  <label for="respite_care2">Respite care</label><br>
               </div>
            </div>

            <div class="button">
               <button type="submit" name="submit">Sign Up</button>
            </div>
         </div>



      </form>
   </div>

   </div>
</body>

</html>