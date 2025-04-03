<?php
require '../BackEnd/database/connect.php';

$conn = getDBConnection();
if(!$conn) {
    die("Database connection failed");
}

// Ensure user has a unique ID
if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    setcookie('user_id', uniqid(), time() + 60*60*24*30, "/");
    $user_id = $_COOKIE['user_id'];
}

// Fetch cart details
$cart_query = $conn->prepare("SELECT cart.cart_id, product.product_id, product.product_name, product.product_image, product.price, product.stock 
                             FROM cart
                             JOIN product_cart ON cart.cart_id = product_cart.cart_id
                             JOIN product ON product_cart.product_id = product.product_id
                             WHERE cart.user_id = ?");
$cart_query->execute([$user_id]);
$cart_items = $cart_query->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['update_qty'])){
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    if($qty <= 0) {
        // Remove item from cart if quantity is zero or less
        $delete_item = $conn->prepare("DELETE FROM product_cart WHERE product_id = ?");
        $delete_item->execute([$product_id]);
    }
}

if(isset($_POST['remove_item'])){
    $product_id = $_POST['product_id'];
    $delete_item = $conn->prepare("DELETE FROM product_cart WHERE product_id = ?");
    $delete_item->execute([$product_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="shopping-cart">
    <h1 class="heading">Your Cart</h1>
    <div class="box-container">

    <?php if(count($cart_items) > 0) { 
        foreach($cart_items as $item) { ?>
        <form action="" method="POST" class="box">
            <img src="../BackEnd/admin/uploaded_files/<?= $item['product_image']; ?>" class="image" alt="">
            <h3 class="name"><?= $item['product_name'] ?></h3>
            <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
            <p class="price">RS. <?= $item['price'] ?></p>
            <div class="flex">
                <input type="number" name="qty" required min="1" max="<?= $item['stock'] ?>" value="1" class="qty">
                <input type="submit" name="update_qty" value="Update" class="btn">
            </div>
            <input type="submit" name="remove_item" value="Remove" class="delete-btn">
        </form>
    <?php } 
    } else { 
        echo '<p class="empty">Your cart is empty!</p>'; 
    } ?>
    </div>
    
    <div class="checkout">
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
</section>

</body>
</html>
