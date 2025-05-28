<?php
session_start();
require_once '../../phpscripts/connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare SQL query to fetch staff details
        $stmt = $conn->prepare("SELECT * FROM staff WHERE username = :username");
        $stmt->bindParam(':username', var: $username);
        $stmt->execute();
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($staff && password_verify($password, $staff['password'])) {
            // Login successful, store staff info in session
            $_SESSION['staff_id'] = $staff['id'];
            $_SESSION['role'] = $staff['role'];

            // Redirect to the staff dashboard
            header("Location: ../staff_dashboard.php");
            exit();
        } else {
            // Invalid credentials, redirect back with an error message
            $error = "Invalid username or password.";
            header("Location: ../staff_login.php?error=" . urlencode($error));
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        $error = "An error occurred. Please try again later.";
        header("Location: ../staff_login.php?error=" . urlencode($error));
        exit();
    }
}
?>