<?php
// Start the session to manage user state
session_start();

// Include the database connection file
require_once 'phpscripts/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <?php 
    include 'phpscripts/header.php'; 
    ?>

    <div class="container">
        <div class="signh">
            <img src="images/logo.png" alt="Logo">
            <h1>Sign Up</h1>
        </div>

        <!-- Display Error Message -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <!-- Sign-Up Form -->
        <form action="phpscripts/signup_handler.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
        </form>
        <p style="text-align: center;">Already have an account? <a href="signin.php" style="color: #e51636;">Sign In</a></p>
    </div>

    <!-- Footer -->
    <?php include 'phpscripts/footer.php'; ?>
</body>
</html>