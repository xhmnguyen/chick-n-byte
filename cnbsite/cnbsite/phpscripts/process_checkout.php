<?php
session_start();
require_once 'connect.php';

$session_id = session_id();
$user_id = $_SESSION['user_id'] ?? null; // NULL for guest users
$order_type = $_POST['order_type'];
$delivery_address = $_POST['delivery_address'] ?? null;
$order_notes = $_POST['order_notes'] ?? null;

// Handle guest user details
$customer_name = null;
$customer_email = null;

if ($user_id) { // If the user is logged in
    // Fetch the user's name from the database
    $stmt = $conn->prepare("SELECT username FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $customer_name = $stmt->fetchColumn();
} else {
    // Use guest input for customer name and email
    $customer_name = $_POST['customer_name'] ?? null;
    $customer_email = $_POST['customer_email'] ?? null;
}

// Calculate total price
$query = "SELECT SUM(m.price * c.quantity) AS total_price
          FROM cart c
          JOIN menu_items m ON c.menu_item_id = m.menu_item_id
          WHERE c.session_id = :session_id";
$stmt = $conn->prepare($query);
$stmt->execute(['session_id' => $session_id]);
$total_price = $stmt->fetchColumn();

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, customer_email, total_price, delivery_address, order_notes, order_type) 
                        VALUES (:user_id, :customer_name, :customer_email, :total_price, :delivery_address, :order_notes, :order_type)");
$stmt->execute([
    'user_id' => $user_id,
    'customer_name' => $customer_name,
    'customer_email' => $customer_email,
    'total_price' => $total_price,
    'delivery_address' => $delivery_address,
    'order_notes' => $order_notes,
    'order_type' => $order_type
]);
$order_id = $conn->lastInsertId();

// Insert order items
$query = "SELECT menu_item_id, quantity FROM cart WHERE session_id = :session_id";
$stmt = $conn->prepare($query);
$stmt->execute(['session_id' => $session_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($cart_items as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity) 
                            VALUES (:order_id, :menu_item_id, :quantity)");
    $stmt->execute([
        'order_id' => $order_id,
        'menu_item_id' => $item['menu_item_id'],
        'quantity' => $item['quantity']
    ]);
}

// Clear cart
$stmt = $conn->prepare("DELETE FROM cart WHERE session_id = :session_id");
$stmt->execute(['session_id' => $session_id]);

header("Location: ../order_confirmation.php?order_id=$order_id");
exit();
?>