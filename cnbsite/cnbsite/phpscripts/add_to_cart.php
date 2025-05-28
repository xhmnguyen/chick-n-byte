<?php
session_start();
require_once 'connect.php'; 

// Get the menu item ID from the form
$menu_item_id = intval($_POST['menu_item_id']);
$session_id = session_id();

// Check if the item is already in the cart
$query = "SELECT * FROM cart WHERE menu_item_id = :menu_item_id AND session_id = :session_id";
$stmt = $conn->prepare($query);
$stmt->execute(['menu_item_id' => $menu_item_id, 'session_id' => $session_id]);
$cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cart_item) {
    // If the item exists, increment the quantity
    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = :cart_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->execute(['cart_id' => $cart_item['cart_id']]);
} else {
    // If the item doesn't exist, add it to the cart
    $insert_query = "INSERT INTO cart (menu_item_id, quantity, session_id) VALUES (:menu_item_id, 1, :session_id)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->execute(['menu_item_id' => $menu_item_id, 'session_id' => $session_id]);
}

// Redirect back to the menu page
header("Location: ../menu.php");
exit();
?>