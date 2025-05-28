<?php
require_once __DIR__ . '/../../phpscripts/connect.php';

session_start();

// Ensure the user is a manager
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../staff_login.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order-id']);
    $driver_id = intval($_POST['driver-id']);

    // Validate inputs
    if (empty($order_id) || empty($driver_id)) {
        $error_message = "Order ID and Driver ID are required.";
        header("Location: ../assign_orders.php?error=" . urlencode($error_message));
        exit();
    }

    try {
        // Validate the order
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id AND order_type = 'delivery' AND status = 'ready'");
        $stmt->execute(['order_id' => $order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            $error_message = "Invalid order ID or the order is not eligible for assignment.";
        } else {
            // Assign the order to the driver
            $stmt = $conn->prepare("UPDATE orders SET assigned_driver_id = :driver_id, status = 'out_for_delivery' WHERE order_id = :order_id");
            $stmt->execute(['driver_id' => $driver_id, 'order_id' => $order_id]);

            $success_message = "Order #$order_id has been successfully assigned to Driver.";
        }
    } catch (PDOException $e) {
        $error_message = "An error occurred while assigning the order.";
    }
}

// Redirect back to the assign orders page with a success or error message
if (!empty($error_message)) {
    header("Location: ../assign_orders.php?error=" . urlencode($error_message));
    exit();
} elseif (!empty($success_message)) {
    header("Location: ../assign_orders.php?success=" . urlencode($success_message));
    exit();
}
?>