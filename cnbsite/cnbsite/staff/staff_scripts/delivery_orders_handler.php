<?php
require_once __DIR__ . '/../../phpscripts/connect.php';

session_start();

// Ensure the user is a delivery driver
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'delivery_driver') {
    header("Location: ../staff_login.php");
    exit();
}

$error_message = "";
$orders = [];

// Fetch orders assigned to the delivery driver
try {
    $stmt = $conn->prepare("SELECT o.order_id, o.customer_name, o.delivery_address, o.order_notes, 
                                   o.status, GROUP_CONCAT(CONCAT(oi.quantity, 'x ', m.name) SEPARATOR ', ') AS items
                            FROM orders o
                            LEFT JOIN order_items oi ON o.order_id = oi.order_id
                            LEFT JOIN menu_items m ON oi.menu_item_id = m.menu_item_id
                            WHERE o.status IN ('ready', 'out_for_delivery') AND o.order_type = 'delivery'
                            GROUP BY o.order_id
                            ORDER BY o.created_at ASC");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "An error occurred while fetching orders.";
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];

    try {
        // Update the order status
        $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
        $stmt->execute(['status' => $new_status, 'order_id' => $order_id]);

        header("Location: ../delivery_dashboard.php?success=Order #$order_id updated to $new_status.");
        exit();
    } catch (PDOException $e) {
        $error_message = "Failed to update the order status.";
    }
}

// Return the results to the frontend
return [
    'orders' => $orders,
    'error_message' => $error_message
];
?>