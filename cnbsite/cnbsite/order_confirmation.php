<?php
require_once 'phpscripts/connect.php';

$order_id = $_GET['order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
$stmt->execute(['order_id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT m.name, oi.quantity, (m.price * oi.quantity) AS total
                        FROM order_items oi
                        JOIN menu_items m ON oi.menu_item_id = m.menu_item_id
                        WHERE oi.order_id = :order_id");
$stmt->execute(['order_id' => $order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<?php include 'phpscripts/header.php'; ?>

<div class="content">
    <h1 class="confirmation-title">Order Confirmation</h1>
    <p class="confirmation-message">Thank you for your order! Your order has been successfully placed.</p>
    <p class="confirmation-message">Track your order <strong><a href = "order_tracking.php">here</a></strong></p>
    <p class="confirmation-message">If you are not logged in, you will need to use your order id and email</p>
    <p class="confirmation-message">Pay in cash when you recieve your order.</p>
    <div class="order-summary">
        <p><strong>Order ID:</strong> <?= $order['order_id']; ?></p>
        <p><strong>Order Type:</strong> <?= ucfirst($order['order_type']); ?></p>
        <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2); ?></p>
        <?php if ($order['delivery_address']): ?>
            <p><strong>Delivery Address:</strong> <?= htmlspecialchars($order['delivery_address']); ?></p>
        <?php endif; ?>
        <?php if ($order['order_notes']): ?>
            <p><strong>Order Notes:</strong> <?= htmlspecialchars($order['order_notes']); ?></p>
        <?php endif; ?>
    </div>

    <h2 class="order-items-title">Order Items</h2>
    <table class="order-items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td>$<?= number_format($item['total'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<?php include 'phpscripts/footer.php'; ?>

</body>
</html>