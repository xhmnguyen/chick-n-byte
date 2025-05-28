<?php
session_start();
require_once 'connect.php';

$session_id = session_id();

try {
    // Delete all items from the cart for the current session
    $query = "DELETE FROM cart WHERE session_id = :session_id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['session_id' => $session_id]);

    // Redirect back to the cart page
    header("Location: ../cart.php");
    exit();
} catch (PDOException $e) {
    echo "Error clearing cart: " . $e->getMessage();
}
?>