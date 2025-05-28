<?php

require_once 'staff_scripts/view_orders_handler.php';

// Fetch the results from the backend script
$view_orders_data = include 'staff_scripts/view_orders_handler.php';
$orders = $view_orders_data['orders'];
$error_message = $view_orders_data['error_message'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Chick-n-Byte</title>
    <link rel="icon" href="../images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="home-page">

  <!-- HEADER -->
  <?php include 'staff_scripts/staff_header.php'; ?>

<!-- MAIN CONTENT -->
<div class="staff-section">
    <h1>View Orders</h1>
    <p>Here you can view all customer orders and manage their status.</p>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Order List -->
    <div class="staff-cards">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="staff-card">
                    <h2>Order #<?php echo htmlspecialchars($order['order_id']); ?></h2>
                    <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email'] ?? 'N/A'); ?></p>
                    <p><strong>Items:</strong> <?php echo htmlspecialchars($order['items']); ?></p>
                    <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
                    <p><strong>Order Type:</strong> <?php echo ucfirst(htmlspecialchars($order['order_type'])); ?></p>
                    <p><strong>Status:</strong> <span class="status"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span></p>
                    <?php if (!empty($order['delivery_address'])): ?>
                        <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                    <?php endif; ?>
                    <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes'] ?? 'None'); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>

                    <!-- Cancel Order Button -->
                    <form action="staff_scripts/cancel_order.php" method="POST" style="margin-top: 10px;">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <button type="submit" class="cancel-button">Cancel Order</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-orders">
            <p>No orders found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../phpscripts/footer.php'; ?>


</body>
</html>