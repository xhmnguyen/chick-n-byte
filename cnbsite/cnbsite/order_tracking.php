<?php
session_start();
// Include the backend logic for order tracking
require_once 'phpscripts/order_tracking_handler.php';

// Fetch the results from the backend script
$tracking_data = include 'phpscripts/order_tracking_handler.php';
$order = $tracking_data['order'];
$error_message = $tracking_data['error_message'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<?php include 'phpscripts/header.php'; ?>

<div class="content">
    <h1 class="tracking-title">Order Tracking</h1>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Order Tracking Form -->
    <?php if (isset($_SESSION['username'])): ?>
        <!-- Logged-in User Form -->
        <form action="order_tracking.php" method="GET" class="tracking-form">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! You can view all your orders below.</p>
        </form>
    <?php else: ?>
        <!-- Non-Logged-In User Form -->
        <form action="order_tracking.php" method="GET" class="tracking-form">
            <label for="order_id">Enter Your Order ID:</label>
            <input type="text" id="order_id" name="order_id" placeholder="Order ID" required>

            <label for="email">Enter Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <button type="submit">Track Order</button>
        </form>
    <?php endif; ?>

    <!-- Display Order Details -->
    <?php if ($order): ?>
    <div class="order-details">
        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p><strong>Order Type:</strong> <?php echo ucfirst(htmlspecialchars($order['order_type'])); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($order['status'])); ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
        <?php if (!empty($order['delivery_address'])): ?>
            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
        <?php endif; ?>
        <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes']); ?></p>
    </div>
    <?php elseif (!empty($orders)): ?>
    <div class="order-list">
        <h2>Your Orders</h2>
        <?php foreach ($orders as $order): ?>
            <div class="order-summary">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
             <p><strong>Order Type:</strong> <?php echo ucfirst(htmlspecialchars($order['order_type'])); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($order['status'])); ?></p>
            <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
        <?php if (!empty($order['delivery_address'])): ?>
            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
        <?php endif; ?>
            <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

<!-- Footer -->
<?php include 'phpscripts/footer.php'; ?>

</body>
</html>