<?php
require_once 'staff_scripts/kitchen_orders_handler.php';

$kitchen_data = include 'staff_scripts/kitchen_orders_handler.php';
$orders = $kitchen_data['orders'];
$error_message = $kitchen_data['error_message'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- HEADER -->
<?php include 'staff_scripts/staff_header.php'; ?>


<div class="staff-section">
    <h1>Staff Dashboard</h1>
    <p>Manage order progress and update statuses below.</p>

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
                    <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address'] ?? 'N/A'); ?></p>
                    <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes'] ?? 'None'); ?></p>
                    <p><strong>Items:</strong> <?php echo htmlspecialchars($order['items']); ?></p>
                    <p><strong>Status:</strong> <span class="status"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span></p>

                    <!-- Status Update Buttons -->
                    <form action="staff_scripts/kitchen_orders_handler.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <?php if ($order['status'] === 'pending'): ?>
                            <button type="submit" name="status" value="preparing">Set to Preparing</button>
                        <?php elseif ($order['status'] === 'preparing'): ?>
                            <button type="submit" name="status" value="ready">Set to Ready</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-orders">
                <p>No active orders found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


    <!-- Footer -->
    <?php include '../phpscripts/footer.php'; ?>


</body>
</html>