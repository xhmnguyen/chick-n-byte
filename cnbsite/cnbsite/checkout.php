<?php
session_start();
require_once 'phpscripts/connect.php';

// Fetch cart items for display
$session_id = session_id();
$query = "SELECT c.cart_id, m.name, m.price, c.quantity, (m.price * c.quantity) AS total
          FROM cart c
          JOIN menu_items m ON c.menu_item_id = m.menu_item_id
          WHERE c.session_id = :session_id";
$stmt = $conn->prepare($query);
$stmt->execute(['session_id' => $session_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate subtotal
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['total'];
}

// Redirect to cart page if there are no items in the cart
if (count($cart_items) === 0) {
    header("Location: cart.php?error=" . urlencode("Your cart is empty. Please add items before checking out."));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<?php include 'phpscripts/header.php'; ?>

<div class="content">
    <h1>Checkout</h1>

    <!-- Display Cart Items -->
    <h2>Your Order</h2>
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

    <!-- Display Subtotal -->
    <h3>Subtotal: $<?php echo number_format($subtotal, 2); ?></h3>

    <!-- Checkout Form -->
    <h2>Delivery or Pickup Details</h2>
    <form action="phpscripts/process_checkout.php" method="POST" class="checkout-form">
        <?php if (!isset($_SESSION['username'])): ?>
            <!-- Guest User Fields -->
            <label for="customer_name">Name:</label>
            <input type="text" id="customer_name" name="customer_name" placeholder="Enter your name" required>

            <label for="customer_email">Email:</label>
            <input type="email" id="customer_email" name="customer_email" placeholder="Enter your email" required>
        <?php endif; ?>

        <label for="order_type">Order Type:</label>
        <select id="order_type" name="order_type" required>
            <option value="pickup">Pickup</option>
            <option value="delivery">Delivery</option>
        </select>

        <div id="address-section" style="display: none;">
            <label for="delivery_address">Delivery Address:</label>
            <textarea id="delivery_address" name="delivery_address" placeholder="Enter your address"></textarea>
        </div>

        <label for="order_notes">Order Notes (optional):</label>
        <textarea id="order_notes" name="order_notes" placeholder="E.g., Leave at the front door, no pickles, etc."></textarea>

        <button type="submit" class="checkout">Place Order</button>
    </form>
</div>

<!-- Footer -->
<?php include 'phpscripts/footer.php'; ?>

<script>
    // JavaScript to toggle the address field if delivery or pickup is selected
    document.getElementById('order_type').addEventListener('change', function () {
        const addressSection = document.getElementById('address-section');
        const deliveryAddress = document.getElementById('delivery_address');

        if (this.value === 'delivery') {
            addressSection.style.display = 'block';
            deliveryAddress.required = true;
        } else {
            addressSection.style.display = 'none';
            deliveryAddress.required = false;
        }
    });
</script>

</body>
</html>