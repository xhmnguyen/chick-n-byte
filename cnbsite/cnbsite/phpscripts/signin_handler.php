<?php
session_start(); 
require_once 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"]; 
    $password = $_POST["password"];

    try {
        // Prepare SQL query to fetch user from the database
        $stmt = $conn->prepare("SELECT username, user_id, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username); 
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, store user info in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id']; 
            
            // Redirect to landing page
            header("Location: ../landing.php");
            exit();
        } else {
            // Redirect back to the sign-in page with an error message (invalid credentials)
            $error_message = "Incorrect username or password.";
            header("Location: ../signin.php?error=" . urlencode($error_message));
            exit();
        }
    } catch (PDOException $e) {
        // Redirect back to the sign-in page with error message
        $error_message = "An error occurred. Please try again later.";
        header("Location: ../signin.php?error=" . urlencode($error_message));
        exit();
    }
}
?>