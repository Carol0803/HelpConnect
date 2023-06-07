// $(document).ready(function () {
//     $.ajax({
//         url: '../../server/service/discover.php',
//         dataType: 'json',
//         success: function (data) {

//             // // Process the user data
//             // for (var i = 0; i < data.length; i++) {
//             //     var userID = data[i].userID;
//             //     var email = data[i].email;
//             //     // Display the user data or perform other operations
//             //     console.log('User ID: ' + userID + ', Email: ' + email);
//             // }

//             var userListContainer = document.getElementById('userList');

//             for (var i = 0; i < data.length; i++) {
//                 var userID = data[i].userID;
//                 var email = data[i].email;

//                 // Create a new HTML element to display user data
//                 var userElement = document.createElement('div');
//                 userElement.innerHTML = 'User ID: ' + userID + ', Email: ' + email;

//                 // Append the user element to the user list container
//                 userListContainer.appendChild(userElement);
//             }
//         }
//     });
// });

// $(document).ready(function () {
//     $.ajax({
//         url: '../../server/service/discover.php',
//         dataType: 'json',
//         success: function (data) {
//             // Process the user data
//             for (var i = 0; i < data.length; i++) {
//                 var userID = data[i].userID;
//                 var name = data[i].firstname + ' ' + data[i].lastname;
//                 // Display the user data or perform other operations
//                 console.log('User ID: ' + userID + ', Name: ' + name);
//             }
//         },
//         error: function (xhr, status, error) {
//             console.log('AJAX request error:');
//             console.log('Status:', status);
//             console.log('Error:', error);
//             console.log('Response:', xhr.responseText);
//         }
//     });
// });

// // avatar
// document.getElementById('UserAvatarText').addEventListener('click', function() {
//     if(this.getAttribute('aria-expanded') === 'true') {
//       this.setAttribute('aria-expanded', 'false');
//     } else {
//       this.setAttribute('aria-expanded', 'true');
//     }
//   });

