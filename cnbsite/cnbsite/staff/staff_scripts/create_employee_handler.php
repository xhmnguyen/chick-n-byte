<?php
require_once '../../phpscripts/connect.php';
require_once '../../phpscripts/included_functions(1).php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Username'];
    $password = password_encrypt($_POST['password']);
    $role = $_POST['role'];

    // Validate inputs
    if (empty($username) || empty($password) || empty($role)) {
        header("Location: ../create_employee.php?error=All fields are required");
        exit();
    }

    // Prepare SQL query to insert user into the database
     $stmt = $conn->prepare("INSERT INTO staff (username, password, role) VALUES (:username, :password, :role)");

    try {
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':role' => $role
        ]);

        // Redirect to the create_employee page with a success message
        header("Location: ../create_employee.php?success=Employee account created successfully");
        exit();
    } catch (PDOException $e) {
        // Handle duplicate username error
        if ($e->getCode() == 23000) {
            $error_message = "Username already exists.";
        } else {
            $error_message = "An error occurred: " . $e->getMessage();
        }
        header("Location: ../create_employee.php?error=" . urlencode($error_message));
        exit();
    }
}
?>