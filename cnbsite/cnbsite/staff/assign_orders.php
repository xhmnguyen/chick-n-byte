<?php
require_once 'staff_scripts/assign_orders_handler.php';

// Fetch the list of drivers
try {
    $stmt = $conn->prepare("SELECT id, username FROM staff WHERE role = 'delivery_driver'");
    $stmt->execute();
    $drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $drivers = [];
    $error_message = "Failed to fetch drivers.";
}

// Fetch the list of available orders
try {
    $stmt = $conn->prepare("SELECT order_id, customer_name, total_price, order_notes 
                            FROM orders 
                            WHERE order_type = 'delivery' AND status IN ('ready', 'preparing')");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $orders = [];
    $error_message = "Failed to fetch orders.";
}

// Display success or error messages
$success_message = $_GET['success'] ?? '';
$error_message = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Orders - Chick-n-Byte</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="home-page">
  <!-- HEADER -->
    <?php include 'staff_scripts/staff_header.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="staff-section">
    <h1>Assign Orders</h1>
    <p>Assign deliveries to drivers and track their progress.</p>

    <!-- Display Success or Error Message -->
    <?php if (!empty($success_message)): ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($success_message); ?></p>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Display Available Orders -->
    <div class="staff-cards">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="staff-card">
                    <h2>Order #<?php echo htmlspecialchars($order['order_id']); ?></h2>
                    <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></p>
                    <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
                    <p><strong>Order Notes:</strong> <?php echo htmlspecialchars($order['order_notes'] ?? 'None'); ?></p>

                    <!-- Assign Driver Form -->
                    <form action="staff_scripts/assign_orders_handler.php" method="POST">
                        <input type="hidden" name="order-id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <div class="form-group">
                            <label for="driver-id-<?php echo htmlspecialchars($order['order_id']); ?>">Assign Driver:</label>
                            <select id="driver-id-<?php echo htmlspecialchars($order['order_id']); ?>" name="driver-id" required>
                                <?php foreach ($drivers as $driver): ?>
                                    <option value="<?php echo htmlspecialchars($driver['id']); ?>">
                                        <?php echo htmlspecialchars($driver['username']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit">Assign Driver</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style = "empty-orders">
                <p style>No orders available for assignment.</p>
            </div>
        <?php endif; ?>
    </div>
  </div>

    <!-- Footer -->
    <?php include '../phpscripts/footer.php'; ?>

</body>
</html>