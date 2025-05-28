<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to the sign-in page if the user is not logged in
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Landing Page after sigup - prompts to log out or profile settings-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <!-- Header -->
    <?php
    include 'phpscripts/header.php';
    ?>


    <div class="container">
        <p>You are now logged in.</p>
        <a href="profile.php">Go to Profile</a>
        <a href="phpscripts/logout.php">Log Out</a>
    </div>


    <!-- Footer -->
    <?php
    include 'phpscripts/footer.php';
    ?>

</body>
</html>