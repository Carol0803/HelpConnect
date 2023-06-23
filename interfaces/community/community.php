<?php

include('../../database/connect.php');

session_start();

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$this_user_role = $_SESSION['role'];
$name = $_SESSION['name'];

?>

<?php
// connect db
include('../../database/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $datetime = date("Y-m-d H:i:s");
    $action = $_POST["action"];

    if ($action === "post") {
        $post_content = $_POST["textArea"];
        $userID = $id;
        // Perform the post action
        $query = "INSERT INTO `post` (post_content, datetime, userID) VALUES ('$post_content', '$datetime', '$userID')";
        $result = mysqli_query($conn, $query);

        if ($result) {
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else if ($action === "like") {
        // Perform the like action
        $postid = $_POST["postID"];

        $query = "INSERT INTO `likes` (postID, datetime, userID) VALUES ('$postid', '$datetime', '$id')";
        $result = mysqli_query($conn, $query);

        if ($result) {
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else if ($action === "comment") {
        // Perform the comment action
        $comment = $_POST["comment"];
        $postid = $_POST["postID"];

        $query = "INSERT INTO `comment` (postID, datetime, comment_content, userID) VALUES ('$postid', '$datetime', '$comment', '$id')";
        $result = mysqli_query($conn, $query);

        if ($result) {
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}


// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Community</title>

    <!-- import custom css -->
    <link rel="stylesheet" href="../../styles/main.css" type="text/css">
    <link rel="stylesheet" href="../../styles/header.css" type="text/css">
    <link rel="stylesheet" href="../../styles/footer.css" type="text/css">
    <link rel="stylesheet" href="../../styles/community.css" type="text/css">

    <script>
        function toggleAvatar() {
            var userDetails = document.getElementById("userDetails");
            userDetails.style.display = (userDetails.style.display === "block") ? "none" : "block";
        }

        function formatText(command) {
            document.execCommand(command, false, null);
        }

        function togglePostButton() {
            var textArea = document.getElementById('textArea');
            var postButton = document.getElementById('postButton');

            if (textArea.value.trim() !== '') {
                postButton.disabled = false;
            } else {
                postButton.disabled = true;
            }
        }

        function importPicture() {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = '.jpg, .jpeg, .png';
            input.onchange = handleFileSelect;
            input.click();
        }

        function handleFileSelect(event) {
            var file = event.target.files[0];
            var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (allowedTypes.indexOf(file.type) === -1) {
                alert('Invalid file type. Please select an image file.');
                return;
            }

            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                img.classList.add('preview-image');
                document.getElementById('imagePreview').appendChild(img);
            };
            reader.readAsDataURL(file);
        }

        // function postContent() {
        //     var content = document.getElementById('myTextArea').innerHTML;
        //     var postedContent = document.createElement('div');
        //     postedContent.innerHTML = content;
        //     postedContent.classList.add('post-content');

        //     var images = document.getElementById('imagePreview').getElementsByTagName('img');
        //     for (var i = 0; i < images.length; i++) {
        //         var imgContainer = document.createElement('div');
        //         imgContainer.classList.add('image-container');

        //         var img = document.createElement('img');
        //         img.src = images[i].src;
        //         img.classList.add('preview-image');
        //         imgContainer.appendChild(img);

        //         postedContent.appendChild(imgContainer);
        //     }

        //     var postActions = document.createElement('div');
        //     postActions.innerHTML = `
        //             <button class="like-button" onclick="likePost(this)"><img src="../../assets/like.svg" alt="like" height="27px" width="27px"></button>
        //             <button class="comment-button" onclick="commentPost(this)"><img src="../../assets/comment.svg" alt="bold" height="24px" width="24px"></button>`;
        //     postedContent.appendChild(postActions);

        //     var likesContainer = document.createElement('div');
        //     likesContainer.classList.add('likes-container');
        //     postedContent.appendChild(likesContainer);

        //     var postedContentContainer = document.getElementById('postedContentContainer');
        //     var firstChild = postedContentContainer.firstChild;
        //     if (firstChild) {
        //         postedContentContainer.insertBefore(postedContent, firstChild);
        //     } else {
        //         postedContentContainer.appendChild(postedContent);
        //     }

        //     document.getElementById('myTextArea').innerHTML = ''; // Clear the text area
        //     document.getElementById('imagePreview').innerHTML = ''; // Clear the image preview
        // }

        // function likePost(button) {
        //     var postElement = button.parentNode.parentNode;
        //     var likesContainer = postElement.querySelector('.likes-container');
        //     var likeCount = likesContainer.querySelector('.like-count');
        //     var likeButton = button.querySelector('img');

        //     if (!likeCount) {
        //         likeCount = document.createElement('span');
        //         likeCount.classList.add('like-count');
        //         likeCount.textContent = 'Likes: 1';
        //         likesContainer.appendChild(likeCount);

        //         likeButton.src = "../../assets/liked.svg"; // Change the like button image to "liked"
        //         likeButton.alt = "liked";
        //     } else {
        //         var currentLikes = parseInt(likeCount.textContent.split(':')[1].trim());
        //         if (likeButton.alt === "liked") {
        //             likeCount.textContent = 'Likes: ' + (currentLikes - 1);
        //             likeButton.src = "../../assets/like.svg"; // Change the like button image back to "like"
        //             likeButton.alt = "like";
        //         } else {
        //             likeCount.textContent = 'Likes: ' + (currentLikes + 1);
        //             likeButton.src = "../../assets/liked.svg"; // Change the like button image to "liked"
        //             likeButton.alt = "liked";
        //         }
        //     }

        //     button.disabled = true; // Disable the like button to prevent multiple clicks
        // }

        function commentPost(button, postID) {
            var postElement = button.parentNode.parentNode;
            var commentContainer = postElement.querySelector('.comment-container');

            if (commentContainer) {
                commentContainer.remove(); // Remove the comment input container if it already exists
            } else {
                commentContainer = document.createElement('div');
                commentContainer.classList.add('comment-container');

                var form = document.createElement('form');
                form.method = 'post';
                form.action = '<?php echo $_SERVER["PHP_SELF"]; ?>';

                var commentInput = document.createElement('input');
                commentInput.type = 'text';
                commentInput.name = 'comment';
                commentInput.placeholder = 'Enter your comment...';
                commentInput.classList.add('comment-input');

                var inputPostID = document.createElement('input');
                inputPostID.type = 'hidden';
                inputPostID.name = 'postID';
                inputPostID.value = postID;

                var inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = 'comment';

                var commentButton = document.createElement('button');
                commentButton.textContent = 'Send';
                commentButton.classList.add('submit-comment-button');
                commentButton.onclick = function() {

                    form.appendChild(commentInput);
                    form.appendChild(inputPostID);
                    form.appendChild(inputAction);

                    document.body.appendChild(form);
                    form.submit();
                    submitComment(postElement, commentInput);
                };

                commentContainer.appendChild(commentInput);
                commentContainer.appendChild(commentButton);

                postElement.appendChild(commentContainer); // Add the comment input container
            }
        }

        function likePost(postID) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '<?php echo $_SERVER["PHP_SELF"]; ?>';

            var inputPostID = document.createElement('input');
            inputPostID.type = 'hidden';
            inputPostID.name = 'postID';
            inputPostID.value = postID;

            var inputAction = document.createElement('input');
            inputAction.type = 'hidden';
            inputAction.name = 'action';
            inputAction.value = 'like';

            form.appendChild(inputPostID);
            form.appendChild(inputAction);

            document.body.appendChild(form);
            form.submit();
        }

        // function commentPost(postID) {
        //     var form = document.createElement('form');
        //     form.method = 'post';
        //     form.action = '<?php echo $_SERVER["PHP_SELF"]; ?>';

        //     var inputPostID = document.createElement('input');
        //     inputPostID.type = 'hidden';
        //     inputPostID.name = 'postID';
        //     inputPostID.value = postID;

        //     var inputAction = document.createElement('input');
        //     inputAction.type = 'hidden';
        //     inputAction.name = 'action';
        //     inputAction.value = 'comment';

        //     var commentInput = document.createElement('input');
        //     commentInput.type = 'text';
        //     commentInput.name = 'comment';
        //     commentInput.placeholder = 'Enter your comment...';

        //     var submitButton = document.createElement('button');
        //     submitButton.textContent = 'Submit';

        //     form.appendChild(inputPostID);
        //     form.appendChild(inputAction);
        //     form.appendChild(commentInput);
        //     form.appendChild(submitButton);

        //     document.body.appendChild(form);
        //     form.submit();
        // }


        function submitComment(postElement, commentInput) {
            var commentText = commentInput.value;
            if (commentText.trim() === '') {
                alert('Please enter a comment.');
                return;
            }

            var username = '<?php echo $name; ?>';
            var commentContent = username + ': ' + commentText;

            var comment = document.createElement('div');
            comment.classList.add('comment');
            comment.textContent = commentContent;

            var commentContainer = postElement.querySelector('.comment-container');
            commentContainer.parentNode.insertBefore(comment, commentContainer);

            commentInput.value = ''; // Clear the comment input
            commentContainer.remove(); // Remove the comment input container
        }
    </script>
</head>

<body>

    <!-- header -->
    <header>
        <div class="header">
            <img src="../../assets/logo.svg" alt="logo" height="55px">

            <!-- menu -->
            <nav class="menu">
                <a href="../../interfaces/business-info/aboutUs.php">Home</a>
                <a href="../../interfaces/service/discover.php">Service</a>
                <a href="#" class="active">Community</a>
                <a href="../../interfaces/profile/userProfile.php">Profile</a>
            </nav>

            <button class="avatar-button fas" type="button" onclick="toggleAvatar()">
                <img src="../../assets/profile-icon.svg" alt="profile" class="avatar-text">
            </button>

            <!-- User Details Box -->
            <div id="userDetails" class="user-box">
                <p class="role" style="text-transform: capitalize;"><?php echo $this_user_role; ?></p>
                <p><strong>Username: </strong><?php echo $name; ?></p>
                <p><strong>Email: </strong><?php echo $email; ?></p>
                <button><a href="../authentication/logout.php" style="text-decoration: none; color: white;">Logout</a></button>

            </div>
        </div>

    </header>

    <!-- community -->
    <div class="community">

        <!-- breadcrumb -->
        <div class="breadcrumb">
            <a href="#">Community</a>
        </div>

        <!-- title-->
        <h1>Community</h1>

        <div class="content">

            <!-- writing area -->
            <div class="writing-area">
                <h3>Share something to your feed</h3>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <textarea name="textArea" id="textArea" class="text-area" contenteditable="true" oninput="togglePostButton()"></textarea>
                    <div id="imagePreview"></div>

                    <div class="action-icon-content">
                        <div class="action-icon-container">
                            <button class="action-icon" onclick="formatText('bold')"><img src="../../assets/bold-icon.svg" alt="bold" height="14px" width="15px"></button>
                            <button class="action-icon" onclick="formatText('underline')"><img src="../../assets/italic-icon.svg" alt="underline" height="14px" width="15px"></button>
                            <button class="action-icon" onclick="formatText('italic')"><img src="../../assets/underline-icon.svg" alt="italic" height="17px" width="17px"></button>
                            <span class="vertical-divider"></span>
                            <button class="action-icon" onclick="importPicture()"><img src="../../assets/photo-icon.svg" alt="picture" height="17px" width="17px"></button>
                        </div>

                        <button type="submit" class="post-button" id="postButton" disabled>Post</button>
                    </div>

                    <input type="hidden" name="action" value="post">
                </form>

            </div>
        </div>

        <hr style=" margin-left: 10px; margin-top: 30px; margin-bottom: 30px;">

        <!-- posting area -->
        <div>
            <div class="posted-content" id="postedContentContainer">

                <?php

                include('../../database/connect.php');

                $query = "SELECT * FROM post WHERE userID = '$id' ORDER BY datetime DESC";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $postID = $row['postID'];
                        $postContent = $row['post_content'];
                        $datetime = $row['datetime'];

                        // // Get the post's images (assuming $conn is the database connection object)
                        // $imageQuery = "SELECT * FROM post_images WHERE postID = '$postID'";
                        // $imageResult = mysqli_query($conn, $imageQuery);

                        // Start generating the HTML structure for each post
                        echo '<div>';
                        echo '<div class="post-content">';

                        // User section
                        echo '<div class="post-user">';
                        echo '<button class="avatar-button">';
                        echo '<img src="../../assets/profile-icon.svg" alt="profile">';
                        echo '</button>';
                        echo '<h3>' . $name . '</h3>';
                        echo '<p>' . $datetime . '</p>';
                        echo '</div>';

                        // Post content section
                        echo '<div style="padding-left: 10px;">';
                        echo '<p>' . $postContent . '</p>';

                        // Images section
                        // echo '<div>';
                        // while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                        //     $imageURL = $imageRow['image_url'];
                        //     echo '<img src="' . $imageURL . '" alt="post-image" class="post-image">';
                        // }
                        // echo '</div>';

                        echo '</div>';
                        echo '<hr>';
                        echo '<div style="display:flex; flex-direction:row; align-items: center;">';

                        // like button
                        $likeQuery = "SELECT COUNT(*) AS likeCount FROM likes WHERE postID = '$postID'";
                        $likeResult = mysqli_query($conn, $likeQuery);
                        $likeRow = mysqli_fetch_assoc($likeResult);
                        $likeCount = $likeRow['likeCount'];

                        $likedQuery = "SELECT * FROM likes WHERE postID = '$postID' AND userID = '$id'";
                        $likedResult = mysqli_query($conn, $likedQuery);
                        $isLiked = false;

                        if ($likedResult && mysqli_num_rows($likedResult) > 0) {
                            $isLiked = true;
                        }

                        echo '<button id="like-button-' . $postID . '" class="like-button" onclick="likePost(' . $postID . ')"';
                        if ($isLiked) {
                            echo ' disabled'; // Disable the button if the post is liked
                        }
                        echo '>';
                        echo '<img src="../../assets/';
                        if ($isLiked) {
                            echo 'liked.svg'; // Change the image source to the liked image
                        } else {
                            echo 'like.svg'; // Use the default like image
                        }
                        echo '" alt="like" height="27px" width="27px">';
                        echo '</button>';
                        echo '<span style="font-size: 18px; padding-bottom: 5px;" id="like-count-' . $postID . '">' . $likeCount . ' like</span>';

                        // comment button
                        echo '<button class="comment-button" onclick="commentPost(this, ' . $postID . ')"><img src="../../assets/comment.svg" alt="bold" height="24px" width="24px"></button>';

                        echo '</div>';
                        echo '<hr>';

                        // Comments section
                        $query2 = "SELECT * FROM comment WHERE postID = '$postID' ORDER BY datetime DESC";
                        $result2 = mysqli_query($conn, $query2);

                        if ($result2 && mysqli_num_rows($result2) > 0) {
                            while ($row = mysqli_fetch_assoc($result2)) {
                                $userID = $row['userID'];
                                $comment = $row['comment_content'];
                                $datetime = $row['datetime'];

                                $query3 = "SELECT * FROM user WHERE userID = '$userID'";
                                $result3 = mysqli_query($conn, $query3);

                                if ($result3 && mysqli_num_rows($result3) > 0) {
                                    while ($userRow = mysqli_fetch_assoc($result3)) {
                                        $username = $userRow['firstname'] . ' ' . $userRow['lastname'];

                                        echo '<div style="padding-left: 10px;">';
                                        echo '<p style="font-size: 18px; display:flex; flex-direction:row; align-items: center; gap: 10px;"><strong>' . $username . '</strong>  ' . $comment . ' <span style="font-size: 12px;">  ' . $datetime . '</span> </p>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No posts found.</p>';
                }

                // Close the database connection
                mysqli_close($conn);
                ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../authentication/footer.php') ?>
</body>

</html>