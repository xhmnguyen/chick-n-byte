<?php
require_once 'connect.php'; 
require_once 'included_functions(1).php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_encrypt($_POST['password']); 

    // Validate inputs
    if (empty($email) || empty($username) || empty($password)) {
        header("Location: ../signup.php?error=All fields are required");
        exit();
    }

    // Prepare SQL query to insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");

    
    try {
        $stmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password
        ]);
        header("Location: ../signin.php");
        exit();
        //If successful, redirect to the signin page
    }  catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            $error_message = "Email or username already exists.";
        } else {
            $error_message = "Error: " . $e->getMessage();
        }
        // Redirect back to signup.html with the error message
        header("Location: ../signup.php?error=" . urlencode($error_message));
        exit();
    }
}
?>