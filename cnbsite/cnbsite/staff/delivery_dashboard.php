<?php
require_once 'staff_scripts/delivery_orders_handler.php';

$delivery_data = include 'staff_scripts/delivery_orders_handler.php';
$orders = $delivery_data['orders'];
$error_message = $delivery_data['error_message'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
  <!-- HEADER -->
    <?php include 'staff_scripts/staff_header.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="staff-section">
    <h1>Driver Dashboard</h1>
    <p>View orders assigned to you and track your deliveries.</p>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Assigned Orders -->
    <div class="staff-cards">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="staff-card">
                    <h2>Order #<?php echo htmlspecialchars($order['order_id']); ?></h2>
                    <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></p>
                    <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address'] ?? 'N/A'); ?></p>
                    <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes'] ?? 'None'); ?></p>
                    <p><strong>Items:</strong> <?php echo htmlspecialchars($order['items']); ?></p>
                    <p><strong>Status:</strong> <span class="status"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span></p>

                    <!-- Status Update Buttons -->
                    <form action="staff_scripts/delivery_orders_handler.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <?php if ($order['status'] === 'ready'): ?>
                            <button type="submit" name="status" value="out_for_delivery">Set to Out for Delivery</button>
                        <?php elseif ($order['status'] === 'out_for_delivery'): ?>
                            <button type="submit" name="status" value="completed">Set to Completed</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-orders">
                <p>No assigned orders found.</p>
             </div>
        <?php endif; ?>
    </div>
  </div>

    <!-- Footer -->
    <?php include '../phpscripts/footer.php'; ?>

</body>
</html>