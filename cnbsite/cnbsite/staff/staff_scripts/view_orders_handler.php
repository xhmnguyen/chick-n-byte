<?php
require_once __DIR__ . '/../../phpscripts/connect.php';

session_start();

// Ensure the user is a manager
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../staff_login.php");
    exit();
}

$error_message = "";
$orders = [];

try {
    // Fetch all orders with their details - left join for null values
$stmt = $conn->prepare("SELECT o.order_id, o.customer_name, o.customer_email, o.total_price, 
                               o.order_type, o.delivery_address, o.order_notes, o.status, o.created_at,
                               GROUP_CONCAT(CONCAT(oi.quantity, 'x ', m.name) SEPARATOR ', ') AS items
                        FROM orders o
                        LEFT JOIN order_items oi ON o.order_id = oi.order_id
                        LEFT JOIN menu_items m ON oi.menu_item_id = m.menu_item_id
                        WHERE o.status != 'completed'
                        GROUP BY o.order_id
                        ORDER BY o.created_at DESC");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "An error occurred while fetching the orders.";
}

// Return the results to the frontend
return [
    'orders' => $orders,
    'error_message' => $error_message
];
?>