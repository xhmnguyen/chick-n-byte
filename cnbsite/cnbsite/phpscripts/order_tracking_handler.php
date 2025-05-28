<?php
require_once 'connect.php';

// Initialize variables
$error_message = "";
$order = null;
$orders = [];

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Fetch all orders associated with the logged-in user
        $stmt = $conn->prepare("SELECT order_id, total_price, order_type, delivery_address, order_notes, status
                                 FROM orders 
                                 WHERE user_id = (SELECT user_id FROM users WHERE username = :username)");
        $stmt->execute(['username' => $username]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all orders as an array

        if (!$orders) {
            $error_message = "No orders found for your account.";
        }
    } catch (PDOException $e) {
        $error_message = "An error occurred while fetching your orders.";
    }
} else {
    // Non-logged-in user: Validate order_id and email
    if (isset($_GET['order_id']) && isset($_GET['email'])) {
        $order_id = intval($_GET['order_id']);
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    
        try {
            // Fetch the order details based on Order ID and Email
            $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id AND customer_email = :email");
            $stmt->execute(['order_id' => $order_id, 'email' => $email]); 
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$order) {
                $error_message = "Order not found. Please check your Order ID and Email.";
            }
        } catch (PDOException $e) {
            $error_message = "An error occurred while fetching the order details.";
        }
    } else {
        $error_message = "Please enter both your Order ID and Email to track your order.";
    }
}

// Return the results to the frontend
return [
    'order' => $order,
    'orders' => $orders,
    'error_message' => $error_message
];
?>