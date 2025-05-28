<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header -->
    <?php include 'phpscripts/header.php'; ?>

    <!-- Profile Settings -->
    <div class="container">
    
        <div class="profile-section">
            <h1>User Profile</h1>

            <!-- Display Username -->
                <p id="username">User: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

            <!-- Form to update user information -->
            <form action="phpscripts/update_profile.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="(123) 456-7890">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Address">
                </div>
                <div class="form-group">
                    <button type="submit">Save Changes</button>
                </div>
            </form>

            <div class="log-out">
                <form action="phpscripts/logout.php" method="POST">
                    <button type="submit">Sign Out</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'phpscripts/footer.php'; ?>

</body>
</html>