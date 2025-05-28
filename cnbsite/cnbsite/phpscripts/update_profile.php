<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to the sign-in page if the user is not logged in
    header("Location: ../signin.php");
    exit();
}

require_once 'connect.php';

// Initialize variables for error and success messages
$error_message = "";
$success_message = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $username = $_SESSION['username']; // Username is stored in the session

    try {
        // Update the user's information in the database
        $stmt = $conn->prepare("UPDATE users SET email = :email, address = :address WHERE username = :username");
        $stmt->execute([
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':username' => $username
        ]);

        // Redirect back to the profile page with a success message
        $success_message = "Profile updated successfully.";
        header("Location: ../profile.php?success=" . urlencode($success_message));
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        $error_message = "An error occurred while updating your profile. Please try again.";
        header("Location: ../profile.php?error=" . urlencode($error_message));
        exit();
    }
}
?>