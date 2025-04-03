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

// Handle Add to Cart request
if(isset($_POST['add_to_cart'])){
   $product_id = $_POST['product_id'];
   $qty = $_POST['qty'];

   $product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
   $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);

   // Check if user has an existing cart
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() == 0){
       // Create a new cart for the user
       $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, add_date) VALUES (?, NOW())");
       $insert_cart->execute([$user_id]);
       $cart_id = $conn->lastInsertId();
   } else {
       // Get the existing cart ID
       $cart = $check_cart->fetch(PDO::FETCH_ASSOC);
       $cart_id = $cart['cart_id'];
   }

   // Check if product is already in the cart
   $check_product = $conn->prepare("SELECT * FROM `product_cart` WHERE cart_id = ? AND product_id = ?");
   $check_product->execute([$cart_id, $product_id]);

   if($check_product->rowCount() > 0){
       echo "<script>alert('Product already in cart!');</script>";
   } else {
       // Add product to product_cart table
       $insert_product = $conn->prepare("INSERT INTO `product_cart` (cart_id, product_id, quantity) VALUES (?, ?, ?)");
       $insert_product->execute([$cart_id, $product_id, $qty]);

       // Update the stock
       $update_stock = $conn->prepare("UPDATE `product` SET stock = stock - ? WHERE product_id = ?");
       $update_stock->execute([$qty, $product_id]);

       echo "<script>alert('Product added to cart successfully!');</script>";

   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="products">
   <h1 class="heading">All Products</h1>
   <div class="box-container">

   <?php 
      $select_products = $conn->prepare("SELECT * FROM `product`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="POST" class="box">
      <img src="../BackEnd/admin/uploaded_files/<?= $fetch_product['product_image']; ?>" class="image" alt="">
      <h3 class="name"><?= $fetch_product['product_name'] ?></h3>
      <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
      <p class="description"><?= $fetch_product['description'] ?></p>
      <div class="flex">
         <p class="price">RS. <?= $fetch_product['price'] ?></p>
         <p class="stock">stock: <?= $fetch_product['stock'] ?></p>
         <input type="number" name="qty" required min="1" max="<?= $fetch_product['stock'] ?>" value="1" class="qty">
      </div>
      <input type="submit" name="add_to_cart" value="Add to Cart" class="btn">
      <a href="checkout.php?get_id=<?= $fetch_product['product_id']; ?>" class="delete-btn">Buy Now</a>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">No products found!</p>';
      }
   ?>
   
   </div>
</section>

</body>
</html>
