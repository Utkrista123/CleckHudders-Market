<?php
require '../BackEnd/database/connect.php';

$conn = getDBConnection();
if (!$conn) {
    die("Database connection failed");
}

// Ensure user has a unique ID
if (!isset($_COOKIE['user_id'])) {
    die("User not identified");
}

$user_id = $_COOKIE['user_id'];

// Check if cart has items
$cart_query = $conn->prepare("SELECT cart.cart_id, product.product_id, product.price, product_cart.quantity 
                             FROM cart
                             JOIN product_cart ON cart.cart_id = product_cart.cart_id
                             JOIN product ON product_cart.product_id = product.product_id
                             WHERE cart.user_id = ?");
$cart_query->execute([$user_id]);
$cart_items = $cart_query->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    die("Your cart is empty.");
}

// Get a collection slot ID (Assuming you assign one manually or pick the next available)
$collection_slot_id = 1; // Replace with logic to get a valid slot

// Insert order for each item in cart
foreach ($cart_items as $item) {
    $order_amount = $item['price']; 
    $total_amount = $item['price'] * $item['quantity'];
    
    $order_insert = $conn->prepare("INSERT INTO orders (collection_slot_id, user_id, cart_id, order_date, order_amount, total_amount) 
                                    VALUES (?, ?, ?, NOW(), ?, ?)");
    $order_insert->execute([$collection_slot_id, $user_id, $item['cart_id'], $order_amount, $total_amount]);
}

// Clear cart after checkout
$clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$clear_cart->execute([$user_id]);

$clear_product_cart = $conn->prepare("DELETE FROM product_cart WHERE cart_id NOT IN (SELECT cart_id FROM cart)");
$clear_product_cart->execute();

echo "Order placed successfully!";
header("Location: order_confirmation.php");
exit();
?>
