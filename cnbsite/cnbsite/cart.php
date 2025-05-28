<?php
session_start();
require_once 'phpscripts/connect.php';

$session_id = session_id();
$query = "SELECT c.cart_id, m.name, m.price, c.quantity, (m.price * c.quantity) AS total
          FROM cart c
          JOIN menu_items m ON c.menu_item_id = m.menu_item_id
          WHERE c.session_id = :session_id";
$stmt = $conn->prepare($query);
$stmt->execute(['session_id' => $session_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

 <!-- Header -->
    <?php include 'phpscripts/header.php';?>

<div class="content">

    <!-- Display Error Message -->
    <?php if (isset($_GET['error'])): ?>
    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <h1>Your Cart</h1>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Subtotal: $<?php echo number_format($subtotal, 2); ?></h3>



    <div class="cart-actions">
        <form action="phpscripts/clear_cart.php" method="POST">
            <button type="submit" class="clear-cart">Clear Cart</button>
        </form>
            
        <form action="checkout.php" method="GET">
            <button type="submit" class="checkout">Proceed to Checkout</button>
        </form>

    </div>
</div>

 <!-- Footer -->
    <?php include 'phpscripts/footer.php'; ?>

</body>
</html>