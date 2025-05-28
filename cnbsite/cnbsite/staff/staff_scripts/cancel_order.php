<?php
require_once '../../phpscripts/connect.php';

session_start();

// Ensure the user is a manager
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../staff_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);

    try {
        // Debugging: Check if order_id is being passed correctly
        if (empty($order_id)) {
            throw new Exception("Order ID is missing or invalid.");
        }

        // Delete related rows in the order_items table
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);

        // Delete the order from the orders table
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);

        // Check if the order was actually deleted
        if ($stmt->rowCount() === 0) {
            throw new Exception("Order not found or could not be deleted.");
        }

        // Redirect back to the view orders page with a success message
        header("Location: ../view_orders.php?success=Order #$order_id has been canceled.");
        exit();
    } catch (Exception $e) {
        // Redirect back with an error message
        header("Location: ../view_orders.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>